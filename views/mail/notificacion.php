<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $notificacion app\models\Notificaciones */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= Html::encode($notificacion->titulo) ?></title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #e0e0e0; border-radius: 4px; padding: 30px;">
        <h2 style="color: #2c3e50; margin-top: 0;"><?= Html::encode($notificacion->titulo) ?></h2>
        
        <?php if (!empty($notificacion->descripcion)): ?>
            <p style="color: #333333; line-height: 1.6;"><?= nl2br(Html::encode($notificacion->descripcion)) ?></p>
        <?php endif; ?>
        
        <?php if (!empty($notificacion->url)): ?>
            <p style="margin-top: 30px;">
                <a href="<?= Url::to($notificacion->url, true) ?>" style="background-color: #337ab7; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 4px; display: inline-block;">
                    Ver en ColaboRAR
                </a>
            </p>
        <?php endif; ?>
        
        <hr style="border: none; border-top: 1px solid #e0e0e0; margin: 30px 0;">
        <p style="color: #999999; font-size: 12px; text-align: center;">
            Este mensaje fue enviado desde ColaboRAR.<br>
            Si no deseas recibir estos correos, puedes desactivar las notificaciones por correo electrónico desde tu perfil.
        </p>
    </div>
</body>
</html>
