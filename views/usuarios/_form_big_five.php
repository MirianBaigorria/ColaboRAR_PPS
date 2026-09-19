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
    <p>Por favor escoja un número para cada una de las siguientes expresiones, indicando así hasta que punto está de acuerdo o en desacuerdo en como le describe a usted.</p>

    <ul>
        <li>Muy en desacuerdo = 1</li>
        <li>Ligeramente en desacuerdo = 2</li>
        <li>Ni de acuerdo ni en desacuerdo = 3</li>
        <li>Ligeramente de acuerdo = 4</li>
        <li>Muy de acuerdo = 5</li>
    </ul>

    <p>Me veo a mi mismo-a como <b>alguien que</b>...</p>

    <div class="item-test">
        <?=
        $form->field($model, 'preg1_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('1. Es bien hablador.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg2_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('2. Tiende a ser criticón.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg3_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('3. Es minucioso en el trabajo.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg4_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('4. Es depresivo, melancólico.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg5_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('5. Es original, se le ocurren ideas nuevas.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg6_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('6. Es reservado.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg7_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('7. Es generoso y ayuda a los demás.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg8_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('8. Puede a veces ser algo descuidado.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg9_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('9. Es calmado, controla bien el estrés.')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg10_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('10. Tiene intereses muy diversos.')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg11_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('11. Está lleno de energía.')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg12_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('12. Prefiere trabajos que son rutinarios.')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg13_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('13. Inicia disputas con los demás.')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg14_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('14. Es un trabajador cumplidor, digno de confianza.')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg15_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('15. Con frecuencia se pone tenso.')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg16_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('16. Tiende a ser callado.')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg17_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('17. Valora lo artístico, lo estético.')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg18_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('18. Tiende a ser desorganizado')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg19_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('19. Es emocionalmente estable, difícil de alterar.')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg20_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('20. Tiene una imaginación activa.')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg21_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('21. Persevera hasta terminar el trabajo.')
        ?> 
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg22_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('22. Es a veces maleducado con los demás.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg23_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('23. Es inventivo.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg24_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('24. Es generalmente confiado.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg25_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('25. Tiende a ser flojo, vago.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg26_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('26. Se preocupa mucho por las cosas.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg27_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('27. Es a veces tímido, inhibido.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg28_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('28. Es indulgente, no le cuesta perdonar.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg29_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('29. Hace las cosas de manera eficiente.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg30_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('30. Es temperamental, de humor cambiante.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg31_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('31. Es ingenioso, analítico.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg32_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('32. Irradia entusiasmo.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg33_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('33. Es a veces frío y distante.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg34_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('34. Hace planes y los sigue cuidadosamente.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg35_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('35. Mantiene la calma en situaciones difíciles.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg36_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('36. Le gusta reflexionar, jugar con las ideas.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg37_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('37. Es considerado y amable con casi todo el mundo.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg38_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('38. Se pone nervioso con facilidad.')
        ?>
    </div>            

    <div class="item-test">
        <?=
        $form->field($model, 'preg39_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('39. Es educado en arte. música o literatura.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg40_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('40. Es asertivo, no teme expresar lo que quiere.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg41_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('41. Le gusta cooperar con los demás')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg42_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('42. Se distrae con facilidad.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg43_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('43. Es extrovertido, sociable.')
        ?>
    </div>

    <div class="item-test">
        <?=
        $form->field($model, 'preg44_bf')->radioList(
                array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        )->label('44. Tiene pocos intereses artísticos.')
        ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Determinar mi personalidad', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
