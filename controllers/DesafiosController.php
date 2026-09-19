<?php

namespace app\controllers;

use Yii;
use app\models\Desafios;
use app\models\DesafiosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Usuarios;  // Asegúrate de añadir esta línea
use app\models\DesafiosUsuarios;
use app\models\AsignaturasAlumnos;
use app\models\RangosUsuarios;
use app\models\Rangos;

/**
 * DesafiosController implements the CRUD actions for Desafios model.
 */
class DesafiosController extends Controller
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
     * Lists all Desafios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DesafiosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Desafios model.
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
     * Creates a new Desafios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Desafios();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Desafios model.
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
     * Deletes an existing Desafios model.
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
     * Finds the Desafios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Desafios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Desafios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    

    //Desafios de Rango Iniciado a Explorador
    //marcarDesafioCompletado(usuarios_id, desafios_id, nombre_desafio, conteo)

    //completar perfil con imagen ✅
    public function actionVerificarCompletarPerfil($usuario_id){
        $usuario = Usuarios::findOne($usuario_id);

        if( $usuario && ($usuario->foto_perfil != " " || $usuario->foto_perfil != NULL)){
            $this->marcarDesafioCompletado($usuario_id, 1 ,'Añade una foto de perfil a COLLAB', 1);
        }
        
    }

    //Verificar el primer mensaje enviado por el usuario ✅

    public function actionVerificarPrimerMensaje($usuario_id){
        $contarMensajes = (new \yii\db\Query())
            ->from('sentencias')
            ->where(['usuarios_id' => $usuario_id])
            ->count();
        
        if ($contarMensajes > 1) {
            $this->marcarDesafioCompletado($usuario_id, 2 ,'Enviar tu primer mensaje en cualquier chat disponible', $contarMensajes);
            if($contarMensajes >=10){
                $this->marcarDesafioCompletado($usuario_id, 4 ,'Envía 10 mensajes o más en el chat', $contarMensajes);
                
                if($contarMensajes >=30){
                    $this->marcarDesafioCompletado($usuario_id, 9 ,'Envía 30 mensajes o más en el chat', $contarMensajes);
                }
                if($contarMensajes >=50){
                    $this->marcarDesafioCompletado($usuario_id, 13 ,'Envía 50 mensajes o más en el chat', $contarMensajes);
                }
                if($contarMensajes >=200){
                    $this->marcarDesafioCompletado($usuario_id, 18 ,'Envía 200 mensajes o más en el chat', $contarMensajes);
                }
            }
           
        }
    }
    
   


    //este seria el TestFelderSilverman ✅
    public function actionVerificarPrimerTestAprendizaje($usuario_id){
        
        $testRealizado  = Usuarios::find($usuario_id)
        ->where(['id' => $usuario_id])
        ->andWhere(['is not', 'estiloaprendizaje', null])  // Verificar que no sea NULL
        ->exists();

        if ($testRealizado) {
            // Marcar el desafío como completado
            $this->marcarDesafioCompletado($usuario_id, 3 ,'Realizar tu primer test de Aprendizaje', 1);
        }

    }

    //verificar inscripcion a primera materia correcto
    public function actionVerificarAsociarPrimeraMateria($usuario_id)
    {
        $materias = AsignaturasAlumnos::find()->where(['usuarios_id' => $usuario_id])->count();
        echo($materias);
        if ($materias >= 1) {
            // Marcar el desafío como completado
            $this->marcarDesafioCompletado($usuario_id, 5 ,'Asociarte a tu primera materia en COLLAB', 1);
        }
    }


    public function actionVerificarCantidadActividadesRealizadas($usuario_id)
{
    // Buscar al usuario por su ID
    $usuario = Usuarios::findOne($usuario_id);

    if ($usuario->cont_actividades_grupales >= 4) {
        // Marca el desafío de 4 actividades grupales como completado
        $this->marcarDesafioCompletado($usuario_id, 10, 'Realiza 4 actividades grupales', $usuario->cont_actividades_grupales);

        if ($usuario->cont_actividades_grupales >= 6) {
            // Marca el desafío de 6 actividades grupales como completado
            $this->marcarDesafioCompletado($usuario_id, 11, 'Realiza 6 actividades grupales', $usuario->cont_actividades_grupales);
        }
        if ($usuario->cont_actividades_grupales >= 12) {
            // Marca el desafío de 12 actividades grupales como completado
            $this->marcarDesafioCompletado($usuario_id, 16, 'Realiza 12 actividades grupales', $usuario->cont_actividades_grupales);
        }
    }
}
    //Explorador 

    //desafio id 7, 12 y 17
    public function actionVerificarNotaDesafios($usuario_id, $tareas_id)
    {
        // Buscar el registro en tareas_alumnos
        $tareaAlumno = (new \yii\db\Query())
            ->from('tareas_alumnos')
            ->where(['usuarios_id' => $usuario_id, 'tareas_id' => $tareas_id])
            ->one();
    
        if ($tareaAlumno) {
            $nota = $tareaAlumno['nota'];
    
            // Desafío: Nota mayor a 7
            if ($nota >= 7) {
                $this->marcarDesafioCompletado($usuario_id, 7, 'Obtén una nota mayor a 7 en una actividad individual', 1);
            }
    
            // Desafío: Nota mayor a 8
            if ($nota >= 8) {
                $this->marcarDesafioCompletado($usuario_id, 12, 'Obtén una nota mayor a 8 en una actividad individual', 1);
            }
    
            // Desafío: Nota igual a 10
            if ($nota == 10) {
                $this->marcarDesafioCompletado($usuario_id, 17, 'Obtén una nota igual a 10 en una actividad individual', 1);
            }
        }
    }

     // desafio id 
    public function actionVerificarNotaMayorA8EnActividadGrupal($usuario_id, $grupos_formados_id)
        {

            $notaGrupo = (new \yii\db\Query())
                ->select('nota')
                ->from('chats')
                ->where(['grupos_formados_id' => $grupos_formados_id])
                ->andWhere(['>', 'nota', 8])
                ->scalar();

            // Si se encuentra una nota mayor a 8
            if ($notaGrupo) {
                $this->marcarDesafioCompletado($usuario_id, 15, 'Obtén una calificación mayor a 8 en una actividad grupal', 1);
            }
        }


        public function verificarYAsignarRango($usuario_id)
        {
            // Obtener el rango actual del usuario
            $rangoUsuario = RangosUsuarios::find()
                ->where(['usuarios_id' => $usuario_id])
                ->orderBy(['rangos_id' => SORT_DESC]) // Ordenar por el mayor rango
                ->one();
        
            $rangoActualId = $rangoUsuario ? $rangoUsuario->rangos_id : 0; // Si no tiene rango, empieza desde 0
        
            // Obtener el siguiente rango a asignar
            $siguienteRango = Rangos::findOne(['id' => $rangoActualId + 1]);
        
            if (!$siguienteRango) {
                Yii::info("No hay más rangos que asignar para el usuario $usuario_id.", __METHOD__);
                return; // No hay más rangos que asignar
            }
        
            // Obtener los desafíos necesarios para el rango siguiente
            $desafiosDelRango = Desafios::find()
                ->where(['rangos_id' => $siguienteRango->id])
                ->count();
        
            // Obtener cuántos desafíos ha completado el usuario para el siguiente rango
            $desafiosCompletados = DesafiosUsuarios::find()
                ->where(['usuarios_id' => $usuario_id, 'estado' => 'completado'])
                ->andWhere(['in', 'desafios_id', Desafios::find()->select('id')->where(['rangos_id' => $siguienteRango->id])])
                ->count();
        
            Yii::info("Usuario $usuario_id ha completado $desafiosCompletados de $desafiosDelRango desafíos requeridos para el rango $siguienteRango->nombre.", __METHOD__);
        
            // Si completó todos los desafíos, asignar el siguiente rango
            if ($desafiosCompletados >= $desafiosDelRango) {
                $nuevoRangoUsuario = new RangosUsuarios();
                $nuevoRangoUsuario->usuarios_id = $usuario_id;
                $nuevoRangoUsuario->rangos_id = $siguienteRango->id;
                $nuevoRangoUsuario->fecha_asignacion = date('Y-m-d H:i:s');
                
                if ($nuevoRangoUsuario->save()) {
                    Yii::info("Se asignó el rango $siguienteRango->nombre (ID: $siguienteRango->id) al usuario $usuario_id.", __METHOD__);
                } else {
                    Yii::error("Error al asignar el rango $siguienteRango->nombre al usuario $usuario_id. Errores: " . print_r($nuevoRangoUsuario->getErrors(), true), __METHOD__);
                }
            } else {
                Yii::info("Usuario $usuario_id no ha completado suficientes desafíos para el rango $siguienteRango->nombre.", __METHOD__);
            }
        }
        


    private function marcarDesafioCompletado($usuario_id, $desafios_id, $nombre_desafio, $contador_completados)
{
    $desafio = Desafios::findOne(['id' => $desafios_id]);
    
    if ($desafio) {
        $desafioUsuario = DesafiosUsuarios::findOne(['usuarios_id' => $usuario_id, 'desafios_id' => $desafio->id]);
        
        if (!$desafioUsuario) {
            // Crear un nuevo registro si no existe
            $desafioUsuario = new DesafiosUsuarios();
            $desafioUsuario->usuarios_id = $usuario_id;
            $desafioUsuario->desafios_id = $desafio->id;
            $desafioUsuario->contador_desafio_completado = $contador_completados;
            $desafioUsuario->estado = 'completado';
            $desafioUsuario->save();

             // Actualizar el puntaje del usuario sumando 1000 puntos
             $usuario = Usuarios::findOne(['id' => $usuario_id]);
             if ($usuario) {
                 $usuario->puntaje += 1000; // Sumar 1000 puntos
                 $usuario->save(); // Guardar los cambios
             }


            // Verificar si se debe asignar un nuevo rango
            $this->verificarYAsignarRango($usuario_id);
        }
    }
}





 






}