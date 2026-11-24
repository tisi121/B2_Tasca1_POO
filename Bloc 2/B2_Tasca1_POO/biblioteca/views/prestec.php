<?php
/** @var \App\Models\Biblioteca $biblioteca */
global $biblioteca;

use App\Exceptions\MaterialNoTrobatException;

$materialId = intParam('material_id');
$material = $materialId === null ? null : $biblioteca->cercarPerId($materialId);
if ($material === null) {
    throw new MaterialNoTrobatException('Indica un material existent per fer el préstec');
}
$usuariId = intParam('usuari_id');
$missatge = null;
if ($usuariId !== null) {
    $biblioteca->prestarMaterial($materialId, $usuariId);
    $missatge = "Préstec realitzat: {$material->getTitol()}";
}
$titolPagina = 'Fer un préstec';
$usuaris = $biblioteca->getUsuaris();
require __DIR__ . '/partials/capcalera.php';
?>
<h1>Fer un préstec</h1>
<?php if ($missatge !== null): ?>
    <p class="avis"><?= h($missatge) ?></p>
    <p><a href="index.php?page=usuari&amp;id=<?= $usuariId ?>">Veure el perfil de l’usuari</a></p>
<?php else: ?>
    <p>Material: <strong><?= h($material->getTitol()) ?></strong></p>
    <form class="formulari" method="get" action="index.php">
        <input type="hidden" name="page" value="prestec">
        <input type="hidden" name="material_id" value="<?= $materialId ?>">
        <label>Usuari
            <select name="usuari_id" required>
                <?php foreach ($usuaris as $usuari): ?>
                    <option value="<?= $usuari->getId() ?>"><?= h($usuari->getNom()) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <button type="submit">Confirmar préstec</button>
    </form>
<?php endif; ?>
<p><a href="index.php?page=materials">Tornar als materials</a></p>
<?php require __DIR__ . '/partials/peu.php'; ?>
