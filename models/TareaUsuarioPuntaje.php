<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tarea_usuario_puntaje".
 *
 * @property int $id
 * @property int $id_usuario
 * @property int $id_tarea
 * @property int $puntaje
 *
 * @property Tareas $tarea
 * @property Usuarios $usuario
 */
class TareaUsuarioPuntaje extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tarea_usuario_puntaje';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_tarea', 'puntaje'], 'required'],
            [['id_usuario', 'id_tarea', 'puntaje'], 'integer'],
            [['id_tarea'], 'exist', 'skipOnError' => true, 'targetClass' => Tareas::className(), 'targetAttribute' => ['id_tarea' => 'id']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['id_usuario' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_usuario' => 'Id Usuario',
            'id_tarea' => 'Id Tarea',
            'puntaje' => 'Puntaje',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTarea()
    {
        return $this->hasOne(Tareas::className(), ['id' => 'id_tarea']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'id_usuario']);
    }
}
