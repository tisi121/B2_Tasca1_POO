<?php
// Funció per calcular l'àrea d'un rectangle
function calcularAreaRectangle($base, $altura) {
    return $base * $altura;
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Exercici 1 - Resultat</title>
</head>
<body>
    <h2>Resultat de l'Exercici 1</h2>
    <?php
    if (isset($_GET['base']) && isset($_GET['altura'])) {
        $base = floatval($_GET['base']);
        $altura = floatval($_GET['altura']);

        if ($base > 0 && $altura > 0) {
            $area = calcularAreaRectangle($base, $altura);
            echo "<p>Amb una base de <strong>$base</strong> i una altura de <strong>$altura</strong>, l'àrea del rectangle és: <strong>$area</strong>.</p>";
        } else {
            echo "<p style='color:red;'>La base i l'altura han de ser valors positius.</p>";
        }
    } else {
        echo "<p style='color:red;'>No s'han rebut totes les dades del formulari.</p>";
    }
    ?>
    <br>
    <a href="ex1.php">Tornar al formulari</a> | <a href="index.php">Índex</a>
</body>
</html>