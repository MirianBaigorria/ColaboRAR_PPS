<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TareasAlumno;

/**
 * TareasAlumnoSearch represents the model behind the search form of `app\models\TareasAlumno`.
 */
class TareasAlumnoSearch extends TareasAlumno
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tareas_id', 'usuarios_id'], 'integer'],
            [['nota'], 'number'],
            [['fecha_entrega', 'comentarios'], 'safe'],
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
        $query = TareasAlumno::find();

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
            'tareas_id' => $this->tareas_id,
            'usuarios_id' => $this->usuarios_id,
            'nota' => $this->nota,
            'fecha_entrega' => $this->fecha_entrega,
        ]);

        $query->andFilterWhere(['like', 'comentarios', $this->comentarios]);

        return $dataProvider;
    }
}
