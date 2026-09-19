<?php

namespace app\controllers;
use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Evento;


class EventoController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionRecuperarEventos($chatid)
    {
        // Obtener la tarea asociada al chat
        $chat = \app\models\Chats::findOne($chatid);
        $eventos = Evento::find()
            ->where(['id_tarea' => $chat->tareas_id]) // Solo eventos activos
            ->orderBy(['fecha_creacion' => SORT_ASC])
            ->all();

        return $this->renderAjax('recuperar-eventos', [
            'eventos' => $eventos,
        ]);
    }
   
    public function actionDesactivar()
{
    if (Yii::$app->request->isPost) {
        $eventoId = Yii::$app->request->post('evento_id');

        // Encuentra el evento y cambia su estado a 'desactivado'
        $evento = \app\models\Evento::findOne($eventoId);
        if ($evento) {
            $evento->estado = 'desactivado';
            if ($evento->save()) {
                Yii::$app->session->setFlash('success', 'El evento se desactivó correctamente.');
            } else {
                Yii::$app->session->setFlash('error', 'No se pudo desactivar el evento. Intente nuevamente.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Evento no encontrado.');
        }

        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    throw new \yii\web\BadRequestHttpException('Solicitud no válida.');
}

    

}
