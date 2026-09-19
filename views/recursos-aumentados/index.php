<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RecursosAumentadosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Recursos Aumentados';
//$this->title = 'Recursos Aumentados de ' . app\models\Asignaturas::findOne(['id' => $asigid])->nombre;
$this->params['breadcrumbs'][] = $this->title;
$rolesUsuario = Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id);



?>
<div class="recursos-aumentados-index">

    <h2 class="perfil-title"><?= Html::encode($this->title) ?><span>.</span></h2>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

     <p>En esta sección, podrás cargar y gestionar recursos aumentados para tus clases.
        Estos recursos, pueden integrarse en actividades para reforzar conceptos, fomentar la exploración y enriquecer la experiencia de aprendizaje. </p>
    <p>
        <!--Boton para crear que el profesor pueda cargar recursos aumentados-->
        <?= (array_key_exists('profesor', $rolesUsuario)) ? Html::a('Cargar Recursos Aumentados', ['create', 'asigid' => $asigid], ['class' => 'btn btn-success']) : '' ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nombre',
            'descripcion',
            'tipoar',
            //'marker',
            //'pattern',
            //'r_archivo1',
            //'r_archivo2',
            //'r_musica',
            //'id_asignatura',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
