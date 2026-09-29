<?php
require_once __DIR__ . '/data.php';
require_once __DIR__ . '/marca.php';
$actual = basename($_SERVER['PHP_SELF'], '.php');
$paginas = [
    'index'    => 'Inicio',
    'menu'     => 'Menú',
    'reservar' => 'Reservar',
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#f4ece1">
    <link rel="icon" href="img/favicon.svg" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&display=swap" rel="stylesheet">
    <title><?= e($titulo ?? $sitio['nombre']) ?> · <?= e($sitio['nombre']) ?></title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header class="nav">
    <div class="nav-inner">
        <a href="index.php" class="logo" aria-label="Aurora, inicio"><?= logo() ?></a>
        <nav class="tabs" aria-label="Principal">
            <?php foreach ($paginas as $archivo => $etiqueta): ?>
                <a href="<?= $archivo ?>.php" class="tab <?= $actual === $archivo ? 'is-active' : '' ?>"><?= $etiqueta ?></a>
            <?php endforeach; ?>
        </nav>
        <button class="bag-btn" id="bagBtn" aria-label="Abrir bolsa">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 7h12l-1 13H7L6 7z"/><path d="M9 7a3 3 0 0 1 6 0"/></svg>
            <span class="bag-count" id="bagCount">0</span>
        </button>
    </div>
</header>
<main>
