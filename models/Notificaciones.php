<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "notificaciones".
 *
 * @property int $id
 * @property int $usuarios_id
 * @property string $tipo
 * @property string $titulo
 * @property string $descripcion
 * @property string $url
 * @property int $grupos_formados_id
 * @property int $tareas_id
 * @property int $leido
 * @property string $creado_en
 *
 * @property Usuarios $usuarios
 * @property GruposFormados $gruposFormados
 * @property Tareas $tareas
 */
class Notificaciones extends \yii\db\ActiveRecord
{
    const DIAS_AVISO_PLAZO = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notificaciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuarios_id', 'titulo'], 'required'],
            [['usuarios_id', 'grupos_formados_id', 'tareas_id'], 'integer'],
            [['leido'], 'boolean'],
            [['creado_en'], 'safe'],
            [['descripcion', 'url'], 'string'],
            [['tipo'], 'string', 'max' => 50],
            [['titulo'], 'string', 'max' => 255],
            [['usuarios_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuarios_id' => 'id']],
            [['grupos_formados_id'], 'exist', 'skipOnError' => true, 'targetClass' => GruposFormados::className(), 'targetAttribute' => ['grupos_formados_id' => 'id']],
            [['tareas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tareas::className(), 'targetAttribute' => ['tareas_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuarios_id' => 'Usuario',
            'tipo' => 'Tipo',
            'titulo' => 'Título',
            'descripcion' => 'Descripción',
            'url' => 'URL',
            'grupos_formados_id' => 'Grupo',
            'tareas_id' => 'Actividad',
            'leido' => 'Leída',
            'creado_en' => 'Creada el',
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
    public function getGruposFormados()
    {
        return $this->hasOne(GruposFormados::className(), ['id' => 'grupos_formados_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTareas()
    {
        return $this->hasOne(Tareas::className(), ['id' => 'tareas_id']);
    }

    /**
     * Crea una notificación para un usuario.
     */
    public static function crear($usuariosId, $tipo, $titulo, $descripcion = null, $url = null, $gruposFormadosId = null, $tareasId = null)
    {
        $model = new self();
        $model->usuarios_id = $usuariosId;
        $model->tipo = $tipo;
        $model->titulo = $titulo;
        $model->descripcion = $descripcion;
        $model->url = $url;
        $model->grupos_formados_id = $gruposFormadosId;
        $model->tareas_id = $tareasId;
        $model->leido = 0;
        $model->creado_en = date('Y-m-d H:i:s');
        return $model->save(false);
    }

    /**
     * Cantidad de notificaciones sin leer de un usuario.
     */
    public static function contarNoLeidas($usuariosId)
    {
        return (int) self::find()->where(['usuarios_id' => $usuariosId, 'leido' => 0])->count();
    }

    /**
     * Notificaciones sin leer de un usuario agrupadas por grupo, para una
     * actividad determinada. Devuelve [grupos_formados_id => cantidad].
     */
    public static function contarNoLeidasPorGrupo($usuariosId, $tareasId)
    {
        $rows = self::find()
            ->select(['grupos_formados_id', 'COUNT(*) AS total'])
            ->where(['usuarios_id' => $usuariosId, 'leido' => 0, 'tareas_id' => $tareasId])
            ->andWhere(['not', ['grupos_formados_id' => null]])
            ->groupBy('grupos_formados_id')
            ->asArray()
            ->all();

        $resultado = [];
        foreach ($rows as $row) {
            $resultado[$row['grupos_formados_id']] = (int) $row['total'];
        }
        return $resultado;
    }

    /**
     * R1: notifica a los integrantes del grupo (y a los docentes de la
     * asignatura, marcando el grupo para el badge) cada nuevo mensaje.
     */
    public static function notificarNuevoMensaje($model, $chat)
    {
        $url = Url::to(['chats/grupo', 'chatid' => $chat->id]);

        $tarea = Tareas::findOne($chat->tareas_id);
        $grupo = GruposFormados::findOne($chat->grupos_formados_id);
        $nombreGrupo = $grupo ? $grupo->nombre : 'grupo';
        $nombreTarea = $tarea ? $tarea->nombre_t : 'tarea';
        $titulo = 'Tienes un nuevo mensaje en el grupo "' . $nombreGrupo . '" de la tarea "' . $nombreTarea . '"';

        $miembros = (new \yii\db\Query())
            ->select('usuarios_id')
            ->from('grupos_alumnos')
            ->where(['grupos_formados_id' => $chat->grupos_formados_id])
            ->andWhere(['<>', 'usuarios_id', $model->usuarios_id])
            ->column();

        foreach ($miembros as $usuarioId) {
            self::crear($usuarioId, 'mensaje', $titulo, $model->sentencia, $url, $chat->grupos_formados_id, $chat->tareas_id);
        }

        if ($tarea) {
            foreach (self::getDocentesDeTarea($tarea) as $usuarioId) {
                self::crear($usuarioId, 'mensaje', $titulo, $model->sentencia, $url, $chat->grupos_formados_id, $chat->tareas_id);
            }
        }
    }

    /**
     * R3: notifica creación, cierre o reapertura de una actividad.
     */
    public static function notificarActividad($tarea, $tipo)
    {
        $url = Url::to(['tareas/view', 'id' => $tarea->id]);

        switch ($tipo) {
            case 'tarea_creada':
                $descripcion = $tarea->fecha_fin
                    ? 'Fecha de finalización: ' . Yii::$app->formatter->asDate($tarea->fecha_fin)
                    : 'Actividad disponible para realizar.';
                // Al docente le interesa saber cuando se abre una tarea
                $destinatarios = array_unique(array_merge(self::getDocentesDeTarea($tarea), self::getAlumnosDeTarea($tarea)));
                foreach ($destinatarios as $usuarioId) {
                    self::crear($usuarioId, 'tarea_creada', 'Nueva actividad: ' . $tarea->nombre_t, $descripcion, $url, null, $tarea->id);
                }
                break;

            case 'tarea_cerrada':
            case 'tarea_reabierta':
                $titulo = $tipo === 'tarea_cerrada' ? 'Actividad cerrada: ' : 'Actividad reabierta: ';
                $titulo .= $tarea->nombre_t;
                $destinatarios = array_unique(array_merge(self::getDocentesDeTarea($tarea), self::getAlumnosDeTarea($tarea)));
                foreach ($destinatarios as $usuarioId) {
                    $yaExiste = self::find()
                        ->where(['usuarios_id' => $usuarioId, 'tipo' => $tipo, 'tareas_id' => $tarea->id, 'leido' => 0])
                        ->exists();
                    if ($yaExiste) {
                        continue;
                    }
                    self::crear($usuarioId, $tipo, $titulo, null, $url, null, $tarea->id);
                }
                break;
        }
    }

    /**
     * R4: notifica plazos por vencer (faltan 2 días) o vencidos de una
     * actividad. El plazo vencido se notifica como actividad cerrada.
     * No repite la alerta si ya existe una sin leer del mismo tipo y actividad.
     */
    public static function notificarPlazo($tarea, $modo)
    {
        $fecha = $tarea->fecha_fin ? Yii::$app->formatter->asDate($tarea->fecha_fin) : 'sin fecha definida';

        if ($modo === 'por_vencer') {
            $tipo = 'plazo_por_vencer';
            $titulo = 'La actividad "' . $tarea->nombre_t . '" vence en ' . self::DIAS_AVISO_PLAZO . ' días (hasta el ' . $fecha . ')';
        } else {
            $tipo = 'tarea_cerrada';
            $titulo = 'La actividad "' . $tarea->nombre_t . '" venció el ' . $fecha;
        }

        $url = Url::to(['tareas/view', 'id' => $tarea->id]);

        // Los plazos solo se notifican a los alumnos: al docente solo le
        // interesan la actividad en los grupos, la apertura y el cierre.
        $destinatarios = self::getAlumnosDeTarea($tarea);
        foreach ($destinatarios as $usuarioId) {
            $yaExiste = self::find()
                ->where(['usuarios_id' => $usuarioId, 'tipo' => $tipo, 'tareas_id' => $tarea->id, 'leido' => 0])
                ->exists();
            if ($yaExiste) {
                continue;
            }
            self::crear($usuarioId, $tipo, $titulo, null, $url, null, $tarea->id);
        }
    }

    /**
     * Etiquetas legibles por tipo de notificación.
     */
    public static function getEtiquetasTipo()
    {
        return [
            'mensaje' => 'Nuevo mensaje',
            'tarea_creada' => 'Nueva actividad',
            'tarea_cerrada' => 'Actividad cerrada',
            'tarea_reabierta' => 'Actividad reabierta',
            'plazo_por_vencer' => 'Plazo por vencer',
        ];
    }

    public static function getEtiquetaTipo($tipo)
    {
        $etiquetas = self::getEtiquetasTipo();
        return isset($etiquetas[$tipo]) ? $etiquetas[$tipo] : $tipo;
    }

    /**
     * Ids de los alumnos que pertenecen a la actividad (todos sus grupos).
     */
    private static function getAlumnosDeTarea($tarea)
    {
        $detalle = GruposFormados::getDetalleGrupos($tarea->grupos_id);
        return array_filter(array_unique(ArrayHelper::getColumn($detalle, 'alumnoId')));
    }

    /**
     * Ids de los docentes a cargo de la asignatura de la actividad.
     */
    private static function getDocentesDeTarea($tarea)
    {
        return (new \yii\db\Query())
            ->select('usuarios_id')
            ->from('asignaturas_docentes')
            ->where(['asignaturas_id' => $tarea->asignaturas_id])
            ->column();
    }
}