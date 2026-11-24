<?php
/** @var \App\Models\Biblioteca $biblioteca */
global $biblioteca;

use App\Exceptions\MaterialNoTrobatException;

$materialId = intParam('material_id');
$material = $materialId === null ? null : $biblioteca->cercarPerId($materialId);
if ($material === null) {
    throw new MaterialNoTrobatException('Indica un material existent per fer la reserva');
}
$usuariId = intParam('usuari_id');
$missatge = null;
if ($usuariId !== null) {
    $creada = $biblioteca->reservarMaterial($materialId, $usuariId);
    $missatge = $creada ? 'Reserva realitzada correctament.' : 'Aquest material ja té una reserva activa.';
}
$titolPagina = 'Reservar material';
$usuaris = $biblioteca->getUsuaris();
require __DIR__ . '/partials/capcalera.php';
?>
<h1>Reservar material</h1>
<?php if ($missatge !== null): ?>
    <p class="<?= $creada ? 'avis' : 'error' ?>"><?= h($missatge) ?></p>
<?php else: ?>
    <p>Material: <strong><?= h($material->getTitol()) ?></strong></p>
    <form class="formulari" method="get" action="index.php">
        <input type="hidden" name="page" value="reserva">
        <input type="hidden" name="material_id" value="<?= $materialId ?>">
        <label>Usuari
            <select name="usuari_id" required>
                <?php foreach ($usuaris as $usuari): ?>
                    <option value="<?= $usuari->getId() ?>"><?= h($usuari->getNom()) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <button type="submit">Confirmar reserva</button>
    </form>
<?php endif; ?>
<p><a href="index.php?page=reserves">Veure les reserves</a></p>
<?php require __DIR__ . '/partials/peu.php'; ?>
