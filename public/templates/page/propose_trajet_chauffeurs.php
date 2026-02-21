<?php require_once APP_ROOT . "/public/templates/layout/header.php" ?>



<main>
    <h2>Voici les trajets que proposent nos chauffeurs<span class="badge bg-secondary"> Trajets chauffeurs</span></h2>
    <br><br>

    <?php foreach ($trajetsChauffeurs as $trajetChauffeur): ?>
    <div class="trajet-card"> 
    
        <h6>Numéro du trajet <span class="badge bg-secondary"><?=$trajetChauffeur->getNumTrajet()?></span></h6>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Ville Départ</label>
                <div class="form-control-plaintext border bg-light p-2"><?=htmlspecialchars($trajetChauffeur->getVilleDepart())?></div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Ville Arrivée</label>
                <div class="form-control-plaintext border bg-light p-2"><?=htmlspecialchars($trajetChauffeur->getVilleArrivee())?></div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Date et heure de départ</label>
                <div class="form-control-plaintext border bg-light p-2">
                    <?=$trajetChauffeur->getDateHeureDepart()->format('d/m/Y H:i')?>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Date et heure d'arrivée</label>
                <div class="form-control-plaintext border bg-light p-2">
                    <?=$trajetChauffeur->getDateHeureArrivee()->format('d/m/Y H:i')?>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Tarif</label>
                <div class="form-control-plaintext border bg-light p-2"><?=htmlspecialchars($trajetChauffeur->getPrixPersonne())?> €</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Nombre de places restantes</label>

                <div class="form-control-plaintext border bg-light p-2">
                    <?=htmlspecialchars($trajetChauffeur->getNbrPlaceRestantes())?> / <?=htmlspecialchars($trajetChauffeur->getNbrPlaceTrajet())?>
                </div>
            </div>

            <div class="col-12">
               
            </div>
        </div>

        <!-- Informations complémentaires -->
        <div class="modal-body mt-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 ms-auto">Pseudo Chauffeur : <?=htmlspecialchars($trajetChauffeur->getPseudoChauffeur())?></div>
                </div>
                <div class="row">
                    <div class="col-sm-9">
                        Marque de véhicule: <?=htmlspecialchars($trajetChauffeur->getMarque())?>
                        <div class="row">
                            <div class="col-8 col-sm-6">
                                Modèle du véhicule: <?=htmlspecialchars($trajetChauffeur->getModele())?>
                            </div>
                            <div class="col-4 col-sm-6">
                                Temps trajet: <?=htmlspecialchars($trajetChauffeur->getTempsTrajets())?> heures
                            </div>
                            <div class="col-4 col-sm-6">
                                Information sup.: <?=htmlspecialchars($trajetChauffeur->getInformationSup())?>
                            </div>
                            <div class="col-8 col-sm-6">
                                
                                Voyage écologique: <?=$trajetChauffeur->getVoyageEcologique() ? 'Oui' : 'Non'?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div> 
    <?php endforeach; ?>
</main>

<?php require_once APP_ROOT . "/public/templates/layout/footer.php" ?>