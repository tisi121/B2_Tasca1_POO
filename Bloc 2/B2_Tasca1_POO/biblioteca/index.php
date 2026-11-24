<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Data\DataGenerator;
use App\Exceptions\MaterialNoDisponibleException;
use App\Exceptions\MaterialNoTrobatException;
use App\Models\Biblioteca;

session_start();

if (isset($_GET['page']) && $_GET['page'] === 'reset') {
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit;
}

if (!isset($_SESSION['biblioteca']) || !($_SESSION['biblioteca'] instanceof Biblioteca)) {
    $_SESSION['biblioteca'] = DataGenerator::crear();
}

$biblioteca = $_SESSION['biblioteca'];

function h(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}

function intParam(string $nom): ?int
{
    if (!isset($_GET[$nom]) || !is_scalar($_GET[$nom])) {
        return null;
    }

    $valor = filter_var((string) $_GET[$nom], FILTER_VALIDATE_INT);
    return $valor === false ? null : (int) $valor;
}

$page = isset($_GET['page']) && is_string($_GET['page']) ? $_GET['page'] : 'inici';

try {
    $vista = match ($page) {
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
        default => 'views/404.php',
    };

    require __DIR__ . '/' . $vista;
} catch (MaterialNoDisponibleException $e) {
    $error = (string) $e;
    require __DIR__ . '/views/error.php';
} catch (MaterialNoTrobatException $e) {
    $error = $e->getMessage();
    require __DIR__ . '/views/error.php';
} catch (Exception $e) {
    $error = $e->getMessage();
    require __DIR__ . '/views/error.php';
}
