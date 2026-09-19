<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GruposSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$usuario = Yii::$app->user->identity->id;
$oUser = \app\models\Usuarios::findOne(['id' => $usuario]);

$this->title = 'Grupos Formados en ' . app\models\Asignaturas::findOne(['id' => $asigid])->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Asignaturas', 'url' => ['asignaturas/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grupos-index">

    <h2 class="perfil-title"><?= Html::encode($this->title) ?><span>.</span></h2>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        En esta sección, se crean los grupos a los cuales se les asignarán las actividades
        correspondientes. Lo que se usa para asignar actividades a los grupos es el <span style="font-weight:600; color:#FD8916;">Codigo de Grupo</span>. El codigo de grupo esta formado por: 
        <span style="font-weight:600; color:#FD8916;">Iniciales de la asignatura/Año-Numero de Grupo creado para esa asignatura-AA(generado por Estilos de Aprendizaje) o AM(generado Manualmente)</span>.
        Entonces por ejemplo, si tengo la asignatura "Base de Datos I" del 2025 y creo un cuarto grupo generado de manera manual el codigo sera: "BDI/2025-4-AM".
        
    </p>
    <p>
        <?= Html::a('Crear Grupos', ['create', 'asigid' => Yii::$app->security->encryptByPassword($asigid, $oUser->password)], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'codigo',
            'year',
            [
                'attribute' => 'metodos_formacion_id',
                'label' => 'Método de Formación',
                'value' => function($data) {
                    return app\models\MetodosFormacion::getNombrePorId($data->metodos_formacion_id);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
                'buttons' => [
                    'view' => function($url, $model) {
                        $contenido = '<span class="glyphicon glyphicon-eye-open"></span>';
                        return Html::a($contenido, ['grupos/view', 'id' => $model->id], ['title' => 'Ver']);
                    },
                    //Boton de delete agregado
                    'delete' => function($url, $model) {
                        $contenido = '<span class="glyphicon glyphicon-trash"></span>';
                        return Html::a($contenido, ['grupos/delete', 'id' => Yii::$app->security->encryptByPassword($model->id, Yii::$app->user->identity->password)], [
                            'title' => 'Eliminar',
                            'data' => [
                                'confirm' => '¿Estás seguro de que quieres eliminar este grupo?',
                                'method' => 'post',
                            ],
                        ]);
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
    ?>
</div>
<?php
//Javascript para agregar el logo de busqueda
$this->registerJs("
$(document).ready(function() {
    // Generar la URL correcta para la imagen
    var imageUrl = '" . Yii::$app->urlManager->baseUrl . "/images/logo_busqueda.png';
    
    // Insertar una imagen en la primera celda de la fila de filtros
    $('#w0-filters td:first-child').html('<img src=\"' + imageUrl + '\" alt=\"Imagen de Filtro\" style=\"width: 30px; height: 30px;\">');
});
");
?>