<?php
use yii\helpers\Html;

$this->title = 'Crear Actividad';
$this->params['breadcrumbs'][] = ['label' => 'Asignaturas', 'url' => ['asignaturas/index', 'asigid' => $asigid]];

/* Variables que determinarán qué tipo de actividad se elige */
$tipoGrupal = 'grupal';
$tipoGamificado = 'gamificado';
$tipoCuestionarioEvaluativo = 'cuestionarioevaluativo';
$tipoRealidadAumentada='realidadaumentada';
?>

<div class="container d-flex flex-column align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="text-center">
        <h2 class="perfil-title"><?= Html::encode($this->title) ?><span>.</span></h2>
        <p class="text-secondary">Crea una actividad para tu asignatura.</p>
    </div>

    <div class="row align-items-center justify-content-center text-center w-100 cont">
       

        <!-- Actividad Grupal -->
        <div class="col-md-4">
            <?= Html::a(
                '<div class="card shadow-sm h-100 hover-card">
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <img src="' . Yii::$app->request->baseUrl . '/images/iconos/grupal.png" class="card-icon" alt="Icono Grupal">
                    </div>
                    <div class="card-footer text-center">
                        <h5 class="text-primary">Actividad Colaborativa</h5>
                        <p class="text-description">Todos los miembros deben trabajar juntos para alcanzar un objetivo común.</p>
                    </div>
                </div>',
                ['create', 'asigid' => $asigid, 'tipoactividad' => $tipoGrupal],
                ['class' => 'text-decoration-none']
            ) ?>
        </div>


        
        <!-- Actividad Grupal -->
        <div class="col-md-4">
            <?= Html::a(
                '<div class="card shadow-sm h-100 hover-card">
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <img src="' . Yii::$app->request->baseUrl . '/images/iconos/prioridad.png" class="card-icon" alt="Icono Grupal">
                    </div>
                    <div class="card-footer text-center">
                        <h5 class="text-primary">Actividad Gamificada</h5>
                        <p class="text-description">Crea un entorno motivador donde los estudiantes participan en eventos interactivos, obtienen puntajes por colaborar y compiten sanamente en un ranking.</p>
                    </div>
                </div>',
                ['create', 'asigid' => $asigid, 'tipoactividad' => $tipoGamificado],
                ['class' => 'text-decoration-none'] 
            ) ?>
        </div>

                <!-- Actividad Grupal con RA -->
        <div class="col-md-4">
            <?= Html::a(
                '<div class="card shadow-sm h-100 hover-card">
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <img src="' . Yii::$app->request->baseUrl . '/images/iconos/realidadaumentada.png" class="card-icon" alt="Icono RA">
                    </div>
                    <div class="card-footer text-center">
                        <h5 class="text-primary">Actividad Colaborativa con Realidad Aumentada</h5>
                        <p class="text-description">Los miembros colaboran 
                        utilizando recursos aumentados que superponen elementos digitales al entorno real.</p>
                    </div>
                </div>',
                ['grupos-ra', 'asigid' => $asigid, 'tipoactividad' => $tipoRealidadAumentada],
                ['class' => 'text-decoration-none']
            ) ?>
        </div>
    </div>
</div>

<?php
$this->registerCss("

    /* Contenedor de las cards */
    .cont {
        display: flex;
        gap: 20px;
        justify-content: center;
        margin-top: 50px;
    }

    /* Estilos generales de las cards */
    .card {
        background-color: #fff;
        border-radius: 10px;
        border: none;
        transition: all 0.3s ease-in-out;
        cursor: pointer;
        height: 400px;
    }

    /* Efecto hover para levantar la card */
    .hover-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    /* Icono dentro de la card */
    .card-icon {
        width: 120px;
        height: 120px;
        object-fit: contain;
    }

    /* Estilo para el título de la actividad */
    .text-primary {
        color: #2C4251;
        font-weight: 600;
    }

    /* Estilo para la descripción */
    .text-description {
        color: #555;
        font-size: 14px;
        padding: 10px 20px;
    }

    /* Fondo blanco para el área del título y descripción */
    .card-footer {
        background-color: #fff;
        padding: 20px;
        border-top: 1px solid #ddd;
        border-radius: 0 0 10px 10px;
    }

    /* Fondo naranja de la card */
    .card-body {
        background-color: #FD8916;
        border-radius: 10px 10px 0 0;
        height: 250px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Texto principal */
    .perfil-title {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    /* Texto secundario */
    .text-secondary {
        color: #C1C1C1;
        font-weight: 400;
    }

");
