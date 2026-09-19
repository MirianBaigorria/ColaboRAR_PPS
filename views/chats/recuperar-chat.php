<?php

use yii\helpers\Html;

if (!empty($chat)) {
    foreach ($chat as $sentencia) {
        // Si es una respuesta de actividad, mostramos la card negra
        if (!empty($sentencia["tipo_respuesta"]) && $sentencia["tipo_respuesta"] == 'actividad'): ?>
            <div class="respuesta-card respuesta-actividad" style="background:#181a1b;color:#fff;">
                <div class="respuesta-header">
                    <span class="respuesta-tipo" style="color:#FEE300;"> ✅ Actividad fue abierta</span>
                    <span class="respuesta-fecha" style="color:#ccc;"><?= Html::encode($sentencia["fecha_hora"]) ?></span>
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
        // NUEVO: Si es respuesta de juego (verdadero/falso)
        elseif (!empty($sentencia["tipo_respuesta"]) && $sentencia["tipo_respuesta"] == 'vf'): ?>
            <div class="respuesta-card respuesta-vf">
                <div class="respuesta-header">
                    <span class="respuesta-tipo" style="color: #FF7124 !important;">👀 Juego: Verdadero/Falso</span>
                    <span class="respuesta-fecha"><?= Html::encode($sentencia["fecha_hora"]) ?>
                        <?php if (!empty($sentencia["puntaje_evento"])): ?>
                            — <span style="color:#28a745;font-weight:bold;">
                               🏆 Puntuado con +<?= Html::encode($sentencia["puntaje_evento"]) ?>. ¡Felicidades! 🥳
                            </span>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="respuesta-body">
                    <div class="respuesta-user">
                        <span class="respuesta-user-avatar">👤</span>
                        <span class="respuesta-username"><?= Html::encode($sentencia["username"]) ?></span>
                    </div>
                    <div class="respuesta-contenido">
                        <?= Html::encode($sentencia["sentencia"]) ?>
                    </div>
                </div>
            </div>
            <hr style="margin:14px 0; border-top:1.5px solid #eee;">
        <?php
        // Si es respuesta a pregunta o debate
        elseif (!empty($sentencia["tipo_respuesta"]) && in_array($sentencia["tipo_respuesta"], ['pregunta', 'debate'])): ?>
            <div class="respuesta-card respuesta-<?= Html::encode($sentencia["tipo_respuesta"]) ?>">
                <div class="respuesta-header">
                    <span class="respuesta-tipo"><?= $sentencia["tipo_respuesta"] == 'pregunta' ? ' ❓ Respuesta a Pregunta: ' . $sentencia["evento_pregunta"] : '🗣️ Opinión en Debate '. $sentencia["evento_titulo"] ?></span>
                    <span class="respuesta-fecha">
                        <?= Html::encode($sentencia["fecha_hora"]) ?>
                        <?php if (!empty($sentencia["puntaje_evento"])): ?>
                            — <span style="color:#28a745;font-weight:bold;">
                               🏆  Puntuado con +<?= Html::encode($sentencia["puntaje_evento"]) ?>. ¡Felicidades! 🥳
                            </span>
                        <?php endif; ?>
                    </span>
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
        <?php
        // Mensaje normal (sin tipo_respuesta)
        else: ?>
            <div>
                <b>
                    👤💬 <?= Html::encode($sentencia["username"]); ?>
                    <?php if ($esgamificado == 'si'): ?>
                        🎯 Puntaje: <?= Html::encode($sentencia["puntaje"]); ?>
                        <?php if (!empty($sentencia["rango_nombre"])): ?>
                            🎖️ Rango: <span style="color:#005C53;"><?= Html::encode($sentencia["rango_nombre"]); ?></span>
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
<?php 
        endif;
    }
}
?>
