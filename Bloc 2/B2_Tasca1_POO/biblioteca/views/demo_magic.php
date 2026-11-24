<?php
/** @var \App\Models\Biblioteca $biblioteca */
global $biblioteca;

$titolPagina = 'Demostració dels mètodes màgics';
$usuari = $biblioteca->cercarUsuari(1);
$usuari->afegirNotificacio('Missatge temporal');
$usuari->email = 'anna.puig@mail.com';
$emailActualitzat = $usuari->email;
$propietatDesconeguda = $usuari->propietatQueNoExisteix;
$errorSet = '';
try {
    $usuari->nom = 'Nom no permès';
} catch (LogicException $e) {
    $errorSet = $e->getMessage();
}
$llibres = $biblioteca->getLlibres();
$nomBiblioteca = $biblioteca->getNom();
$errorCall = '';
try {
    $biblioteca->metodeInexistent();
} catch (BadMethodCallException $e) {
    $errorCall = $e->getMessage();
}
require __DIR__ . '/partials/capcalera.php';
?>
<h1>Mètodes màgics</h1>
<ul>
    <li><strong>__toString() d'Usuari:</strong> <?= h((string) $usuari) ?></li>
    <li><strong>__get('email'):</strong> <?= h($emailActualitzat) ?></li>
    <li><strong>__get() d'una propietat desconeguda:</strong> <?= $propietatDesconeguda === null ? 'null' : h((string) $propietatDesconeguda) ?></li>
    <li><strong>__set('nom') no permès:</strong> <?= h($errorSet) ?></li>
    <li><strong>__call getNom():</strong> <?= h($nomBiblioteca) ?></li>
    <li><strong>__call getLlibres():</strong> <?= count($llibres) ?> llibres</li>
    <li><strong>__call mètode desconegut:</strong> <?= h($errorCall) ?></li>
</ul>
<p>El mètode <code>__toString()</code> converteix l’objecte en text; <code>__get()</code> i <code>__set()</code> controlen l’accés a les propietats, i <code>__call()</code> tracta les crides a mètodes que no estan definits.</p>
<?php require __DIR__ . '/partials/peu.php'; ?>
