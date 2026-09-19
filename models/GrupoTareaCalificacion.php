<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grupo_tarea_calificacion".
 *
 * @property int $id
 * @property int $grupos_formados_id
 * @property int $tareas_id
 * @property float|null $nota
 * @property string|null $descripcion_nota
 * @property string|null $estado_calificacion  // 'NC' (no calificado) o 'C' (calificado)
 * @property float|null $puntaje_otorgado
 *
 * @property GruposFormados $grupo
 * @property Tareas $tarea
 */
class GrupoTareaCalificacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grupo_tarea_calificacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grupos_formados_id', 'tareas_id'], 'required'],
            [['grupos_formados_id', 'tareas_id'], 'integer'],
            [['nota', 'puntaje_otorgado'], 'number'],
            [['descripcion_nota'], 'string'],
            [['estado_calificacion'], 'string', 'max' => 2],
            [['grupos_formados_id', 'tareas_id'], 'unique', 'targetAttribute' => ['grupos_formados_id', 'tareas_id'], 'message' => 'Ya existe una calificación para este grupo y tarea.'],
            [['grupos_formados_id'], 'exist', 'skipOnError' => true, 'targetClass' => GruposFormados::class, 'targetAttribute' => ['grupos_formados_id' => 'id']],
            [['tareas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tareas::class, 'targetAttribute' => ['tareas_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'grupos_formados_id' => 'Grupo',
            'tareas_id' => 'Tarea',
            'nota' => 'Nota',
            'descripcion_nota' => 'Descripción de la nota',
            'estado_calificacion' => 'Estado',
            'puntaje_otorgado' => 'Puntaje Otorgado',
        ];
    }

    /**
     * Gets query for [[Grupo]].
     */
    public function getGrupo()
    {
        return $this->hasOne(GruposFormados::class, ['id' => 'grupos_formados_id']);
    }

    /**
     * Gets query for [[Tarea]].
     */
    public function getTarea()
    {
        return $this->hasOne(Tareas::class, ['id' => 'tareas_id']);
    }
}
