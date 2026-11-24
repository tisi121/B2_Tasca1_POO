<?php
require_once 'includes/functions.php';

// Array base predefinit
$temperaturesBase = [
    78, 60, 62, 68, 71, 68, 73, 85, 66, 64, 76, 63, 75, 76, 73,
    68, 62, 73, 72, 65, 74, 62, 62, 65, 64, 68, 73, 75, 79, 73
];

// Estat de temperatures mantingut a través de POST
if (isset($_POST['temps_estat']) && !empty($_POST['temps_estat'])) {
    $tempsArray = json_decode($_POST['temps_estat'], true);
} else {
    $tempsArray = $temperaturesBase;
}

// Afegir nova temperatura si s'envia el formulari
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nova_temp']) && $_POST['nova_temp'] !== '') {
    $nova = floatval($_POST['nova_temp']);
    $tempsArray[] = $nova;
}

// Escala seleccionada (F o C)
$escala = $_GET['escala'] ?? ($_POST['escala'] ?? 'F');

// Preparem les dades a mostrar segons l'escala
$simbol = ($escala === 'C') ? '°C' : '°F';
$tempsConvertides = [];
foreach ($tempsArray as $t) {
    $tempsConvertides[] = ($escala === 'C') ? fahrenheitACelsius((float)$t) : (float)$t;
}

// Càlculs
$mitjana = calcularMitjana($tempsConvertides);
$mediana = calcularMediana($tempsConvertides);
$maxima = !empty($tempsConvertides) ? max($tempsConvertides) : 0;
$minima = !empty($tempsConvertides) ? min($tempsConvertides) : 0;
$top5Altes = obtenirTop5Altes($tempsConvertides);
$top5Baixes = obtenirTop5Baixes($tempsConvertides);

require_once 'includes/header.php';
?>

<h2>Anàlisi de Temperatures</h2>

<!-- Formularis superiors -->
<div class="row my-4 g-3 align-items-center">
    <div class="col-md-6">
        <form action="" method="post" class="d-flex gap-2">
            <!-- Camp ocult per mantenir l'estat de les dades -->
            <input type="hidden" name="temps_estat" value="<?= htmlspecialchars(json_encode($tempsArray)) ?>">
            <input type="hidden" name="escala" value="<?= htmlspecialchars($escala) ?>">
            
            <input type="number" step="0.1" name="nova_temp" class="form-control" placeholder="Afegir nova temperatura (°F)" required>
            <button type="submit" class="btn btn-primary">Afegir</button>
        </form>
    </div>
    <div class="col-md-6 text-md-end">
        <span>Escala de temperatura: </span>
        <div class="btn-group" role="group">
            <a href="?escala=F" class="btn btn-outline-primary <?= $escala === 'F' ? 'active' : '' ?>">Fahrenheit</a>
            <a href="?escala=C" class="btn btn-outline-primary <?= $escala === 'C' ? 'active' : '' ?>">Celsius</a>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Estadístiques Bàsiques -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header fw-bold">Estadístiques Bàsiques</div>
            <div class="card-body">
                <table class="table mb-0">
                    <tr><td>Mitjana:</td><td class="text-end fw-bold"><?= number_format($mitjana, 2) ?><?= $simbol ?></td></tr>
                    <tr><td>Mediana:</td><td class="text-end fw-bold"><?= number_format($mediana, 2) ?><?= $simbol ?></td></tr>
                    <tr><td>Temperatura màxima:</td><td class="text-end fw-bold"><?= number_format($maxima, 2) ?><?= $simbol ?></td></tr>
                    <tr><td>Temperatura mínima:</td><td class="text-end fw-bold"><?= number_format($minima, 2) ?><?= $simbol ?></td></tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Top 5 Temperatures -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header fw-bold">Top 5 Temperatures</div>
            <div class="card-body">
                <h6>Més altes:</h6>
                <p class="mb-2"><?= implode(' | ', array_map(fn($v) => number_format($v, 2) . $simbol, $top5Altes)) ?></p>
                <hr>
                <h6>Més baixes:</h6>
                <p class="mb-0"><?= implode(' | ', array_map(fn($v) => number_format($v, 2) . $simbol, $top5Baixes)) ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Llista completa -->
<div class="card mt-4">
    <div class="card-header fw-bold">Totes les temperatures</div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th style="width: 10%;">#</th>
                    <th>Temperatura (<?= $simbol ?>)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tempsConvertides as $i => $val): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= number_format($val, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>