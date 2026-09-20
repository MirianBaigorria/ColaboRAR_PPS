<?php

namespace app\controllers;

use Yii;
use app\models\Notificaciones;
use app\models\NotificacionesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * NotificacionesController implementa las acciones para las notificaciones
 * del usuario logueado.
 */
class NotificacionesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'ver', 'marcar-leida', 'marcar-todas-leidas', 'no-leidas'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'ver', 'marcar-leida', 'marcar-todas-leidas', 'no-leidas'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'marcar-leida' => ['POST'],
                    'marcar-todas-leidas' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lista las notificaciones del usuario logueado.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NotificacionesSearch();

        // Forzar que siempre se listen las notificaciones del usuario actual
        $params = Yii::$app->request->queryParams;
        unset($params['NotificacionesSearch']['usuarios_id']);
        $params['NotificacionesSearch']['usuarios_id'] = Yii::$app->user->id;

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra una notificación (solo del usuario logueado).
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Marca la notificación como leída y redirige a su destino.
     * @param integer $id
     * @return mixed
     */
    public function actionVer($id)
    {
        $model = $this->findModel($id);
        if (!$model->leido) {
            $model->leido = 1;
            $model->save(false);
        }

        if ($model->url) {
            return $this->redirect($model->url);
        }

        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Marca una notificación como leída (POST).
     * @param integer $id
     * @return mixed
     */
    public function actionMarcarLeida($id)
    {
        $model = $this->findModel($id);
        if (!$model->leido) {
            $model->leido = 1;
            $model->save(false);
        }

        return $this->redirect(['index']);
    }

    /**
     * Marca todas las notificaciones del usuario como leídas (POST).
     * @return mixed
     */
    public function actionMarcarTodasLeidas()
    {
        Notificaciones::updateAll(
            ['leido' => 1],
            ['usuarios_id' => Yii::$app->user->id, 'leido' => 0]
        );

        return $this->redirect(['index']);
    }

    /**
     * Devuelve en JSON la cantidad de notificaciones sin leer del usuario.
     * @return string json
     */
    public function actionNoLeidas()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'count' => Notificaciones::contarNoLeidas(Yii::$app->user->id),
        ];
    }

    /**
     * Encuentra el modelo basado en su clave primaria, validando que
     * pertenezca al usuario logueado.
     * @param integer $id
     * @return Notificaciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Notificaciones::find()
            ->where(['id' => $id, 'usuarios_id' => Yii::$app->user->id])
            ->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}