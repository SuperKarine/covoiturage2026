
<h1 class="mb-4">Mon espace passager</h1>

<a href="/trajets" class="btn btn-primary mb-4">Rechercher un trajet</a>

<h2 class="mt-5">Devenir chauffeur</h2>
<p class="text-muted">Vous souhaitez proposer des trajets ? Soumettez une demande, notre équipe vous contactera.</p>
<button id="btn-devenir-chauffeur" class="btn btn-success mb-4">Faire une demande</button>
<div id="msg-demande" class="mt-2"></div>

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
                <th>Noter</th>
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
                        <?php if ($reservation['status'] === 'confirmee' && $reservation['trajet_termine']): ?>
                            <div class="etoiles" data-id-trajet="<?= $reservation['id_trajet'] ?>" data-id-chauffeur="<?= $reservation['id_chauffeur'] ?>">
                                <span class="etoile" data-valeur="1">&#9734;</span>
                                <span class="etoile" data-valeur="2">&#9734;</span>
                                <span class="etoile" data-valeur="3">&#9734;</span>
                                <span class="etoile" data-valeur="4">&#9734;</span>
                                <span class="etoile" data-valeur="5">&#9734;</span>
                            </div>
                        <?php endif; ?>
                    </td>
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

<script>
    const idPassagerConnecte = <?= (int) $_SESSION['user_id'] ?>;
</script>

<script src="/assets/js/dashboard-passager.js"></script>
<script src="/assets/js/notation.js"></script>
<script src="/assets/js/devenir-chauffeur.js"></script>