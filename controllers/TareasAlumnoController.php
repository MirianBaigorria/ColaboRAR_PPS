<?php

namespace app\controllers;

use Yii;
use app\models\TareasAlumno;
use app\models\TareasAlumnoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Tareas;
use app\models\Usuarios;


/**
 * TareasAlumnoController implements the CRUD actions for TareasAlumno model.
 */
class TareasAlumnoController extends Controller
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
     * Lists all TareasAlumno models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TareasAlumnoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TareasAlumno model.
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
     * Creates a new TareasAlumno model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TareasAlumno();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TareasAlumno model.
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
     * Deletes an existing TareasAlumno model.
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
     * Finds the TareasAlumno model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TareasAlumno the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TareasAlumno::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAsignarNota($tareas_id, $alumno_id)
    {
        // Buscar la tarea y el alumno
        $tarea = Tareas::findOne($tareas_id);
        $alumno = Usuarios::findOne($alumno_id);
    
        // Crear o buscar una entrada en tareas_alumnos
        $tareaAlumno = TareasAlumno::findOne(['tareas_id' => $tareas_id, 'usuarios_id' => $alumno_id]);
    
        if (!$tareaAlumno) {
            $tareaAlumno = new TareasAlumno();
            $tareaAlumno->tareas_id = $tareas_id;
            $tareaAlumno->usuarios_id = $alumno_id;
        }
    
        // Si los datos del formulario fueron enviados y son válidos, guarda el modelo
        if (Yii::$app->request->post()) {
            // Cargar los datos y guardar la nota
            if ($tareaAlumno->load(Yii::$app->request->post()) && $tareaAlumno->save()) {
                
                // Obtener la nota ingresada en el formulario
                $nota = $tareaAlumno->nota;
    
                // Calcular el nuevo puntaje: (nota * puntaje de la tarea)
                $tarea_puntaje = $tarea->puntaje_tarea ?: 0;  // Si el puntaje de la tarea es nulo, lo predeterminamos a 0
                $nuevo_puntaje = ($nota * $tarea_puntaje);
    
                // Sumar el nuevo puntaje al puntaje actual del alumno
                $alumno->puntaje += $nuevo_puntaje;
    
                // Guardar el puntaje actualizado del alumno
                if ($alumno->save(false)) {
                    Yii::$app->session->setFlash('success', 'Nota asignada y puntaje actualizado correctamente.');
                     // Llamar al método para verificar todos los desafíos de notas
                Yii::$app->runAction('desafios/verificar-nota-desafios', [
                    'usuario_id' => $alumno_id,
                    'tareas_id' => $tareas_id
                ]); 


                } else {
                    Yii::$app->session->setFlash('error', 'Error al actualizar el puntaje del alumno.');
                    var_dump($alumno->errors);  // Ver errores si falló la actualización
                }
    
                return $this->redirect(['/tareas/view', 'id' => $tareas_id]);
            }
        }
    
        return $this->render('asignar-nota', [
            'tarea' => $tarea,
            'alumno' => $alumno,
            'tareaAlumno' => $tareaAlumno,
        ]);
    }

    


    
    
}
