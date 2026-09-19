<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tareas_alumnos".
 *
 * @property int $id
 * @property int $tareas_id
 * @property int $usuarios_id
 * @property string $nota
 * @property string $fecha_entrega
 * @property string $comentarios
 *
 * @property Tareas $tareas
 * @property Usuarios $usuarios
 */
class TareasAlumno extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tareas_alumnos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tareas_id', 'usuarios_id'], 'required'],
            [['tareas_id', 'usuarios_id'], 'integer'],
            [['nota'], 'number'],
            [['fecha_entrega'], 'safe'],
            [['comentarios'], 'string'],
            [['tareas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tareas::className(), 'targetAttribute' => ['tareas_id' => 'id']],
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
            'tareas_id' => 'Tareas ID',
            'usuarios_id' => 'Usuarios ID',
            'nota' => 'Nota',
            'fecha_entrega' => 'Fecha Entrega',
            'comentarios' => 'Comentarios',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTareas()
    {
        return $this->hasOne(Tareas::className(), ['id' => 'tareas_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuarios_id']);
    }
}
