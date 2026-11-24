<?php
require_once 'includes/functions.php';

// Arrays inicials
$keysDefault = [
    "field1" => "first",
    "field2" => "second",
    "field3" => "third"
];

$valuesDefault = [
    "field1value" => "dinosaur",
    "field2value" => "pig",
    "field3value" => "platypus"
];

// Estat mantingut per hidden field
if (isset($_POST['combinat_estat']) && !empty($_POST['combinat_estat'])) {
    $combinat = json_decode($_POST['combinat_estat'], true);
} else {
    // Si és la primera càrrega, provem les dues funcions requerides
    $combinatBucle = combinarAmbBucle($keysDefault, $valuesDefault);
    $combinat = combinarAmbArrayCombine($keysDefault, $valuesDefault);
}

// Processament d'accions POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accio = $_POST['accio'] ?? '';

    if ($accio === 'afegir' && !empty($_POST['nova_clau']) && !empty($_POST['nou_valor'])) {
        $combinat[trim($_POST['nova_clau'])] = trim($_POST['nou_valor']);
    } elseif ($accio === 'modificar' && isset($_POST['clau_mod']) && isset($_POST['nou_valor_mod'])) {
        $k = $_POST['clau_mod'];
        if (isset($combinat[$k])) {
            $combinat[$k] = trim($_POST['nou_valor_mod']);
        }
    } elseif ($accio === 'eliminar' && isset($_POST['clau_del'])) {
        unset($combinat[$_POST['clau_del']]);
    }
}

require_once 'includes/header.php';
?>

<h2>Arrays Associatius</h2>

<div class="row mt-4 g-4">
    <!-- Formulari per Afegir -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header fw-bold">Afegir nova parella clau-valor</div>
            <div class="card-body">
                <form action="" method="post">
                    <input type="hidden" name="combinat_estat" value="<?= htmlspecialchars(json_encode($combinat)) ?>">
                    <input type="hidden" name="accio" value="afegir">

                    <div class="mb-3">
                        <label for="nova_clau" class="form-label">Clau:</label>
                        <input type="text" name="nova_clau" id="nova_clau" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="nou_valor" class="form-label">Valor:</label>
                        <input type="text" name="nou_valor" id="nou_valor" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Afegir parella</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Taula i edició de valors -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header fw-bold">Resultat de l'Array Associatiu</div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Clau</th>
                            <th>Valor</th>
                            <th style="width: 35%;">Accions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($combinat)): ?>
                            <?php foreach ($combinat as $clau => $valor): ?>
                                <tr>
                                    <td class="fw-bold"><?= htmlspecialchars($clau) ?></td>
                                    <td>
                                        <!-- Formulari per modificar -->
                                        <form action="" method="post" class="d-flex gap-1">
                                            <input type="hidden" name="combinat_estat" value="<?= htmlspecialchars(json_encode($combinat)) ?>">
                                            <input type="hidden" name="accio" value="modificar">
                                            <input type="hidden" name="clau_mod" value="<?= htmlspecialchars($clau) ?>">
                                            <input type="text" name="nou_valor_mod" value="<?= htmlspecialchars($valor) ?>" class="form-control form-control-sm">
                                            <button type="submit" class="btn btn-sm btn-outline-success">Guardar</button>
                                        </form>
                                    </td>
                                    <td>
                                        <!-- Formulari per eliminar -->
                                        <form action="" method="post">
                                            <input type="hidden" name="combinat_estat" value="<?= htmlspecialchars(json_encode($combinat)) ?>">
                                            <input type="hidden" name="accio" value="eliminar">
                                            <input type="hidden" name="clau_del" value="<?= htmlspecialchars($clau) ?>">
                                            <button type="submit" class="btn btn-sm btn-danger w-100" onclick="return confirm('Segur que vols eliminar aquesta clau?')">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="3" class="text-center text-muted">L'array és buit.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>