

<div class="col-md-8 col-md-offset-2">
    <h2>Se connecter</h2>

<form action="/auth/login" method="POST">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    
    <div class="form-group">
        <label for="mail">Mail</label>
        <input type="email" id="mail" class="form-control" name="mail"
               value="<?= htmlspecialchars($_POST['mail'] ?? '') ?>">
        <?php if (!empty($errors['mail'])): ?>
            <span class="text-danger"><?= htmlspecialchars($errors['mail']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" id="password" class="form-control" name="password">
        <?php if (!empty($errors['password'])): ?>
            <span class="text-danger"><?= htmlspecialchars($errors['password']) ?></span>
        <?php endif; ?>
    </div>

    <input type="submit" class="btn btn-primary" value="Se connecter">
</form>

</div>