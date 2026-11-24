<?php
/** @var \App\Models\Biblioteca $biblioteca */
global $biblioteca;

$titolPagina = 'Auditoria';
$materials = $biblioteca->getMaterials();
require __DIR__ . '/partials/capcalera.php';
?>
<h1>Historial d’auditoria</h1>
<?php foreach ($materials as $material): ?>
    <?php $historial = $material->obtenirHistorial(); ?>
    <?php if (count($historial) > 0): ?>
        <h2><?= h($material->getTitol()) ?></h2>
        <div class="taula-contenidor">
        <table class="table">
            <thead><tr><th>Data</th><th>Acció</th><th>Detalls</th></tr></thead>
            <tbody>
            <?php foreach ($historial as $accio): ?>
                <tr><td><?= h($accio['data']) ?></td><td><?= h($accio['accio']) ?></td><td><?= h($accio['detalls']) ?></td></tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    <?php endif; ?>
<?php endforeach; ?>
<?php require __DIR__ . '/partials/peu.php'; ?>
