<?php
/** @var \App\Models\Biblioteca $biblioteca */
global $biblioteca;

use App\Exceptions\UsuariNoTrobatException;

$id = intParam('id');
$usuari = $id === null ? null : $biblioteca->cercarUsuari($id);
if ($usuari === null) {
    throw new UsuariNoTrobatException('No s’ha trobat l’usuari demanat');
}
$historial = $biblioteca->llistarPrestecsUsuari($usuari->getId());
$nomesHistorial = isset($_GET['action']) && $_GET['action'] === 'prestecs';
$titolPagina = 'Perfil de l’usuari';
require __DIR__ . '/partials/capcalera.php';
?>
<h1><?= h($usuari->getNom()) ?></h1>
<ul>
    <li><strong>Email:</strong> <?= h($usuari->getEmail()) ?></li>
    <li><strong>Data de registre:</strong> <?= h($usuari->getDataRegistre()->format('Y-m-d')) ?></li>
</ul>
<h2><?= $nomesHistorial ? 'Historial de préstecs' : 'Préstecs actius' ?></h2>
<?php
$prestecsMostrats = $nomesHistorial
    ? $historial
    : array_values(array_filter($historial, function ($prestec): bool {
        return $prestec->estaActiu();
    }));
?>
<?php if (count($prestecsMostrats) === 0): ?>
    <p>No hi ha préstecs per mostrar.</p>
<?php else: ?>
    <div class="taula-contenidor">
    <table class="table">
        <thead><tr><th>Material</th><th>Data del préstec</th><th>Estat</th><th>Multa actual</th></tr></thead>
        <tbody>
        <?php foreach ($prestecsMostrats as $prestec): ?>
            <tr>
                <td><a href="index.php?page=material&amp;id=<?= $prestec->getMaterial()->getId() ?>"><?= h($prestec->getMaterial()->getTitol()) ?></a></td>
                <td><?= h($prestec->getDataPrestec()->format('Y-m-d')) ?></td>
                <td><?= $prestec->estaActiu() ? 'Actiu' : 'Retornat' ?></td>
                <td><?= number_format($prestec->calcularMulta(), 2, ',', '.') ?> €</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
<?php endif; ?>
<p>
    <?php if ($nomesHistorial): ?>
        <a href="index.php?page=usuari&amp;id=<?= $usuari->getId() ?>">Veure només els actius</a>
    <?php else: ?>
        <a href="index.php?page=usuari&amp;id=<?= $usuari->getId() ?>&amp;action=prestecs">Veure historial complet</a>
    <?php endif; ?>
</p>
<?php require __DIR__ . '/partials/peu.php'; ?>
