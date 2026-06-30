
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

<script src="/assets/js/dashboard-chauffeur.js"></script>