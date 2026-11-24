<?php
// Declaració de l'array bidimensional amb els mesos i els seus dies
$mesosAny = [
    ["Gener", 31],
    ["Febrer", 28], // 29 en cas de bixest
    ["Març", 31],
    ["Abril", 30],
    ["Maig", 31],
    ["Juny", 30],
    ["Juliol", 31],
    ["Agost", 31],
    ["Setembre", 30],
    ["Octubre", 31],
    ["Novembre", 30],
    ["Desembre", 31]
];

// Funció que recorre l'array de dues dimensions i retorna els dies
function obtenirDiesMes($nomMes, $taulaMesos) {
    foreach ($taulaMesos as $fila) {
        // Comparem sense importar majúscules/minúscules
        if (strcasecmp($fila[0], trim($nomMes)) === 0) {
            return $fila[1];
        }
    }
    return null; // Si no es troba
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Exercici 2 - Resultat</title>
</head>
<body>
    <h2>Resultat de l'Exercici 2</h2>
    <?php
    if (isset($_GET['mes']) && !empty($_GET['mes'])) {
        $mesBuscador = $_GET['mes'];
        $dies = obtenirDiesMes($mesBuscador, $mesosAny);

        if ($dies !== null) {
            echo "<p>El mes de <strong>" . htmlspecialchars($mesBuscador) . "</strong> té <strong>$dies dies</strong>.</p>";
        } else {
            echo "<p style='color:red;'>El mes introduït no és vàlid.</p>";
        }
    } else {
        echo "<p style='color:red;'>No s'ha especificat cap mes per GET.</p>";
    }
    ?>
    <br>
    <a href="ex2.php">Tornar al formulari</a> | <a href="index.php">Índex</a>
</body>
</html>