<?php
use App\Exceptions\EmailInvalidException;
use App\Exceptions\MaterialNoDisponibleException;
use App\Exceptions\MaterialNoPrestatException;
use App\Exceptions\MaterialNoTrobatException;
use App\Exceptions\UsuariNoTrobatException;
use App\Models\Usuari;

/** @var \App\Models\Biblioteca $biblioteca */
global $biblioteca;

$titolPagina = 'Demostració d’excepcions';
$proves = [
    'MaterialNoTrobatException' => function () use ($biblioteca): void {
        $biblioteca->prestarMaterial(999, 1);
    },
    'MaterialNoDisponibleException' => function () use ($biblioteca): void {
        $biblioteca->prestarMaterial(1, 2);
    },
    'MaterialNoPrestatException' => function () use ($biblioteca): void {
        $biblioteca->retornarMaterial(2);
    },
    'UsuariNoTrobatException' => function () use ($biblioteca): void {
        $biblioteca->prestarMaterial(2, 999);
    },
    'EmailInvalidException' => function (): void {
        new Usuari(999, 'Usuari de prova', 'correu-no-valid');
    },
];
$resultats = [];
foreach ($proves as $nom => $prova) {
    try {
        $prova();
        $resultats[] = ['nom' => $nom, 'missatge' => 'No s’ha produït l’excepció esperada'];
    } catch (Exception $e) {
        $resultats[] = ['nom' => get_class($e), 'missatge' => $e->getMessage()];
    }
}
require __DIR__ . '/partials/capcalera.php';
?>
<h1>Demostració d’excepcions</h1>
<p>Cada operació incorrecta es captura i mostra el nom de l’excepció i el seu missatge.</p>
<ul>
    <?php foreach ($resultats as $resultat): ?>
        <li><strong><?= h($resultat['nom']) ?>:</strong> <?= h($resultat['missatge']) ?></li>
    <?php endforeach; ?>
</ul>
<?php require __DIR__ . '/partials/peu.php'; ?>
