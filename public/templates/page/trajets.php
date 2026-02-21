<?php 
require_once APP_ROOT . "/public/templates/layout/header.php"; ?>


<main>
    <h2>Voir un trajet<span class="badge bg-secondary"> Nos trajets </span></h2>
    <br>

    <h6>Numéro du trajet <span class="badge bg-secondary"><?=htmlspecialchars($num_trajet)?></span></h6>

    <!-- Affichage du trajet -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Informations du trajet</h5>
            <p><strong>Ville départ :</strong> <?=htmlspecialchars($ville_depart)?></p>
            <p><strong>Ville arrivée :</strong> <?=htmlspecialchars($ville_arrivee)?></p>
            <p><strong>Date et heure de départ :</strong> <?=htmlspecialchars($date_depart)?></p>
            <p><strong>Places disponibles :</strong> <?=htmlspecialchars($nbr_place_trajet)?></p>
            <p><strong>Chauffeur :</strong> <?=htmlspecialchars($pseudo_chauffeur)?></p>
        </div>
    </div>


</main>

<?php require_once APP_ROOT . "/public/templates/layout/footer.php" ?>