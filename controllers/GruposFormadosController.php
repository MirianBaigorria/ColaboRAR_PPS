<?php

namespace app\controllers;

use Yii;
use app\models\GruposFormados;
use app\models\GruposFormadosSearch;
use app\models\Tareas;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * GruposFormadosController implements the CRUD actions for GruposFormados model.
 */
class GruposFormadosController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'update', 'delete', 'create'],
                'rules' => [
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
                    'eliminar' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all GruposFormados models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GruposFormadosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GruposFormados model.
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
     * Creates a new GruposFormados model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GruposFormados();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing GruposFormados model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing GruposFormados model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $model_id) {
        $usuario = Yii::$app->user->identity->id;
        $oUser = \app\models\Usuarios::findOne(['id' => $usuario]);
        $id = Yii::$app->security->decryptByPassword($id, $oUser->password);
        $model = $this->findModel($id);
        $this->findModel($id)->delete();

        return $this->redirect(['grupos/view', 'id' => $model_id]);
    }

   public function actionClasificar($id, $tareas_id)
{
    $usuario = Yii::$app->user->identity->id;
    $oUser = \app\models\Usuarios::findOne(['id' => $usuario]);
    $id = Yii::$app->security->decryptByPassword($id, $oUser->password);

    $model = $this->findModel($id); // Grupo
    $tarea = \app\models\Tareas::findOne($tareas_id);
    $chat = \app\models\Chats::findOne(['grupos_formados_id' => $id]);

    // Buscar o crear calificación
    $calificacion = \app\models\GrupoTareaCalificacion::findOne([
        'grupos_formados_id' => $id,
        'tareas_id' => $tareas_id
    ]);

    $ya_calificada = false;

    if (!$calificacion) {
        $calificacion = new \app\models\GrupoTareaCalificacion();
        $calificacion->grupos_formados_id = $id;
        $calificacion->tareas_id = $tareas_id;
        $calificacion->estado_calificacion = 'NC'; // No calificada por defecto
    } else {
        $ya_calificada = ($calificacion->estado_calificacion === 'C');
    }

    if ($calificacion->load(Yii::$app->request->post()) && $calificacion->validate()) {

        $nota = $calificacion->nota;
        $tarea_puntaje = $tarea->puntaje_tarea ?: 0;
        $nuevo_puntaje = ($nota * 10) + $tarea_puntaje;

        if (!$ya_calificada) {
            $calificacion->estado_calificacion = 'C';
            $calificacion->puntaje_otorgado = $nuevo_puntaje;

            $model->puntaje = $nuevo_puntaje;
            $model->save();

            if ($tarea->actividad_gamificada == 1) {
                $miembros = \app\models\GruposAlumnos::find()->where(['grupos_formados_id' => $id])->all();
                foreach ($miembros as $miembro) {
                    $usuarioModel = \app\models\Usuarios::findOne($miembro->usuarios_id);
                    $usuarioModel->cont_actividades_grupales += 1;

                    Yii::$app->runAction('desafios/verificar-cantidad-actividades-realizadas', [
                        'usuario_id' => $miembro->usuarios_id
                    ]);
                    Yii::$app->runAction('desafios/verificar-nota-mayor-a8-en-actividad-grupal', [
                        'usuario_id' => $miembro->usuarios_id,
                        'grupos_formados_id' => $id,
                    ]);
                    $usuarioModel->save();

                    $registroPuntaje = \app\models\TareaUsuarioPuntaje::findOne([
                        'id_usuario' => $miembro->usuarios_id,
                        'id_tarea' => $tareas_id,
                    ]);

                    if (!$registroPuntaje) {
                        $registroPuntaje = new \app\models\TareaUsuarioPuntaje();
                        $registroPuntaje->id_usuario = $miembro->usuarios_id;
                        $registroPuntaje->id_tarea = $tareas_id;
                        $registroPuntaje->puntaje = $nuevo_puntaje;
                        $registroPuntaje->save();
                    }
                }
            }
        }

        $calificacion->save(false);

        Yii::$app->session->setFlash('success', 'Clasificación guardada correctamente.');
        return $this->redirect(['tareas/view', 'id' => $tareas_id]);
    }

    return $this->render('clasificar', [
        'model' => $model,
        'tarea' => $tarea,
        'chat' => $chat,
        'calificacion' => $calificacion,
    ]);
}

    
    
    
    
    
    
    /**
     * Finds the GruposFormados model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GruposFormados the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GruposFormados::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
  
}
