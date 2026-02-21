<?php require_once APP_ROOT . "/public/templates/layout/header.php" ?>

<?php $this->extend('layout/default'); ?>

<?php $this->section('content'); ?>
<div class="container mt-4">
    <h1>Tableau de bord Administrateur</h1>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Espace Chauffeur</h5>
                    <p class="card-text">Gerer les trajets, creer et modifier des offres</p>
                    <a href="" class="btn btn-primary">Acceder</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Espace Passager</h5>
                    <p class="card-text">Voir les reservations, historique et profil</p>
                    <a href="" class="btn btn-success">Acceder</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Administration</h5>
                    <p class="card-text">Gestion complete des trajets</p>
                    <a href="" class="btn btn-warning">Gerer les trajets</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Section actions rapides -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Actions rapides</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2 d-md-flex">
                        <a href="" class="btn btn-success me-2">
                            Creer un trajet
                        </a>
                        <a href="" class="btn btn-primary me-2">
                            Modifier des trajets
                        </a>
                        <a href="" class="btn btn-info me-2">
                            Voir les reservations
                        </a>
                        <a href="" class="btn btn-secondary">
                            Voir tous les trajets
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection(); ?>








<?php require_once APP_ROOT . "/public/templates/layout/footer.php" ?>
