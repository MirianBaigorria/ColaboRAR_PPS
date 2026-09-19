<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AsignaturasAlumnos;

/**
 * AsignaturasAlumnosSearch represents the model behind the search form of `app\models\AsignaturasAlumnos`.
 */
class AsignaturasAlumnosSearch extends AsignaturasAlumnos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'year', 'asignaturas_id', 'usuarios_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    

  
    public function search($params)
    {
    $query = AsignaturasAlumnos::find();

    // Relacionar con la tabla asignaturas(asignaturas para ordenar asignaturas en vista estudiantes) y usuarios(usuarios para ordenar estudiantes en asignaturasalumnos en profesores)
    $query->joinWith(['asignaturas', 'usuarios']);//El asignaturas entre parentesis el es nombre del metodo que se uso para definir la relacion con la tabla Asignaturas en la clase AsignaturasAlumnos
    //En este caso era: getAsignaturas().

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'sort' => [
            //Definimos las opciones de ordenamiento
            'attributes' => [
                //Por el año de asignaturas_alumnos
                'year',
                //Por el nombre de asignaturas
                'asignaturas.nombre' => [
                    'asc' => ['asignaturas.nombre' => SORT_ASC],
                    'desc' => ['asignaturas.nombre' => SORT_DESC],
                ],
                //Por el apellido de usuarios
                'usuarios.apellido' => [
                    'asc' => ['usuarios.apellido' => SORT_ASC],
                    'desc' => ['usuarios.apellido' => SORT_DESC],
                ],
            ],
            //Define la configuracion de ordenamiento, Primero por año descendente y luego por nombre de asignatura ascendente(En el caso de usar la relacion: asignaturasalumnos-asignaturas)
            //Define la configuracion de ordenamiento, Primero por año descendente y luego por apellido de usuario ascendente(En el caso de usar la relacion: asignaturasalumnos-usuarios)
            'defaultOrder' => [
                'year' => SORT_DESC,
                'asignaturas.nombre' => SORT_ASC,
                'usuarios.apellido'=> SORT_ASC,
            ],
        ],
    ]);

    $this->load($params);

    if (!$this->validate()) {
        return $dataProvider;
    }

    $query->andFilterWhere([
        'id' => $this->id,
        'year' => $this->year,
        'asignaturas_id' => $this->asignaturas_id,
        'usuarios_id' => $this->usuarios_id,
    ]);

    return $dataProvider;
}

}
