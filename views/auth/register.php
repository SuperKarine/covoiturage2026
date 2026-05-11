<?php

session_start(); 
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);
?>


<div class="col-md-8 col-md-offset-2">
    <h2>S'inscrire</h2>
<form action="/auth" method="POST">
    <fieldset>
    <div class="form-group">
    <label for="pseudo">Nom d'utilisateur</label>
    <input type="text" id="pseudo" class="form-control" name="username"
           value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
    <?php if (!empty($errors['username'])): ?>
        <span class="text-danger"><?= htmlspecialchars($errors['username']) ?></span>
    <?php endif; ?>
</div>

<div class="form-group">
    <label for="email">Email</label>
    <input type="email" id="email" class="form-control" name="email"
           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
    <?php if (!empty($errors['email'])): ?>
        <span class="text-danger"><?= htmlspecialchars($errors['email']) ?></span>
    <?php endif; ?>
</div>

<div class="form-group">
    <label for="password">Mot de passe</label>
    <input type="password" id="password" class="form-control" name="password">
    <?php if (!empty($errors['password'])): ?>
        <span class="text-danger"><?= htmlspecialchars($errors['password']) ?></span>
    <?php endif; ?>
</div>

<div class="form-group">
    <label for="password_confirm">Confirmation mot de passe</label>
    <input type="password" id="password_confirm" class="form-control" name="password_confirm">
</div>
       
    <input type="submit" class="btn btn-primary"  value="s'inscrire">
    </fieldset>
</form>


</div>


