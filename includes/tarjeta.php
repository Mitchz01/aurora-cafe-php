<?php
// Tarjeta de producto reutilizable. Espera la variable $p.
?>
<article class="card product" data-cat="<?= $p['cat'] ?>" data-text="<?= e(strtolower($p['nombre'] . ' ' . $p['desc'])) ?>" <?= !empty($oculto) ? 'hidden' : '' ?>>
    <div class="product-img">
        <img src="img/<?= $p['img'] ?>.jpg" alt="<?= e($p['nombre']) ?>" loading="lazy">
    </div>
    <div class="product-body">
        <h3><?= e($p['nombre']) ?></h3>
        <p><?= e($p['desc']) ?></p>
        <div class="product-foot">
            <span class="price"><?= precio($p['precio']) ?></span>
            <button class="pill-btn add-btn" data-id="<?= $p['id'] ?>" data-nombre="<?= e($p['nombre']) ?>" data-precio="<?= $p['precio'] ?>">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                <span>Agregar</span>
            </button>
        </div>
    </div>
</article>
