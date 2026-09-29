<?php
$titulo = 'Reservar';
require_once __DIR__ . '/includes/data.php';

$archivo = __DIR__ . '/data/reservas.json';
$reservas = file_exists($archivo) ? (json_decode(file_get_contents($archivo), true) ?: []) : [];

$errores = [];
$exito = null;
$datos = ['nombre' => '', 'correo' => '', 'fecha' => date('Y-m-d', strtotime('+1 day')), 'hora' => '10:00', 'personas' => 2, 'zona' => 'interior', 'notas' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($datos as $k => $v) {
        $datos[$k] = trim($_POST[$k] ?? '');
    }
    $datos['personas'] = (int) $datos['personas'];

    if (strlen($datos['nombre']) < 2) {
        $errores['nombre'] = 'Escribe tu nombre.';
    }
    if (!filter_var($datos['correo'], FILTER_VALIDATE_EMAIL)) {
        $errores['correo'] = 'Ese correo no parece válido.';
    }
    $f = DateTime::createFromFormat('Y-m-d H:i', $datos['fecha'] . ' ' . $datos['hora']);
    if (!$f) {
        $errores['fecha'] = 'Elige una fecha y hora.';
    } elseif ($f < new DateTime()) {
        $errores['fecha'] = 'La fecha ya pasó, elige otra.';
    } else {
        [$abre, $cierra] = $horario[(int) $f->format('N')];
        if ($datos['hora'] < $abre || $datos['hora'] >= $cierra) {
            $errores['hora'] = "Ese día abrimos de $abre a $cierra.";
        }
    }
    if ($datos['personas'] < 1 || $datos['personas'] > 10) {
        $errores['personas'] = 'Reservamos de 1 a 10 personas.';
    }
    if (!in_array($datos['zona'], ['interior', 'terraza', 'barra'], true)) {
        $datos['zona'] = 'interior';
    }

    if (!$errores) {
        $datos['folio'] = strtoupper(substr(md5(uniqid('', true)), 0, 6));
        $datos['creada'] = date('c');
        $reservas[] = $datos;
        if (!is_dir(dirname($archivo))) {
            mkdir(dirname($archivo), 0777, true);
        }
        file_put_contents($archivo, json_encode($reservas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $exito = $datos;
        $datos['nombre'] = $datos['correo'] = $datos['notas'] = '';
    }
}

// Próximas reservas (solo nombre corto por privacidad)
$proximas = array_filter($reservas, fn($r) => ($r['fecha'] . ' ' . $r['hora']) >= date('Y-m-d H:i'));
usort($proximas, fn($a, $b) => strcmp($a['fecha'] . $a['hora'], $b['fecha'] . $b['hora']));
$proximas = array_slice($proximas, 0, 5);

require __DIR__ . '/includes/header.php';
?>

<section class="section page-head">
    <h1>Reserva tu mesa</h1>
    <p class="muted">Te guardamos el lugar 15 minutos. Te confirmamos por correo.</p>
</section>

<?php if ($exito): ?>
<section class="section">
    <div class="card success">
        <h2>Listo, <?= e(explode(' ', $exito['nombre'])[0]) ?>.</h2>
        <p>Tu mesa para <?= $exito['personas'] ?> en <?= e($exito['zona']) ?> quedó apartada el
            <?= e(date('d/m/Y', strtotime($exito['fecha']))) ?> a las <?= e($exito['hora']) ?>.</p>
        <p class="folio">Folio <strong><?= e($exito['folio']) ?></strong></p>
    </div>
</section>
<?php endif; ?>

<section class="section">
    <div class="grid-2 align-start">
        <form method="post" class="card form" novalidate id="resForm">
            <div class="field <?= isset($errores['nombre']) ? 'has-error' : '' ?>">
                <label for="nombre">Nombre</label>
                <input id="nombre" name="nombre" value="<?= e($datos['nombre']) ?>" placeholder="Ana García" required>
                <?php if (isset($errores['nombre'])): ?><small><?= $errores['nombre'] ?></small><?php endif; ?>
            </div>
            <div class="field <?= isset($errores['correo']) ? 'has-error' : '' ?>">
                <label for="correo">Correo</label>
                <input id="correo" name="correo" type="email" value="<?= e($datos['correo']) ?>" placeholder="ana@correo.com" required>
                <?php if (isset($errores['correo'])): ?><small><?= $errores['correo'] ?></small><?php endif; ?>
            </div>
            <div class="row-2">
                <div class="field <?= isset($errores['fecha']) ? 'has-error' : '' ?>">
                    <label for="fecha">Fecha</label>
                    <input id="fecha" name="fecha" type="date" value="<?= e($datos['fecha']) ?>" min="<?= date('Y-m-d') ?>" required>
                    <?php if (isset($errores['fecha'])): ?><small><?= $errores['fecha'] ?></small><?php endif; ?>
                </div>
                <div class="field <?= isset($errores['hora']) ? 'has-error' : '' ?>">
                    <label for="hora">Hora</label>
                    <input id="hora" name="hora" type="time" step="1800" value="<?= e($datos['hora']) ?>" required>
                    <?php if (isset($errores['hora'])): ?><small><?= $errores['hora'] ?></small><?php endif; ?>
                </div>
            </div>

            <div class="field <?= isset($errores['personas']) ? 'has-error' : '' ?>">
                <label>Personas</label>
                <div class="stepper">
                    <button type="button" data-step="-1" aria-label="Menos">−</button>
                    <input name="personas" id="personas" type="number" min="1" max="10" value="<?= (int) $datos['personas'] ?>" readonly>
                    <button type="button" data-step="1" aria-label="Más">+</button>
                </div>
                <?php if (isset($errores['personas'])): ?><small><?= $errores['personas'] ?></small><?php endif; ?>
            </div>

            <div class="field">
                <label>Zona</label>
                <div class="segmented full">
                    <?php foreach (['interior' => 'Interior', 'terraza' => 'Terraza', 'barra' => 'Barra'] as $v => $t): ?>
                        <label class="seg <?= $datos['zona'] === $v ? 'is-active' : '' ?>">
                            <input type="radio" name="zona" value="<?= $v ?>" <?= $datos['zona'] === $v ? 'checked' : '' ?>><?= $t ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="field">
                <label for="notas">Notas <span class="muted">(opcional)</span></label>
                <textarea id="notas" name="notas" rows="3" maxlength="200" placeholder="Cumpleaños, silla para bebé, alergias..."><?= e($datos['notas']) ?></textarea>
            </div>

            <button class="btn-primary full" type="submit">Confirmar reserva</button>
        </form>

        <div class="stack">
        <div class="card foto-card">
            <img src="img/terraza.jpg" alt="Terraza con mesas al aire libre" loading="lazy">
            <div class="foto-card-texto">
                <h3>La terraza</h3>
                <p>Doce mesas bajo los fresnos de Chapultepec. Se llena rápido los sábados.</p>
            </div>
        </div>
        <div class="card">
            <h2 class="card-title">Próximas reservas</h2>
            <?php if (!$proximas): ?>
                <p class="muted">Aún no hay reservas. Sé el primero.</p>
            <?php else: ?>
                <ul class="list">
                    <?php foreach ($proximas as $r): ?>
                        <li>
                            <span><?= e(explode(' ', $r['nombre'])[0]) ?> · <?= (int) $r['personas'] ?> pers.</span>
                            <span class="muted"><?= e(date('d/m', strtotime($r['fecha']))) ?>, <?= e($r['hora']) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <p class="muted small">Total de reservas registradas: <?= count($reservas) ?></p>
        </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
