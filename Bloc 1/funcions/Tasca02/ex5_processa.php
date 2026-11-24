<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Exercici 5 - Resultat</title>
</head>
<body>
    <h2>Resultat del filtratge</h2>
    <?php
    if (isset($_POST['nombres'])) {
        $cadena = $_POST['nombres'];

        // Convertim el text separat per comes en un array
        $elements = explode(',', $cadena);

        // Netegem espais en blanc i convertim els valors a enters
        $numeros = [];
        foreach ($elements as $el) {
            $el = trim($el);
            if (is_numeric($el)) {
                $numeros[] = intval($el);
            }
        }

        // Ús d'array_filter amb una FUNCIÓ ANÒNIMA per filtrar múltiples de 3
        $multiplesDe3 = array_filter($numeros, function($num) {
            return $num % 3 === 0;
        });

        echo "<p><strong>Array original introduït:</strong> " . implode(', ', $numeros) . "</p>";
        
        if (!empty($multiplesDe3)) {
            echo "<p><strong>Elements que són múltiples de 3:</strong> " . implode(', ', $multiplesDe3) . "</p>";
        } else {
            echo "<p>No s'ha trobat cap múltiple de 3 a la llista.</p>";
        }
    } else {
        echo "<p style='color:red;'>No s'han rebut dades del formulari.</p>";
    }
    ?>
    <br>
    <a href="ex5.php">Tornar al formulari</a> | <a href="index.php">Índex</a>
</body>
</html>