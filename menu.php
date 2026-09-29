<?php
$titulo = 'Menú';
require __DIR__ . '/includes/header.php';

// Filtro por categoría desde la URL (funciona también sin JavaScript)
$cat = $_GET['cat'] ?? 'todo';
if ($cat !== 'todo' && !isset($categorias[$cat])) {
    $cat = 'todo';
}
$lista = $cat === 'todo' ? $productos : array_filter($productos, fn($p) => $p['cat'] === $cat);
?>

<section class="section page-head">
    <h1>Menú</h1>
    <p class="muted">Todo se prepara al momento. Agrega a tu bolsa y recoge en barra.</p>
</section>

<section class="section">
    <div class="toolbar">
        <div class="segmented" role="tablist">
            <a href="menu.php" class="seg <?= $cat === 'todo' ? 'is-active' : '' ?>" data-cat="todo">Todo</a>
            <?php foreach ($categorias as $clave => $nombre): ?>
                <a href="menu.php?cat=<?= $clave ?>" class="seg <?= $cat === $clave ? 'is-active' : '' ?>" data-cat="<?= $clave ?>"><?= $nombre ?></a>
            <?php endforeach; ?>
        </div>
        <label class="search">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
            <input type="search" id="searchInput" placeholder="Buscar en el menú">
        </label>
    </div>

    <div class="grid-3" id="menuGrid">
        <?php foreach ($productos as $p) {
            $oculto = $cat !== 'todo' && $p['cat'] !== $cat;
            include __DIR__ . '/includes/tarjeta.php';
        } ?>
    </div>
    <p class="empty-state" id="noResults" hidden>No encontramos nada con ese nombre.</p>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
