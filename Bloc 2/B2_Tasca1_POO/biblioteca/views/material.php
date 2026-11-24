<?php
/** @var \App\Models\Biblioteca $biblioteca */
global $biblioteca;

use App\Exceptions\MaterialNoTrobatException;

$id = intParam('id');
$material = $id === null ? null : $biblioteca->cercarPerId($id);
if ($material === null) {
    throw new MaterialNoTrobatException('No s’ha trobat el material demanat');
}
$titolPagina = 'Detall del material';
require __DIR__ . '/partials/capcalera.php';
?>
<h1>Detall del material</h1>
<ul class="list-group">
    <li class="list-item"><strong>Informació:</strong> <?= h((string) $material) ?></li>
    <li class="list-item"><strong>Autor:</strong> <?= h($material->getAutor()) ?></li>
    <li class="list-item"><strong>Any de publicació:</strong> <?= $material->getAnyPublicacio() ?></li>
    <li class="list-item"><strong>Estat de reserva:</strong>
        <?php if ($material instanceof \App\Interfaces\Reservable && $material->estaReservat()): ?>
            Reservat per <?= h((string) $material->getUsuariReserva()) ?>
        <?php else: ?>
            Sense reserva
        <?php endif; ?>
    </li>
</ul>
<h2>Historial d'auditoria</h2>
<?php $historial = $material->obtenirHistorial(); ?>
<?php if (count($historial) === 0): ?>
    <p>Encara no hi ha accions registrades.</p>
<?php else: ?>
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
<p><a href="index.php?page=materials">Tornar als materials</a></p>
<?php require __DIR__ . '/partials/peu.php'; ?>
