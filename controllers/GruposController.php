<?php

namespace app\controllers;

use Yii;
use app\models\Grupos;
use app\models\GruposAlumnos;
use app\models\GruposFormados;
use app\models\GruposSearch;
use app\models\Usuarios;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * GruposController implements the CRUD actions for Grupos model.
 */
class GruposController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
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

    /**
     * Lists all Grupos models.
     * @return mixed
     */
    public function actionIndex($asigid) {
        $usuario = Yii::$app->user->identity->id;
        $oUser = \app\models\Usuarios::findOne(['id' => $usuario]);
        $asigid = Yii::$app->security->decryptByPassword($asigid, $oUser->password);

        $searchModel = new GruposSearch();
        $searchModel->asignaturas_id = $asigid;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'asigid' => $asigid,
        ]);
    }


    /**
     * Displays a single Grupos model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    //Convierte un estilo de aprendizaje abreviado a un nombre de clase CSS para aplicar estilos visuales.
    function getEstilo($estilo) {
        $nestilo = '';
        switch (substr(trim($estilo), 0, 3)) {
            case 'ACT':
                $nestilo = 'activo';
                break;
            case 'REF':
                $nestilo = 'reflexivo';
                break;
            case 'NAR':
                // Neutral Activo Reflexivo
                $nestilo = 'neutral-ar';
                break;
            case 'SEN':
                $nestilo = 'sensitivo';
                break;
            case 'INT':
                $nestilo = 'intuitivo';
                break;
            case 'NSI':
                // Neutral Sensitivo Intuitivo
                $nestilo = 'neutral-is';
                break;
            case 'VIS':
                $nestilo = 'visual';
                break;
            case 'VER':
                $nestilo = 'verbal';
                break;
            case 'NVV':
                // Neutral Visual Verbal
                $nestilo = 'neutral-vv';
                break;
            case 'SEC':
                $nestilo = 'secuencial';
                break;
            case 'GLO':
                $nestilo = 'global';
                break;
            case 'NSG':
                //Neutral Secuencial Global
                $nestilo = 'neutral-sg';
                break;
        }
        return $nestilo;
    }

    /**
     * Creates a new Grupos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
    public function actionCreate($asigid) {
        $usuario = Yii::$app->user->identity->id;
        $oUser = \app\models\Usuarios::findOne(['id' => $usuario]);
        $asigid = Yii::$app->security->decryptByPassword($asigid, $oUser->password);

    // Consulta a la tabla Asignaturas para obtener el nombre y año
    $asignatura = \app\models\Asignaturas::findOne(['id' => $asigid]);
    if ($asignatura) {
        $asignaturaNombre = $asignatura->nombre;
        $asignaturaYear = $asignatura->year;
    } else {
        Yii::$app->session->setFlash('error', 'La asignatura no existe.');
        return $this->redirect(['index']); // Redirigir a index en caso de error
    }
    // Consulta a la tabla Grupos para obtener la cantidad de grupos para esta asignatura
    $cantidadGrupos = \app\models\Grupos::find()->where(['asignaturas_id' => $asigid])->count();
    
        $model = new Grupos();
        $model->asignaturas_id = $asigid;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->metodos_formacion_id == 1) {
                // Lógica para formar grupos manualmente
                $grupos = json_decode($model->alumnosPorGrupo);
                foreach ($grupos as $id => $alumnosGrupo) {
                    $objGrupo = new \app\models\GruposFormados();
                    $objGrupo->nombre = "Grupo " . ($id + 1);
                    $objGrupo->grupos_id = $model->id;
                    $objGrupo->save();
                    foreach ($alumnosGrupo as $indice => $miembro) {
                        $objAlumnoGrupo = new \app\models\GruposAlumnos();
                        $objAlumnoGrupo->usuarios_id = $miembro;
                        $objAlumnoGrupo->grupos_formados_id = $objGrupo->id;
                        $objAlumnoGrupo->save();
                    }
                }
            } elseif ($model->metodos_formacion_id == 2) {
                // Invocar al algoritmo genético
                $alumnosporyear = \app\models\AsignaturasAlumnos::getListaAlumnosPorYear($model->year, $model->asignaturas_id);
                $alumnos = [];
                foreach ($alumnosporyear as $alumnoInscripto) {
                    $estilos = explode('-', $alumnoInscripto['estiloaprendizaje']);
                    // Asegurar que siempre haya 4 elementos en el array
                    while (count($estilos) < 4) {
                        $estilos[] = 'NSG'; // o cualquier valor predeterminado
                    }
                    list($e1, $e2, $e3, $e4) = $estilos;
                    $estilo = $this->getEstilo($e1) . "," . $this->getEstilo($e2);
                    $estilo .= "," . $this->getEstilo($e3) . "," . $this->getEstilo($e4);
                    $alumnos[] = ['nombre' => $alumnoInscripto['usuarios_id'], 'ea' => $estilo];
                }
    
                if (!empty($alumnos)) {
                    $grupos = $model->optimizarAG($alumnos, $model->cantidadintegrantes);
                    if ($grupos && !empty($grupos["grupos"])) {
                        $cont = 1;
                        foreach ($grupos["grupos"] as $grupo) {
                            $objGrupo = new \app\models\GruposFormados();
                            $objGrupo->nombre = "Grupo $cont";
                            $objGrupo->grupos_id = $model->id;
                            $objGrupo->save();
                            foreach ($grupo as $miembro) {
                                $objAlumnoGrupo = new \app\models\GruposAlumnos();
                                $objAlumnoGrupo->usuarios_id = $alumnos[$miembro]["nombre"];
                                $objAlumnoGrupo->grupos_formados_id = $objGrupo->id;
                                $objAlumnoGrupo->save();
                            }
                            $cont += 1;
                        }
                    } else {
                        Yii::$app->session->setFlash('error', 'No se pudieron formar grupos.');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'No hay alumnos disponibles para formar grupos.');
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
    
        return $this->render('create', [
            'model' => $model,
            'asigid' => $asigid,
            'asignaturaNombre'=>$asignaturaNombre,
            'asignaturaYear'=>$asignaturaYear,
            'cantidadGrupos'=>$cantidadGrupos,
        ]);
    }
    
    

    /**
     * Updates an existing Grupos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Grupos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $usuario = Yii::$app->user->identity->id;
        $oUser = \app\models\Usuarios::findOne(['id' => $usuario]);
        $id = Yii::$app->security->decryptByPassword($id, $oUser->password);

        $model = $this->findModel($id); // Obtener el modelo ANTES de eliminarlo
        $asignaturas_id = $model->asignaturas_id; // Obtener el asignaturas_id

        $model->delete(); // Eliminar el modelo DESPUÉS de obtener el asignaturas_id

        return $this->redirect(['index', 'asigid' => Yii::$app->security->encryptByPassword($asignaturas_id, $oUser->password)]);
    }

    /**
     * Finds the Grupos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Grupos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Grupos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    
    public function actionCambiarAlumno($alumno_id, $grupo_id, $view)
    {
        $alumno = Usuarios::findOne($alumno_id);
        $grupoActual = GruposFormados::findOne($grupo_id); // Encuentra el modelo del grupo actual
    
        if ($alumno && $grupoActual) {

        //Se obtiene la cantidad máxima de integrantes del grupo principal. Como todos tienen la misma cantidad maxima de integrantes se puede usar de base.
        $cantidadMaximaIntegrantes = Grupos::findOne($grupoActual->grupos_id)->cantidadintegrantes;
        //Se construye la consulta
        // Encuentra todos los grupos formados disponibles con espacio, excluyendo el grupo actual
            $gruposDisponibles = GruposFormados::find()
            //Selecciona todos los grupos formados con su cantidad de integrantes
            ->select(['grupos_formados.*', 'COUNT(grupos_alumnos.usuarios_id) AS cantidad_alumnos'])
            //Realizamos la union entre grupos alumnos y grupos formados  por el id
            ->leftJoin('grupos_alumnos', 'grupos_formados.id = grupos_alumnos.grupos_formados_id')
            ->where(['grupos_formados.grupos_id' => $grupoActual->grupos_id])
            ->andWhere(['!=', 'grupos_formados.id', $grupo_id]) // Excluye el grupo actual
            //agrupa los resultados por el valor de la columna id en grupos_formados
            ->groupBy('grupos_formados.id')
            //Esta condición incluye solo los grupos formados donde el número de alumnos (cantidad_alumnos) es menor que la cantidad máxima permitida ($cantidadMaximaIntegrantes).
            ->having('cantidad_alumnos < :cantidad_maxima', [':cantidad_maxima' => $cantidadMaximaIntegrantes])
            ->all();
            
    
            $dynamicModel = new \yii\base\DynamicModel(['nuevo_grupo_formado_id']);
            $dynamicModel->addRule(['nuevo_grupo_formado_id'], 'required');
    
            if (Yii::$app->request->isPost) {
                $dynamicModel->load(Yii::$app->request->post());
                if ($dynamicModel->validate()) {
                    $nuevoGrupoFormadoId = $dynamicModel->nuevo_grupo_formado_id;
    
                    // Encuentra el registro del alumno en la tabla GruposAlumnos
                    $grupoAlumno = GruposAlumnos::findOne(['usuarios_id' => $alumno_id, 'grupos_formados_id' => $grupo_id]);
                    if ($grupoAlumno) {
                        $grupoAlumno->grupos_formados_id = $nuevoGrupoFormadoId;
                        if ($grupoAlumno->save()) {
                            // Redirigir a la vista del grupo original después de guardar
                            return $this->redirect(['grupos/view', 'id' =>  $view]);
                        }
                    }
                }
            }
    
            return $this->render('cambiar-alumno', [
                'alumno' => $alumno,
                'gruposDisponibles' => $gruposDisponibles,
                'grupoActual' => $grupoActual,
                'dynamicModel' => $dynamicModel,
            ]);
        } else {
            throw new NotFoundHttpException('El alumno o grupo no existe.');
        }
    }
    
    
    


}
