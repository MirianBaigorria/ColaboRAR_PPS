<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "eventos".
 *
 * @property int $id
 * @property int $id_tarea
 * @property string $tipo_evento
 * @property string $titulo
 * @property string $descripcion
 * @property string $link
 * @property string $pregunta
 * @property string $descripcion_pregunta
 * @property string $imagen
 * @property string $fecha_creacion
 * @property string $estado
 * @property Tareas $tarea
 */
class Evento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'eventos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tarea'], 'required'],
            [['id_tarea'], 'integer'],
            [['tipo_evento', 'descripcion', 'descripcion_pregunta'], 'string'],
            [['fecha_creacion'], 'safe'],
            [['titulo', 'link', 'pregunta', 'imagen'], 'string', 'max' => 255],
            ['estado', 'in', 'range' => ['activado', 'desactivado']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_tarea' => 'Id Tarea',
            'tipo_evento' => 'Tipo Evento',
            'titulo' => 'Titulo',
            'descripcion' => 'Descripcion',
            'link' => 'Link',
            'pregunta' => 'Pregunta',
            'descripcion_pregunta' => 'Descripcion Pregunta',
            'imagen' => 'Imagen',
            'fecha_creacion' => 'Fecha Creacion',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTarea()
    {
        return $this->hasOne(Tareas::className(), ['id' => 'id_tarea']);
    }

    public static function getEventosPorTarea($idTarea)
    {
        return self::find()
            ->where(['id_tarea' => $idTarea])
            ->orderBy(['fecha_creacion' => SORT_ASC])
            ->all();
    }

}
