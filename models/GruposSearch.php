<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Grupos;

/**
 * GruposSearch represents the model behind the search form of `app\models\Grupos`.
 */
class GruposSearch extends Grupos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'asignaturas_id', 'metodos_formacion_id'], 'integer'],
            [['year', 'codigo'], 'safe'],
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
        $query = Grupos::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'asignaturas_id' => $this->asignaturas_id,
            'metodos_formacion_id' => $this->metodos_formacion_id,
            'codigo' => $this->codigo,
        ]);

        $query->andFilterWhere(['like', 'year', $this->year]);

        return $dataProvider;
    }
}
