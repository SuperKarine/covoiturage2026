<?php 
require_once APP_ROOT . "/public/templates/layout/header.php"; ?>


<main>
    <h2>Voici nos véhicules<span class="badge bg-secondary"> Nos véhicules</span></h2>
    <br>

    <!-- Affichage de la voiture -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Informations sur le véhicule </h5>
            <p><strong>Marque :</strong> <?=htmlspecialchars($marque)?></p>
            <p><strong>Modele :</strong> <?=htmlspecialchars($modele)?></p>
            <p><strong>Couleur:</strong> <?=htmlspecialchars($couleur)?></p>
            <p><strong>Plaque Immatriculation:</strong> <?=htmlspecialchars($plaqueImmatriculation)?></p>
            <p><strong>Date 1ère mise en circulation:</strong> <?=htmlspecialchars($Date1MiseEnCirculation)?></p>
        </div>
    </div>

    
</main>

<?php require_once APP_ROOT . "/public/templates/layout/footer.php" ?>