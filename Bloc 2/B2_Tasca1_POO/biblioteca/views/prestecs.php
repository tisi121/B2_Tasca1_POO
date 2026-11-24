<?php
/** @var \App\Models\Biblioteca $biblioteca */
global $biblioteca;

$titolPagina = 'Préstecs actius';
$prestecs = $biblioteca->llistarPrestecsActius();
require __DIR__ . '/partials/capcalera.php';
?>
<h1>Préstecs actius</h1>
<?php if (count($prestecs) === 0): ?>
    <p>No hi ha préstecs actius.</p>
<?php else: ?>
    <div class="taula-contenidor">
    <table class="table">
        <thead><tr><th>Material</th><th>Usuari</th><th>Data del préstec</th><th>Termini</th><th>Multa actual</th><th>Acció</th></tr></thead>
        <tbody>
        <?php foreach ($prestecs as $prestec): ?>
            <tr>
                <td><?= h($prestec->getMaterial()->getTitol()) ?></td>
                <td><a href="index.php?page=usuari&amp;id=<?= $prestec->getUsuari()->getId() ?>"><?= h($prestec->getUsuari()->getNom()) ?></a></td>
                <td><?= h($prestec->getDataPrestec()->format('Y-m-d')) ?></td>
                <td>
                    <?php if ($prestec->estaVencut()): ?>
                        <span class="etiqueta etiqueta-error">Vençut fa <?= abs($prestec->getDiesPendents()) ?> dies</span>
                    <?php else: ?>
                        <?= $prestec->getDiesPendents() ?> dies pendents
                    <?php endif; ?>
                </td>
                <td><?= number_format($prestec->calcularMulta(), 2, ',', '.') ?> €</td>
                <td><a href="index.php?page=retorn&amp;material_id=<?= $prestec->getMaterial()->getId() ?>">Retornar</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
<?php endif; ?>
<?php require __DIR__ . '/partials/peu.php'; ?>
