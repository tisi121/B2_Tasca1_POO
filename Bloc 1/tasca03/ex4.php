<?php
require_once 'includes/functions.php';

// Matriu bidimensional per defecte (Nivells x Idiomes => Alumnes)
$academiaDefault = [
    'Bàsic' => [
        'Anglès' => ['Marc', 'Laura', 'Pol'],
        'Francès' => ['Anna', 'David'],
        'Alemany' => ['Sergi'],
        'Rus' => []
    ],
    'Mitjà' => [
        'Anglès' => ['Marta', 'Jordi', 'Pau', 'Clara'],
        'Francès' => ['Carla'],
        'Alemany' => ['Arnau', 'Helena'],
        'Rus' => ['Igor']
    ],
    'Perfeccionament' => [
        'Anglès' => ['Laia', 'Xavier'],
        'Francès' => ['Roger'],
        'Alemany' => ['Sílvia'],
        'Rus' => []
    ]
];

// Gestió de l'estat amb camp ocult
if (isset($_POST['academia_estat']) && !empty($_POST['academia_estat'])) {
    $academia = json_decode($_POST['academia_estat'], true);
} else {
    $academia = $academiaDefault;
}

$nivells = ['Bàsic', 'Mitjà', 'Perfeccionament'];
$idiomes = ['Anglès', 'Francès', 'Alemany', 'Rus'];

// Processament de formularis POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accio = $_POST['accio'] ?? '';

    // Afegir alumne
    if ($accio === 'afegir' && !empty($_POST['nom']) && !empty($_POST['nivell']) && !empty($_POST['idioma'])) {
        $niv = $_POST['nivell'];
        $idi = $_POST['idioma'];
        $academia[$niv][$idi][] = trim($_POST['nom']);
    }

    // Eliminar alumne
    if ($accio === 'eliminar' && isset($_POST['nivell'], $_POST['idioma'], $_POST['nom'])) {
        $niv = $_POST['nivell'];
        $idi = $_POST['idioma'];
        $nom = $_POST['nom'];
        $key = array_search($nom, $academia[$niv][$idi]);
        if ($key !== false) {
            unset($academia[$niv][$idi][$key]);
            $academia[$niv][$idi] = array_values($academia[$niv][$idi]); // Reindexar
        }
    }

    // Moure alumne entre grups
    if ($accio === 'moure' && !empty($_POST['nom']) && !empty($_POST['origen_n']) && !empty($_POST['origen_i']) && !empty($_POST['desti_n']) && !empty($_POST['desti_i'])) {
        $nom = $_POST['nom'];
        $origN = $_POST['origen_n'];
        $origI = $_POST['origen_i'];
        $destN = $_POST['desti_n'];
        $destI = $_POST['desti_i'];

        $key = array_search($nom, $academia[$origN][$origI]);
        if ($key !== false) {
            unset($academia[$origN][$origI][$key]);
            $academia[$origN][$origI] = array_values($academia[$origN][$origI]);
            $academia[$destN][$destI][] = $nom;
        }
    }
}

// Cerca d'alumne per GET
$cercaNom = $_GET['cerca_alumne'] ?? '';
$resultatsCerca = cercarAlumnePerNom($academia, $cercaNom);

// Càlculs estadístics
$totalAlumnes = comptarTotalAlumnes($academia);
$grupMes = buscarGrupExtrem($academia, true);
$grupMenys = buscarGrupExtrem($academia, false);

require_once 'includes/header.php';
?>

<h2>Gestió d'Acadèmia d'Idiomes</h2>

<!-- Taula general de grups i alumnes -->
<div class="card my-4">
    <div class="card-header fw-bold">Distribució d'Alumnes per Grup</div>
    <div class="card-body p-0">
        <table class="table table-bordered mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nivell \ Idioma</th>
                    <?php foreach ($idiomes as $idioma): ?>
                        <th><?= htmlspecialchars($idioma) ?></th>
                    <?php endforeach; ?>
                    <th>Mitjana Nivell</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($nivells as $nivell): ?>
                    <tr>
                        <th class="table-light"><?= htmlspecialchars($nivell) ?></th>
                        <?php foreach ($idiomes as $idioma): ?>
                            <td>
                                <strong>(<?= count($academia[$nivell][$idioma]) ?>)</strong><br>
                                <?php foreach ($academia[$nivell][$idioma] as $alumne): ?>
                                    <span class="badge bg-secondary mb-1">
                                        <?= htmlspecialchars($alumne) ?>
                                        <form action="" method="post" style="display:inline;">
                                            <input type="hidden" name="academia_estat" value="<?= htmlspecialchars(json_encode($academia)) ?>">
                                            <input type="hidden" name="accio" value="eliminar">
                                            <input type="hidden" name="nivell" value="<?= htmlspecialchars($nivell) ?>">
                                            <input type="hidden" name="idioma" value="<?= htmlspecialchars($idioma) ?>">
                                            <input type="hidden" name="nom" value="<?= htmlspecialchars($alumne) ?>">
                                            <button type="submit" class="btn-close btn-close-white" style="font-size:0.65rem;" title="Eliminar"></button>
                                        </form>
                                    </span>
                                <?php endforeach; ?>
                            </td>
                        <?php endforeach; ?>
                        <td class="fw-bold"><?= calcularMitjanaPerNivell($academia, $nivell) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="table-light">
                <tr>
                    <th>Total Idioma</th>
                    <?php foreach ($idiomes as $idioma): ?>
                        <th><?= comptarTotalPerIdioma($academia, $idioma) ?></th>
                    <?php endforeach; ?>
                    <th>Total: <?= $totalAlumnes ?></th>
                </tr>
                <tr>
                    <th>Mitjana Idioma</th>
                    <?php foreach ($idiomes as $idioma): ?>
                        <th><?= calcularMitjanaPerIdioma($academia, $idioma) ?></th>
                    <?php endforeach; ?>
                    <th>-</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- Estadístiques de grups extrems -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="alert alert-info mb-0">
            <strong>Grup més nombrós:</strong> <?= $grupMes['nivell'] ?> - <?= $grupMes['idioma'] ?> (<?= $grupMes['total'] ?> alumnes)
        </div>
    </div>
    <div class="col-md-6">
        <div class="alert alert-warning mb-0">
            <strong>Grup menys nombrós:</strong> <?= $grupMenys['nivell'] ?> - <?= $grupMenys['idioma'] ?> (<?= $grupMenys['total'] ?> alumnes)
        </div>
    </div>
</div>

<!-- Secció de Formularis (Afegir, Moure i Cercar) -->
<div class="row g-4">
    <!-- Formulari Afegir -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header fw-bold">Afegir Alumne</div>
            <div class="card-body">
                <form action="" method="post">
                    <input type="hidden" name="academia_estat" value="<?= htmlspecialchars(json_encode($academia)) ?>">
                    <input type="hidden" name="accio" value="afegir">

                    <div class="mb-2">
                        <label class="form-label">Nom:</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Nivell:</label>
                        <select name="nivell" class="form-select">
                            <?php foreach ($nivells as $n): ?><option value="<?= $n ?>"><?= $n ?></option><?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Idioma:</label>
                        <select name="idioma" class="form-select">
                            <?php foreach ($idiomes as $i): ?><option value="<?= $i ?>"><?= $i ?></option><?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Afegir</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Formulari Moure -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header fw-bold">Moure Alumne de Grup</div>
            <div class="card-body">
                <form action="" method="post">
                    <input type="hidden" name="academia_estat" value="<?= htmlspecialchars(json_encode($academia)) ?>">
                    <input type="hidden" name="accio" value="moure">

                    <div class="mb-2">
                        <label class="form-label">Nom de l'alumne:</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col">
                            <label class="form-label">Origen (Nivell):</label>
                            <select name="origen_n" class="form-select"><?php foreach ($nivells as $n): ?><option value="<?= $n ?>"><?= $n ?></option><?php endforeach; ?></select>
                        </div>
                        <div class="col">
                            <label class="form-label">Origen (Idioma):</label>
                            <select name="origen_i" class="form-select"><?php foreach ($idiomes as $i): ?><option value="<?= $i ?>"><?= $i ?></option><?php endforeach; ?></select>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col">
                            <label class="form-label">Destí (Nivell):</label>
                            <select name="desti_n" class="form-select"><?php foreach ($nivells as $n): ?><option value="<?= $n ?>"><?= $n ?></option><?php endforeach; ?></select>
                        </div>
                        <div class="col">
                            <label class="form-label">Destí (Idioma):</label>
                            <select name="desti_i" class="form-select"><?php foreach ($idiomes as $i): ?><option value="<?= $i ?>"><?= $i ?></option><?php endforeach; ?></select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Moure Alumne</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Cerca d'alumnes per GET -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header fw-bold">Cercador d'Alumnes</div>
            <div class="card-body">
                <form action="" method="get" class="mb-3">
                    <label for="cerca_alumne" class="form-label">Nom a cercar:</label>
                    <div class="input-group">
                        <input type="text" name="cerca_alumne" id="cerca_alumne" class="form-control" value="<?= htmlspecialchars($cercaNom) ?>">
                        <button type="submit" class="btn btn-outline-secondary">Cercar</button>
                    </div>
                </form>

                <?php if ($cercaNom !== ''): ?>
                    <h6>Resultats de la cerca:</h6>
                    <?php if (!empty($resultatsCerca)): ?>
                        <ul class="list-group">
                            <?php foreach ($resultatsCerca as $r): ?>
                                <li class="list-group-item">
                                    <strong><?= htmlspecialchars($r['nom']) ?></strong> està a: <br>
                                    <small class="text-muted"><?= htmlspecialchars($r['nivell']) ?> - <?= htmlspecialchars($r['idioma']) ?></small>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-danger small">No s'ha trobat cap alumne amb aquest nom.</p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>