<?php
/** @var \App\Models\Biblioteca $biblioteca */
global $biblioteca;

$materialId = intParam('material_id');
if ($materialId === null) {
    throw new \App\Exceptions\MaterialNoPrestatException('Indica quin material vols retornar');
}
$material = $biblioteca->cercarPerId($materialId);
$multa = $biblioteca->retornarMaterial($materialId);
$titolPagina = 'Retorn de material';
require __DIR__ . '/partials/capcalera.php';
?>
<h1>Material retornat</h1>
<p><?= h($material->getTitol()) ?> s’ha retornat correctament.</p>
<p><strong>Multa:</strong> <?= number_format($multa, 2, ',', '.') ?> €</p>
<p><a href="index.php?page=prestecs">Tornar als préstecs actius</a></p>
<?php require __DIR__ . '/partials/peu.php'; ?>
