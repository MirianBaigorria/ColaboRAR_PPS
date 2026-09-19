<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;

$this->registerJsFile('https://unpkg.com/sweetalert/dist/sweetalert.min.js', ['position' => View::POS_HEAD]);
?>

<?php $form = ActiveForm::begin([
    'id' => 'carga-form',
    'layout' => 'default',
    'options' => ['enctype' => 'multipart/form-data'],

]); ?>

<!-- Dropdown para seleccionar el tipo de archivo -->
<?= $form->field($model, 'tipoarchivo')->dropDownList([
    'glb' => 'glb',
    'gltf' => 'gltf',
    'obj' => 'obj',
    'mp4' => 'mp4',
    'jpg' => 'jpg',
    'png' => 'png',
], [
    'prompt' => 'Seleccione el tipo de archivo',
    'id' => 'tipoarchivo-dropdown',
])->label('Tipo de recurso aumentado') ?>

<!-- Campo archivo principal -->
<div id="archivo1-container" style="display: none;">
    <?= $form->field($model, 'nomb')->textInput(['id' => 'nombre'])->label('Nombre del recurso', ['id' => 'nombre-label']) ?>
    <?= $form->field($model, 'desc')->textarea(['id' => 'descripcion'])->label('Descripcion del recurso', ['id' => 'descripcion-label']) ?>
    <?= $form->field($model, 'archivo1')->fileInput(['id' => 'archivo1'])->label('Archivo principal', ['id' => 'archivo1-label']) ?>
</div>

<!-- Campo archivo secundario -->
<div id="archivo2-container" style="display: none;">
    <?= $form->field($model, 'archivo2')->fileInput(['id' => 'archivo2'])->label('Archivo secundario', ['id' => 'archivo2-label']) ?>
</div>

<!-- Campo texturas -->
<div id="textures-container" style="display: none;">
    <?= $form->field($model, 'textures[]')->fileInput(['multiple' => true, 'id' => 'textures'])->label('Texturas', ['id' => 'textures-label']) ?>
</div>

<!-- Campo música -->
<div id="musica-container" style="display: none;">
    <?= $form->field($model, 'musica')->fileInput(['id' => 'musica'])->label('Seleccione un archivo con formato .mp3') ?>
</div>

<!-- Botón de envío -->
<div class="form-group">
        <?= Html::submitButton('Cargar', ['class' => 'btn btn-info']) ?>
</div>

<?php ActiveForm::end(); ?>




<?php
// JavaScript para mostrar los campos 'archivo1', 'archivo2', 'textures' solo cuando se seleccione el tipo de archivo correspondiente
$this->registerJs("
    $('#tipoarchivo-dropdown').on('change', function() {
        var tipo = $(this).val();
        var labelTextA1 = '';
        var labelTextA2 = '';
        var labelTextT = '';
        // Ocultar todos los campos al principio
        $('#archivo1-container').hide();
        $('#archivo2-container').hide();
        $('#textures-container').hide();
        $('#musica-container').hide();

        // Limpiar todos los inputs file
        $('#archivo1').val('');
        $('#archivo2').val('');
        $('#textures').val('');
        $('#musica').val('');

        
        // Mostrar los campos según el tipo seleccionado
        if (tipo == 'glb') {
            labelTextA1 = 'Seleccione un archivo con formato .glb';
            $('#archivo1-container').show();
            $('#musica-container').show();
        } else if (tipo == 'gltf') {
            labelTextA1 = 'Seleccione un archivo con formato .gltf';
            $('#archivo1-container').show();
             labelTextA2 = 'Seleccione un archivo con formato .bin';
            $('#archivo2-container').show();
            labelTextT = 'Seleccione las texturas correspondientes al archivo .gltf(archivos de imagen .jpg o .png)';
            $('#textures-container').show();
             $('#musica-container').show();
        } else if (tipo == 'obj') {
          labelTextA1 = 'Seleccione un archivo con formato .obj';
            $('#archivo1-container').show();
            labelTextA2 = 'Seleccione un archivo con formato .mtl';
            $('#archivo2-container').show();
             labelTextT = 'Seleccione las texturas correspondientes al archivo .obj(archivos de imagen .jpg o .png)';
            $('#textures-container').show();
             $('#musica-container').show();
        } else if (tipo == 'mp4') {
            labelTextA1 = 'Seleccione un archivo con formato .mp4';
            $('#archivo1-container').show();
        } else if (tipo == 'jpg') {
         labelTextA1 = 'Seleccione un archivo con formato .jpg';
            $('#archivo1-container').show();
             $('#musica-container').show();
        } else if (tipo == 'png') {
         labelTextA1 = 'Seleccione un archivo con formato .png';
            $('#archivo1-container').show();
             $('#musica-container').show();
        }
    
        $('#archivo1-label').text(labelTextA1);
        $('#archivo2-label').text(labelTextA2);
        $('#textures-label').text(labelTextT);

    });

", View::POS_READY); ?>

<?php
// JavaScript para verificar que no se envien campos de archivos vacios
$this->registerJs("
    // Validar antes de enviar el formulario
$('#carga-form').on('beforeSubmit', function(e) {
    var tipoArchivo = $('#tipoarchivo-dropdown').val(); // Obtener tipo de archivo seleccionado
    var archivo1 = $('#archivo1')[0].files.length; // Verificar si se seleccionó un archivo en archivo1
    var archivo2 = $('#archivo2')[0].files.length; // Verificar si se seleccionó un archivo en archivo2
    var textures = $('#textures')[0].files.length; // Verificar si se seleccionó un archivo en archivo2

    // Si el campo tipo de archivo es 'glb', 'gltf', 'obj', 'mp4', 'jpg' o 'png' y no hay archivo seleccionado, mostrar un mensaje
    if ((tipoArchivo === 'glb' || tipoArchivo === 'gltf' || tipoArchivo === 'obj' || tipoArchivo === 'mp4' || tipoArchivo === 'jpg' || tipoArchivo === 'png') && archivo1 === 0) {
        swal({title: 'Error', text: 'Por favor, sube un archivo .' +tipoArchivo, icon: 'error', button: 'Aceptar'});
        return false;  // Evitar el envío del formulario
    }
    
    if ((tipoArchivo === 'gltf' || tipoArchivo === 'obj') && archivo2 === 0) {
        //alert('Por favor, sube un archivo');
        if(tipoArchivo === 'gltf'){
        swal({title: 'Error', text: 'Por favor, sube un archivo .bin', icon: 'error', button: 'Aceptar'});
        return false;  // Evitar el envío del formulario
        }else {
        swal({title: 'Error', text: 'Por favor, sube un archivo .mtl', icon: 'error', button: 'Aceptar'});
        return false;  // Evitar el envío del formulario
        }     
    }

     if (textures === 0) {
        if(tipoArchivo === 'gltf'){
        swal({title: 'Error', text: 'Por favor, sube las texturas para tu archivo .gltf', icon: 'error', button: 'Aceptar'});
        return false;  // Evitar el envío del formulario
        }else if(tipoArchivo === 'obj') {
        swal({title: 'Error', text: 'Por favor, sube las texturas para tu archivo .obj', icon: 'error', button: 'Aceptar'});
        return false;  // Evitar el envío del formulario
        }     
    }

    // Si todo está bien, continuar con el envío
    return true;
});


", View::POS_READY);
?>

<?php
// JavaScript para verificar las extensiones de los archivos: archivo1, archivo2 y texturas
$this->registerJs("
    $(document).ready(function() {
        // Verifica si existe un elemento con id tipoarchivo-dropdown
        if($('#tipoarchivo-dropdown').length) { 

            // Para comprobar que la extensión del archivo principal coincida con el tipo de archivo seleccionado
            //Evento que se dispara cuando el usuario selecciona un archivo para archivo1
            $('#archivo1').on('change', function(event) {
                var tipoar = $('#tipoarchivo-dropdown').val(); // Obtener tipo de archivo seleccionado
                var file1 = event.target.files[0]; // Accede al primer archivo seleccionado por el usuario
                
                if (file1) {
                    var nombreFile1 = file1.name;  // Obtener el nombre del archivo
                    var extensionFile1 = nombreFile1.split('.').pop().toLowerCase();  // Obtener la extensión del archivo
                    
                    // Comparar la extensión del archivo con el valor de tipoarchivo (sin el punto)
                    if (extensionFile1 !== tipoar.toLowerCase()) {
                        swal({title: 'Error', text: 'Solo se admiten archivos .' + tipoar + '. Por favor, seleccione un archivo válido.', icon: 'error', button: 'Aceptar'});
                        event.target.value = '';  // Limpiar el input de archivo
                    }
                }
            });

            // Para comprobar que la extensión del archivo secundario coincida con .bin o .mtl
            //Evento que se dispara cuando el usuario selecciona un archivo para archivo1
            $('#archivo2').on('change', function(event) {
                var tipoar = $('#tipoarchivo-dropdown').val(); // Obtener tipo de archivo seleccionado
                var file2 = event.target.files[0]; // Accede al primer archivo seleccionado por el usuario
                
                if (file2) {
                    var nombreFile2 = file2.name;  // Obtener el nombre del archivo
                    var extensionFile2 = nombreFile2.split('.').pop().toLowerCase();  // Obtener la extensión del archivo
                    
                    // Si el tipo de archivo es 'gltf', la extensión secundaria debe ser '.bin'
                    if (tipoar === 'gltf' && extensionFile2 !== 'bin') {
                        swal({title: 'Error', text: 'Solo se admiten archivos .bin. Por favor, seleccione un archivo válido.', icon: 'error', button: 'Aceptar'});
                        event.target.value = '';  // Limpiar el input de archivo
                    } 
                    // Si el tipo de archivo es 'obj', la extensión secundaria debe ser '.mtl'
                    else if (tipoar === 'obj' && extensionFile2 !== 'mtl') {
                        swal({title: 'Error', text: 'Solo se admiten archivos .mtl. Por favor, seleccione un archivo válido.', icon: 'error', button: 'Aceptar'});
                        event.target.value = '';  // Limpiar el input de archivo
                    }
                }
            });

            // Para comprobar que la extensión del archivo de música sea .mp3 si no se seleccionó un archivo .mp4
            //Evento que se dispara cuando el usuario selecciona un archivo para musica
            $('#musica').on('change', function(event) {
                var tipoar = $('#tipoarchivo-dropdown').val(); // Obtener tipo de archivo seleccionado
                var fileMusica = event.target.files[0]; // Accede al archivo seleccionado por el usuario
                
                if (fileMusica) {
                    var nombreMusica = fileMusica.name;  // Obtener el nombre del archivo
                    var extensionMusica = nombreMusica.split('.').pop().toLowerCase();  // Obtener la extensión del archivo
                    
                    // Si el tipo de archivo no es 'mp4', la extensión de la música debe ser 'mp3'
                    if (tipoar !== 'mp4' && extensionMusica !== 'mp3') {
                        swal({title: 'Error', text: 'Solo se admiten archivos .mp3. Por favor, seleccione un archivo válido.', icon: 'error', button: 'Aceptar'});
                        event.target.value = '';  // Limpiar el input de archivo
                    }
                }
            });

            // Verificar las extensiones de las texturas
            //Evento que se dispara cuando el usuario selecciona un archivo para las texturas
            $('#textures').on('change', function(event) {
                var archivosTexturas = event.target.files; // Obtener los archivos seleccionados
                var tiposPermitidos = ['jpg', 'png']; // Extensiones permitidas para las texturas
                var archivosInvalidos = false;

                // Iterar sobre los archivos seleccionados porque pueden ser mas que uno
                for (var i = 0; i < archivosTexturas.length; i++) {
                    var nombreArchivo = archivosTexturas[i].name;
                    var extensionArchivo = nombreArchivo.split('.').pop().toLowerCase(); // Obtener la extensión del archivo

                    // Si la extensión no está permitida, marcar el archivo como inválido
                    if (!tiposPermitidos.includes(extensionArchivo)) {
                        archivosInvalidos = true;
                        break; // Si encontramos un archivo inválido, salimos del ciclo
                    }
                }

                // Si hay archivos inválidos, mostrar una alerta y limpiar el campo de texturas
                if (archivosInvalidos) {
                    swal({title: 'Error', text: 'Solo se admiten archivos del tipo .jpg o .png para las texturas. Por favor, seleccione archivos válidos.', icon: 'error', button: 'Aceptar'});
                    event.target.value = '';  // Limpiar el input de archivo
                }
            });

        }
    });
", View::POS_READY);
?>