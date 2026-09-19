<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "logros_usuario".
 *
 * @property int $id
 * @property int $contador_realizado
 * @property string $estado
 * @property int $logros_id
 * @property int $usuarios_id
 *
 * @property Logros $logros
 * @property Usuarios $usuarios
 */
class LogrosUsuario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'logros_usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contador_realizado', 'logros_id', 'usuarios_id'], 'integer'],
            [['estado'], 'string'],
            [['logros_id', 'usuarios_id'], 'required'],
            [['logros_id'], 'exist', 'skipOnError' => true, 'targetClass' => Logros::className(), 'targetAttribute' => ['logros_id' => 'id']],
            [['usuarios_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuarios_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contador_realizado' => 'Contador Realizado',
            'estado' => 'Estado',
            'logros_id' => 'Logros ID',
            'usuarios_id' => 'Usuarios ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogros()
    {
        return $this->hasOne(Logros::className(), ['id' => 'logros_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuarios_id']);
    }
}
