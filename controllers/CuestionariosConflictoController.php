<?php

namespace app\controllers;

use Yii;
use app\models\Cuestionariosconflicto;
use app\models\CuestionariosconflictoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CuestionariosConflictoController implements the CRUD actions for Cuestionariosconflicto model.
 */
class CuestionariosConflictoController extends Controller
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
     * Lists all Cuestionariosconflicto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CuestionariosconflictoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cuestionariosconflicto model.
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
     * Creates a new Cuestionariosconflicto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cuestionariosconflicto();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
    public function actionCrearConAjax()
    {
        if (isset($_POST)){
            $idsentencia = $_POST["sentenciaid"];
            $cuestionario = json_decode($_POST['datacuestionario']);
            $oCuestionario = new Cuestionariosconflicto();
            
            for($i=1; $i <= 8; $i++){
                $indice = "nc$i";
                $oCuestionario->$indice = $cuestionario->$indice;
            }
            
            for($i=1; $i <= 20; $i++){
                $indice = "cc$i";
                $oCuestionario->$indice = $cuestionario->$indice;
            }
            
            $oCuestionario->sentencias_id = $idsentencia;
            $oCuestionario->save();
        }
        return true;
    }    

    /**
     * Updates an existing Cuestionariosconflicto model.
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
     * Deletes an existing Cuestionariosconflicto model.
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
     * Finds the Cuestionariosconflicto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cuestionariosconflicto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cuestionariosconflicto::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
