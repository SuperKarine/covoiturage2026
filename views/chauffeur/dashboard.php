
<h1 class="mb-4">Mon espace chauffeur</h1>

<a href="/chauffeur/trajets/ajouter" class="btn btn-primary mb-4">+ Ajouter un trajet</a>

<h2>Mes trajets</h2>

<?php if (empty($trajets)): ?>
    <p class="text-muted">Vous n'avez pas encore de trajet.</p>
<?php else: ?>
    <?php foreach ($trajets as $trajet): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">
                    <?= htmlspecialchars($trajet['ville_depart']) ?> → <?= htmlspecialchars($trajet['ville_arrivee']) ?>
                </h5>
                <p class="card-text">
                    <strong>Date :</strong> <?= htmlspecialchars($trajet['date_depart']) ?><br>
                    <strong>Prix :</strong> <?= htmlspecialchars($trajet['prix']) ?> €<br>
                    <strong>Places disponibles :</strong> <?= htmlspecialchars($trajet['nbr_places_dispo']) ?><br>
                    <strong>Véhicule :</strong> <?= htmlspecialchars($trajet['voiture_modele']) ?>
                </p>

                <h6>Réservations en attente</h6>
                <?php if (empty($trajet['reservations_en_attente'])): ?>
                    <p class="text-muted">Aucune réservation en attente.</p>
                <?php else: ?>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Passager</th>
                                <th>Places demandées</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($trajet['reservations_en_attente'] as $reservation): ?>
                                <tr>
                                    <td><?= htmlspecialchars($reservation['prenom'] . ' ' . $reservation['nom']) ?></td>
                                    <td><?= htmlspecialchars($reservation['nombre_places']) ?></td>
                                    <td>
                                        <button class="btn btn-success btn-sm" onclick="confirmerReservation(<?= $reservation['id_reservation'] ?>)">Confirmer</button>
                                        <button class="btn btn-danger btn-sm" onclick="refuserReservation(<?= $reservation['id_reservation'] ?>)">Refuser</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>


<hr class="my-5">

<h2>Messagerie</h2>

<form id="form-nouveau-message" class="row g-3 mb-4">
    <div class="col-md-4">
        <label for="id_destinataire" class="form-label">Destinataire (ID utilisateur)</label>
        <input type="number" id="id_destinataire" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label for="contenu" class="form-label">Message</label>
        <input type="text" id="contenu" class="form-control" required>
    </div>
    <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100">Envoyer</button>
    </div>
</form>

<?php if (empty($mesMessages)): ?>
    <p class="text-muted">Aucun message.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>De</th>
                <th>Vers</th>
                <th>Message</th>
                <th>Date</th>
                <th>Lu</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mesMessages as $message): ?>
                <tr>
                    <td><?= htmlspecialchars($message['id_expediteur']) ?></td>
                    <td><?= htmlspecialchars($message['id_destinataire']) ?></td>
                    <td><?= htmlspecialchars($message['contenu']) ?></td>
                    <td><?= htmlspecialchars($message['date_envoi']) ?></td>
                    <td><?= $message['lu'] ? 'Oui' : 'Non' ?></td>
                    <td>
                        <?php if (!$message['lu']): ?>
                            <button class="btn btn-sm btn-secondary" onclick="marquerLu('<?= $message['_id'] ?>')">Marquer lu</button>
                        <?php endif; ?>
                        <button class="btn btn-sm btn-danger" onclick="supprimerMessage('<?= $message['_id'] ?>')">Supprimer</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<script>
    const idChauffeurConnecte = <?= (int) $_SESSION['user_id'] ?>;
</script>
<script src="/assets/js/messagerie.js"></script>

<script src="/assets/js/dashboard-chauffeur.js"></script>