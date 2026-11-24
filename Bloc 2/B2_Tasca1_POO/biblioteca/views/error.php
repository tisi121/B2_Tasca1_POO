<?php
$titolPagina = 'S’ha produït un error';
require __DIR__ . '/partials/capcalera.php';
?>
<h1>S’ha produït un error</h1>
<p class="error"><?= h($error) ?></p>
<p><a href="index.php">Tornar a l’inici</a></p>
<?php require __DIR__ . '/partials/peu.php'; ?>
