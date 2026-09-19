<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuarios;

/**
 * UsuariosSearch represents the model behind the search form of `app\models\Usuarios`.
 */
class UsuariosSearch extends Usuarios {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'tipo'], 'integer'],
            [['username', 'nombre', 'apellido', 'estiloaprendizaje', 'fechanacimiento', 'email'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = Usuarios::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC, // orden descendente
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
            'tipo' => $this->tipo,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'nombre', $this->nombre])
                ->andFilterWhere(['like', 'apellido', $this->apellido])
                ->andFilterWhere(['like', 'estiloaprendizaje', $this->estiloaprendizaje])
                ->andFilterWhere(['like', 'fechanacimiento', $this->fechanacimiento])
                ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }

}
