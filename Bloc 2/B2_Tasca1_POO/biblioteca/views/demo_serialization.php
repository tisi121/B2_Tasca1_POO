<?php
use App\Models\Usuari;

$titolPagina = 'Demostració de serialització';
$usuariDemo = new Usuari(99, 'Usuari de prova', 'prova@mail.com');
$usuariDemo->afegirNotificacio('Aquesta notificació és temporal');
$abans = $usuariDemo->obtenirNotificacions();
$usuariDemo->afegirNotificacio('Aquesta notificació no es desarà');
$serialitzat = serialize($usuariDemo);
$restaurat = unserialize($serialitzat);
$notificacionsRestaurades = $restaurat->obtenirNotificacions();
require __DIR__ . '/partials/capcalera.php';
?>
<h1>Serialització d’un usuari</h1>
<p>El mètode <code>__sleep()</code> desa les propietats de l’usuari excepte les notificacions. Quan es reconstrueix l’objecte, <code>__wakeup()</code> inicialitza aquesta llista buida.</p>
<p>Notificació abans de serialitzar: <?= h(implode(', ', $abans)) ?></p>
<p>Notificacions després de restaurar: <?= count($notificacionsRestaurades) === 0 ? 'cap (llista buida)' : h(implode(', ', $notificacionsRestaurades)) ?></p>
<h2>Text serialitzat</h2>
<pre><?= h($serialitzat) ?></pre>
<p>Objecte restaurat: <?= h((string) $restaurat) ?></p>
<?php require __DIR__ . '/partials/peu.php'; ?>
