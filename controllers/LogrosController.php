<?php

namespace app\controllers;

use Yii;
use app\models\Logros;
use app\models\LogrosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LogrosController implements the CRUD actions for Logros model.
 */
class LogrosController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

     //LOGROS MANDAR MENSAJE 
     public function actionActualizarPuntajePorMensaje($usuario_id)
     {
         // Buscar al usuario por su ID
         $usuario = \app\models\Usuarios::findOne($usuario_id);
 
         if ($usuario) {
             // Incrementar el puntaje en 10 puntos
             $usuario->puntaje += 10;
 
             // Guardar los cambios en la base de datos
             if ($usuario->save(false)) {
                 return [
                     'success' => true,
                     'message' => 'Puntaje actualizado correctamente.',
                 ];
             } else {
                 return [
                     'success' => false,
                     'message' => 'No se pudo actualizar el puntaje del usuario.',
                     'errors' => $usuario->errors, // Mostrar errores si falla
                 ];
             }
         } else {
             return [
                 'success' => false,
                 'message' => 'Usuario no encontrado.',
             ];
         }
     }












    /**
     * Lists all Logros models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LogrosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Logros model.
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
     * Creates a new Logros model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Logros();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Logros model.
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
     * Deletes an existing Logros model.
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
     * Finds the Logros model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Logros the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Logros::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
