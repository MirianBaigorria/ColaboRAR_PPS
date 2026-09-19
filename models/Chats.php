<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chats".
 *
 * @property int $id
 * @property string $descripcion
 * @property string $fecha
 * @property int $grupos_formados_id
 * @property int $tareas_id
 * @property int $nota
 * @property string $descripcion_nota
 *
 * @property Grupos $grupos
 * @property TareasYear $tareasYear
 * @property Sentencias[] $sentencias
 */
class Chats extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chats';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha'], 'safe'],
            [['grupos_formados_id', 'tareas_id'], 'required'],
            [['grupos_formados_id', 'tareas_id'], 'integer'],
            [['descripcion'], 'string', 'max' => 1000],
            [['grupos_formados_id'], 'exist', 'skipOnError' => true, 'targetClass' => GruposFormados::className(), 'targetAttribute' => ['grupos_formados_id' => 'id']],
            [['tareas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tareas::className(), 'targetAttribute' => ['tareas_id' => 'id']],
            [['nota'], 'number'],
            [['descripcion_nota'], 'string'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
            'fecha' => 'Fecha',
            'grupos_formados_id' => 'Grupos ID',
            'tareas_id' => 'Tarea',
            'nota' => 'Nota',
            'descripcion_nota' => 'Descripción de la Nota',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrupos()
    {
        return $this->hasOne(GruposFormados::className(), ['id' => 'grupos_formados_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTareasYear()
    {
        return $this->hasOne(Tareas::className(), ['id' => 'tareas_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSentencias()
    {
        return $this->hasMany(Sentencias::className(), ['chats_id' => 'id']);
    }
    
    public static function getChatsGrupos($tarea_id) {

        $query = (new \yii\db\Query())
                ->select(['ch.id', 'ch.grupos_formados_id', 'GROUP_CONCAT(apellido) as alumnos'])
                ->from('chats as ch')
                ->innerJoin('grupos_alumnos as ga', 'ch.grupos_formados_id = ga.grupos_formados_id')
                ->innerJoin('usuarios as u', 'ga.usuarios_id = u.id')
                ->where(['tareas_id' => $tarea_id])
                ->groupBy('ch.grupos_formados_id');

        //echo $query->createCommand()->sql; die();
        return $query->all();
        ;
    }
    
    public static function getMiembrosChat($grupo_id) {

        $query = (new \yii\db\Query())
                ->select(['grupos_formados_id', 'GROUP_CONCAT(apellido) as alumnos'])
                ->from('usuarios as u')
                ->innerJoin('grupos_alumnos as ga', 'ga.usuarios_id = u.id')
                ->where(['grupos_formados_id' => $grupo_id])
                ->groupBy('grupos_formados_id');

        //echo $query->createCommand()->sql; die();
        return $query->all();
        ;
    }
}
