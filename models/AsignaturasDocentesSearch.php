<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AsignaturasDocentes;

/**
 * AsignaturasDocentesSearch represents the model behind the search form of `app\models\AsignaturasDocentes`.
 */
class AsignaturasDocentesSearch extends AsignaturasDocentes
{
    //Bloque agregado
    //Se agrega el atributo $nombre_asignatura, que se usará para filtrar(en la busqueda) por el nombre de la asignatura.
    public $nombre_asignatura;
    //Fin de bloque agregado
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'usuarios_id', 'asignaturas_id'], 'integer'],
            [['nombre_asignatura'], 'safe'], // Regla para el campo nombre_asignatura. Safe es que no necesita validacion
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
        $query = AsignaturasDocentes::find();

        // add conditions that should always apply here

        //Bloque agregado
        // Relacionar la tabla Asignaturas
        $query->joinWith('asignatura'); //El asignaturas entre parentesis el es nombre del metodo que se uso para definir en la clase AsignaturasDocentes
        //la relacion con la tabla Asignaturas. En este caso era: getAsignatura().
        
        $query->limit(10); // Limitar los resultados directamente en la consulta

        $query->andWhere(['asignaturas.estado' => 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //Definimos las opciones de ordenamiento
            'sort' => [
                'attributes' => [
                    //Por el año de asignaturas
                    'asignaturas.year' => [
                        'asc' => ['asignaturas.year' => SORT_ASC],
                        'desc' => ['asignaturas.year' => SORT_DESC],
                        'label' => 'Año de la Asignatura',
                    ],
                    //Por el nombre de asigntaturas
                    'asignaturas.nombre' => [
                        'asc' => ['asignaturas.nombre' => SORT_ASC],
                        'desc' => ['asignaturas.nombre' => SORT_DESC],
                        'label' => 'Nombre de la Asignatura',
                    ],
                    'id',
                    'usuarios_id',
                    'asignaturas_id',
                ],
                 //Define la configuracion de ordenamiento, Por año de asignatura descendente y por nombre de asignatura ascendente
                'defaultOrder' => [
                    'asignaturas.year' => SORT_DESC,'asignaturas.nombre' => SORT_ASC, // Orden alfabético ascendente por nombre de asignatura
                ],
            ],
        ]);

        //Fin de bloque agregado

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        
        // grid filtering conditions

        //para filtrar los registros de AsignaturasDocentes según el nombre de la asignatura, que está en la tabla Asignaturas
        //andFilterWhere(): Este es un método que añade una condición WHERE a la consulta.
        //Si $this->nombre_asignatura tiene algún valor (por ejemplo, el usuario escribió un nombre de asignatura en el filtro), la condición andFilterWhere se agrega a la consulta.
        //['like', 'asignaturas.nombre', $this->nombre_asignatura]: Aquí es donde realmente se define la condición de filtrado.
        //'like': El operador like se usa para hacer una búsqueda que no sea exacta, sino parcial. Es decir, busca registros que contengan el valor que estamos buscando en cualquier parte del campo.
        //'asignaturas.nombre': Esto especifica el campo de la tabla Asignaturas en el que estamos buscando.
        $query->andFilterWhere(['like', 'asignaturas.nombre', $this->nombre_asignatura]);

        return $dataProvider;
    }
}
