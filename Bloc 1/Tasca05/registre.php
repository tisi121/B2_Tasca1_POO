<?php
session_start();

// Generar token CSRF segur si no existeix a la sessió
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Recuperar errors i valors introduïts prèviament
$errors = $_SESSION['errors'] ?? [];
$dades = $_SESSION['dades_form'] ?? [];

// Esborrar errors i dades de la sessió perquè no tornin a aparèixer en recarregar (F5)
unset($_SESSION['errors'], $_SESSION['dades_form']);

require_once __DIR__ . '/includes/header.php';
?>

<h2>Registre d'Usuari</h2>
<p><a href="index.php">&larr; Tornar a l'índex</a></p>

<form action="valida_registre.php" method="post" novalidate>
    <!-- Camp ocult per al token CSRF -->
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

    <!-- Nom -->
    <div class="form-group">
        <label for="nom">Nom: *</label>
        <input type="text" id="nom" name="nom" 
               class="<?= isset($errors['nom']) ? 'camp-error' : '' ?>"
               value="<?= htmlspecialchars($dades['nom'] ?? '') ?>" required maxlength="50">
        <?php if (isset($errors['nom'])): ?>
            <div class="missatge-error"><?= htmlspecialchars($errors['nom']) ?></div>
        <?php endif; ?>
    </div>

    <!-- Email -->
    <div class="form-group">
        <label for="email">Correu electrònic: *</label>
        <input type="email" id="email" name="email" 
               class="<?= isset($errors['email']) ? 'camp-error' : '' ?>"
               value="<?= htmlspecialchars($dades['email'] ?? '') ?>" required>
        <?php if (isset($errors['email'])): ?>
            <div class="missatge-error"><?= htmlspecialchars($errors['email']) ?></div>
        <?php endif; ?>
    </div>

    <!-- Edat -->
    <div class="form-group">
        <label for="edat">Edat: *</label>
        <input type="number" id="edat" name="edat" 
               class="<?= isset($errors['edat']) ? 'camp-error' : '' ?>"
               value="<?= htmlspecialchars($dades['edat'] ?? '') ?>" required min="18" max="120">
        <?php if (isset($errors['edat'])): ?>
            <div class="missatge-error"><?= htmlspecialchars($errors['edat']) ?></div>
        <?php endif; ?>
    </div>

    <!-- Telèfon -->
    <div class="form-group">
        <label for="telefon">Telèfon (opcional):</label>
        <input type="text" id="telefon" name="telefon" 
               class="<?= isset($errors['telefon']) ? 'camp-error' : '' ?>"
               value="<?= htmlspecialchars($dades['telefon'] ?? '') ?>">
        <?php if (isset($errors['telefon'])): ?>
            <div class="missatge-error"><?= htmlspecialchars($errors['telefon']) ?></div>
        <?php endif; ?>
    </div>

    <!-- Població -->
    <div class="form-group">
        <label for="poblacio">Població: *</label>
        <input type="text" id="poblacio" name="poblacio" 
               class="<?= isset($errors['poblacio']) ? 'camp-error' : '' ?>"
               value="<?= htmlspecialchars($dades['poblacio'] ?? '') ?>" required maxlength="50">
        <?php if (isset($errors['poblacio'])): ?>
            <div class="missatge-error"><?= htmlspecialchars($errors['poblacio']) ?></div>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn">Enviar Registre</button>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>