<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Rangos;

/**
 * RangosSearch represents the model behind the search form of `app\models\Rangos`.
 */
class RangosSearch extends Rangos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nivel'], 'integer'],
            [['nombre', 'descripcion', 'imagen'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Rangos::find();

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
            'nivel' => $this->nivel,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'imagen', $this->imagen]);

        return $dataProvider;
    }
}
