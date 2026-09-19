<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cuestionariosconflicto;

/**
 * CuestionariosconflictoSearch represents the model behind the search form of `app\models\Cuestionariosconflicto`.
 */
class CuestionariosconflictoSearch extends Cuestionariosconflicto
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sentencias_id'], 'integer'],
            [['nc1', 'nc2', 'nc3', 'nc4', 'nc5', 'nc6', 'nc7', 'nc8', 'cc1', 'cc2', 'cc3', 'cc4', 'cc5', 'cc6', 'cc7', 'cc8', 'cc9', 'cc10', 'cc11', 'cc12', 'cc13', 'cc14', 'cc15', 'cc16', 'cc17', 'cc18', 'cc19', 'cc20'], 'number'],
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
        $query = Cuestionariosconflicto::find();

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
            'nc1' => $this->nc1,
            'nc2' => $this->nc2,
            'nc3' => $this->nc3,
            'nc4' => $this->nc4,
            'nc5' => $this->nc5,
            'nc6' => $this->nc6,
            'nc7' => $this->nc7,
            'nc8' => $this->nc8,
            'cc1' => $this->cc1,
            'cc2' => $this->cc2,
            'cc3' => $this->cc3,
            'cc4' => $this->cc4,
            'cc5' => $this->cc5,
            'cc6' => $this->cc6,
            'cc7' => $this->cc7,
            'cc8' => $this->cc8,
            'cc9' => $this->cc9,
            'cc10' => $this->cc10,
            'cc11' => $this->cc11,
            'cc12' => $this->cc12,
            'cc13' => $this->cc13,
            'cc14' => $this->cc14,
            'cc15' => $this->cc15,
            'cc16' => $this->cc16,
            'cc17' => $this->cc17,
            'cc18' => $this->cc18,
            'cc19' => $this->cc19,
            'cc20' => $this->cc20,
            'sentencias_id' => $this->sentencias_id,
        ]);

        return $dataProvider;
    }
}
