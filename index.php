<?php
$titulo = 'Inicio';
require __DIR__ . '/includes/header.php';

$estado = estadoTienda($horario);
$hoy = (int) date('N');
$destacados = array_filter($productos, fn($p) => in_array($p['id'], [2, 6, 9]));

$hora = (int) date('G');
if ($hora < 12)      $saludo = 'Buenos días';
elseif ($hora < 19)  $saludo = 'Buenas tardes';
else                 $saludo = 'Buenas noches';
?>

<section class="hero">
    <div class="hero-card">
        <img class="hero-foto" src="img/hero.jpg" alt="Interior de Aurora con plantas y luz de la mañana">
        <div class="hero-velo"></div>
        <div class="hero-text">
            <h1><?= $saludo ?>.<br>El café sale con el sol.</h1>
            <p><?= e($sitio['lema']) ?> Pide desde aquí y recógelo sin hacer fila.</p>
            <div class="hero-actions">
                <a href="menu.php" class="btn-primary">Ver el menú</a>
                <a href="reservar.php" class="btn-glass">Reservar mesa</a>
            </div>
        </div>
        <?= sello('sello-hero') ?>
    </div>
</section>

<section class="section">
    <div class="grid-3">
        <div class="card stat">
            <div class="stat-icon"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="3" width="18" height="18" rx="5"/><path d="M12 7v5l3 2"/></svg></div>
            <div>
                <strong><?= $estado['abierto'] ? 'Abierto' : 'Cerrado' ?></strong>
                <span><?= e($estado['texto']) ?></span>
            </div>
        </div>
        <div class="card stat">
            <div class="stat-icon"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3c4 3 4 15 0 18M12 3c-4 3-4 15 0 18"/><ellipse cx="12" cy="12" rx="7" ry="9"/></svg></div>
            <div>
                <strong>Tostado cada martes</strong>
                <span>Lotes de 12 kg, nunca más de dos semanas en barra</span>
            </div>
        </div>
        <div class="card stat">
            <div class="stat-icon"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"><path d="M12 3l2.8 5.7 6.2.9-4.5 4.4 1 6.2L12 17.3 6.5 20.2l1-6.2L3 9.6l6.2-.9L12 3z"/></svg></div>
            <div>
                <strong>4.9 de 5</strong>
                <span>Promedio de más de 1,200 reseñas</span>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="section-head">
        <h2>Favoritos de la casa</h2>
        <a href="menu.php" class="link">Ver todo</a>
    </div>
    <div class="grid-3">
        <?php foreach ($destacados as $p) { include __DIR__ . '/includes/tarjeta.php'; } ?>
    </div>
</section>

<section class="section">
    <div class="historia card">
        <div class="historia-fotos">
            <img src="img/tostador.jpg" alt="Café recién tostado saliendo del tostador" loading="lazy">
            <img src="img/interior.jpg" alt="Máquina de espresso en la barra" loading="lazy">
        </div>
        <div class="historia-texto">
            <?= marcaSol(44, 'historia-sol') ?>
            <h2>Del cafetal a tu taza en menos de un mes</h2>
            <p>Compramos directo a tres familias productoras en Chiapas, Veracruz y Oaxaca. El café llega en verde a nuestro taller en la colonia Americana y lo tostamos cada martes, antes de que salga el sol.</p>
            <p>Por eso el nombre: aquí el día empieza temprano y huele a café.</p>
            <div class="franjas" aria-hidden="true"><span></span><span></span><span></span></div>
        </div>
    </div>
</section>

<section class="section">
    <div class="grid-2">
        <div class="card">
            <h2 class="card-title">Horario</h2>
            <ul class="list">
                <?php foreach ($horario as $n => [$abre, $cierra]): ?>
                    <li class="<?= $n === $hoy ? 'is-today' : '' ?>">
                        <span><?= $dias[$n] ?><?= $n === $hoy ? ' (hoy)' : '' ?></span>
                        <span><?= $abre ?> – <?= $cierra ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="card">
            <h2 class="card-title">Calcula tu cafeína</h2>
            <p class="muted">Mueve el control para ver cuántas tazas llevas hoy.</p>
            <div class="slider-row">
                <input type="range" min="0" max="6" value="1" id="cupRange" aria-label="Tazas de café">
                <output id="cupOut" class="big-num">1</output>
            </div>
            <p id="cupMsg" class="cup-msg">Una taza, buen comienzo.</p>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
