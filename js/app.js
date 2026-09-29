// Aurora Café — interacciones
const $ = (s, c = document) => c.querySelector(s);
const $$ = (s, c = document) => [...c.querySelectorAll(s)];
const money = n => '$' + n.toLocaleString('es-MX') + ' MXN';

/* ---------- Toast ---------- */
let toastTimer;
function toast(msg) {
    const t = $('#toast');
    t.textContent = msg;
    t.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => t.classList.remove('show'), 2200);
}

/* ---------- Bolsa (guardada en localStorage) ---------- */
let bag = [];
try { bag = JSON.parse(localStorage.getItem('aurora-bag')) || []; } catch (e) { bag = []; }

function saveBag() {
    try { localStorage.setItem('aurora-bag', JSON.stringify(bag)); } catch (e) {}
    renderBag();
}

function renderBag() {
    const count = bag.reduce((a, i) => a + i.qty, 0);
    const total = bag.reduce((a, i) => a + i.qty * i.precio, 0);
    const badge = $('#bagCount');
    badge.textContent = count;
    badge.classList.toggle('show', count > 0);

    $('#bagList').innerHTML = bag.map(i => `
        <li>
            <span class="name">${i.nombre}<span class="sub">${money(i.precio)}</span></span>
            <div class="qty">
                <button data-qty="-1" data-id="${i.id}" aria-label="Quitar uno">−</button>
                <span>${i.qty}</span>
                <button data-qty="1" data-id="${i.id}" aria-label="Agregar uno">+</button>
            </div>
        </li>`).join('');
    $('#bagEmpty').hidden = bag.length > 0;
    $('#bagTotal').textContent = money(total);
    $('#bagCheckout').disabled = bag.length === 0;
    $('#bagCheckout').style.opacity = bag.length ? 1 : .4;
}

function addToBag(id, nombre, precio) {
    const item = bag.find(i => i.id === id);
    item ? item.qty++ : bag.push({ id, nombre, precio, qty: 1 });
    saveBag();
    const btn = $('#bagBtn');
    btn.classList.remove('bump'); void btn.offsetWidth; btn.classList.add('bump');
    toast(`${nombre} agregado`);
}

$$('.add-btn').forEach(b => b.addEventListener('click', () => {
    addToBag(+b.dataset.id, b.dataset.nombre, +b.dataset.precio);
    const label = b.querySelector('span');
    b.classList.add('added');
    label.textContent = 'Agregado';
    setTimeout(() => { b.classList.remove('added'); label.textContent = 'Agregar'; }, 1200);
}));

$('#bagList').addEventListener('click', e => {
    const b = e.target.closest('[data-qty]');
    if (!b) return;
    const item = bag.find(i => i.id === +b.dataset.id);
    item.qty += +b.dataset.qty;
    if (item.qty <= 0) bag = bag.filter(i => i !== item);
    saveBag();
});

const sheet = $('#bagSheet'), backdrop = $('#sheetBackdrop');
function openSheet() { backdrop.hidden = false; sheet.classList.add('open'); sheet.setAttribute('aria-hidden', 'false'); }
function closeSheet() { sheet.classList.remove('open'); backdrop.hidden = true; sheet.setAttribute('aria-hidden', 'true'); }
$('#bagBtn').addEventListener('click', openSheet);
$('#bagClose').addEventListener('click', closeSheet);
backdrop.addEventListener('click', closeSheet);
document.addEventListener('keydown', e => e.key === 'Escape' && closeSheet());

$('#bagCheckout').addEventListener('click', () => {
    if (!bag.length) return;
    const folio = Math.random().toString(36).slice(2, 7).toUpperCase();
    bag = [];
    saveBag();
    closeSheet();
    toast(`Pedido ${folio} enviado. Listo en 10 min.`);
});

renderBag();

/* ---------- Menú: filtro y búsqueda ---------- */
const grid = $('#menuGrid');
if (grid) {
    let cat = ($('.segmented .seg.is-active') || {}).dataset?.cat || 'todo';
    const search = $('#searchInput');

    function filter() {
        const q = search.value.trim().toLowerCase();
        let visibles = 0;
        $$('.product', grid).forEach(card => {
            const ok = (cat === 'todo' || card.dataset.cat === cat) && card.dataset.text.includes(q);
            card.hidden = !ok;
            if (ok) visibles++;
        });
        $('#noResults').hidden = visibles > 0;
    }

    $$('.segmented .seg').forEach(s => s.addEventListener('click', e => {
        e.preventDefault();
        $$('.segmented .seg').forEach(x => x.classList.remove('is-active'));
        s.classList.add('is-active');
        cat = s.dataset.cat;
        history.replaceState(null, '', cat === 'todo' ? 'menu.php' : `menu.php?cat=${cat}`);
        filter();
    }));
    search.addEventListener('input', filter);
}

/* ---------- Inicio: calculadora de cafeína ---------- */
const range = $('#cupRange');
if (range) {
    const msgs = [
        'Cero tazas. ¿Todo bien?',
        'Una taza, buen comienzo.',
        'Dos tazas, ritmo perfecto.',
        'Tres tazas, productividad máxima.',
        'Cuatro tazas, ya vas bien servido.',
        'Cinco tazas, mejor pásate a un descafeinado.',
        'Seis tazas. Toma agua, en serio.',
    ];
    const update = () => {
        const v = +range.value;
        $('#cupOut').textContent = v;
        $('#cupMsg').textContent = `${msgs[v]} Aproximadamente ${v * 95} mg de cafeína.`;
        range.style.setProperty('--fill-pct', (v / 6 * 100) + '%');
    };
    range.addEventListener('input', update);
    update();
}

/* ---------- Reservar: stepper, segmentado y validación ---------- */
const form = $('#resForm');
if (form) {
    const personas = $('#personas');
    $$('[data-step]', form).forEach(b => b.addEventListener('click', () => {
        personas.value = Math.min(10, Math.max(1, +personas.value + +b.dataset.step));
    }));

    $$('.segmented.full .seg', form).forEach(l => l.addEventListener('click', () => {
        $$('.segmented.full .seg', form).forEach(x => x.classList.remove('is-active'));
        l.classList.add('is-active');
    }));

    form.addEventListener('submit', e => {
        const nombre = $('#nombre').value.trim();
        const correo = $('#correo').value.trim();
        if (nombre.length < 2 || !/^\S+@\S+\.\S+$/.test(correo)) {
            e.preventDefault();
            toast('Revisa tu nombre y correo');
        }
    });
}
