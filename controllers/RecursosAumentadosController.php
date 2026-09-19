<?php

namespace app\controllers;

use Yii;
use app\models\RecursosAumentados;
use app\models\RecursosAumentadosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * RecursosAumentadosController implements the CRUD actions for RecursosAumentados model.
 */
class RecursosAumentadosController extends Controller
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

    /**
     * Lists all RecursosAumentados models.
     * @return mixed
     */
    public function actionIndex($asigid)
    {
        $usuario = Yii::$app->user->identity->id;
        $oUser = \app\models\Usuarios::findOne(['id' => $usuario]);
        $asigid = Yii::$app->security->decryptByPassword($asigid, $oUser->password);

        $searchModel = new RecursosAumentadosSearch();
        //Se asigna el id de asignatura para que solo muestre los recursos aumentados para esa asignatura
        $searchModel->id_asignatura = $asigid;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'asigid' => $asigid,
        ]);
    }

    /**
     * Displays a single RecursosAumentados model.
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
     * Creates a new RecursosAumentados model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($asigid)
    {
        //Creamos un objeto del tipo modelo Recursos Aumentados
        $model = new RecursosAumentados();
        

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            // Asignar los archivos cargados a las propiedades del modelo:
            //Se obtienen las instancias de los archivos cargados (archivo1, archivo2, texturas y música) para cada escena 
            //Y se asignan a las propiedades correspondientes del modelo modeles.
            //UploadedFile::getInstance() se usa para obtener un solo archivo.
            //UploadedFile::getInstances() se usa para obtener múltiples archivos 
            $model->{"archivo1"} = UploadedFile::getInstance($model, "archivo1");
            $model->{"archivo2"} = UploadedFile::getInstance($model, "archivo2");
            $model->{"textures"} = UploadedFile::getInstances($model, "textures"); // Para múltiples archivos
            $model->{"musica"} = UploadedFile::getInstance($model, "musica");

            $filePaths = $model->upload();

            // Almacenar las rutas en los campos de la base de datos
            if (isset($filePaths["archivo1"])) {
                $model->r_archivo1 = $filePaths["archivo1"];
            }
            
            if (isset($filePaths["archivo2"])) {
                $model->r_archivo2 = $filePaths["archivo2"];
            }
            if (isset($filePaths["musica"])) {
                $model->r_musica = $filePaths["musica"];
            }
            //Almacenar los demas campos en la base de datos
            $model->tipoar = $model->tipoarchivo;
            $model->nombre = $model->nomb;
            $model->descripcion = $model->desc;
            $model->id_asignatura = $asigid;

            //Obtengo la informacion del marcador(rutas del marcador y patron) y las almaceno en la base de datos
            $markerInfo = $this->getMarker();
            $model->marker=$markerInfo['marker'];
            $model->pattern=$markerInfo['pattern'];

            //$modeles->save(false);

            // Intentar guardar el modelo
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Recurso aumentado guardado exitosamente.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Hubo un error al guardar el recurso aumentado. Inténtalo de nuevo.');
                    // Redireccionar al usuario a site/index
                    return $this->redirect(['site/index']);
            }
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    //Accion para reproducir el recurso aumentado
    public function actionReproducirRecurso(){

        // Recuperar los parametros enviados a traves del GET
        $tipoar = Yii::$app->request->get('tipoar');
        $music = Yii::$app->request->get('music');
        $pattern = Yii::$app->request->get('pattern');
        $archivo1 = Yii::$app->request->get('archivo1');
        $archivo2 = Yii::$app->request->get('archivo2');
        $musica = Yii::$app->request->get('musica');


        if($music==="true"){
        switch ($tipoar) {
            case "glb": return $this->render('glbmusic', ['archivo1'=>$archivo1, 'musica'=>$musica, 'pattern'=>$pattern]);
                break;
            case "gltf": return $this->render('glbmusic', ['archivo1'=>$archivo1, 'musica'=>$musica, 'pattern'=>$pattern]);
                break; 
            case "obj": return $this->render('objmusic', ['archivo1'=>$archivo1, 'archivo2'=>$archivo2 ,'musica'=>$musica, 'pattern'=>$pattern]);
                break;
            case "jpg": return $this->render('imgmusic', ['archivo1'=>$archivo1, 'musica'=>$musica, 'pattern'=>$pattern]);
                break;  
            case "png": return $this->render('imgmusic', ['archivo1'=>$archivo1, 'musica'=>$musica, 'pattern'=>$pattern]);
                break;
        }
        }else{
        switch ($tipoar) {
            case "glb": 
                //$this->layout = false;
                return $this->render('glb', ['archivo1'=>$archivo1, 'pattern'=>$pattern]);
                break;
            case "gltf": return $this->render('glb', ['archivo1'=>$archivo1, 'pattern'=>$pattern]);
                break;
            case "obj": return $this->render('obj', ['archivo1'=>$archivo1, 'archivo2'=>$archivo2, 'pattern'=>$pattern]);
                break;
            case "jpg": return $this->render('img', ['archivo1'=>$archivo1, 'pattern'=>$pattern]);
                break;
            case "png": return $this->render('img', ['archivo1'=>$archivo1, 'pattern'=>$pattern]);
                break;
                case "mp4": return $this->render('mp4', ['archivo1'=>$archivo1, 'pattern'=>$pattern]);
                break;
        }
        }
    }

    /**
     * Updates an existing RecursosAumentados model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate(false)) {
            $model->nombre = $model->nomb;
            $model->descripcion = $model->desc;
            $model->save(false);
            Yii::$app->session->setFlash('success', 'Recurso aumentado actualizado exitosamente.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RecursosAumentados model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
        public function actionDelete($id)
        {
            $model = $this->findModel($id);
            $asigid = $model->id_asignatura;

            $model->delete();

            // Encriptar $asigid antes de redirigir
            $usuario = Yii::$app->user->identity->id;
            $oUser = \app\models\Usuarios::findOne(['id' => $usuario]);
            $encryptedAsigid = Yii::$app->security->encryptByPassword($asigid, $oUser->password);

            Yii::$app->session->setFlash('success', 'Recurso aumentado eliminado exitosamente.');
            return $this->redirect(['index', 'asigid' => $encryptedAsigid]);
        }



    /**
     * Finds the RecursosAumentados model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RecursosAumentados the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RecursosAumentados::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



    public function getMarker(){
            $markerData = [
                'marker' => 'uploads/markers/marcador.png',
                'pattern' => 'uploads/patterns/marcador.patt'
            ];
        return $markerData;
    }
}
