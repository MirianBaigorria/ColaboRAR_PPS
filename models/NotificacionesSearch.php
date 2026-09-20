<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * NotificacionesSearch represents the model behind the search form about `app\models\Notificaciones`.
 */
class NotificacionesSearch extends Notificaciones
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'usuarios_id', 'grupos_formados_id', 'tareas_id', 'leido'], 'integer'],
            [['tipo', 'titulo', 'descripcion', 'url', 'creado_en'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::SCENARIO_DEFAULT;
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
        $query = Notificaciones::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['creado_en' => SORT_DESC],
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
            'usuarios_id' => $this->usuarios_id,
            'grupos_formados_id' => $this->grupos_formados_id,
            'tareas_id' => $this->tareas_id,
            'leido' => $this->leido,
            'creado_en' => $this->creado_en,
        ]);

        $query->andFilterWhere(['like', 'tipo', $this->tipo])
            ->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}