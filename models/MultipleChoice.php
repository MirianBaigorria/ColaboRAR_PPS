<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "multiple_choice".
 *
 * @property int $id
 * @property int $preguntas_id
 * @property string $opcion
 * @property int $es_correcta
 *
 * @property Preguntas $preguntas
 */
class MultipleChoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'multiple_choice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['preguntas_id', 'opcion'], 'required'],
            [['preguntas_id', 'es_correcta'], 'integer'],
            [['opcion'], 'string'],
            [['preguntas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Preguntas::className(), 'targetAttribute' => ['preguntas_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'preguntas_id' => 'Preguntas ID',
            'opcion' => 'Opcion',
            'es_correcta' => 'Es Correcta',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreguntas()
    {
        return $this->hasOne(Preguntas::className(), ['id' => 'preguntas_id']);
    }
}
