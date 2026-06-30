
<h1>Bonjour <?= htmlspecialchars($toName) ?>,</h1>

<?php if ($accepte): ?>
    <p>Bonne nouvelle ! Votre demande pour devenir chauffeur a été <strong>acceptée</strong>.</p>
    <p>Vous pouvez désormais accéder à votre espace chauffeur et proposer vos premiers trajets.</p>
<?php else: ?>
    <p>Après examen de votre dossier, nous sommes au regret de vous informer que votre demande pour devenir chauffeur a été <strong>refusée</strong>.</p>
    <p>N'hésitez pas à nous contacter pour plus d'informations.</p>
<?php endif; ?>

<p>Cordialement,<br>L'équipe Covoiturage2026</p>