<?php

namespace app\controllers;

use Yii;
use app\models\Asignaturas;
use app\models\AsignaturasSearch;
use app\models\AsignaturasDocentes;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AsignaturasController implements the CRUD actions for Asignaturas model.
 */
class AsignaturasController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'update', 'delete', 'create', 'asignaturas-alumnos', 'create-profesor'],
                'rules' => [
                    [
                        'actions' => ['asignaturas-alumnos'],
                        'allow' => true,
                        'roles' => ['estudiante'],
                    ],
                    [
                        'actions' => ['index', 'view', 'update', 'delete', 'create', 'asignaturas-alumnos','create-profesor'],
                        'allow' => true,
                        'roles' => ['profesor'],
                    ],
                    [
                        'actions' => ['index', 'view', 'update', 'delete', 'create', 'asignaturas-alumnos','create-profesor'],
                        'allow' => true,
                        'roles' => ['administrador'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST', 'GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all Asignaturas models.
     * @return mixed
     */

     public function actionIndex()
     {
     
         // Obtener el ID del usuario (docente)
         $docente = Yii::$app->user->identity->id;
     
         // Obtener los roles del usuario (docente)
         $rolesUsuario = Yii::$app->authManager->getRolesByUser($docente);
     
         $esAdministrador = false;
     
         // Optimización: Cargar el usuario desde cache si ya existe, de lo contrario hacer la consulta
         $oUser = Yii::$app->cache->get('user_' . $docente);
         if ($oUser === false) {
             // Si no está en cache, obtener el usuario de la base de datos
             $oUser = \app\models\Usuarios::findOne(['id' => $docente]);
             // Guardar en caché por 3600 segundos (1 hora)
             Yii::$app->cache->set('user_' . $docente, $oUser, 3600);
         }
     
         // Comienza la lógica de negocio
         if (!array_key_exists('administrador', $rolesUsuario)) {
             $searchModel = new \app\models\AsignaturasDocentesSearch();
             $searchModel->usuarios_id = $docente;
     
             // Definir clave de caché única basada en el usuario
             $cacheKey = 'asignaturas_docentes_' . $docente . '_' . md5(serialize(Yii::$app->request->queryParams)); 
             
             // Verificar si ya existe el caché
             $dataProvider = Yii::$app->cache->get($cacheKey);
             
             if ($dataProvider === false) {
                 // Si no está en caché, ejecutar la consulta
                 $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                 
                 // Almacenar en caché durante 3600 segundos (1 hora)
                 Yii::$app->cache->set($cacheKey, $dataProvider, 3600);
             }
         } else {
             $esAdministrador = true;
             $searchModel = new \app\models\AsignaturasSearch();
             
             // Definir clave de cache única para administrador
             $cacheKey = 'asignaturas_admin_' . md5(serialize(Yii::$app->request->queryParams));
             
             // Verificar si ya existe el caché
             $dataProvider = Yii::$app->cache->get($cacheKey);
             
             if ($dataProvider === false) {
                 // Si no está en cache, ejecutar la consulta
                 $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                 
                 // Almacenar en caché durante 3600 segundos (1 hora)
                 Yii::$app->cache->set($cacheKey, $dataProvider, 3600);
             }
         }
     
         // Configurar la paginación para mostrar 10 elementos por página
         $dataProvider->pagination->pageSize = 10;
         
     
         // Devuelve la vista con los parámetros necesarios
         return $this->render('index', [
             'searchModel' => $searchModel,
             'dataProvider' => $dataProvider,
             'esAdministrador' => $esAdministrador,
             'oUser' => $oUser, // Pasar los datos del usuario a la vista
         ]);
     }
         
    
    
    
    public function actionAsignaturasAlumnos() {
        $usuario = Yii::$app->user->identity->id;
        $searchModel = new \app\models\AsignaturasAlumnosSearch();
        $searchModel->usuarios_id = $usuario;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('asignaturas-alumnos', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Asignaturas model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $usuario = Yii::$app->user->identity->id;
        $oUser = \app\models\Usuarios::findOne(['id' => $usuario]);
        $id = Yii::$app->security->decryptByPassword($id, $oUser->password);

        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionViewRedirect($id) {
        // Aquí $id ya está encriptado, lo que está bien
        return $this->redirect(['view', 'id' => $id]);
    }

    //Este view solo se renderiza cuando el profesor recien crea la asignatura
    public function actionViewCreate($id) {
        $usuario = Yii::$app->user->identity->id;
        $oUser = \app\models\Usuarios::findOne(['id' => $usuario]);
        $id = Yii::$app->security->decryptByPassword($id, $oUser->password);

        return $this->render('viewcreate', [
                    'model' => $this->findModel($id),
        ]);
    }


    /**
     * Creates a new Asignaturas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Asignaturas();
        $userid = Yii::$app->user->identity->id;
        $oUser = \app\models\Usuarios::findOne(['id' => $userid]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => Yii::$app->security->encryptByPassword($model->id, $oUser->password)]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    //Este metodo es para que un Profesor pueda crear una materia y que automaticamente se cree un registro AsignaturaDocentes que se asocie a el
    public function actionCreateProfesor() {
        $model = new Asignaturas();
        $userid = Yii::$app->user->identity->id;
        $oUser = \app\models\Usuarios::findOne(['id' => $userid]);
    
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Crear un nuevo registro en AsignaturasDocentes
            $asignaturaDocente = new AsignaturasDocentes();
            $asignaturaDocente->asignaturas_id = $model->id; // Asignar el ID de la asignatura
            $asignaturaDocente->usuarios_id = $userid; // Asignar el ID del usuario que creó la asignatura
            
            // Guardar el modelo de AsignaturasDocentes
            if ($asignaturaDocente->save()) {
                // Redirigir después de guardar
                return $this->redirect(['view-create', 'id' => Yii::$app->security->encryptByPassword($model->id, $oUser->password)]);
            } else {
                // Si no se puede guardar AsignaturasDocentes, tira el error
                Yii::$app->session->setFlash('error', 'No se pudo guardar esta asignatura.');
            }
        }
    
        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing Asignaturas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $usuario = Yii::$app->user->identity->id;
        $oUser = \app\models\Usuarios::findOne(['id' => $usuario]);
        $id = Yii::$app->security->decryptByPassword($id, $oUser->password);
    
        $model = $this->findModel($id);
    
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Encripta el ID antes de redirigir porque view espera un id encriptado
            $encryptedId = Yii::$app->security->encryptByPassword($model->id, $oUser->password);
            return $this->redirect(['view', 'id' => $encryptedId]);
        }
    
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdateRedirect($id) {
        // Aquí $id ya está encriptado, lo que está bien
        return $this->redirect(['update', 'id' => $id]);
    }
    

    /**
     * Deletes an existing Asignaturas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */ 
    public function actionDelete($id) {
        $usuario = Yii::$app->user->identity->id;
        $oUser = \app\models\Usuarios::findOne(['id' => $usuario]);
        $id = Yii::$app->security->decryptByPassword($id, $oUser->password);

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    //Elimina una asignatura de manera logica y no fisica. Es decir, cambia el valor del campo estado de la BD de 0=activo a 1=inactivo
    public function actionDeleteLogico($id) {
        $usuario = Yii::$app->user->identity->id;
        $oUser = \app\models\Usuarios::findOne(['id' => $usuario]);
        $id = Yii::$app->security->decryptByPassword($id, $oUser->password);

        $model = $this->findModel($id);
        $model->estado = 1;
        $model->save();

        return $this->redirect(['index']);
    }


    /**
     * Finds the Asignaturas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Asignaturas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Asignaturas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
