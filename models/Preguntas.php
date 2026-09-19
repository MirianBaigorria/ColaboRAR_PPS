<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "preguntas".
 *
 * @property int $id
 * @property int $tareas_id
 * @property string $pregunta
 * @property int $es_multiple_choice
 * @property string $archivo
 * @property string $created_at
 *
 * @property MultipleChoice[] $multipleChoices
 * @property Tareas $tareas
 */
class Preguntas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'preguntas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tareas_id', 'pregunta'], 'required'],
            [['tareas_id', 'es_multiple_choice'], 'integer'],
            [['pregunta'], 'string'],
            [['created_at'], 'safe'],
            [['archivo'], 'string', 'max' => 255],
            [['tareas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tareas::className(), 'targetAttribute' => ['tareas_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tareas_id' => 'Tareas ID',
            'pregunta' => 'Pregunta',
            'es_multiple_choice' => 'Es Multiple Choice',
            'archivo' => 'Archivo',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMultipleChoices()
    {
        return $this->hasMany(MultipleChoice::className(), ['preguntas_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTareas()
    {
        return $this->hasOne(Tareas::className(), ['id' => 'tareas_id']);
    }
}
