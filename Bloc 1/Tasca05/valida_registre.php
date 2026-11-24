<?php
session_start();

require_once __DIR__ . '/includes/validacio.php';

// 1. Si la petició no és POST, redirigir a registre.php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: registre.php');
    exit;
}

// 2. Comprovar el token CSRF amb hash_equals()
$tokenEnviat = $_POST['csrf_token'] ?? '';
$tokenSessio = $_SESSION['csrf_token'] ?? '';

if (empty($tokenEnviat) || empty($tokenSessio) || !hash_equals($tokenSessio, $tokenEnviat)) {
    http_response_code(403);
    echo "Error 403: Petició no permesa (Token CSRF invàlid o inexistent).";
    exit;
}

// 3. Comprovació, extracció i neteja inicial amb trim()
$nomBrut = isset($_POST['nom']) && is_string($_POST['nom']) ? trim($_POST['nom']) : '';
$emailBrut = isset($_POST['email']) && is_string($_POST['email']) ? trim($_POST['email']) : '';
$edatBrut = isset($_POST['edat']) && is_string($_POST['edat']) ? trim($_POST['edat']) : '';
$telefonBrut = isset($_POST['telefon']) && is_string($_POST['telefon']) ? trim($_POST['telefon']) : '';
$poblacioBrut = isset($_POST['poblacio']) && is_string($_POST['poblacio']) ? trim($_POST['poblacio']) : '';

// Desa de dades originals per mantenir el que l'usuari havia escrit
$dadesEnviades = [
    'nom' => $nomBrut,
    'email' => $emailBrut,
    'edat' => $edatBrut,
    'telefon' => $telefonBrut,
    'poblacio' => $poblacioBrut
];

$errors = [];

// Validar Nom
$errNom = validarNom($nomBrut);
if ($errNom) {
    $errors['nom'] = $errNom;
}

// Normalitzar i validar Email (minúscules)
$emailNormalitzat = mb_strtolower($emailBrut, 'UTF-8');
$errEmail = validarEmail($emailNormalitzat);
if ($errEmail) {
    $errors['email'] = $errEmail;
}

// Validar Edat
$errEdat = validarEdat($edatBrut);
if ($errEdat) {
    $errors['edat'] = $errEdat;
}

// Normalitzar i validar Telèfon (treure espais i guions)
$telefonNormalitzat = str_replace([' ', '-'], '', $telefonBrut);
$errTelefon = validarTelefon($telefonNormalitzat);
if ($errTelefon) {
    $errors['telefon'] = $errTelefon;
}

// Validar Població
$errPoblacio = validarPoblacio($poblacioBrut);
if ($errPoblacio) {
    $errors['poblacio'] = $errPoblacio;
}

// 4. Si hi ha errors: desar a la sessió i redirigir al formulari
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['dades_form'] = $dadesEnviades;
    header('Location: registre.php');
    exit;
}

// 5. Si tot és correcte: desar dades normalitzades a la sessió i redirigir a resultat.php
$_SESSION['dades_validades'] = [
    'nom' => $nomBrut,
    'email' => $emailNormalitzat,
    'edat' => (int)$edatBrut,
    'telefon' => $telefonNormalitzat !== '' ? $telefonNormalitzat : null,
    'poblacio' => normalitzarPoblacio($poblacioBrut)
];

header('Location: resultat.php');
exit;