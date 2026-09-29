<?php
// Identidad visual de Aurora: sol naciente con franjas sobre la línea del horizonte.

function marcaSol($tam = 40, $clase = '') {
    static $n = 0;
    $id = 'sol' . (++$n);
    return <<<SVG
<svg class="marca-sol $clase" width="$tam" height="{$tam}" viewBox="0 0 48 48" aria-hidden="true">
    <defs>
        <mask id="$id">
            <rect width="48" height="48" fill="#fff"/>
            <rect y="22" width="48" height="1.8" fill="#000"/>
            <rect y="27" width="48" height="2.6" fill="#000"/>
            <rect y="32.4" width="48" height="3.4" fill="#000"/>
        </mask>
    </defs>
    <path d="M6 38a18 18 0 0 1 36 0z" fill="currentColor" mask="url(#$id)"/>
    <rect x="2" y="40" width="44" height="2.4" rx="1.2" fill="currentColor"/>
</svg>
SVG;
}

function logo($clase = '') {
    return '<span class="logo-lockup ' . $clase . '">' . marcaSol(34) .
        '<span class="logo-texto"><span class="logo-nombre">aurora</span>' .
        '<span class="logo-sub">tostadores de café</span></span></span>';
}

function sello($clase = '') {
    static $n = 0;
    $id = 'arco' . (++$n);
    return '<div class="sello ' . $clase . '" aria-hidden="true">
        <svg class="sello-texto" viewBox="0 0 200 200">
            <defs><path id="' . $id . '" d="M100 100 m-78 0 a78 78 0 1 1 156 0 a78 78 0 1 1 -156 0"/></defs>
            <text><textPath textLength="486" lengthAdjust="spacing" href="#' . $id . '">AURORA · TOSTADORES DE CAFÉ · GUADALAJARA · DESDE 2019 · </textPath></text>
        </svg>
        <div class="sello-centro">' . marcaSol(56) . '</div>
    </div>';
}
