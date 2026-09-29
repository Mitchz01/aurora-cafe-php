<?php
date_default_timezone_set('America/Mexico_City');

$sitio = [
    'nombre'    => 'Aurora',
    'lema'      => 'Tostamos cada semana, en pequeños lotes, café de productores de Chiapas, Veracruz y Oaxaca.',
    'direccion' => 'Av. Chapultepec 214, Guadalajara, Jal.',
    'telefono'  => '33 1234 5678',
];

// Horario: día de la semana (1 = lunes ... 7 = domingo) => [abre, cierra]
$horario = [
    1 => ['07:30', '21:00'],
    2 => ['07:30', '21:00'],
    3 => ['07:30', '21:00'],
    4 => ['07:30', '21:00'],
    5 => ['07:30', '22:30'],
    6 => ['09:00', '22:30'],
    7 => ['09:00', '18:00'],
];

$dias = [1 => 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

$categorias = [
    'cafe'     => 'Café',
    'frio'     => 'Fríos',
    'panaderia'=> 'Panadería',
    'comida'   => 'Comida',
];

$productos = [
    ['id' => 1,  'nombre' => 'Capuchino',          'cat' => 'cafe',      'precio' => 58,  'img' => 'capuchino',      'desc' => 'Espresso de la casa con leche de Los Altos, espuma sedosa.'],
    ['id' => 2,  'nombre' => 'Flat white',         'cat' => 'cafe',      'precio' => 62,  'img' => 'flat-white',     'desc' => 'Doble ristretto con leche texturizada fina.'],
    ['id' => 3,  'nombre' => 'V60 de temporada',   'cat' => 'cafe',      'precio' => 70,  'img' => 'v60',            'desc' => 'Origen único de Pluma Hidalgo, Oaxaca. Filtrado a mano.'],
    ['id' => 4,  'nombre' => 'Cortado de avena',   'cat' => 'cafe',      'precio' => 58,  'img' => 'cortado',        'desc' => 'Espresso con bebida de avena tibia, sin azúcar añadida.'],
    ['id' => 5,  'nombre' => 'Cold brew',          'cat' => 'frio',      'precio' => 65,  'img' => 'cold-brew',      'desc' => 'Extracción en frío por 18 horas. Suave y dulce.'],
    ['id' => 6,  'nombre' => 'Espresso tonic',     'cat' => 'frio',      'precio' => 72,  'img' => 'espresso-tonic', 'desc' => 'Agua tónica, hielo, espresso y cáscara de naranja.'],
    ['id' => 7,  'nombre' => 'Matcha helado',      'cat' => 'frio',      'precio' => 75,  'img' => 'matcha',         'desc' => 'Matcha ceremonial batido con leche fría.'],
    ['id' => 8,  'nombre' => 'Croissant',          'cat' => 'panaderia', 'precio' => 48,  'img' => 'croissant',      'desc' => 'Laminado por tres días, horneado cada mañana.'],
    ['id' => 9,  'nombre' => 'Rol de canela',      'cat' => 'panaderia', 'precio' => 52,  'img' => 'canela',         'desc' => 'Masa brioche, canela de Ceylán y azúcar mascabado.'],
    ['id' => 10, 'nombre' => 'Concha de vainilla', 'cat' => 'panaderia', 'precio' => 38,  'img' => 'concha',         'desc' => 'La clásica, con costra de vainilla de Papantla.'],
    ['id' => 11, 'nombre' => 'Toast de aguacate',  'cat' => 'comida',    'precio' => 118, 'img' => 'toast',          'desc' => 'Pan de masa madre, aguacate, limón y aceite de oliva.'],
    ['id' => 12, 'nombre' => 'Chilaquiles rojos',  'cat' => 'comida',    'precio' => 135, 'img' => 'chilaquiles',    'desc' => 'Salsa de chile guajillo, huevo estrellado, crema y queso.'],
];

function precio($n) {
    return '$' . number_format($n, 0) . ' MXN';
}

function estadoTienda($horario) {
    $dia = (int) date('N');
    $ahora = date('H:i');
    [$abre, $cierra] = $horario[$dia];
    if ($ahora >= $abre && $ahora < $cierra) {
        return ['abierto' => true, 'texto' => "Abierto hoy hasta las $cierra"];
    }
    if ($ahora < $abre) {
        return ['abierto' => false, 'texto' => "Cerrado, abrimos hoy a las $abre"];
    }
    $manana = $dia === 7 ? 1 : $dia + 1;
    return ['abierto' => false, 'texto' => 'Cerrado, abrimos mañana a las ' . $horario[$manana][0]];
}

function e($s) {
    return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
}
