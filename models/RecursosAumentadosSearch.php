<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RecursosAumentados;

/**
 * RecursosAumentadosSearch represents the model behind the search form of `app\models\RecursosAumentados`.
 */
class RecursosAumentadosSearch extends RecursosAumentados
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_asignatura'], 'integer'],
            [['nombre', 'descripcion', 'tipoar', 'marker', 'pattern', 'r_archivo1', 'r_archivo2', 'r_musica'], 'safe'],
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
        $query = RecursosAumentados::find();

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
            'id_asignatura' => $this->id_asignatura,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'tipoar', $this->tipoar])
            ->andFilterWhere(['like', 'marker', $this->marker])
            ->andFilterWhere(['like', 'pattern', $this->pattern])
            ->andFilterWhere(['like', 'r_archivo1', $this->r_archivo1])
            ->andFilterWhere(['like', 'r_archivo2', $this->r_archivo2])
            ->andFilterWhere(['like', 'r_musica', $this->r_musica]);

        return $dataProvider;
    }
}
