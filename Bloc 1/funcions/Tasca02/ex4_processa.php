<?php
// Funció que valida la contrasenya caràcter per caràcter (sense expressions regulars)
function validarContrasenya($pwd) {
    $errors = [];

    // Requisit 1: Comprovar longitud mínima de 8 caràcters
    if (strlen($pwd) < 8) {
        $errors[] = "Ha de tenir almenys 8 caràcters de longitud.";
    }

    $teMajuscula = false;
    $teNumero = false;
    $teEspecial = false;

    // Llista de caràcters especials permesos o comuns
    $caractersEspecials = '@#$%&*!?+=_-.,;:/';

    // Recorrem la cadena caràcter a caràcter
    for ($i = 0; $i < strlen($pwd); $i++) {
        $char = $pwd[$i];

        // Comprovem si és majúscula (lletra i igual a la seva majúscula)
        if (ctype_upper($char)) {
            $teMajuscula = true;
        }

        // Comprovem si és un dígit numèric
        if (ctype_digit($char)) {
            $teNumero = true;
        }

        // Comprovem si és un caràcter especial
        if (strpos($caractersEspecials, $char) !== false) {
            $teEspecial = true;
        }
    }

    // Requisit 2
    if (!$teMajuscula) {
        $errors[] = "Ha de contenir almenys una lletra majúscula.";
    }

    // Requisit 3
    if (!$teNumero) {
        $errors[] = "Ha de contenir almenys un número.";
    }

    // Requisit 4
    if (!$teEspecial) {
        $errors[] = "Ha de contenir almenys un caràcter especial (com ara @, #, $, etc.).";
    }

    return $errors;
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Exercici 4 - Resultat</title>
</head>
<body>
    <h2>Resultat de la validació</h2>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
        $password = $_POST['password'];
        $motiusError = validarContrasenya($password);

        if (empty($motiusError)) {
            echo "<p style='color:green;'><strong>La contrasenya és correcta i compleix tots els criteris!</strong></p>";
        } else {
            echo "<p style='color:red;'><strong>La contrasenya no és vàlida pels següents motius:</strong></p>";
            echo "<ul>";
            foreach ($motiusError as $error) {
                echo "<li>" . htmlspecialchars($error) . "</li>";
            }
            echo "</ul>";
        }
    } else {
        echo "<p style='color:red;'>No s'ha rebut la contrasenya per mètode POST.</p>";
    }
    ?>
    <br>
    <a href="ex4.php">Provar una altra contrasenya</a> | <a href="index.php">Índex</a>
</body>
</html>