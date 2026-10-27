<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tareas".
 *
 * @property int $id
 * @property string $nombre_t
 * @property string $descripcion
 * @property int $year
 * @property int $usar_sentencias_apertura
 * @property int $reportar_estado_animo
 * @property int $reportar_conflicto
 * @property int $actividad_gamificada
 * @property int $modo_ra
 * @property int $asignaturas_id
 * @property int $grupos_id 
 *@property string $tipo_tarea
 * @property int $cerrada_por
 * @property string $cerrada_en
 * @property Usuarios $cerradaPorUsuario
 * @property Chats[] $chats
 * @property Asignaturas $asignaturas
 */
class Tareas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tareas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre_t', 'year', 'asignaturas_id', 'grupos_id'], 'required'],
            [['descripcion', 'consigna'], 'string'],
            [['puntaje_tarea'],'number'],
            [['tipo_tarea'], 'string', 'max'=> 255],
            [['year', 'asignaturas_id', 'grupos_id', 'usar_sentencias_apertura', 'reportar_estado_animo', 'reportar_conflicto', 'actividad_gamificada'], 'integer'],
            [['fecha_inicio', 'fecha_fin'], 'safe'],
            [['cerrada'], 'integer'],
            [['cerrada_en'], 'safe'],
            [['cerrada_por'], 'integer'],
            [['nombre_t'], 'string', 'max' => 255],
            [['asignaturas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Asignaturas::className(), 'targetAttribute' => ['asignaturas_id' => 'id']],
            [['grupos_id'], 'exist', 'skipOnError' => true, 'targetClass' => Grupos::className(), 'targetAttribute' => ['grupos_id' => 'id']],
            [['cerrada_por'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['cerrada_por' => 'id']],
            [['modo_ra'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre_t' => 'Nombre',
            'consigna' => 'Consigna',
            'descripcion' => 'Descripción',
            'year' => 'Año',
            'usar_sentencias_apertura' => 'Emplear Sentencias de Apertura',
            'reportar_estado_animo' => 'Permitir Reportar Estado de Ánimo',
            'reportar_conflicto' => 'Permitir Reportar Conflicto',
            'actividad_gamificada' => 'Permitir Actividad Gamificada 🏆',
            'asignaturas_id' => 'Asignaturas ID',
            'grupos_id' => 'Cod. de Configuración de Grupo',
            'puntaje_tarea'=>'Puntaje de la tarea',
            'tipo_tarea' => 'Tipo de tarea',
            'modo_ra' => 'Modo de asignacion de Recursos Aumentados',
            'fecha_inicio' => 'Fecha de inicio',
            'fecha_fin' => 'Fecha de finalización',
            'cerrada' => 'Estado',
            'cerrada_por' => 'Cerrada por',
            'cerrada_en' => 'Fecha de cierre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chats::className(), ['tareas_year_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignaturas()
    {
        return $this->hasOne(Asignaturas::className(), ['id' => 'asignaturas_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCerradaPorUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'cerrada_por']);
    }

    /**
     * Devuelve el estado de la actividad en texto, indicando quien la cerro y cuando.
     * @return string
     */
    public function getTextoEstado()
    {
        if (!$this->cerrada) {
            if ($this->fecha_fin && $this->fecha_fin < date('Y-m-d')) {
                return 'Vencida';
            }
            return 'Abierta';
        }

        // Fecha y hora del cierre; si no hay registro, uso la fecha de finalizacion
        if ($this->cerrada_en) {
            $cierre = Yii::$app->formatter->asDatetime($this->cerrada_en, 'php:d/m/Y H:i');
        } elseif ($this->fecha_fin) {
            $cierre = Yii::$app->formatter->asDate($this->fecha_fin, 'php:d/m/Y');
        } else {
            $cierre = null;
        }

        // Cierre manual por docente
        if ($this->cerrada_por) {
            $usuario = $this->cerradaPorUsuario;
            if ($usuario) {
                $nombre = trim($usuario->nombre . ' ' . $usuario->apellido);
                if ($nombre === '') {
                    $nombre = $usuario->username;
                }
                return 'Cerrada por ' . $nombre . ($cierre ? ' el ' . $cierre : '');
            }
            return 'Cerrada' . ($cierre ? ' el ' . $cierre : '');
        }

        return 'Cerrada' . ($cierre ? ' el ' . $cierre : '');
    }

    /**
     * Indica si la tarea ya venció por fecha de finalización.
     */
    public function estaVencida()
    {
        if ($this->cerrada) {
            return false;
        }
        if ($this->fecha_fin) {
            return $this->fecha_fin < date('Y-m-d');
        }
        return false;
    }
}
