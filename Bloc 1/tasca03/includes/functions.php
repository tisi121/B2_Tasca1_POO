<?php
// ==========================================
// EXERCICI 1: CAPITALS EUROPEES
// ==========================================

// Ordena l'array associatiu per valor (capital) mantenint el país (clau)
function ordenarPerCapital(array $array): array {
    asort($array);
    return $array;
}

// Filtra per cerca parcial en país o capital sense distingir majúscules
function cercarPaisOCapital(array $array, string $cerca): array {
    if (trim($cerca) === '') return $array;
    $resultat = [];
    foreach ($array as $pais => $capital) {
        if (stripos($pais, $cerca) !== false || stripos($capital, $cerca) !== false) {
            $resultat[$pais] = $capital;
        }
    }
    return $resultat;
}

// Filtra per la primera lletra del país
function filtrarPerLletraInicial(array $array, string $lletra): array {
    if ($lletra === '' || $lletra === 'Totes') return $array;
    $resultat = [];
    foreach ($array as $pais => $capital) {
        if (strtoupper($pais[0]) === strtoupper($lletra)) {
            $resultat[$pais] = $capital;
        }
    }
    return $resultat;
}

// ==========================================
// EXERCICI 2: TEMPERATURES
// ==========================================

function fahrenheitACelsius(float $f): float {
    return round(($f - 32) * 5 / 9, 2);
}

function calcularMitjana(array $temps): float {
    if (empty($temps)) return 0.0;
    return round(array_sum($temps) / count($temps), 2);
}

function calcularMediana(array $temps): float {
    if (empty($temps)) return 0.0;
    sort($temps);
    $n = count($temps);
    $mig = (int) floor($n / 2);
    if ($n % 2 !== 0) {
        return (float) $temps[$mig];
    }
    return round(($temps[$mig - 1] + $temps[$mig]) / 2, 2);
}

function obtenirTop5Altes(array $temps): array {
    rsort($temps);
    return array_slice($temps, 0, 5);
}

function obtenirTop5Baixes(array $temps): array {
    sort($temps);
    return array_slice($temps, 0, 5);
}

// ==========================================
// EXERCICI 3: ARRAYS ASSOCIATIUS
// ==========================================

// Combinar utilitzant bucle
function combinarAmbBucle(array $keys, array $values): array {
    $resultat = [];
    $kList = array_values($keys);
    $vList = array_values($values);
    for ($i = 0; $i < count($kList); $i++) {
        if (isset($vList[$i])) {
            $resultat[$kList[$i]] = $vList[$i];
        }
    }
    return $resultat;
}

// Combinar utilitzant array_combine
function combinarAmbArrayCombine(array $keys, array $values): array {
    return array_combine(array_values($keys), array_values($values));
}

// ==========================================
// EXERCICI 4: ACADÈMIA D'IDIOMES
// ==========================================

function comptarTotalAlumnes(array $academia): int {
    $total = 0;
    foreach ($academia as $nivell => $idiomes) {
        foreach ($idiomes as $alumnes) {
            $total += count($alumnes);
        }
    }
    return $total;
}

function comptarTotalPerIdioma(array $academia, string $idioma): int {
    $total = 0;
    foreach ($academia as $nivell => $idiomes) {
        if (isset($idiomes[$idioma])) {
            $total += count($idiomes[$idioma]);
        }
    }
    return $total;
}

function buscarGrupExtrem(array $academia, bool $max = true): array {
    $extrem = $max ? -1 : PHP_INT_MAX;
    $grupExtrem = ['nivell' => '', 'idioma' => '', 'total' => 0];

    foreach ($academia as $nivell => $idiomes) {
        foreach ($idiomes as $idioma => $alumnes) {
            $cnt = count($alumnes);
            if ($max ? ($cnt > $extrem) : ($cnt < $extrem)) {
                $extrem = $cnt;
                $grupExtrem = ['nivell' => $nivell, 'idioma' => $idioma, 'total' => $cnt];
            }
        }
    }
    return $grupExtrem;
}

function calcularMitjanaPerNivell(array $academia, string $nivell): float {
    if (!isset($academia[$nivell])) return 0.0;
    $total = 0;
    $numIdiomes = count($academia[$nivell]);
    foreach ($academia[$nivell] as $alumnes) {
        $total += count($alumnes);
    }
    return $numIdiomes > 0 ? round($total / $numIdiomes, 2) : 0.0;
}

function calcularMitjanaPerIdioma(array $academia, string $idioma): float {
    $total = 0;
    $numNivells = count($academia);
    foreach ($academia as $nivell => $idiomes) {
        if (isset($idiomes[$idioma])) {
            $total += count($idiomes[$idioma]);
        }
    }
    return $numNivells > 0 ? round($total / $numNivells, 2) : 0.0;
}

function cercarAlumnePerNom(array $academia, string $nom): array {
    $trobats = [];
    if (trim($nom) === '') return $trobats;
    foreach ($academia as $nivell => $idiomes) {
        foreach ($idiomes as $idioma => $alumnes) {
            foreach ($alumnes as $a) {
                if (stripos($a, $nom) !== false) {
                    $trobats[] = ['nom' => $a, 'nivell' => $nivell, 'idioma' => $idioma];
                }
            }
        }
    }
    return $trobats;
}