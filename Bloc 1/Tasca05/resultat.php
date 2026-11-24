<?php
session_start();

// Si s'hi accedeix sense dades validades, redirigir a registre.php
if (!isset($_SESSION['dades_validades'])) {
    header('Location: registre.php');
    exit;
}

$dades = $_SESSION['dades_validades'];

// Després de recuperar-les, les esborrem de la sessió
unset($_SESSION['dades_validades']);

require_once __DIR__ . '/includes/header.php';
?>

<h2>Registre Completat amb Èxit</h2>
<p>Aquestes són les dades verificades i desades correctament al servidor:</p>

<table class="dades-taula">
    <tr>
        <th>Nom:</th>
        <td><?= htmlspecialchars($dades['nom']) ?></td>
    </tr>
    <tr>
        <th>Correu electrònic:</th>
        <td><?= htmlspecialchars($dades['email']) ?></td>
    </tr>
    <tr>
        <th>Edat:</th>
        <td><?= htmlspecialchars((string)$dades['edat']) ?> anys</td>
    </tr>
    <tr>
        <th>Telèfon:</th>
        <td><?= $dades['telefon'] !== null ? htmlspecialchars($dades['telefon']) : '<em>No indicat</em>' ?></td>
    </tr>
    <tr>
        <th>Població:</th>
        <td><?= htmlspecialchars($dades['poblacio']) ?></td>
    </tr>
</table>

<br>
<p>
    <a href="index.php" class="btn btn-secondary">Tornar a l'inici</a>
</p>

<?php require_once __DIR__ . '/includes/footer.php'; ?>