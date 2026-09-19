<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "desafios_usuarios".
 *
 * @property int $id
 * @property int $usuarios_id
 * @property int $desafios_id
 * @property int $contador_desafio_completado
 * @property string $estado
 * @property string $fecha_completado
 *
 * @property Usuarios $usuarios
 * @property Desafios $desafios
 */
class DesafiosUsuarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'desafios_usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuarios_id', 'desafios_id'], 'required'],
            [['usuarios_id', 'desafios_id', 'contador_desafio_completado'], 'integer'],
            [['estado'], 'string'],
            [['fecha_completado'], 'safe'],
            [['usuarios_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuarios_id' => 'id']],
            [['desafios_id'], 'exist', 'skipOnError' => true, 'targetClass' => Desafios::className(), 'targetAttribute' => ['desafios_id' => 'id']],
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
            'desafios_id' => 'Desafios ID',
            'contador_desafio_completado' => 'Contador Desafio Completado',
            'estado' => 'Estado',
            'fecha_completado' => 'Fecha Completado',
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
    public function getDesafios()
    {
        return $this->hasOne(Desafios::className(), ['id' => 'desafios_id']);
    }
}
