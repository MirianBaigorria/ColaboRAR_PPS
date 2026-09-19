<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Sentencias;

/**
 * SentenciasSearch represents the model behind the search form of `app\models\Sentencias`.
 */
class SentenciasSearch extends Sentencias
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'usuarios_id', 'chats_id'], 'integer'],
            [['sentencia', 'fecha_hora'], 'safe'],
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
        $query = Sentencias::find();

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
            'usuarios_id' => $this->usuarios_id,
            'fecha_hora' => $this->fecha_hora,
            'chats_id' => $this->chats_id,
        ]);

        $query->andFilterWhere(['like', 'sentencia', $this->sentencia]);

        return $dataProvider;
    }
}
