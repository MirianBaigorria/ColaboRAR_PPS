<?php
use yii\widgets\LinkPager;
use yii\helpers\Html;
?>

<h2 class="perfil-title"><span>Tabla de </span>Posiciones 🎯</h2>
<p>Comenta en el chat, responde preguntas y acepta desafíos para demostrar tu motivación y compromiso.
Cada aporte te acerca a la cima del ranking… <strong>¡y recuerda que el profesor está siguiendo tu participación!</strong>
Sé activo, hazte notar y disfruta compitiendo con tus compañeros.
<strong>¿Listo para destacar y superar tus propios límites?</strong> 💬🎯🔥</p>

<!-- 🏆 PODIO TARJETAS -->
<?php $top3 = array_slice($dataProvider->models, 0, 3); ?>
<div class="champions-container">
    <?php foreach ($top3 as $i => $u): ?>
        <div class="champion-card position-<?= $i + 1 ?>">
            <div class="champion-header">
                <?= ($i + 1) === 1 ? '1°' : (($i + 1) === 2 ? '2°' : '3°') ?>
            </div>
            <div class="champion-avatar">
                <img src="<?= Yii::getAlias('@web/' . ($u['foto_perfil'] ?: 'uploads/default_profile.png')) ?>" alt="Foto" />
            </div>
            <div class="champion-info">
                <div class="champion-name"><?= Html::encode($u['nombre'] . ' ' . $u['apellido']) ?></div>
                <div class="champion-rango"><?= Html::encode($u['rango_nombre']) ?></div>
             
            </div>
            <div class="champion-puntaje"><?= Html::encode($u['puntaje']) ?> pts</div>
        </div>
    <?php endforeach; ?>
</div>

<!-- 📋 TABLA COMPLETA -->
<div class="leaderboard-header">
    <div class="col-pos">#</div>
    <div class="col-name">Nombre</div>
    <div class="col-rank">Rango</div>
    <div class="col-score">Puntaje</div>
</div>

<div class="leaderboard-container">
    <?php foreach ($dataProvider->models as $index => $usuario): ?>
        <div class="leaderboard-entry">
            <div class="col-pos"><?= $index + 1 ?></div>

            <div class="col-name d-flex align-items-center">
                <div class="leaderboard-photo">
                    <img src="<?= Yii::getAlias('@web/' . ($usuario['foto_perfil'] ?: 'uploads/default_profile.png')) ?>" class="profile-picture">
                </div>
                <div class="leaderboard-name"><?= Html::encode($usuario['nombre'] . ' ' . $usuario['apellido']) ?></div>
            </div>

            <div class="col-rank">
                <?php if (!empty($usuario['rango_imagen'])): ?>
                    <img src="<?= Yii::getAlias('@web/' . $usuario['rango_imagen']) ?>" class="rank-image">
                <?php endif; ?>
                <?= Html::encode($usuario['rango_nombre']) ?>
            </div>

           

            <div class="col-score"><?= Html::encode($usuario['puntaje']) ?> pts</div>
        </div>
    <?php endforeach; ?>
</div>

<!-- 📄 PAGINACIÓN -->
<div class="pagination-container text-center">
    <?= LinkPager::widget([
        'pagination' => $dataProvider->pagination,
    ]) ?>
</div>

<!-- 🎨 ESTILOS -->
<style>
.perfil-title {
    margin-bottom: 15px;
}

/* 🏆 PODIO TARJETAS */
.champions-container {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin: 40px auto;
    flex-wrap: wrap;
}

.champion-card {
    border-radius: 20px;
    padding: 20px;
    width: 200px;
    text-align: center;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    position: relative;
    transition: transform 0.3s ease;
}

.champion-card.position-1 {
    background: linear-gradient(145deg, #fff8dc, #ffe57f); /* Oro suave */
}
.champion-card.position-2 {
    background: linear-gradient(145deg, #e0e0e0, #f5f5f5); /* Plata suave */
}
.champion-card.position-3 {
    background: linear-gradient(145deg, #fbe9e7, #d7ccc8); /* Bronce suave */
}

.champion-header {
    position: absolute;
    top: -10px;
    right: -10px;
    background: #ffffff;
    padding: 5px 10px;
    border-radius: 20px;
    font-weight: bold;
    font-size: 12px;
    color: #444;
    box-shadow: 0 2px 5px rgba(0,0,0,0.08);
}

.champion-avatar img {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    border: 3px solid white;
    margin-bottom: 10px;
    background: #fff;
}

.champion-info {
    font-size: 14px;
    color: #333;
    margin-bottom: 10px;
}

.champion-name {
    font-weight: bold;
    font-size: 16px;
}

.champion-rango {
    font-size: 13px;
    opacity: 0.9;
}

.champion-grupo {
    font-size: 12px;
    color: #555;
}

.champion-puntaje {
    font-weight: bold;
    font-size: 16px;
    color: #222;
    margin-top: 5px;
}

/* 📋 TABLA */
.leaderboard-header,
.leaderboard-entry {
    display: flex;
    align-items: center;
    padding: 10px 15px;
    border-radius: 8px;
}

.leaderboard-header {
    background-color: #f1f1f1;
    font-weight: bold;
    font-size: 14px;
    color: #333;
    margin-top: 10px;
    margin-bottom: 5px;
}

.leaderboard-entry {
    background-color: #ffffff;
    margin-bottom: 8px;
    transition: background-color 0.3s ease;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.leaderboard-entry:hover {
    background-color: #f9f9f9;
}

.col-pos {
    width: 50px;
    font-size: 16px;
    font-weight: bold;
}

.col-name {
    display: flex;
    align-items: center;
    flex: 1;
    font-size: 16px;
    padding-left: 10px;
}

.profile-picture {
    border-radius: 50%;
    width: 42px;
    height: 42px;
    margin-right: 10px;
}

.col-rank {
    width: 180px;
    font-size: 14px;
    display: flex;
    align-items: center;
}

.rank-image {
    width: 36px;
    height: 36px;
    margin-right: 6px;
}

.col-group {
    width: 120px;
    font-size: 14px;
}

.col-score {
    width: 100px;
    font-size: 16px;
    font-weight: bold;
    text-align: right;
}

.pagination-container {
    margin-top: 20px;
}
</style>
