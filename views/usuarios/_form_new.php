<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Alumno */
/* @var $form yii\widgets\ActiveForm */
?>

<style type="text/css">
    div.item-test{
        border: 1px solid;
        padding: 5px;
        margin: 5px;
    }
    h1{
        text-align: center;
    }
    .error{
        color:red;
    }
</style>

<div class="alumno-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <h2>Instrucciones</h2>
    <p>Responda cada pregunta seleccionando la opci&oacute;n "a" o "b". Por favor seleccione solamente una respuesta para cada pregunta. Si tanto "a" como "b" parecen aplicarse a usted, entonces seleccione aquella con la que se sienta m&aacute;s identificado.</p> 

    <div class="item-test">
        <?=
        $form->field($model, 'preg1')->radioList(
                array('a' => 'a) si lo practico.', 'b' => 'b) si pienso en ello.')
        )->label('1. Entiendo mejor algo:')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg2')->radioList(
                array('a' => 'a) realista.', 'b' => 'b) innovador.')
        )->label('2. Me considero:')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg3')->radioList(
                array('a' => 'a) una imagen.', 'b' => 'b) palabras.')
        )->label('3. Cuando pienso acerca de lo que hice ayer, es m&aacute;s probable que lo haga sobre la base de:')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg4')->radioList(
                array('a' => 'a) entender los detalles de un tema pero no ver claramente su estructura completa.', 'b' => 'b) entender la estructura completa pero no ver claramente los detalles.')
        )->label('4. Tengo tendencia a:')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg5')->radioList(
                array('a' => 'a) hablar de ello.', 'b' => 'b) pensar en ello.')
        )->label('5. Cuando estoy aprendiendo algo nuevo, me ayuda:')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg6')->radioList(
                array('a' => 'a) que trate sobre hechos y situaciones reales de la vida.', 'b' => 'b) que trate con ideas y teor&iacute;as.')
        )->label('6. Si yo fuera profesor, yo preferir&iacute;a dar un curso:')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg7')->radioList(
                array('a' => html_entity_decode('a) im&aacute;genes, diagramas, gr&aacute;ficas o mapas.'), 'b' => html_entity_decode('b) instrucciones escritas o informaci&oacute;n verbal.'))
        )->label('7. Prefiero obtener informaci&oacute;n nueva de:')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg8')->radioList(
                array('a' => 'a) todas las partes, entiendo el total.', 'b' => 'b) el total de algo, entiendo como encajan sus partes.')
        )->label('8. Una vez que entiendo:')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg9')->radioList(
                array('a' => 'a) participe y contribuya con ideas.', 'b' => 'b) no participe y solo escuche.')
        )->label('9. En un grupo de estudio que trabaja con un material dif&iacute;cil, es m&aacute;s probable que:')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg10')->radioList(
                array('a' => 'a) aprender hechos.', 'b' => 'b) aprender conceptos.')
        )->label('10.Es m&aacute;s f&aacute;cil para m&iacute;:')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg11')->radioList(
                array('a' => html_entity_decode('a) revise cuidadosamente las im&aacute;genes y las gr&aacute;ficas.'), 'b' => 'b) me concentre en el texto escrito.')
        )->label('11.En un libro con muchas im&aacute;genes y gr&aacute;ficas es m&aacute;s probable que:')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg12')->radioList(
                array('a' => 'a) generalmente trabajo sobre las soluciones con un paso a la vez.', 'b' => html_entity_decode('b) frecuentemente s&eacute; cu&aacute;les son las soluciones, pero luego tengo dificultad para imaginarme los pasos para llegar a ellas.'))
        )->label('12.Cuando resuelvo problemas de matem&aacute;ticas:')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg13')->radioList(
                array('a' => 'a) he llegado a saber como son muchos de los estudiantes.', 'b' => 'b) raramente he llegado a saber como son muchos estudiantes.')
        )->label('13.En las clases a las que he asistido:')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg14')->radioList(
                array('a' => html_entity_decode('a) algo que me ense&ntilde;e nuevos hechos o me diga como hacer algo.'), 'b' => html_entity_decode('b) algo que me d&eacute; nuevas ideas en que pensar.'))
        )->label('14.Cuando leo temas que no son de ficci&oacute;n, prefiero:')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg15')->radioList(
                array('a' => html_entity_decode('a) que utilizan muchos esquemas en el pizarr&oacute;n.'), 'b' => 'b) que toman mucho tiempo para explicar.')
        )->label('15.Me gustan los maestros:')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg16')->radioList(
                array('a' => 'a) pienso en los incidentes y trato de acomodarlos para configurar los temas.', 'b' => 'b) me doy cuenta de cuales son los temas cuando termino de leer y luego tengo que regresar y encontrar los incidentes que los demuestran.')
        )->label('16.Cuando estoy analizando un cuento o una novela:')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg17')->radioList(
                array('a' => html_entity_decode('a) comience a trabajar en su soluci&oacute;n inmediatamente.'), 'b' => 'b) primero trate de entender completamente el problema.')
        )->label('17.Cuando comienzo a resolver un problema de tarea, es m&aacute;s probable que:')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg18')->radioList(
                array('a' => 'a) certeza.', 'b' => html_entity_decode('b) teor&iacute;a.'))
        )->label('18.Prefiero la idea de:')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg19')->radioList(
                array('a' => 'a) lo que veo.', 'b' => 'b) lo que oigo.')
        )->label('19.Recuerdo mejor:')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg20')->radioList(
                array('a' => 'a) exponga el material en pasos secuenciales claros.', 'b' => html_entity_decode('b) me d&eacute; un panorama general y relacione el material con otros temas.'))
        )->label('20.Es m&aacute;s importante para m&iacute; que un profesor:')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg21')->radioList(
                array('a' => 'a) en un grupo de estudio.', 'b' => 'b) solo.')
        )->label('21.Prefiero estudiar:')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg22')->radioList(
                array('a' => 'a) cuidadoso en los detalles de mi trabajo.', 'b' => 'b) creativo en la forma en la que hago mi trabajo.')
        )->label('22.Me considero:')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg23')->radioList(
                array('a' => 'a) un mapa.', 'b' => 'b) instrucciones escritas.')
        )->label('23.Cuando alguien me da direcciones de nuevos lugares, prefiero: ')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg24')->radioList(
                array('a' => html_entity_decode('a) a un paso constante. Si estudio con ah&iacute;nco consigo lo que deseo.'), 'b' => html_entity_decode('b) en inicios y pausas. Me llego a confundir y s&uacute;bitamente lo entiendo.'))
        )->label('24.Aprendo: ')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg25')->radioList(
                array('a' => 'a) hacer algo y ver que sucede.', 'b' => 'b) pensar como voy a hacer algo.')
        )->label('25.Prefiero primero: ')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg26')->radioList(
                array('a' => 'a) dicen claramente los que desean dar a entender.', 'b' => 'b) dicen las cosas en forma creativa e interesante.')
        )->label('26.Cuando leo por diversi&oacute;n, me gustan los escritores que: ')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg27')->radioList(
                array('a' => 'a) la imagen.', 'b' => 'b) lo que el profesor dijo acerca de ella.')
        )->label('27.Cuando veo un esquema o bosquejo en clase, es m&aacute;s probable que recuerde: ')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg28')->radioList(
                array('a' => 'a) me concentro en los detalles y pierdo de vista el total de la misma.', 'b' => 'b) trato de entender el todo antes de ir a los detalles.')
        )->label('28.Cuando me enfrento a un cuerpo de informaci&oacute;n: ')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg29')->radioList(
                array('a' => 'a) algo que he hecho.', 'b' => 'b) algo en lo que he pensado mucho.')
        )->label('29.Recuerdo m&aacute;s f&aacute;cilmente: ')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg30')->radioList(
                array('a' => 'a) dominar una forma de hacerlo.', 'b' => 'b) intentar nuevas formas de hacerlo.')
        )->label('30.Cuando tengo que hacer un trabajo, prefiero: ')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg31')->radioList(
                array('a' => html_entity_decode('a) gr&aacute;ficas.'), 'b' => html_entity_decode('b) res&uacute;menes con texto.'))
        )->label('31.Cuando alguien me ense&ntilde;a datos, prefiero: ')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg32')->radioList(
                array('a' => 'a) lo haga (piense o escriba) desde el principio y avance.', 'b' => 'b) lo haga (piense o escriba) en diferentes partes y luego las ordene.')
        )->label('32.Cuando escribo un trabajo, es m&aacute;s probable que:')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg33')->radioList(
                array('a' => 'a) realizar una "tormenta de ideas" donde cada uno contribuye con ideas.', 'b' => 'b) realizar la "tormenta de ideas" en forma personal y luego juntarme con el grupo para comparar las ideas.')
        )->label('33.Cuando tengo que trabajar en un proyecto de grupo, primero quiero: ')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg34')->radioList(
                array('a' => 'a) sensible.', 'b' => 'b) imaginativo.')
        )->label('34.Considero que es mejor elogio llamar a alguien: ')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg35')->radioList(
                array('a' => html_entity_decode('a) c&oacute;mo es su apariencia.'), 'b' => html_entity_decode('b) lo que dicen de s&iacute; mismos.'))
        )->label('35.Cuando conozco gente en una fiesta, es m&aacute;s probable que recuerde: ')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg36')->radioList(
                array('a' => html_entity_decode('a) mantenerme concentrado en ese tema, aprendiendo lo m&aacute;s que pueda de &eacute;l.'), 'b' => 'b) hacer conexiones entre ese tema y temas relacionados.')
        )->label('36.Cuando estoy aprendiendo un tema, prefiero: ')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg37')->radioList(
                array('a' => 'a) abierto.', 'b' => 'b) reservado.')
        )->label('37.Me considero: ')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg38')->radioList(
                array('a' => 'a) material concreto (hechos, datos).', 'b' => html_entity_decode('b) material abstracto (conceptos, teor&iacute;as).'))
        )->label('38.Prefiero cursos que dan m&aacute;s importancia a: ')
        ?>
    </div>            

    <div class="item-test">
        <?=
        $form->field($model, 'preg39')->radioList(
                array('a' => html_entity_decode('a) ver televisi&oacute;n.'), 'b' => 'b) leer un libro.')
        )->label('39.Para divertirme, prefiero: ')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg40')->radioList(
                array('a' => html_entity_decode('a) algo &uacute;tiles para m&iacute;.'), 'b' => html_entity_decode('b) muy &uacute;tiles para m&iacute;.'))
        )->label('40.Algunos profesores inician sus clases haciendo un bosquejo de lo que ense&ntilde;ar&aacute;n. Esos bosquejos son: ')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg41')->radioList(
                array('a' => 'a) me parece bien.', 'b' => 'b) no me parece bien.')
        )->label('41.La idea de hacer una tarea en grupo con una sola calificaci&oacute;n para todos: ')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg42')->radioList(
                array('a' => 'a) tiendo a repetir todos mis pasos y revisar cuidadosamente mi trabajo.', 'b' => html_entity_decode('b) me cansa hacer su revisi&oacute;n y tengo que esforzarme para hacerlo.'))
        )->label('42.Cuando hago grandes c&aacute;lculos: ')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg43')->radioList(
                array('a' => html_entity_decode('a) f&aacute;cilmente y con bastante exactitud.'), 'b' => 'b) con dificultad y sin mucho detalle.')
        )->label('43.Tiendo a recordar lugares en los que he estado: ')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg44')->radioList(
                array('a' => html_entity_decode('a) piense en los pasos para la soluci&oacute;n de los problemas.'), 'b' => html_entity_decode('b) piense en las posibles consecuencias o aplicaciones de la soluci&oacute;n en un amplio rango de campos.'))
        )->label('44.Cuando resuelvo problemas en grupo, es m&aacute;s probable que yo: ')
        ?>
    </div>

    <div class="form-group">
    <?= Html::submitButton('Determinar mi Estilo de Aprendizaje', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
