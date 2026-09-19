<?php

namespace app\controllers;

use Yii;
use app\models\SentenciasApertura;
use app\models\SentenciasAperturaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SentenciasAperturaController implements the CRUD actions for SentenciasApertura model.
 */
class SentenciasAperturaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'update', 'delete', 'create', 'recuperar-sentencias'],
                'rules' => [
                    [
                        'actions' => ['recuperar-sentencias'],
                        'allow' => true,
                        'roles' => ['estudiante'],
                    ],
                    [
                        'actions' => ['index', 'view', 'update', 'delete', 'create'],
                        'allow' => true,
                        'roles' => ['administrador'],
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
     * Lists all SentenciasApertura models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SentenciasAperturaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionRecuperarSentencias($idsubhab){
        $objSentenciaApertura = new SentenciasApertura();
        $sentencias = $objSentenciaApertura->getSentenciasAperturaPorSubhabilidad($idsubhab);
        return $this->renderAjax('recuperar-sentencias', [
            'sentencias' => $sentencias,
        ]);
    }

    /**
     * Displays a single SentenciasApertura model.
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
     * Creates a new SentenciasApertura model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SentenciasApertura();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SentenciasApertura model.
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
     * Deletes an existing SentenciasApertura model.
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
     * Finds the SentenciasApertura model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SentenciasApertura the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SentenciasApertura::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
