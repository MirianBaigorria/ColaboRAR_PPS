<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Tareas */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Crear actividad con Realidad Aumentada';
$this->params['breadcrumbs'][] = ['label' => 'Tareas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


//JS y CSS de select2
$this->registerCssFile('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
$this->registerJsFile('https://code.jquery.com/jquery-3.6.0.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile('https://unpkg.com/sweetalert/dist/sweetalert.min.js', ['position' => View::POS_HEAD]);

?>

<h2 class="perfil-title"><?= Html::encode($this->title) ?><span>.</span></h1>
<div class="tareas-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'nombre_t')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'consigna')->textarea() ?>

    <?= $form->field($model, 'descripcion')->textarea() ?>

    <?= $form->field($model, 'year')->textInput(['value' => $asignaturaYear, 'readonly' => true]) ?>

    <?= $form->field($model, 'usar_sentencias_apertura')->radioList(['1' => 'Sí', '0' => 'No'], ['value' => '0']) ?>

    <?= $form->field($model, 'reportar_estado_animo')->radioList(['1' => 'Sí', '0' => 'No'], ['value' => '0']) ?>

    <?= $form->field($model, 'reportar_conflicto')->radioList(['1' => 'Sí', '0' => 'No'], ['value' => '0']) ?>
    

    <div id="ra-modo-container" style="margin-top: 20px">
        <?= $form->field($model, 'modo_ra')->radioList(['1' => 'Manual', '0' => 'Aleatorio'],['value' => '0']) ?>

        <div id="ra-modo-manual-container" style="display:none;">
            
            <?php foreach ($grupos as $id => $nombre): //Para cada grupo del arreglo grupos?>
                <div class="emparejamiento" style="margin-top: 10px;">
                    <label><?= Html::encode($nombre) //Se crea la etiqueta del Grupo?></label>
                    <?= Html::dropDownList(
                        "emparejamientos[$id][]",       // nombre del select con el id de cada uno de los grupos
                        null,                         // valor seleccionado por defecto
                    $recursos, // opciones del select, que en este caso es el arreglo recursos
                        ['multiple'=>  true,
                        'class' => 'select-multiple']   //
                    ) ?>
                </div>
            <?php endforeach; ?>
            <p style="margin-top: 10px;"><b>Nota:</b> Se pueden seleccionar hasta 4 recursos por chat de grupo.</p>
        </div>

    <div id="ra-modo-aleatorio-container" style="display:none;">
        <?= Html::dropDownList(
            'recursos_seleccionados[]',   // name como array
            [],                           // valores seleccionados por defecto (vacío al inicio)
            $recursos,                    // opciones: [id => nombre]
            [
                'multiple' => true,       // permite seleccionar varios
                'class' => 'select-multiple2'
            ]
        ) ?>
        <p style="margin-top: 10px;"><b>Nota:</b> Se pueden seleccionar hasta 8 recursos pero solo se pueden asignar un maximo de 4 por chat de grupo.</p>
        <div class="form-group" style="margin-top: 15px;">
            <label for="cantidadxchat">Cantidad de recursos por chat:</label>
            <?= Html::input('number', 'cantidadxchat', null, [
                'min' => 1,
                'max' => 4,
                'class' => 'form-control',
                'style' => 'width: 100px;',
                'id' => 'cantidadxchat'
            ]) ?>
            <small class="form-text text-muted">Debe estar entre 1 y 4.</small>
        </div>
    </div>

    </div>
   

    <div class="form-group" style="margin-top: 20px;">
        <?= Html::submitButton('Guardar', ['class' => 'button-g2']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<script>
    // Lógica para mostrar/ocultar los contenedores de modo según la selección de modo_ra
    document.addEventListener('DOMContentLoaded', function () {
        const modoRadios = document.querySelectorAll('input[name="Tareas[modo_ra]"]');
        const modoContainerManual = document.getElementById('ra-modo-manual-container');
        const modoContainerAleatorio = document.getElementById('ra-modo-aleatorio-container');

        function toggleModosRa() {
            modoContainerManual.style.display = 'none';
            modoContainerAleatorio.style.display = 'none';
            const selectedRadio = document.querySelector('input[name="Tareas[modo_ra]"]:checked');
            if (selectedRadio && selectedRadio.value === '1') {
                modoContainerManual.style.display = 'block';
            } else {
                modoContainerAleatorio.style.display = 'block';
            }
        }


        // Inicializar al cargar la página
        toggleModosRa();

        // Escuchar cambios en los radios
        modoRadios.forEach(radio => {
            radio.addEventListener('change', toggleModosRa);
        });
    });
</script>


<?php
//JS de select2 para el dropdownlist select-multiple
$this->registerJs("
    $('.select-multiple').select2({
        maximumSelectionLength: 4,
        placeholder: 'Selecciona uno o más recursos',
        allowClear: true,
        width: '100%',
        language: {
            maximumSelected: function (args) {
                return 'Solo puedes seleccionar hasta ' + args.maximum + ' recursos.';
            }
        }
    });
");

//JS de select2 para el dropdownlist select-multiple2
$this->registerJs("
    $('.select-multiple2').select2({
        maximumSelectionLength: 8,
        placeholder: 'Selecciona uno o más recursos',
        allowClear: true,
        width: '100%',
        language: {
            maximumSelected: function (args) {
                return 'Solo puedes seleccionar hasta ' + args.maximum + ' recursos.';
            }
        }
    });
");

//JS para que no se envien campos de seleccion de recursos vacios en select-multiple
$this->registerJs("
    $('form').on('submit', function(e) {
        let valid = true;
        let mensaje = '';

        $('.select-multiple:visible').each(function() {
            const valor = $(this).val();

            if (!valor || valor.length === 0) {
                valid = false;
                const label = $(this).closest('.emparejamiento').find('label').text();
                mensaje += '• El grupo \"' + label + '\" debe tener al menos un recurso seleccionado.\\n';
            }
        });

        if (!valid) {
            e.preventDefault();
            swal({
                title: 'Error',
                text: mensaje,
                icon: 'error',
                button: 'Aceptar'
            });
            return false;
        }
    });
");


//JS para que no se envie el campo de seleccion de recusos en select-multiple2 o cantidadxchat vacios y que cantidadxchat sea < a la cantidad de recursos seleccionados
$this->registerJs("
    $('form').on('submit', function(e) {
        let valid = true;
        let mensaje = '';

        const modoRA = $('input[name=\"Tareas[modo_ra]\"]:checked').val();

        if (modoRA === '0') {
            const recursosSeleccionados = $('.select-multiple2').val() || [];
            const cantidad = parseInt($('#cantidadxchat').val());

            // Validar selección de recursos
            if (recursosSeleccionados.length === 0) {
                valid = false;
                mensaje += '• Debes seleccionar al menos un recurso.\\n';
            }

            // Validar cantidadxchat
            if (isNaN(cantidad) || cantidad < 1 || cantidad > 4) {
                valid = false;
                mensaje += '• La cantidad de recursos por chat debe estar entre 1 y 4.\\n';
            }

            // Validar que cantidadxchat no sea mayor que la cantidad de recursos seleccionados
            if (cantidad > recursosSeleccionados.length) {
                valid = false;
                mensaje += '• La cantidad de recursos por chat no puede ser mayor que la cantidad de recursos seleccionados.\\n';
            }
        }

        if (!valid) {
            e.preventDefault();
            swal({
                title: 'Error',
                text: mensaje,
                icon: 'error',
                button: 'Aceptar'
            });
            return false;
        }
    });
");

?>


