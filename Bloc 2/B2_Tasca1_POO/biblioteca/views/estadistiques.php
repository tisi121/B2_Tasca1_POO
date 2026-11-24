<?php
/** @var \App\Models\Biblioteca $biblioteca */
global $biblioteca;

$titolPagina = 'Estadístiques';
$estadistiques = $biblioteca->obtenirEstadistiques();
require __DIR__ . '/partials/capcalera.php';
?>
<h1>Estadístiques</h1>
<section class="targetes">
    <article class="targeta"><h2>Total materials</h2><span class="numero"><?= $estadistiques['total'] ?></span></article>
    <article class="targeta"><h2>Disponibles</h2><span class="numero"><?= $estadistiques['disponibles'] ?></span></article>
    <article class="targeta"><h2>Prestats</h2><span class="numero"><?= $estadistiques['prestats'] ?></span></article>
    <article class="targeta"><h2>Reservats</h2><span class="numero"><?= $estadistiques['reservats'] ?></span></article>
</section>
<h2>Materials per tipus</h2>
<div class="taula-contenidor">
<table class="table">
    <thead><tr><th>Tipus</th><th>Quantitat</th></tr></thead>
    <tbody>
    <?php foreach ($estadistiques['perTipus'] as $tipus => $quantitat): ?>
        <tr><td><?= h($tipus) ?></td><td><?= $quantitat ?></td></tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<p><strong>Multes pendents estimades:</strong> <?= number_format($estadistiques['multesPendents'], 2, ',', '.') ?> €</p>
<?php require __DIR__ . '/partials/peu.php'; ?>
