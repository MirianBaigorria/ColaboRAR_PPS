<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Chats;

/**
 * ChatsSearch represents the model behind the search form of `app\models\Chats`.
 */
class ChatsSearch extends Chats
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'grupos_id', 'tareas_id'], 'integer'],
            [['descripcion', 'fecha'], 'safe'],
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
        $query = Chats::find();

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
            'fecha' => $this->fecha,
            'grupos_id' => $this->grupos_id,
            'tareas_id' => $this->tareas_year_id,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
