<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Data\DataGenerator;
use App\Exceptions\MaterialNoDisponibleException;
use App\Exceptions\MaterialNoTrobatException;
use App\Http\PageRouter;
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
    $vista = PageRouter::obtenirVista($page);
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
