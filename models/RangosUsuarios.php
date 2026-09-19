<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rangos_usuarios".
 *
 * @property int $id
 * @property int $usuarios_id
 * @property int $rangos_id
 * @property string $fecha_asignacion
 *
 * @property Usuarios $usuarios
 * @property Rangos $rangos
 */
class RangosUsuarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rangos_usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuarios_id', 'rangos_id', 'fecha_asignacion'], 'required'],
            [['usuarios_id', 'rangos_id'], 'integer'],
            [['fecha_asignacion'], 'safe'],
            [['usuarios_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuarios_id' => 'id']],
            [['rangos_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rangos::className(), 'targetAttribute' => ['rangos_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuarios_id' => 'Usuarios ID',
            'rangos_id' => 'Rangos ID',
            'fecha_asignacion' => 'Fecha Asignacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuarios_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRangos()
    {
        return $this->hasOne(Rangos::className(), ['id' => 'rangos_id']);
    }
    public function getRango()
{
    return $this->hasOne(Rangos::class, ['id' => 'rangos_id']);
}
}
