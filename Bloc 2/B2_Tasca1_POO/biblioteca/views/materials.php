<?php
/** @var \App\Models\Biblioteca $biblioteca */
global $biblioteca;

use App\Models\DVD;
use App\Models\Llibre;
use App\Interfaces\Reservable;

$titolPagina = 'Materials';
$filtre = isset($_GET['type']) && is_string($_GET['type']) ? strtolower($_GET['type']) : '';
$tipus = match ($filtre) {
    'llibre' => 'Llibre',
    'revista' => 'Revista',
    'dvd' => 'DVD',
    default => null,
};
$materials = $tipus === null
    ? ($filtre === '' ? $biblioteca->getMaterials() : [])
    : $biblioteca->llistarPerTipus($tipus);
$usuaris = $biblioteca->getUsuaris();
require __DIR__ . '/partials/capcalera.php';
?>
<h1>Materials</h1>
<p>Filtra el catàleg per tipus:</p>
<p class="accions">
    <a class="boto" href="index.php?page=materials">Tots</a>
    <a class="boto" href="index.php?page=materials&amp;type=llibre">Llibres</a>
    <a class="boto" href="index.php?page=materials&amp;type=revista">Revistes</a>
    <a class="boto" href="index.php?page=materials&amp;type=dvd">DVDs</a>
</p>
<?php if ($filtre !== '' && $tipus === null): ?>
    <p class="error">El tipus indicat no és vàlid.</p>
<?php endif; ?>
<div class="taula-contenidor">
<table class="table">
    <thead><tr><th>ID</th><th>Tipus</th><th>Títol</th><th>Autor</th><th>Detalls</th><th>Estat</th><th>Accions</th></tr></thead>
    <tbody>
    <?php foreach ($materials as $material): ?>
        <tr>
            <td><?= $material->getId() ?></td>
            <td><?= h($material->getTipus()) ?></td>
            <td><?= h($material->getTitol()) ?></td>
            <td><?= h($material->getAutor()) ?></td>
            <td>
                <?php if ($material instanceof Llibre): ?>
                    <?= $material->getNumeroPagines() ?> pàgines
                <?php elseif ($material instanceof DVD): ?>
                    <?= h($material->getDuracioFormatada()) ?>
                <?php else: ?>
                    Edició <?= $material->getNumeroEdicio() ?>
                <?php endif; ?>
            </td>
            <td><?= $material->isDisponible() ? 'Disponible' : 'Prestat' ?></td>
            <td>
                <a href="index.php?page=material&amp;id=<?= $material->getId() ?>">Detall</a>
                <?php if ($material->isDisponible()): ?>
                    <form class="formulari" method="get" action="index.php">
                        <input type="hidden" name="page" value="prestec">
                        <input type="hidden" name="material_id" value="<?= $material->getId() ?>">
                        <label>Prestar a
                            <select name="usuari_id" required>
                                <?php foreach ($usuaris as $usuari): ?>
                                    <option value="<?= $usuari->getId() ?>"><?= h($usuari->getNom()) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <button type="submit">Prestar</button>
                    </form>
                <?php endif; ?>
                <?php if ($material instanceof Reservable && !$material->estaReservat()): ?>
                    <form class="formulari" method="get" action="index.php">
                        <input type="hidden" name="page" value="reserva">
                        <input type="hidden" name="material_id" value="<?= $material->getId() ?>">
                        <label>Reservar per a
                            <select name="usuari_id" required>
                                <?php foreach ($usuaris as $usuari): ?>
                                    <option value="<?= $usuari->getId() ?>"><?= h($usuari->getNom()) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <button type="submit">Reservar</button>
                    </form>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php require __DIR__ . '/partials/peu.php'; ?>
