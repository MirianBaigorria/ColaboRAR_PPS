<?php

namespace app\controllers;

use Yii;
use app\models\AsignaturasDocentes;
use app\models\AsignaturasDocentesSearch;
use app\models\Asignaturas;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AsignaturasDocentesController implements the CRUD actions for AsignaturasDocentes model.
 */
class AsignaturasDocentesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'update', 'delete', 'create', 'create-profesor-aux'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'update', 'delete', 'create'],
                        'allow' => true,
                        'roles' => ['administrador'],
                    ],
                    [
                        'actions' => ['create-profesor-aux', 'view'],
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
     * Lists all AsignaturasDocentes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AsignaturasDocentesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AsignaturasDocentes model.
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
     * Creates a new AsignaturasDocentes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AsignaturasDocentes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    //Este metodo lo que hace es permitir que un profesor pueda asociar a una de sus asignaturas a otro profesor creando un registro de AsignaturasDocentes
    public function actionCreateProfesorAux($id) 
    {
    // Buscar la asignatura existente
    $asignatura = Asignaturas::findOne($id);

    if (!$asignatura) {
        // Si no se encuentra la asignatura, mostrar un error o redirigir
        Yii::$app->session->setFlash('error', 'La asignatura no existe.');
        return $this->redirect(['index']);
    }

    $model = new AsignaturasDocentes();

    // Establecer el valor predeterminado para el campo 'tipo'
    $model->tipo = 1;  // Esto hace que el valor de tipo sea 1 por defecto

    // Si el formulario fue enviado y los datos son válidos
    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        // Redirigir al usuario a la vista de la asignatura
        return $this->redirect(['view', 'id' => $model->id]);
    }

    // Pasar el modelo de AsignaturasDocentes y la asignatura existente al formulario
    return $this->render('create_aux', [
        'model' => $model,
        'asignatura' => $asignatura, // Asignar la asignatura a la vista
    ]);
}



    /**
     * Updates an existing AsignaturasDocentes model.
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
     * Deletes an existing AsignaturasDocentes model.
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
     * Finds the AsignaturasDocentes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AsignaturasDocentes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AsignaturasDocentes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
