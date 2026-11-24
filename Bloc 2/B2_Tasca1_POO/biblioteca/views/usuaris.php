<?php
/** @var \App\Models\Biblioteca $biblioteca */
global $biblioteca;

$titolPagina = 'Usuaris';
$usuaris = $biblioteca->getUsuaris();
require __DIR__ . '/partials/capcalera.php';
?>
<h1>Usuaris</h1>
<div class="taula-contenidor">
<table class="table">
    <thead><tr><th>ID</th><th>Nom</th><th>Email</th><th>Materials prestats</th><th>Acció</th></tr></thead>
    <tbody>
    <?php foreach ($usuaris as $usuari): ?>
        <tr>
            <td><?= $usuari->getId() ?></td>
            <td><?= h($usuari->getNom()) ?></td>
            <td><?= h($usuari->getEmail()) ?></td>
            <td><?= $usuari->getNumeroMaterialsPrestats() ?></td>
            <td><a href="index.php?page=usuari&amp;id=<?= $usuari->getId() ?>">Veure perfil</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php require __DIR__ . '/partials/peu.php'; ?>
