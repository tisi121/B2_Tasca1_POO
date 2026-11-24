<?php
/** @var \App\Models\Biblioteca $biblioteca */
global $biblioteca;

$titolPagina = 'Inici';
$estadistiques = $biblioteca->obtenirEstadistiques();
require __DIR__ . '/partials/capcalera.php';
?>
<h1>Biblioteca Digital</h1>
<p>Consulta els materials, gestiona els préstecs i revisa les reserves de la biblioteca.</p>
<section class="targetes">
    <article class="targeta"><h2>Materials</h2><span class="numero"><?= $estadistiques['total'] ?></span><a href="index.php?page=materials">Veure el catàleg</a></article>
    <article class="targeta"><h2>Disponibles</h2><span class="numero"><?= $estadistiques['disponibles'] ?></span><a href="index.php?page=materials">Consultar materials</a></article>
    <article class="targeta"><h2>Préstecs actius</h2><span class="numero"><?= count($biblioteca->llistarPrestecsActius()) ?></span><a href="index.php?page=prestecs">Veure préstecs</a></article>
    <article class="targeta"><h2>Reserves</h2><span class="numero"><?= $estadistiques['reservats'] ?></span><a href="index.php?page=reserves">Veure reserves</a></article>
</section>
<h2>Demostracions de POO</h2>
<p class="accions">
    <a class="boto" href="index.php?page=demo_magic">Mètodes màgics</a>
    <a class="boto" href="index.php?page=demo_serialization">Serialització</a>
    <a class="boto" href="index.php?page=demo_exceptions">Excepcions</a>
    <a class="boto" href="index.php?page=demo_autoload">Autoloading</a>
</p>
<?php require __DIR__ . '/partials/peu.php'; ?>
