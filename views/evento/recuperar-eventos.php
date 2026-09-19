<?php

use yii\helpers\Html;

$rolesUsuario = Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id);
$esProfesor = array_key_exists('profesor', $rolesUsuario);

$baseUrl = Yii::$app->request->baseUrl;
?>

<?php foreach ($eventos as $evento): ?>
    <?php if ($evento->estado === 'activado'): ?>
        <?php
        $tipo = Html::encode($evento->tipo_evento);
        $imgRuta = $baseUrl . "/images/eventos/evento-{$tipo}.png";
        ?>
        <div class="evento-card" data-evento-id="<?= Html::encode($evento->id) ?>" data-tipo-evento="<?= $tipo ?>">
            <div class="evento-img">
                <img src="<?= $imgRuta ?>" alt="Imagen <?= $tipo ?>">
            </div>
            <div class="evento-contenido">
                <div class="evento-titulo">
                    📅 <?= strtoupper($tipo) ?> en curso
                </div>
                <div class="evento-id-estado">
                    <span class="badge-id">ID: <?= Html::encode($evento->id) ?></span>
                    <span class="badge-estado">🟢 <?= ucfirst(Html::encode($evento->estado)) ?></span>
                </div>

                <div class="evento-detalle">
                    <?php if ($tipo === 'pregunta'): ?>
                        <p><strong>❓ Pregunta:</strong> <?= Html::encode($evento->pregunta) ?></p>
                        <p><strong>📝 Descripción:</strong> <?= Html::encode($evento->descripcion_pregunta) ?></p>
                    <?php elseif ($tipo === 'debate'): ?>
                        <p><strong>💬 Debate:</strong> <?= Html::encode($evento->titulo) ?></p>
                        <p><strong>📝 Descripción:</strong> <?= Html::encode($evento->descripcion) ?></p>
                    <?php elseif ($tipo === 'juego'): ?>
                        <p><strong>💬 Sentencia:</strong> <?= Html::encode($evento->titulo) ?></p>
                    <?php elseif ($tipo === 'actividad'): ?>
                        <p><strong>💬 Título:</strong> <?= Html::encode($evento->titulo) ?></p>
                        <p><strong>📝 Descripción:</strong> <?= Html::encode($evento->descripcion) ?></p>
                    <?php endif; ?>

                    <?php if (!empty($evento->link)): ?>
                        <?php
                        $link = $evento->link;
                        if (!preg_match('/^https?:\/\//', $link)) {
                            $link = 'https://' . $link;
                        }
                        ?>
                        <p><strong>🔗 Link:</strong> <a href="<?= Html::encode($link) ?>" target="_blank"><?= Html::encode($evento->link) ?></a></p>
                    <?php endif; ?>

                    <div class="evento-botones" style="display: flex; gap: 8px;">
                        <?php if ($esProfesor): ?>
                            <?= Html::beginForm(['evento/desactivar'], 'post') ?>
                            <?= Html::hiddenInput('evento_id', $evento->id) ?>
                            <?= Html::submitButton('Terminar evento', ['class' => 'btn-terminar']) ?>
                            <?= Html::endForm() ?>
                            <button type="button"
                                class="btn-ver-respuestas-evento btn btn-secondary"
                                data-evento-id="<?= $evento->id ?>">
                                Ver respuestas de evento
                            </button>
                        <?php else: ?>
                            <?php if ($tipo === 'pregunta' || $tipo === 'debate'): ?>
                                <button type="button"
                                    class="btn-responder-evento btn btn-primary"
                                    data-id="<?= $evento->id ?>"
                                    data-tipo="<?= $tipo ?>"
                                    data-titulo="<?= Html::encode($evento->pregunta ?: $evento->titulo) ?>"
                                    data-descripcion="<?= Html::encode($evento->descripcion ?: $evento->descripcion_pregunta) ?>">
                                    <?= $tipo === 'pregunta' ? 'Responder' : 'Opinar' ?>
                                </button>
                            <?php elseif ($tipo === 'actividad'): ?>
                                <?php
                                $link = $evento->link;
                                if (!preg_match('/^https?:\/\//', $link)) {
                                    $link = 'https://' . $link;
                                }
                                ?>
                                <a href="<?= Html::encode($link) ?>"
                                    class="btn btn-success btn-ir-actividad"
                                    data-link="<?= Html::encode($link) ?>"
                                    data-titulo="<?= Html::encode($evento->titulo) ?>"
                                    target="_blank" rel="noopener noreferrer">
                                    Ir a actividad
                                </a>

                            <?php elseif ($tipo === 'juego'): ?>
                                <!-- Botones Verdadero/Falso personalizados -->
                                <button type="button"
                                    class="btn-responder-vf btn btn-info"
                                    data-id="<?= $evento->id ?>"
                                    data-correcto="<?= Html::encode($evento->descripcion) ?>"
                                    data-valor="verdadero">
                                    ✅ Verdadero
                                </button>
                                <button type="button"
                                    class="btn-responder-vf btn btn-warning"
                                    data-id="<?= $evento->id ?>"
                                    data-correcto="<?= Html::encode($evento->descripcion) ?>"
                                    data-valor="falso">
                                    ❌ Falso
                                </button>
                                <div class="feedback-vf mt-2"></div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>