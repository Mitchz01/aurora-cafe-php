</main>

<div class="sheet-backdrop" id="sheetBackdrop" hidden></div>
<aside class="sheet" id="bagSheet" aria-label="Tu bolsa" aria-hidden="true">
    <div class="sheet-grabber"></div>
    <div class="sheet-head">
        <h2>Tu bolsa</h2>
        <button class="pill-btn subtle" id="bagClose">Listo</button>
    </div>
    <ul class="bag-list" id="bagList"></ul>
    <p class="bag-empty" id="bagEmpty">Tu bolsa está vacía. Agrega algo desde el menú.</p>
    <div class="bag-total">
        <span>Total</span>
        <strong id="bagTotal">$0 MXN</strong>
    </div>
    <button class="btn-primary full" id="bagCheckout">Pedir para recoger</button>
</aside>

<div class="toast" id="toast" role="status"></div>

<footer class="footer">
    <div class="footer-inner">
        <div class="footer-marca">
            <?= logo('logo-grande') ?>
            <p><?= e($sitio['direccion']) ?><br>Tel. <?= e($sitio['telefono']) ?></p>
        </div>
        <?= sello('sello-footer') ?>
    </div>
    <div class="footer-inner footer-legal">
        <p>&copy; <?= date('Y') ?> Aurora Tostadores de Café.</p>
        <p>Fotografías: Pexels.</p>
    </div>
</footer>
<script src="js/app.js"></script>
</body>
</html>
