<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
$tipoUsuario = ($tipo == 'a') ? 'Alumnos' : (($tipo == 'd') ? 'Docentes' : (($tipo == 'm') ? 'Administradores' : 'Usuarios'));
$this->title = $tipoUsuario;
$rolesUsuario = Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id);
?>
<div class="usuarios-index">

<h2 class="perfil-title"><?= Html::encode($this->title) ?><span>.</span></h2>

<?php
if (array_key_exists('administrador', $rolesUsuario)) {

    ?>
    <p><p>Da de alta a algún <?= $tipoUsuario ?> y gestiona su información desde esta sección. Aquí podrás consultar y editar los datos de cada estudiante, como su nombre, apellido, correo electrónico, estilo de aprendizaje, personalidad y país de origen. Además, tienes la opción de filtrar y ordenar la lista según tus necesidades, y gestionar acciones como ver detalles del alumno, editar su información o eliminarlo.</p></p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a("Crear " . $tipoUsuario, ['create', 't' => $tipo], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    
    // GridView para Administradores
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'username',
             //'password',
            'nombre',
            'apellido',
            //'tipo:boolean',
            (array_key_exists('administrador', $rolesUsuario)) ? 'tipo' : 
            'tipo',
            'email',
            'estiloaprendizaje',
            [
                'attribute' => 'personalidad',
                'label' => 'Personalidad',
                'format' => 'html',
                'value' => function($data){
                    $personalidad = '';
                    if (isset($data->personalidad) && strlen($data->personalidad) > 0) {
                        list($extra, $agrea, $consc, $neuro, $openn) = explode(",", $data->personalidad);
                        $extra = explode(':', $extra);
                        $agrea = explode(':', $agrea);
                        $consc = explode(':', $consc);
                        $neuro = explode(':', $neuro);
                        $openn = explode(':', $openn);
                        $personalidad = "Extroversión: " . $extra[1] . "<br/>";
                        $personalidad .= "Afabilidad: " . $agrea[1] . "<br/>";
                        $personalidad .= "Excrupulosidad: " . $consc[1] . "<br/>";
                        $personalidad .= "Neuroticismo: " . $neuro[1] . "<br/>";
                        $personalidad .= "Apertura: " . $openn[1] . "<br/>";
                    }
                    return $personalidad;
                }
            ],
            [
                'attribute' => 'pais_idpais',
                'label' => 'País',
                'value' => function($data) {
                    return app\models\Pais::getNombrePorId($data->pais_idpais);
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
        //Para agregar un logo de busqueda a la fila a la primera celda de la fila de busqueda por filtros
        'filterRowOptions' => [
            'id' => 'w0-filters', // Esto es por si quieres apuntar específicamente a esta fila
            'class' => 'custom-filter-row', // Agregar una clase para personalización
            ],
    ]);
} elseif (array_key_exists('profesor', $rolesUsuario)) {
    // GridView para Docentes
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'username',
            'nombre',
            'apellido',
            //'email',
            'institucion',
            'estiloaprendizaje',
            [
                'attribute' => 'personalidad',
                'label' => 'Personalidad',
                'format' => 'html',
                'value' => function($data){
                    $personalidad = '';
                    if (isset($data->personalidad) && strlen($data->personalidad) > 0) {
                        list($extra, $agrea, $consc, $neuro, $openn) = explode(",", $data->personalidad);
                        $extra = explode(':', $extra);
                        $agrea = explode(':', $agrea);
                        $consc = explode(':', $consc);
                        $neuro = explode(':', $neuro);
                        $openn = explode(':', $openn);
                        $personalidad = "Extroversión: " . $extra[1] . "<br/>";
                        $personalidad .= "Afabilidad: " . $agrea[1] . "<br/>";
                        $personalidad .= "Excrupulosidad: " . $consc[1] . "<br/>";
                        $personalidad .= "Neuroticismo: " . $neuro[1] . "<br/>";
                        $personalidad .= "Apertura: " . $openn[1] . "<br/>";
                    }
                    return $personalidad;
                }
            ],
            [
                'attribute' => 'pais_idpais',
                'label' => 'País',
                'value' => function($data) {
                    return app\models\Pais::getNombrePorId($data->pais_idpais);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
                'buttons' => [
                    'view' => function($url, $model) {
                        $contenido = '<span class="glyphicon glyphicon-eye-open"></span>';
                        return Html::a($contenido, ['usuarios/view', 'id' => $model->id], ['title' => 'Ver']);
                    },
                    'delete' => function($url, $model) {
                        $contenido = '<span class="glyphicon glyphicon-trash"></span>';
                        return Html::a($contenido, ['usuarios/delete', 'id' => $model->id, 't'=>'a'], [
                            'title' => 'Eliminar',
                            'data' => [
                                'confirm' => '¿Seguro que quiere eliminar este usuario?',
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
}
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