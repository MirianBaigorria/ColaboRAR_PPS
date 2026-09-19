<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Grupos */
/* @var $form yii\widgets\ActiveForm */
$recuperarAlumnos = Yii::$app->urlManager->createUrl(['asignaturas-alumnos/recuperar-alumnos']);
$script = <<< JS
    $(function () {
        //Declara una variable idasignatura y le asigna el valor de $asigid. Se asume que $asigid
        var idasignatura = $asigid;
        //Inicializa una variable cantidadContenedoresGrupo en 0. 
        // Esta variable se utilizará para almacenar la cantidad de contenedores de grupos que se crean dinámicamente.
        var cantidadContenedoresGrupo = 0;
        //Esta función se encarga de cargar la lista de alumnos de la asignatura mediante una petición AJAX.
        function recuperarAlumnos() {
            //Verifica que los campos "año" (#grupos-year) y "cantidad de integrantes" (#grupos-cantidadintegrantes) estén completos, 
            // sean números y que la cantidad de integrantes sea mayor a 1.       
            if ($('#grupos-year').val().length != 0 && $.isNumeric($('#grupos-year').val()) &&
                $('#grupos-cantidadintegrantes').val().length != 0 && $.isNumeric($('#grupos-cantidadintegrantes').val()) &&
                $('#grupos-cantidadintegrantes').val() > 1) {
                $('#contenedorAlumnos').html('');
                $('#contenedorGrupos').html('');
                //Realiza una petición AJAX a la URL $recuperarAlumnos (generada en PHP).
                //Envía el ID de la asignatura y el año como datos.
                //La función .done() se ejecuta cuando la petición AJAX es exitosa.
                $.ajax({
                    url: "$recuperarAlumnos",
                    data: { asigid: idasignatura, year: $('#grupos-year').val() },
                }).done(function (data) {
                    //Convierte la respuesta JSON (la lista de alumnos) en un objeto JavaScript.
                    var aAlumnos = JSON.parse(data);
                    var i = 0;
                    //Itera sobre la lista de alumnos y crea un elemento <div> para cada alumno.
                    while (i < aAlumnos.length) {
                        //Agrega los elementos div al contenedor de alumnos.
                        $('#contenedorAlumnos').append('<div id="' + aAlumnos[i].alumno.idUsuario + '" class="divAlumno draggable">' + aAlumnos[i].alumno.apellido + ', ' + aAlumnos[i].alumno.nombre + '</div>');
                        i = i + 1;
                    }

                    //Bloque agregado
                    //Esta línea selecciona todos los elementos con la clase draggable (que son los elementos divAlumno) y les aplica la funcionalidad draggable de jQuery UI.
                    $(".draggable").draggable({
                        //Esta funcion se ejecuta cuando el usuario comienza a arrastrar un elemento draggable
                        start: function (event, ui) {
                            //Estos almacenan las coordenadas Top y left de los elementos draggable
                            $(this).data('originalTop', $(this).offset().top);
                            $(this).data('originalLeft', $(this).offset().left);
                        }
                    });
                    //Fin bloque agregado

                    //Calcula cuantos grupos se podran crear en base a la cantidad de alumnos y la cantidad de integrantes por grupo.
                    var j = 0;
                    var cantidadGrupos = Math.ceil(aAlumnos.length / $('#grupos-cantidadintegrantes').val());
                    cantidadContenedoresGrupo = cantidadGrupos;
                    //Bloque cambiado
                    // Crear contenedor padre para alumnos y grupos
                    var contenedorPadre = $('<div id="contenedorPadre"></div>').css('display', 'flex');
                    $('#contenedorAlumnos').wrap(contenedorPadre); //Coloca los contenedores de alumnos en el contenedor padre
                    //Crea los contenedores de grupos dinámicamente.
                    while (j < cantidadGrupos) {
                        $('#contenedorGrupos').append('<div id="grupo' + (j + 1) + '" class="contenedorGrupos droppable" style="margin-left: 20px;">Grupo ' + (j + 1) + '<input type="hidden" id="inputgrupo' + (j + 1) + '" value="[]"/></div>');
                        j = j + 1;
                    }
                    // Añadir contenedorGrupos al lado de contenedorAlumnos
                    $('#contenedorAlumnos').after($('#contenedorGrupos'));

                    //Habilita la funcionalidad de drop para los elementos con la clase "droppable" (los grupos).
                    $(".droppable").droppable({
                        //Se ejecuta cuando un elemento arrastrable se suelta en un grupo.
                        drop: function (event, ui) {
                            //Obtiene la lista de IDs de alumnos que ya están en el grupo.
                            var idsAlumnos = JSON.parse($('#input' + $(this).attr('id')).val());
                            var cantidadMaxima = parseInt($('#grupos-cantidadintegrantes').val());//Obtiene cantidad maxima

                            if (idsAlumnos.length < cantidadMaxima) {//Verifica que el grupo tiene espacio
                                //Agrega el ID del alumno arrastrado a la lista si aún no está en ella. 
                                if (idsAlumnos.indexOf($(ui.draggable).attr('id')) == -1) {
                                    idsAlumnos.push($(ui.draggable).attr('id'));
                                }
                                //Actualiza el campo oculto con la nueva lista de IDs de alumnos.
                                $('#input' + $(this).attr('id')).val(JSON.stringify(idsAlumnos));
                                //Llama a la función establecerGrupos() para actualizar la información de los grupos.
                                establecerGrupos();
                            } else {
                                alert('Este grupo ha alcanzado la cantidad máxima de integrantes.');
                                // Revertir el arrastre a la posición original
                                ui.draggable.offset({
                                    top: ui.draggable.data('originalTop'),
                                    left: ui.draggable.data('originalLeft')
                                });
                            }
                        },
                        //Se ejecuta cuando un elemento arrastrable se retira de un grupo.
                        out: function (event, ui) {
                            idsAlumnos = JSON.parse($('#input' + $(this).attr('id')).val());
                            //Elimina el ID del alumno de la lista. 
                            var index = idsAlumnos.indexOf($(ui.draggable).attr('id'));
                            if (index > -1) {
                                idsAlumnos.splice(index, 1);
                            }
                            //Actualiza el campo oculto.
                            $('#input' + $(this).attr('id')).val(JSON.stringify(idsAlumnos));
                            //Llama a la función establecerGrupos().
                            establecerGrupos();
                        }
                    });
                    //Fin de bloque cambiado
                });
            }
            //Nota:
            //Dentro de cada contenedorGrupos droppable, tienes un campo oculto con un id como inputgrupo1, inputgrupo2, etc.
            //Estos campos ocultan un array JSON que contiene los IDs de los alumnos que han sido asignados a cada grupo mediante drag-and-drop.
            //Cuando se envía el formulario, estos campos ocultos permiten al servidor saber qué alumnos pertenecen a cada grupo.
        }
        
        function establecerGrupos(){
            var i = 0;
            var aGrupos = [];
            while ( i < cantidadContenedoresGrupo){                
                aGrupos[i] = JSON.parse($('#inputgrupo' + (i+1)).val());
                i = i + 1;
            }
            $('#grupos-alumnosporgrupo').val(JSON.stringify(aGrupos));
        }
        
        $('#grupos-year').change(function(){
            if ($('#grupos-metodos_formacion_id').val() == 1){
                recuperarAlumnos();
            }
        });
            
        $('#grupos-cantidadintegrantes').change(function(){
            if ($('#grupos-metodos_formacion_id').val() == 1){
                recuperarAlumnos();
            }
        });        
        
        $('#grupos-metodos_formacion_id').change(function(){
            if ($('#grupos-metodos_formacion_id').val() == 1){
                recuperarAlumnos();
            } else {
                $('#contenedorAlumnos').html('');
                $('#contenedorGrupos').html('');
            }
        });                     
        
    });                             
JS;
$this->registerJs($script, yii\web\View::POS_END);
?>

<?php
// Extraer solo las letras mayúsculas de $asignaturaNombre
$iniciales = preg_replace('/[^A-Z]/', '', $asignaturaNombre);
$numGrupoCreado=$cantidadGrupos+1;
$codigoAsignatura=$iniciales.'/'.$asignaturaYear.'-'.$numGrupoCreado.'-';

?>

<div class="grupos-form">

    <?php $form = ActiveForm::begin(['id' => 'miFormulario']); ?>

    <?= $form->field($model, 'year')->textInput(['value' => $asignaturaYear, 'readonly' => true]) ?>

    <!-- Asigna un id al campo para poder manipularlo con JavaScript -->
    <?= $form->field($model, 'codigo')->textInput(['value' => $codigoAsignatura, 'readonly' => true, 'id' => 'codigoAsignatura']) ?>

    <?= $form->field($model, 'cantidadintegrantes')->textInput()->label('Cantidad de Integrantes (Cantidad máxima de integrantes por grupo)') ?>

    <?= $form->field($model, 'metodos_formacion_id')->dropDownList(app\models\MetodosFormacion::getListaMetodosFormacion()); ?>

    <?= $form->field($model, 'alumnosPorGrupo')->hiddenInput()->label(''); ?>

    <div>
        <div id='contenedorAlumnos' style="width: 380px;float:left;"></div>
        <div id='contenedorGrupos' style="float:right; width:700px"></div>
        <br style='clear: both;'/>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<!--Script para modificar el valor antes de enviar el formulario-->
<script>
    //Se obtiene el formulario y se le agrega un addEventListener para cuando se envia el formulario
    document.getElementById('miFormulario').addEventListener('submit', function(event) {
        var codigoCampo = document.getElementById('codigoAsignatura'); //Obtener el elemento codigo
        var metodosFormacion = document.getElementById('grupos-metodos_formacion_id'); // Obtener el elemento metodos_formacion_id

        if (metodosFormacion.value == 1) { //Si el valor de metodosFormacion es 1(Manual), se agrega AM a codigo
            var guardado = codigoCampo.value;
            var nuevoCodigo = guardado + 'AM';
            codigoCampo.value = nuevoCodigo;
        }else if(metodosFormacion.value==2){
            var guardado = codigoCampo.value;
            var nuevoCodigo = guardado + 'AA'; //Si el valor de metodosFormacion es 2(Por estilos de aprendizaje), se agrega AA a codigo
            codigoCampo.value = nuevoCodigo;
        }
    });
</script>

