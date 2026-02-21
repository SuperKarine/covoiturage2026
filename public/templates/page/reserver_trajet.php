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
            <p><strong>Date et heure de départ :</strong> <?=htmlspecialchars($date_heure_depart)?></p>
            <p><strong>Places disponibles :</strong> <?=htmlspecialchars($nbr_place_trajet)?></p>
            <p><strong>Chauffeur :</strong> <?=htmlspecialchars($pseudo_chauffeur)?></p>
        </div>
    </div>

    <!-- Affichage des infos utilisateur  -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Vos informations de réservation</h5>
            <p><strong>Passager :</strong> <?=htmlspecialchars($prenom)?> <?=htmlspecialchars($nom)?></p>
            <p><strong>Email :</strong> <?=htmlspecialchars($email)?></p>
        </div>
    </div>

    <!-- Formulaire de réservation -->
    <form class="row g-3" method="POST" action="">
        <input type="hidden" name="num_trajet" value="<?=$num_trajet?>">
        
        <div class="col-md-6">
            <label for="nbr_places" class="form-label">Nombre de places à réserver *</label>
            <input type="number" class="form-control" id="nbr_places" name="nbr_places"  min="1" 
                   max="<?=$nbr_place_trajet?>" required
                   value="<?= isset($_POST['nbr_places']) ? htmlspecialchars($_POST['nbr_places']) : '' ?>" 
                   placeholder="Nombre de places à réserver (max: <?=$nbr_place_trajet?>)">
            <small class="form-text text-muted">Maximum : <?=$nbr_place_trajet?> places</small>
        </div>
        
        <div class="col-md-6">
            <label for="message" class="form-label">Message au chauffeur</label>
            <textarea class="form-control" id="message" name="message" rows="3"><?= isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '' ?></textarea>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-success me-2">
                <i class="bi bi-check-lg"></i> Confirmer la réservation
            </button>
            <a href="" class="btn btn-secondary">Annuler</a>
        </div>
        <p><strong>*= champs obligatoire</strong></p>
    </form>
</main>

<?php require_once APP_ROOT . "/public/templates/layout/footer.php" ?>