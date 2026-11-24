<?php
require_once 'includes/functions.php';

$ceu = array(
    "Italy"=>"Rome", "Luxembourg"=>"Luxembourg", "Belgium"=> "Brussels",
    "Denmark"=>"Copenhagen", "Finland"=>"Helsinki", "France" => "Paris",
    "Slovakia"=>"Bratislava", "Slovenia"=>"Ljubljana", "Germany" => "Berlin",
    "Greece" => "Athens", "Ireland"=>"Dublin", "Netherlands"=>"Amsterdam",
    "Portugal"=>"Lisbon", "Spain"=>"Madrid", "Sweden"=>"Stockholm",
    "United Kingdom"=>"London", "Cyprus"=>"Nicosia", "Lithuania"=>"Vilnius",
    "Czech Republic"=>"Prague", "Estonia"=>"Tallinn", "Hungary"=>"Budapest",
    "Latvia"=>"Riga", "Malta"=>"Valletta", "Austria" => "Vienna",
    "Poland"=>"Warsaw"
);

// Obtenim lletres úniques per al selector
$lletres = [];
foreach (array_keys($ceu) as $p) {
    $lletres[] = strtoupper($p[0]);
}
$lletres = array_unique($lletres);
sort($lletres);

// 1. Primer ordenem per capital
$dades = ordenarPerCapital($ceu);

// 2. Filtres per GET
$cerca = $_GET['cerca'] ?? '';
$lletraSeleccionada = $_GET['lletra'] ?? 'Totes';

if ($cerca !== '') {
    $dades = cercarPaisOCapital($dades, $cerca);
}
if ($lletraSeleccionada !== 'Totes' && $lletraSeleccionada !== '') {
    $dades = filtrarPerLletraInicial($dades, $lletraSeleccionada);
}

require_once 'includes/header.php';
?>

<h2>Capitals Europees</h2>

<form action="" method="get" class="row g-3 my-3 p-3 bg-white border rounded">
    <div class="col-md-5">
        <label for="cerca" class="form-label">Cerca per país o capital:</label>
        <input type="text" name="cerca" id="cerca" class="form-control" value="<?= htmlspecialchars($cerca) ?>">
    </div>
    <div class="col-md-4">
        <label for="lletra" class="form-label">Filtrar per lletra inicial:</label>
        <select name="lletra" id="lletra" class="form-select">
            <option value="Totes">Totes</option>
            <?php foreach ($lletres as $l): ?>
                <option value="<?= $l ?>" <?= $lletraSeleccionada === $l ? 'selected' : '' ?>><?= $l ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100">Cercar</button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-striped table-bordered bg-white">
        <thead class="table-light">
            <tr>
                <th>País</th>
                <th>Capital</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($dades)): ?>
                <?php foreach ($dades as $pais => $capital): ?>
                    <tr>
                        <td><?= htmlspecialchars($pais) ?></td>
                        <td><?= htmlspecialchars($capital) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2" class="text-center text-muted">No s'han trobat resultats.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'includes/footer.php'; ?>