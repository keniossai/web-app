<?php

function convertOpacity($hexa)
{
    $color_hex = $hexa;
    $opacidad = 0.2;
    // Convertir el código hexadecimal en componentes RGB
    $rojo = hexdec(substr($color_hex, 1, 2));
    $verde = hexdec(substr($color_hex, 3, 2));
    $azul = hexdec(substr($color_hex, 5, 2));
    // Crear el valor RGBA correspondiente
    $color_rgba = "rgba($rojo, $verde, $azul, $opacidad)";
    return $color_rgba;
}
