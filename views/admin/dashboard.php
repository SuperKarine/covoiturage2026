
<h1 class="mb-4">Espace administrateur</h1>

<!-- Demandes chauffeur en attente -->
<h2>Demandes pour devenir chauffeur</h2>

<?php if (empty($demandesEnAttente)): ?>
    <p class="text-muted">Aucune demande en attente.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Date de la demande</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($demandesEnAttente as $demande): ?>
                <tr>
                    <td><?= htmlspecialchars($demande['prenom'] . ' ' . $demande['nom']) ?></td>
                    <td><?= htmlspecialchars($demande['mail']) ?></td>
                    <td><?= htmlspecialchars($demande['date_demande']) ?></td>
                    <td>
                        <button class="btn btn-success btn-sm" onclick="accepterDemande(<?= $demande['id_demande'] ?>)">Accepter</button>
                        <button class="btn btn-danger btn-sm" onclick="refuserDemande(<?= $demande['id_demande'] ?>)">Refuser</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<hr class="my-5">

<!-- Vue globale des trajets -->
<h2>Tous les trajets</h2>

<?php if (empty($tousLesTrajets)): ?>
    <p class="text-muted">Aucun trajet enregistré.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>Trajet</th>
                <th>Date</th>
                <th>Prix</th>
                <th>Chauffeur</th>
                <th>Places dispo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tousLesTrajets as $trajet): ?>
                <tr>
                    <td><?= htmlspecialchars($trajet['ville_depart']) ?> → <?= htmlspecialchars($trajet['ville_arrivee']) ?></td>
                    <td><?= htmlspecialchars($trajet['date_depart']) ?></td>
                    <td><?= htmlspecialchars($trajet['prix']) ?> €</td>
                    <td><?= htmlspecialchars($trajet['chauffeur_prenom'] . ' ' . $trajet['chauffeur_nom']) ?></td>
                    <td><?= htmlspecialchars($trajet['nbr_places_dispo']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<hr class="my-5">

<!-- Notes par chauffeur -->
<h2>Notes des chauffeurs</h2>

<?php if (empty($notesParChauffeur)): ?>
    <p class="text-muted">Aucune note enregistrée.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>Chauffeur</th>
                <th>Moyenne</th>
                <th>Nombre de notes</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($notesParChauffeur as $note): ?>
                <tr>
                    <td><?= htmlspecialchars($note['prenom'] . ' ' . $note['nom']) ?></td>
                    <td><?= number_format((float) $note['moyenne'], 2) ?> / 5</td>
                    <td><?= htmlspecialchars($note['nombre_notes']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<script src="/assets/js/dashboard-admin.js"></script>