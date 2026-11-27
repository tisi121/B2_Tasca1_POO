<?php
use App\Models\Usuari;

$titolPagina = 'Demostració de serialització';
$usuariDemo = new Usuari(99, 'Usuari de prova', 'prova@mail.com');
$notificacio = 'Aquesta notificació és temporal';
$usuariDemo->afegirNotificacio($notificacio);
$serialitzat = serialize($usuariDemo);
$notificacionsAbans = $usuariDemo->obtenirNotificacions();
$restaurat = unserialize($serialitzat);
$notificacionsRestaurades = $restaurat->obtenirNotificacions();
$proves = [
    [
        'nom' => 'Notificacions abans de serialitzar',
        'correcte' => $notificacionsAbans === [$notificacio],
        'resultat' => implode(', ', $notificacionsAbans),
    ],
    [
        'nom' => 'Notificacions després de restaurar',
        'correcte' => $notificacionsRestaurades === [],
        'resultat' => count($notificacionsRestaurades) === 0
            ? 'cap (llista buida)'
            : implode(', ', $notificacionsRestaurades),
    ],
];
require __DIR__ . '/partials/capcalera.php';
?>
<h1>Serialització d’un usuari</h1>
<p>El mètode <code>__sleep()</code> desa les propietats de l’usuari excepte les notificacions. Quan es reconstrueix l’objecte, <code>__wakeup()</code> inicialitza aquesta llista buida.</p>
<ul>
    <?php foreach ($proves as $prova): ?>
        <li><strong><?= h($prova['nom']) ?>:</strong> <?= $prova['correcte'] ? 'Correcte' : 'Resultat inesperat' ?> — <?= h($prova['resultat']) ?></li>
    <?php endforeach; ?>
</ul>
<h2>Text serialitzat</h2>
<pre><?= h($serialitzat) ?></pre>
<p>Objecte restaurat: <?= h((string) $restaurat) ?></p>
<?php require __DIR__ . '/partials/peu.php'; ?>
