<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;

class LeaderboardController extends Controller
{
    public function actionIndex($tarea_id)
    {
        // Verificar que se proporcione un ID de tarea
        if ($tarea_id === null) {
            throw new \yii\web\BadRequestHttpException('Debe proporcionar un ID de tarea.');
        }

        // Consulta para obtener el leaderboard de la tarea
        $query = (new \yii\db\Query())
            ->select([
                'usuarios.id AS usuario_id',
                'usuarios.nombre',
                'usuarios.apellido',
                'usuarios.foto_perfil',
                'rangos.nombre AS rango_nombre',
                'rangos.imagen AS rango_imagen',
                'tarea_usuario_puntaje.puntaje',
            ])
            ->from('tarea_usuario_puntaje')
            ->innerJoin('usuarios', 'tarea_usuario_puntaje.id_usuario = usuarios.id')
            ->leftJoin(
                '(SELECT usuarios_id, MAX(rangos_id) AS rangos_id FROM rangos_usuarios GROUP BY usuarios_id) AS usuario_rango',
                'usuarios.id = usuario_rango.usuarios_id'
            )
            ->leftJoin('rangos', 'rangos.id = usuario_rango.rangos_id')
            ->where(['tarea_usuario_puntaje.id_tarea' => $tarea_id])
            ->orderBy(['tarea_usuario_puntaje.puntaje' => SORT_DESC]);

        // Configurar ActiveDataProvider
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
