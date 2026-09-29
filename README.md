# Aurora · tienda en línea de una cafetería

Práctica de PHP para la materia de desarrollo web. La idea era armar un sitio con HTML5, CSS3, JavaScript y PHP, así que me inventé una cafetería de especialidad en Guadalajara y le hice su página: menú, pedidos para recoger y reservaciones.

## Qué hace

- **Inicio**: saluda según la hora y dice si la cafetería está abierta en este momento, calculado con el horario de cada día.
- **Menú**: los productos salen de un arreglo en PHP. Se pueden filtrar por categoría y buscar sin recargar la página.
- **Bolsa de pedido**: agregas productos, cambias cantidades y se guarda en el navegador aunque recargues.
- **Reservaciones**: el formulario se valida en PHP (correo, fecha futura, hora dentro del horario, número de personas) y las reservas se guardan en un archivo JSON.

## Cómo correrlo

Necesitas PHP 8 o XAMPP.

```bash
php -S localhost:8000
```

Y abres http://localhost:8000

Con XAMPP, copia la carpeta a `htdocs` y entra a `http://localhost/aurora-cafe-php/`.

## Estructura

```
includes/   datos, header, footer, logo y tarjeta de producto
css/        estilos
js/         bolsa, filtros y detalles de la interfaz
img/        fotos y favicon
data/       aquí se guardan las reservas
```

## Lo que aprendí

Separar el header y el footer con `include` me ahorró repetir código en cada página, y validar el formulario del lado del servidor fue lo más interesante: el navegador puede validar, pero el que decide al final es PHP.

Las fotos son de [Pexels](https://www.pexels.com). La cafetería no existe (ojalá).
