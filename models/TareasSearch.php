<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tareas;

/**
 * TareasSearch represents the model behind the search form of `app\models\Tareas`.
 */
class TareasSearch extends Tareas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'year', 'asignaturas_id', 'grupos_id'], 'integer'],
            [['nombre_t','descripcion', 'consigna'], 'safe'],
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
        $query = Tareas::find();

        // add conditions that should always apply here

        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //Definimos las opciones de ordenamiento
            //Define la configuracion de ordenamiento, Por id descendente 
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);
        

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'year' => $this->year,
            'asignaturas_id' => $this->asignaturas_id,
            'grupos_id' => $this->grupos_id,
        ]);
        
        $query->andFilterWhere(['like', 'nombre_t', $this->nombre_t]);
        $query->andFilterWhere(['like', 'consigna', $this->nombre_t]);
        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);
        
        //echo ($query->createCommand()->sql); die();

        return $dataProvider;
    }
}
