<?php

namespace app\commands;

use app\models\Notificaciones;
use app\models\Tareas;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * Comando que verifica los plazos de las actividades.
 *
 * Debe ejecutarse una vez por día, por ejemplo agendado como tarea del sistema
 * operativo o mediante el cron del hosting:
 *
 *     php yii notificaciones/verificar-plazos
 *
 * Qué hace en cada pasada:
 *  - Si a una actividad abierta le faltan N días (parametro plazo_dias_aviso,
 *    por defecto 2) para su fecha de finalizacion, notifica a los alumnos
 *    que el plazo esta por vencer.
 *  - Si la fecha de finalizacion ya paso, cierra la actividad y notifica a
 *    los alumnos el vencimiento (vencida = cerrada).
 */
class NotificacionesController extends Controller
{
    /**
     * Verifica los plazos de las actividades abiertas con fecha de finalizacion.
     * @return int Codigo de salida
     */
    public function actionVerificarPlazos()
    {
        // Dias de anticipacion con los que se avisa el vencimiento
        $diasAviso = (int) (Yii::$app->params['plazo_dias_aviso'] ?? Notificaciones::DIAS_AVISO_PLAZO);
        $hoy = strtotime(date('Y-m-d'));

        // Recorro las actividades abiertas que tienen fecha de finalizacion definida
        $tareas = Tareas::find()
            ->where(['cerrada' => 0])
            ->andWhere(['not', ['fecha_fin' => null]])
            ->all();

        foreach ($tareas as $tarea) {
            $diasRestantes = (int) round((strtotime($tarea->fecha_fin) - $hoy) / 86400);

            if ($diasRestantes < 0) {
                // La actividad ya vencio: la cierro automaticamente y notifico a los alumnos
                $tarea->cerrada = 1;
                if ($tarea->save(false)) {
                    Notificaciones::notificarPlazo($tarea, 'vencida');
                    $this->stdout("Actividad vencida y cerrada: {$tarea->nombre_t}\n", Console::FG_YELLOW);
                }
            } elseif ($diasRestantes === $diasAviso) {
                // Faltan exactamente $diasAviso dias: aviso del vencimiento a los alumnos
                Notificaciones::notificarPlazo($tarea, 'por_vencer');
                $this->stdout("Aviso de vencimiento proximo: {$tarea->nombre_t}\n", Console::FG_GREEN);
            }
        }

        $this->stdout("Verificacion de plazos finalizada.\n", Console::FG_CYAN);
        return ExitCode::OK;
    }
}