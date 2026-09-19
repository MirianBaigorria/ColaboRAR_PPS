<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AsignaturasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $oUser app\models\Usuarios */ // Añadir esta línea para definir el tipo de $oUser

$this->title = 'Asignaturas';
$this->params['breadcrumbs'][] = $this->title;
$rolesUsuario = Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id);
?>
<div class="asignaturas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= (array_key_exists('administrador', $rolesUsuario)) ? Html::a('Crear Asignatura', ['create'], ['class' => 'btn btn-success']) : '' ?>
    <!--Boton para crear que el profesor pueda crear asignatura-->
        <?= (array_key_exists('profesor', $rolesUsuario)) ? Html::a('Crear Asignatura', ['create-profesor'], ['class' => 'btn btn-success']) : '' ?>
    </p>

    <?php
    if ($esAdministrador) {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'nombre',
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
    } else {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                ($esAdministrador) ?
                        'nombre' :
                        //Bloque cambiado
                        [
                            'attribute' => 'nombre_asignatura', // Atributo que se utilizara para el filtrado
                            'label' => 'Nombre de Asignatura',
                            //callback (función anónima) que se ejecuta para determinar qué valor debe mostrarse en la columna para cada fila
                            'value' => function($data) {
                                // Si no es administrador, usamos la función getNombrePorId
                                return \app\models\Asignaturas::getNombrePorId($data->asignaturas_id);
                            },
                            //Este es el campo de entrada (input) para filtrar la columna. 
                            //En lugar de usar un filtro estándar para el atributo nombre_asignatura, aquí se está creando un campo de texto manualmente.
                            //$searchModel es el modelo de búsqueda (AsignaturasDocentesSearch), que maneja la lógica de filtrado.
                            //'nombre_asignatura' es el atributo del modelo de búsqueda que se utiliza para realizar la búsqueda (este es el alias que has definido para filtrar por el nombre de la asignatura).
                            'filter' => Html::activeInput('text', $searchModel, 'nombre_asignatura', [
                                'class' => 'form-control', // Esto es para que el campo de filtro sea un input de texto
                                'placeholder' => 'Buscar por nombre de asignatura'
                            ]),
                        ],
                        //Para que se mueste el año de la asignatura
                        [
                            'attribute' => 'year_asignatura', // Atributo que se utilizara para el filtrado
                            'label' => 'Año',
                            //callback (función anónima) que se ejecuta para determinar qué valor debe mostrarse en la columna para cada fila
                            'value' => function($data) {
                                // Si no es administrador, usamos la función getNombrePorId
                                return \app\models\Asignaturas::getYearPorId($data->asignaturas_id);
                            },
                        ],
                        //Fin de boque cambiado
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{actividades}  {grupos}  {view}  {update}  {delete}  {alumnos}  {asociar} {recursosau}',
                    'buttons' => [
                        'actividades' => function($data, $model) use ($oUser) {
                                return Html::a('Actividades', ['tareas/index', 'asigid' => Yii::$app->security->encryptByPassword($model->asignaturas_id, $oUser->password)], ['target' => '_blank']);

                        },
                        'grupos' => function($url, $model) use ($oUser){
                            return ' | ' .Html::a('Grupos', ['grupos/index', 'asigid' => Yii::$app->security->encryptByPassword($model->asignaturas_id, $oUser->password)], ['target' => '_blank']);

                        },
                        'view' => function($data, $model) use ($oUser){
                            // Si el docente es auxiliar(tipo==1), no muestra nada
                            if ($model->tipo==1) {
                                return '';
                            } else {
                                return ' | ' .Html::a('Ver Asignatura', ['asignaturas/view', 'id' => Yii::$app->security->encryptByPassword($model->asignaturas_id, $oUser->password)], ['target' => '_blank']);
                                
                            }
                        },
                        'update' => function($data, $model) use ($oUser){
                            // Si el docente es auxiliar(tipo==1), no muestra nada
                            if ($model->tipo==1) {
                                return '';
                            } else {
                                return ' | ' .Html::a('Editar Asignatura', ['asignaturas/update', 'id' => Yii::$app->security->encryptByPassword($model->asignaturas_id, $oUser->password)], ['target' => '_blank']);
                            }
                        },
                        'delete' => function($data, $model) use ($oUser) {
                            // Si el docente es auxiliar(tipo==1), no muestra nada
                            if ($model->tipo==1) {
                                return '';
                            } else {
                                return ' | ' .Html::a('Eliminar Asignatura', ['asignaturas/delete-logico', 'id' => Yii::$app->security->encryptByPassword($model->asignaturas_id, $oUser->password)]);
                            }
                        },
                        'alumnos' => function($data, $model) use ($oUser){
                            // Si el docente es auxiliar(tipo==1), no muestra nada
                            if ($model->tipo==1) {
                                return '';
                            } else {
                                return ' | ' .Html::a('Asociar Alumnos a Asignatura', ['asignaturas-alumnos/index', 'asigid' => Yii::$app->security->encryptByPassword($model->asignaturas_id, $oUser->password)],['target' => '_blank']);
                            }
                        },
                        'asociar' => function($data, $model) use ($oUser){
                            // Si el docente es auxiliar(tipo==1), no muestra nada
                            if ($model->tipo==1) {
                                return '';
                            } else {
                                return ' | ' .Html::a('Asociar Profesor a Asignatura', ['asignaturas-docentes/create-profesor-aux', 'id' => $model->asignaturas_id], ['target' => '_blank']);
                            }
                        },
                        'recursosau' => function($data, $model) use ($oUser) {
                            return ' | ' .Html::a('Recursos Aumentados', ['recursos-aumentados/index', 'asigid' => Yii::$app->security->encryptByPassword($model->asignaturas_id, $oUser->password)], ['target' => '_blank']);

                        },

                    ],
                ],
            ],
        //Para agregar un logo de busqueda a la fila a la primera celda de la fila de busqueda por filtros
        'filterRowOptions' => [
            'id' => 'w0-filters', // Esto es por si quieres apuntar específicamente a esta fila
            'class' => 'custom-filter-row', // Agregar una clase para personalización
            ],
        ]);
    }
    ?>


</div>

<?php
//Javascript para agregar el logo de busqueda

$this->registerJs(
    "
    $(document).ready(function() {
        // Generar la URL correcta para la imagen
        var imageUrl = '" . Yii::$app->urlManager->baseUrl . "/images/logo_busqueda.png';
        
        // Insertar una imagen en la primera celda de la fila de filtros
        $('#w0-filters td:first-child').html('<img src=\"' + imageUrl + '\" alt=\"Imagen de Filtro\" style=\"width: 30px; height: 30px;\" loading=\"lazy\">');
    });
    ",
    \yii\web\View::POS_END // Esto coloca el script al final del body
);
?>