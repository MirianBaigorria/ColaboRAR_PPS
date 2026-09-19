<?php

namespace app\controllers;

use Yii;
use app\models\Sentencias;
use app\models\SentenciasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SentenciasController implements the CRUD actions for Sentencias model.
 */
class SentenciasController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'update', 'delete', 'create', 'crear-con-ajax'],
                'rules' => [
                    [
                        'actions' => ['crear-con-ajax'],
                        'allow' => true,
                        'roles' => ['estudiante'],
                    ],
                    [
                        'actions' => ['index', 'view', 'update', 'delete', 'create'],
                        'allow' => true,
                        'roles' => ['profesor'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Sentencias models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SentenciasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sentencias model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Sentencias model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $model = new Sentencias();
        $model->fecha_hora = date('Y-m-d h:i:s', time());

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
public function actionCrearConAjax()
{
    // Definir la zona horaria adecuada
    date_default_timezone_set('America/Argentina/Buenos_Aires');

    // Tomar los parámetros por POST (no como argumentos)
    $request = Yii::$app->request;
    $usuarios_id = $request->post('usuarios_id');
    $chats_id = $request->post('chats_id');
    $sentencia = $request->post('sentencia');
    $tipo_respuesta = $request->post('tipo_respuesta');
    $evento_id = $request->post('evento_id');

    // Validación básica
    if (!$usuarios_id || !$chats_id || !$sentencia) {
        throw new \yii\web\BadRequestHttpException('Parámetros requeridos ausentes: usuarios_id, chats_id, sentencia');
    }

    // Instanciar y cargar el modelo
    $model = new \app\models\Sentencias();
    $model->fecha_hora = date('Y-m-d H:i:s');
    $model->usuarios_id = $usuarios_id;
    $model->chats_id = $chats_id;
    $model->sentencia = $sentencia;
    $model->tipo_respuesta = $tipo_respuesta ?: null;
    $model->evento_id = $evento_id ?: null;

    // Actualizar puntaje general por mensaje
    Yii::$app->runAction('logros/actualizar-puntaje-por-mensaje', ['usuario_id' => $usuarios_id]);

    // Actualizar puntaje de tarea, si corresponde
    $chat = \app\models\Chats::findOne($chats_id);
    if ($chat && $chat->tareas_id) {
        $tareaUsuarioPuntaje = \app\models\TareaUsuarioPuntaje::findOne([
            'id_usuario' => $usuarios_id,
            'id_tarea' => $chat->tareas_id
        ]);

        if (!$tareaUsuarioPuntaje) {
            $tareaUsuarioPuntaje = new \app\models\TareaUsuarioPuntaje();
            $tareaUsuarioPuntaje->id_usuario = $usuarios_id;
            $tareaUsuarioPuntaje->id_tarea = $chat->tareas_id;
            $tareaUsuarioPuntaje->puntaje = 10;
        } else {
            $tareaUsuarioPuntaje->puntaje += 10;
        }
        $tareaUsuarioPuntaje->save(false);
    }

    // Guardar la sentencia con los nuevos campos
    $model->save(false);

    // Puedes devolver un JSON si lo usás con AJAX
    return $model->id;
}


    
    /**
     * Updates an existing Sentencias model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $model = $this->findModel($id);
        $model->fecha_hora = date('Y-m-d h:i:s', time());

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
       

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Sentencias model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Sentencias model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sentencias the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sentencias::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
