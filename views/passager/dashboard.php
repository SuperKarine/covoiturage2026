
<h1 class="mb-4">Mon espace passager</h1>

<a href="/trajets" class="btn btn-primary mb-4">Rechercher un trajet</a>

<h2>Mes réservations</h2>

<?php if (empty($mesReservations)): ?>
    <p class="text-muted">Vous n'avez pas encore de réservation.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>Trajet</th>
                <th>Date</th>
                <th>Prix</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mesReservations as $reservation): ?>
                <tr>
                    <td><?= htmlspecialchars($reservation['ville_depart']) ?> → <?= htmlspecialchars($reservation['ville_arrivee']) ?></td>
                    <td><?= htmlspecialchars($reservation['date_depart']) ?></td>
                    <td><?= htmlspecialchars($reservation['prix']) ?> €</td>
                    <td><?= htmlspecialchars($reservation['status']) ?></td>
                    <td>
                        <?php if (in_array($reservation['status'], ['en_attente', 'confirmee'])): ?>
                            <button class="btn btn-sm btn-danger" onclick="annulerReservation(<?= $reservation['id_reservation'] ?>)">Annuler</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<script src="/assets/js/dashboard-passager.js"></script>