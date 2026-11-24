<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Exercici 3 - Conversió de Temperatures</title>
</head>
<body>
    <h2>Exercici 3: Conversió de Temperatures</h2>
    <form action="ex3_processa.php" method="get">
        <!-- Escala d'origen -->
        <div>
            <label><input type="radio" name="origen" value="Fahrenheit" checked> Fahrenheit</label>
            <label><input type="radio" name="origen" value="Celsius"> Celsius</label>
            <label><input type="radio" name="origen" value="Kelvin"> Kelvin</label>
        </div>
        <br>
        <!-- Valor numèric -->
        <div>
            <input type="number" step="any" name="temperatura" value="12" required>
        </div>
        <br>
        <!-- Escala de destí -->
        <div>
            <label><input type="radio" name="desti" value="Fahrenheit"> Fahrenheit</label>
            <label><input type="radio" name="desti" value="Celsius" checked> Celsius</label>
            <label><input type="radio" name="desti" value="Kelvin"> Kelvin</label>
        </div>
        <br>
        <input type="submit" value="Convertir">
    </form>
    <br>
    <a href="index.php">Tornar a l'índex</a>
</body>
</html>