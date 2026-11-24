<?php
declare(strict_types=1);
$alumnes = [
    ["nom" => "Anna", "nota" => 8.2],
    ["nom" => "Pau", "nota" => 9.6],
    ["nom" => "Pere", "nota" => 7.22],
    ["nom" => "Laura", "nota" => 10],
    ["nom" => "David",  "nota" => 4.95]
];

function aprovats(array $alumnes, float $minim = 5.0):array {
    $filtrats = array_filter($alumnes, fn($alumne) => $alumne['nota'] >= $minim);
    return array_values($filtrats);
}

function noms(array $alumnes):array {
    return array_column($alumnes, 'nom');
}

function notaMitjana(float ...$notes):float {

    $total=count($notes);

    if ($total === 0) {
        throw new InvalidArgumentException("No s'han passat notes per calcular la mitjana.");
    }

    return array_sum($notes) / $total;
}

$alumnesAprovats = aprovats($alumnes);
$nomsAprovats   = noms($alumnesAprovats);
$notesAprovats  = array_column($alumnesAprovats, 'nota');

// Usem l'operador '...' (splat/unpacking) per passar l'array a arguments variables
$mitjanaAprovats = notaMitjana(...$notesAprovats);


$aprovats = aprovats($alumnes);
$noms = noms($aprovats);

// Sacamos las notas de los aprobados para pasárselas a la función
$notes = array_column($aprovats, 'nota');

$mitjana = round(notaMitjana(...$notes), 2);
$llistaNoms = implode(", ", $noms);

echo "Aprovats: " . $llistaNoms . " (mitjana " . $mitjana . ")";