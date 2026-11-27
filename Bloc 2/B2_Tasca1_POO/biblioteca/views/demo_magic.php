<?php
/** @var \App\Models\Biblioteca $biblioteca */
global $biblioteca;

$titolPagina = 'Demostració dels mètodes màgics';
$usuari = $biblioteca->cercarUsuari(1);
$usuari->afegirNotificacio('Missatge temporal');
$usuari->email = 'anna.puig@mail.com';
$emailActualitzat = $usuari->email;
$propietatDesconeguda = $usuari->propietatQueNoExisteix;
$textUsuari = (string) $usuari;
$errorSet = 'No s’ha produït l’excepció esperada';
$setRebutjat = false;
try {
    $usuari->nom = 'Nom no permès';
} catch (LogicException $e) {
    $errorSet = $e->getMessage();
    $setRebutjat = true;
}
$llibres = $biblioteca->getLlibres();
$nomBiblioteca = $biblioteca->getNom();
$errorCall = 'No s’ha produït l’excepció esperada';
$cridaRebutjada = false;
try {
    $biblioteca->metodeInexistent();
} catch (BadMethodCallException $e) {
    $errorCall = $e->getMessage();
    $cridaRebutjada = true;
}
$proves = [
    [
        'nom' => '__toString() d’Usuari',
        'correcte' => $textUsuari !== '',
        'resultat' => $textUsuari,
    ],
    [
        'nom' => '__get(\'email\') després de __set()',
        'correcte' => $emailActualitzat === 'anna.puig@mail.com',
        'resultat' => $emailActualitzat,
    ],
    [
        'nom' => '__get() d’una propietat desconeguda',
        'correcte' => $propietatDesconeguda === null,
        'resultat' => $propietatDesconeguda === null ? 'null' : (string) $propietatDesconeguda,
    ],
    [
        'nom' => '__set(\'nom\') no permès',
        'correcte' => $setRebutjat,
        'resultat' => $errorSet,
    ],
    [
        'nom' => '__call getNom()',
        'correcte' => is_string($nomBiblioteca) && $nomBiblioteca !== '',
        'resultat' => $nomBiblioteca,
    ],
    [
        'nom' => '__call getLlibres()',
        'correcte' => is_array($llibres),
        'resultat' => count($llibres) . ' llibres',
    ],
    [
        'nom' => '__call mètode desconegut',
        'correcte' => $cridaRebutjada,
        'resultat' => $errorCall,
    ],
];
require __DIR__ . '/partials/capcalera.php';
?>
<h1>Mètodes màgics</h1>
<ul>
    <?php foreach ($proves as $prova): ?>
        <li><strong><?= h($prova['nom']) ?>:</strong> <?= $prova['correcte'] ? 'Correcte' : 'Resultat inesperat' ?> — <?= h($prova['resultat']) ?></li>
    <?php endforeach; ?>
</ul>
<p>El mètode <code>__toString()</code> converteix l’objecte en text; <code>__get()</code> i <code>__set()</code> controlen l’accés a les propietats, i <code>__call()</code> tracta les crides a mètodes que no estan definits.</p>
<?php require __DIR__ . '/partials/peu.php'; ?>
