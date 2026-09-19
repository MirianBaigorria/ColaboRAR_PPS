<?php

use yii\helpers\Html;
/* @var $esProfesor boolean */
// $chat es un array que puede tener 0 o 1 elemento (la última sentencia)
// puntaje, rangoNombre, esProfesor, esgamificado

if (!empty($chat)) {
    $sentencia = $chat[0];
    if (!empty($sentencia["tipo_respuesta"])):

        // Si es actividad, renderizamos la card negra sin botón puntuar
        if ($sentencia["tipo_respuesta"] == 'actividad'): ?>
            <div class="respuesta-card respuesta-actividad" style="background:#181a1b;color:#fff;">
                <div class="respuesta-header">
                    <span class="respuesta-tipo" style="color:#FEE300;"><?= 'Actividad' . $sentencia["evento_id"] . 'abierta' ?> </span>
                    <span class="respuesta-fecha" style="color:#ccc;"><?= Html::encode($sentencia["fecha_hora"]) ?></span>
                     <?php if (!empty($sentencia["puntaje_evento"])): ?>
                            — <span style="color:#28a745;font-weight:bold;">
                               🏆  Puntuado con +<?= Html::encode($sentencia["puntaje_evento"]) ?>. ¡Felicidades! 🥳
                            </span>
                        <?php endif; ?>
                </div>
                <div class="respuesta-body">
                    <div class="respuesta-user">
                        <span class="respuesta-user-avatar">👤</span>
                        <span class="respuesta-username"><?= Html::encode($sentencia["username"]) ?></span>
                    </div>
                    <div class="respuesta-contenido" style="color:#fff;">
                        <?= Html::encode($sentencia["sentencia"]) ?>
                    </div>
                </div>
            </div>
            <hr style="margin:14px 0; border-top:1.5px solid #eee;">
        <?php
        // Si es pregunta o debate, la card de evento tradicional
        else: ?>
            <!-- CARD PARA RESPUESTAS DE EVENTO (pregunta o debate) -->
            <div class="respuesta-card respuesta-<?= Html::encode($sentencia["tipo_respuesta"]) ?>">
                <div class="respuesta-header">
                    <span class="respuesta-tipo"><?= $sentencia["tipo_respuesta"] == 'pregunta' ? ' ❓ Respuesta a Pregunta ' . $sentencia["evento_pregunta"] : '🗣️ Opinión en Debate '. $sentencia["evento_titulo"] ?></span>
                    <span class="respuesta-fecha"><?= Html::encode($sentencia["fecha_hora"]) ?></span>
                        <?php if (!empty($sentencia["puntaje_evento"])): ?>
                            — <span style="color:#28a745;font-weight:bold;">
                               🏆  Puntuado con +<?= Html::encode($sentencia["puntaje_evento"]) ?>. ¡Felicidades! 🥳
                            </span>
                        <?php endif; ?>
                </div>
                <div class="respuesta-body">
                    <div class="respuesta-user">
                        <span class="respuesta-user-avatar">👤</span>
                        <span class="respuesta-username"><?= Html::encode($sentencia["username"]) ?></span>
                    </div>
                    <div class="respuesta-contenido">
                        <?php
                        if (preg_match('/<a href=[\'"]([^\'"]+)[\'"][^>]*>([^<]+)<\/a>/', $sentencia["sentencia"], $matches)):
                            $url = $matches[1];
                            $nombreArchivo = $matches[2];
                        ?>
                            <a href="<?= Html::encode($url) ?>" target="_blank" style="color:#4F8EF7; font-weight:600;">
                                📎 <?= Html::encode($nombreArchivo) ?>
                            </a>
                        <?php else: ?>
                            <?= Html::encode($sentencia["sentencia"]) ?>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
            <hr style="margin:14px 0; border-top:1.5px solid #eee;">
        <?php endif; ?>

    <?php else: ?>
        <!-- MENSAJE NORMAL -->
        <div>
            <b>
                👤💬 <?= Html::encode($sentencia["username"]); ?>
                <?php if ($esgamificado == 'si'): ?>
                    🎯 Puntaje: <?= Html::encode($puntaje); ?>
                    <?php if (!empty($rangoNombre)): ?>
                        🎖️ Rango: <span style="color:#005C53;"><?= Html::encode($rangoNombre); ?></span>
                    <?php else: ?>
                        - <span style="color:#FF0000;">Sin Rango</span>
                    <?php endif; ?>
                <?php endif; ?>
            </b>
            <br>
            <span class="chat-message">
                <?php
                if (preg_match('/<a href=[\'"]([^\'"]+)[\'"][^>]*>([^<]+)<\/a>/', $sentencia["sentencia"], $matches)):
                    $url = $matches[1];
                    $nombreArchivo = $matches[2];
                ?>
                    <a href="<?= Html::encode($url) ?>" target="_blank" style="color:#4F8EF7; font-weight:600;">
                        📎 <?= Html::encode($nombreArchivo) ?>
                    </a>
                <?php else: ?>
                    <?= Html::encode($sentencia["sentencia"]); ?>
                <?php endif; ?>
            </span>
        </div>
        <hr style="margin:14px 0; border-top:1.5px solid #eee;">
<?php endif;
}
?>