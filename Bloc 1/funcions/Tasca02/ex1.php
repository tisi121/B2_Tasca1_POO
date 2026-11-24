<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Exercici 1 - Formulari</title>
</head>
<body>
    <h2>Exercici 1: Càlcul de l'àrea d'un rectangle</h2>
    <form action="ex1_processa.php" method="get">
        <label for="base">Base:</label>
        <input type="number" step="any" name="base" id="base" required><br><br>

        <label for="altura">Altura:</label>
        <input type="number" step="any" name="altura" id="altura" required><br><br>

        <input type="submit" value="Calcular àrea">
    </form>
    <br>
    <a href="index.php">Tornar a l'índex</a>
</body>
</html>