<?php 
require_once APP_ROOT . "/public/templates/layout/header.php"; ?>


<main>
    <h2>Réserver un trajet<span class="badge bg-secondary"> Réservation</span></h2>
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

    <!-- Affichage des infos utilisateur  -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Vos informations de réservation</h5>
            <p><strong>Passager :</strong> <?=htmlspecialchars($user_prenom)?> <?=htmlspecialchars($user_nom)?></p>
            <p><strong>Email :</strong> <?=htmlspecialchars($user_email)?></p>
        </div>
    </div>

    <!-- Formulaire de creation vehicules -->
    <form class="row g-3" method="POST" action="">
        <input type="hidden" name="id_voitures" value="<?=$id_voitures?>">
        
        <div class="col-md-6">
            <label for="Marque" class="form-label">Marque du véhicule</label>
            <input type="text" class="form-control" id="inputMarque" name="marque" 
                   value="<?=$marque?>">
        </div>

        <div class="col-md-6">
            <label for="Modele" class="form-label">Modele</label>
            <input type="text" class="form-control" id="inputModele" name="modele" 
                   value="<?=$modele?>">
        </div>

        <div class="col-md-6">
            <label for="Couleur" class="form-label">Couleur du véhicule</label>
            <input type="text" class="form-control" id="inputCoulelur" name="couleur" 
                   value="<?=$couleur?>">
        </div>

        <div class="col-md-6">
            <label for="PlaqueImmatriculation" class="form-label">Plaque Immatriculation</label>
            <input type="text" class="form-control" id="inputPlaqueImmatriculation" name="plaqueImmatriculation" 
                   value="<?=$plaqueImmatriculation?>">
        </div>

        <div class="col-md-6">
            <label for="Date1MiseEnCirculation" class="form-label">Date 1ère mise en circulation</label>
            <input type="date" class="form-control" id="inputDate1MiseEnCirculation" name="Date1MiseEnCirculation" 
                   value="<?=$Date1MiseEnCirculation?>">
        </div>
        
        <div class="col-12">
            <button type="submit" class="btn btn-primary">
    
    </form>
</main>

<?php require_once APP_ROOT . "/public/templates/layout/footer.php" ?>