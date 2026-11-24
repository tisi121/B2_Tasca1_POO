<?php
/** @var \App\Models\Biblioteca $biblioteca */
global $biblioteca;

$titolPagina = 'Demostració de l’autoloading';
$biblioteca->getMaterials();
$classes = array_values(array_filter(get_declared_classes(), function (string $classe): bool {
    return strpos($classe, 'App\\') === 0;
}));
sort($classes);
require __DIR__ . '/partials/capcalera.php';
?>
<h1>Classes carregades</h1>
<p>Composer carrega automàticament les classes de l’espai de noms <code>App\</code> des de la carpeta <code>src/</code>.</p>
<ul>
    <?php foreach ($classes as $classe): ?>
        <li><?= h($classe) ?></li>
    <?php endforeach; ?>
</ul>
<?php require __DIR__ . '/partials/peu.php'; ?>
