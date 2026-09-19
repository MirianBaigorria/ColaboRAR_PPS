<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Emociones;

/**
 * EmocionesSearch represents the model behind the search form of `app\models\Emociones`.
 */
class EmocionesSearch extends Emociones
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'chats_id'], 'integer'],
            [['valencia', 'activacion', 'dominancia'], 'number'],
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
        $query = Emociones::find();

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
            'valencia' => $this->valencia,
            'activacion' => $this->activacion,
            'dominancia' => $this->dominancia,
            'chats_id' => $this->chats_id,
        ]);

        return $dataProvider;
    }
}
