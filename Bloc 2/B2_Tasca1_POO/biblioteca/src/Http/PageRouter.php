<?php
namespace App\Http;

final class PageRouter
{
    private const RUTES = [
        'inici' => 'views/inici.php',
        'materials' => 'views/materials.php',
        'material' => 'views/material.php',
        'usuaris' => 'views/usuaris.php',
        'usuari' => 'views/usuari.php',
        'prestec' => 'views/prestec.php',
        'retorn' => 'views/retorn.php',
        'prestecs' => 'views/prestecs.php',
        'reserva' => 'views/reserva.php',
        'reserves' => 'views/reserves.php',
        'estadistiques' => 'views/estadistiques.php',
        'auditoria' => 'views/auditoria.php',
        'demo_magic' => 'views/demo_magic.php',
        'demo_serialization' => 'views/demo_serialization.php',
        'demo_exceptions' => 'views/demo_exceptions.php',
        'demo_autoload' => 'views/demo_autoload.php',
    ];

    public static function obtenirVista(string $pagina): string
    {
        return self::RUTES[$pagina] ?? 'views/404.php';
    }
}
