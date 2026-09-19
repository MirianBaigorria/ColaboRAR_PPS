<?php

namespace app\models;

use Yii;
use app\models\Evento;
/**
 * This is the model class for table "respuesta_preguntas".
 *
 * @property int $id
 * @property int $evento_id
 * @property int $usuario_id
 * @property string $respuesta
 *
 * @property Eventos $evento
 * @property Usuarios $usuario
 */
class RespuestaPreguntas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'respuesta_preguntas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['evento_id', 'usuario_id', 'respuesta'], 'required'],
            [['evento_id', 'usuario_id'], 'integer'],
            [['respuesta'], 'string'],
            [['evento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Eventos::className(), 'targetAttribute' => ['evento_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'evento_id' => 'Evento ID',
            'usuario_id' => 'Usuario ID',
            'respuesta' => 'Respuesta',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvento()
    {
        return $this->hasOne(Evento::className(), ['id' => 'evento_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id']);
    }
}
