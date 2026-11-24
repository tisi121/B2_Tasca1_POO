<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Exercici 2 - Formulari</title>
</head>
<body>
    <h2>Exercici 2: Consultar dies del mes</h2>
    <form action="ex2_processa.php" method="get">
        <label for="mes">Introdueix o escull un mes:</label>
        <select name="mes" id="mes" required>
            <option value="">-- Selecciona un mes --</option>
            <option value="Gener">Gener</option>
            <option value="Febrer">Febrer</option>
            <option value="Març">Març</option>
            <option value="Abril">Abril</option>
            <option value="Maig">Maig</option>
            <option value="Juny">Juny</option>
            <option value="Juliol">Juliol</option>
            <option value="Agost">Agost</option>
            <option value="Setembre">Setembre</option>
            <option value="Octubre">Octubre</option>
            <option value="Novembre">Novembre</option>
            <option value="Desembre">Desembre</option>
        </select>
        <input type="submit" value="Consultar">
    </form>
    <br>
    <a href="index.php">Tornar a l'índex</a>
</body>
</html>