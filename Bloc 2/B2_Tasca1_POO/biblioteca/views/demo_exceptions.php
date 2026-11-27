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
    [
        'excepcio' => MaterialNoTrobatException::class,
        'operacio' => function () use ($biblioteca): void {
            $biblioteca->prestarMaterial(999, 1);
        },
    ],
    [
        'excepcio' => MaterialNoDisponibleException::class,
        'operacio' => function () use ($biblioteca): void {
            $biblioteca->prestarMaterial(1, 2);
        },
    ],
    [
        'excepcio' => MaterialNoPrestatException::class,
        'operacio' => function () use ($biblioteca): void {
            $biblioteca->retornarMaterial(2);
        },
    ],
    [
        'excepcio' => UsuariNoTrobatException::class,
        'operacio' => function () use ($biblioteca): void {
            $biblioteca->prestarMaterial(2, 999);
        },
    ],
    [
        'excepcio' => EmailInvalidException::class,
        'operacio' => function (): void {
            new Usuari(999, 'Usuari de prova', 'correu-no-valid');
        },
    ],
];

$resultats = [];
foreach ($proves as $prova) {
    $excepcioEsperada = $prova['excepcio'];
    try {
        $prova['operacio']();
        $resultats[] = [
            'nom' => $excepcioEsperada,
            'estat' => 'No s’ha produït l’excepció esperada',
            'missatge' => '',
        ];
    } catch (Exception $e) {
        $coincideix = $e instanceof $excepcioEsperada;
        $resultats[] = [
            'nom' => $excepcioEsperada,
            'estat' => $coincideix ? 'Correcte' : 'Excepció inesperada: ' . get_class($e),
            'missatge' => $e->getMessage(),
        ];
    }
}

require __DIR__ . '/partials/capcalera.php';
?>
<h1>Demostració d’excepcions</h1>
<p>Cada prova comprova que es produeixi l’excepció esperada i en mostra el resultat.</p>
<ul>
    <?php foreach ($resultats as $resultat): ?>
        <li><strong><?= h($resultat['nom']) ?>:</strong> <?= h($resultat['estat']) ?> <?= h($resultat['missatge']) ?></li>
    <?php endforeach; ?>
</ul>
<?php require __DIR__ . '/partials/peu.php'; ?>
