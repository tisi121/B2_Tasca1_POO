<?php
// Funció per fer la conversió entre qualsevol de les 3 escales
function convertirTemperatura($valor, $de, $a) {
    if ($de === $a) {
        return $valor;
    }

    // 1. Passem primer el valor d'origen a Celsius
    $celsius = 0;
    switch ($de) {
        case 'Celsius':
            $celsius = $valor;
            break;
        case 'Fahrenheit':
            $celsius = ($valor - 32) * (5 / 9);
            break;
        case 'Kelvin':
            $celsius = $valor - 273.15;
            break;
    }

    // 2. Passem de Celsius a la unitat de destí
    $resultat = 0;
    switch ($a) {
        case 'Celsius':
            $resultat = $celsius;
            break;
        case 'Fahrenheit':
            $resultat = ($celsius * 9 / 5) + 32;
            break;
        case 'Kelvin':
            $resultat = $celsius + 273.15;
            break;
    }

    return $resultat;
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Exercici 3 - Resultat</title>
</head>
<body>
    <h2>Resultat</h2>
    <?php
    if (isset($_GET['temperatura']) && isset($_GET['origen']) && isset($_GET['desti'])) {
        $temp = floatval($_GET['temperatura']);
        $origen = $_GET['origen'];
        $desti = $_GET['desti'];

        $resultat = convertirTemperatura($temp, $origen, $desti);

        echo "<p>$temp $origen = $resultat $desti</p>";
    } else {
        echo "<p style='color:red;'>Falten paràmetres per processar la conversió.</p>";
    }
    ?>
    <br>
    <a href="ex3.php">Fer una altra conversió</a> | <a href="index.php">Índex</a>
</body>
</html>