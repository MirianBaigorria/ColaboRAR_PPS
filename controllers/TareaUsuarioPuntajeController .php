<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\TareaUsuarioPuntaje;

class TareaUsuarioPuntajeController extends Controller
{
    /**
     * Método para asignar puntaje a un usuario en una tarea específica.
     *
     * @param int $id_usuario El ID del usuario
     * @param int $id_tarea El ID de la tarea
     * @param int $puntaje El puntaje a asignar
     * @return bool True si se guardó correctamente, False en caso contrario
     */
    public function actionAsignarPuntaje($id_usuario, $id_tarea, $puntaje)
    {
        // Busca si ya existe un registro para el usuario y la tarea
        $registro = TareaUsuarioPuntaje::findOne(['id_usuario' => $id_usuario, 'id_tarea' => $id_tarea]);

        if ($registro) {
            // Si existe, actualiza el puntaje
            $registro->puntaje = $puntaje;
        } else {
            // Si no existe, crea un nuevo registro
            $registro = new TareaUsuarioPuntaje();
            $registro->id_usuario = $id_usuario;
            $registro->id_tarea = $id_tarea;
            $registro->puntaje = $puntaje;
        }

        // Intenta guardar el registro en la base de datos
        if ($registro->save()) {
            return true;
        } else {
            Yii::error('Error al guardar el puntaje: ' . json_encode($registro->getErrors()), __METHOD__);
            return false;
        }
    }

   
}
