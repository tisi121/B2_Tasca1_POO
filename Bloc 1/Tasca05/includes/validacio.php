<?php
// Validació del Nom (2-50 caràcters, lletres, accents, espais, apòstrofs i guions)
function validarNom(string $nom): ?string {
    $longitud = mb_strlen($nom, 'UTF-8');
    if ($longitud < 2 || $longitud > 50) {
        return "El nom ha de tenir entre 2 i 50 caràcters.";
    }
    // Modificador /u per a suport correcte de caràcters UTF-8 i accents
    if (!preg_match("/^[a-zA-ZàèéíòóúÀÈÉÍÒÓÚçÇñÑ\s'\-]+$/u", $nom)) {
        return "El nom només pot contenir lletres, espais, apòstrofs i guions.";
    }
    return null;
}

// Validació d'Email (format d'email vàlid)
function validarEmail(string $email): ?string {
    if (empty($email)) {
        return "El camp de correu electrònic és obligatori.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "El format del correu electrònic no és vàlid.";
    }
    return null;
}

// Validació d'Edat (enter entre 18 i 120, sense decimals ni formats científics)
function validarEdat(string $edatStr): ?string {
    if ($edatStr === '') {
        return "L'edat és obligatòria.";
    }
    // Assegurem que només conté dígits (rebutja 18.5, 1e3, abc, etc.)
    if (!ctype_digit($edatStr)) {
        return "L'edat ha de ser un nombre enter sense decimals.";
    }
    $edat = (int)$edatStr;
    if ($edat < 18 || $edat > 120) {
        return "L'edat ha d'estar compresa entre 18 i 120 anys.";
    }
    return null;
}

// Validació de Telèfon (opcional; si s'omple, 9 dígits)
function validarTelefon(string $telefon): ?string {
    if ($telefon === '') {
        return null; // És opcional
    }
    if (!ctype_digit($telefon) || strlen($telefon) !== 9) {
        return "El telèfon ha de contenir exactament 9 dígits.";
    }
    return null;
}

// Validació de Població (2-50 caràcters, lletres, accents, espais, apòstrofs i guions)
function validarPoblacio(string $poblacio): ?string {
    $longitud = mb_strlen($poblacio, 'UTF-8');
    if ($longitud < 2 || $longitud > 50) {
        return "La població ha de tenir entre 2 i 50 caràcters.";
    }
    if (!preg_match("/^[a-zA-ZàèéíòóúÀÈÉÍÒÓÚçÇñÑ\s'\-]+$/u", $poblacio)) {
        return "La població només pot contenir lletres, espais, apòstrofs i guions.";
    }
    return null;
}

// Normalització de Població amb suport UTF-8 (Majúscula inicial de cada paraula)
function normalitzarPoblacio(string $poblacio): string {
    // mb_convert_case amb MB_CASE_TITLE per transformar "la seu d'urgell" a "La Seu D'Urgell"
    return mb_convert_case($poblacio, MB_CASE_TITLE, "UTF-8");
}