<?php
/** @var \App\Models\Biblioteca $biblioteca */
global $biblioteca;

$titolPagina = 'Reserves';
$reserves = $biblioteca->llistarReserves();
require __DIR__ . '/partials/capcalera.php';
?>
<h1>Reserves actives</h1>
<?php if (count($reserves) === 0): ?>
    <p>No hi ha reserves actives.</p>
<?php else: ?>
    <div class="taula-contenidor">
    <table class="table">
        <thead><tr><th>Material</th><th>Tipus</th><th>Reservat per</th><th>Acció</th></tr></thead>
        <tbody>
        <?php foreach ($reserves as $material): ?>
            <tr>
                <td><?= h($material->getTitol()) ?></td>
                <td><?= h($material->getTipus()) ?></td>
                <td><?= h((string) $material->getUsuariReserva()) ?></td>
                <td><a href="index.php?page=material&amp;id=<?= $material->getId() ?>">Detall</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
<?php endif; ?>
<?php require __DIR__ . '/partials/peu.php'; ?>
