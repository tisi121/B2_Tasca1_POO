<?php
/** @var \App\Models\Biblioteca $biblioteca */
global $biblioteca;

$missatges = [];
foreach ($biblioteca->getUsuaris() as $usuariNotificacio) {
    $missatges = array_merge($missatges, $usuariNotificacio->obtenirNotificacions());
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= h($titolPagina) ?> · <?= h($biblioteca->getNom()) ?></title>
    <link rel="stylesheet" href="assets/estils.css">
</head>
<body>
<header class="capcalera">
    <a class="marca" href="index.php"><?= h($biblioteca->getNom()) ?></a>
    <nav>
        <a href="index.php">Inici</a>
        <a href="index.php?page=materials">Materials</a>
        <a href="index.php?page=usuaris">Usuaris</a>
        <a href="index.php?page=prestecs">Préstecs</a>
        <a href="index.php?page=reserves">Reserves</a>
        <a href="index.php?page=estadistiques">Estadístiques</a>
        <a href="index.php?page=auditoria">Auditoria</a>
    </nav>
</header>
<main class="contenidor">
    <?php foreach ($missatges as $notificacioActual): ?>
        <p class="avis"><?= h($notificacioActual) ?></p>
    <?php endforeach; ?>
