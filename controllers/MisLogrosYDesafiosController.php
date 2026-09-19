<?php

namespace app\controllers;
use yii\web\Controller;
use app\models\Usuarios;
use app\models\RangosUsuarios;
use app\models\Logros;
use app\models\Desafios;
use app\models\Rangos;
use app\models\DesafiosUsuarios;

class MisLogrosYDesafiosController extends Controller
{
    public function actionIndex()
    {

        $usuario_id = \Yii::$app->user->id;


        // Obtener datos del usuario
        $usuario = Usuarios::findOne($usuario_id);

        //trae todo los rangos
        $rangos= Rangos::find()->all();

        // Obtener el rango actual del usuario
            $rangoUsuario = RangosUsuarios::find()
        ->where(['usuarios_id' => $usuario_id])
        ->orderBy(['rangos_id' => SORT_DESC]) // Ordenar por el mayor rango
        ->one();


        // Obtener todos los logros
        $logros = Logros::find()->all();

        // Obtener todos los desafíos
        $desafios = Desafios::find()->all();

        // Obtener progreso en los desafíos
        $progresoDesafios = DesafiosUsuarios::find()
            ->where(['usuarios_id' => $usuario_id])
            ->indexBy('desafios_id') // Organizar por desafíos_id para fácil acceso en la vista
            ->all();
            
        return $this->render('index', [
            'usuario' => $usuario,
            'rangoUsuario' => $rangoUsuario,
            'logros' => $logros,
            'desafios' => $desafios,
            'progresoDesafios' => $progresoDesafios,
            'rangos' => $rangos,
        ]);
    }
}
