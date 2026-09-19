<?php

namespace app\controllers;

use Yii;
use app\models\AsignaturasAlumnos;
use app\models\AsignaturasAlumnosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AsignaturasAlumnosController implements the CRUD actions for AsignaturasAlumnos model.
 */
class AsignaturasAlumnosController extends Controller
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
                ],
            ],
        ];
    }
    
    public function actionRecuperarAlumnos($asigid, $year)
    {               
        $alumnos = \app\models\AsignaturasAlumnos::getListaAlumnosPorYear($year, $asigid);

        return $this->renderAjax('recuperar-alumnos', [
            'alumnos' => $alumnos,
        ]);
    }

    /**
     * Lists all AsignaturasAlumnos models.
     * @return mixed
     */
    public function actionIndex($asigid)
    {
        $usuario = Yii::$app->user->identity->id;
        $oUser = \app\models\Usuarios::findOne(['id' => $usuario]);
        $asigid = Yii::$app->security->decryptByPassword($asigid, $oUser->password);
        
        $searchModel = new AsignaturasAlumnosSearch();
        $searchModel->asignaturas_id = $asigid;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'asigid' => $asigid,
        ]);
    }

    /**
     * Displays a single AsignaturasAlumnos model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $asigid = $model->asignaturas_id;
        return $this->render('view', [
            'model' => $model,
            'asigid' => $asigid,
        ]);
    }

    /**
     * Creates a new AsignaturasAlumnos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($asigid)
    {
        $usuario = Yii::$app->user->identity->id;
        $oUser = \app\models\Usuarios::findOne(['id' => $usuario]);
        $asigid = Yii::$app->security->decryptByPassword($asigid, $oUser->password);
        
        $model = new AsignaturasAlumnos();
        $model->asignaturas_id = $asigid;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'asigid' => $asigid]);
        }

        return $this->render('create', [
            'model' => $model,
            'asigid' => $asigid,
        ]);
    }
    
    
    public function actionCreateAsociation()
    {
        $usuario = Yii::$app->user->identity->id;
        $model = new AsignaturasAlumnos();
        $model->usuarios_id = $usuario;
        $model->year = date("Y");

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            Yii::$app->runAction('desafios/verificar-asociar-primera-materia', ['usuario_id' => $model->usuarios_id]);


            return $this->redirect(['asignaturas/asignaturas-alumnos']);
        }

        return $this->render('create-asociation', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AsignaturasAlumnos model.
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
     * Deletes an existing AsignaturasAlumnos model.
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
     * Finds the AsignaturasAlumnos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AsignaturasAlumnos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AsignaturasAlumnos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
