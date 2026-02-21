<?php require_once APP_ROOT . "/public/templates/layout/header.php" ?>

<main>

<div class="accueil-container">
    <div class="container">
        <!-- Section Carrousel -->
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="carousel-accueil">
                    <div id="carouselAccueil" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="assets/images/Paysage 7.png" 
                                     class="d-block w-100" 
                                     alt="Chemin dans forêt">
                            </div>
                            <div class="carousel-item">
                                <img src="assets/images/Paysage 1.png" 
                                     class="d-block w-100" 
                                     alt="Colline">
                            </div>
                            <div class="carousel-item">
                                <img src="assets/images/Paysage 4.png" 
                                     class="d-block w-100" 
                                     alt="Village">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselAccueil" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Précédent</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselAccueil" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Suivant</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    
<!-- Texte -->
<div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="texte-accueil">
                    <p class="lead mb-0 text-center">

                        Covoiturage Hauts-de-France est une plateforme de covoiturage locale qui connecte les habitants de la région pour des trajets économiques, écologiques, et solidaires.
                        Notre mission : faciliter la mobilité quotidienne tout en réduisant l'empreinte carbone.  
                    </p>
                </div>
            </div>
        </div>


<!-- Image Voiture -->
<div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="voiture-accueil">
    
                <img src="assets/images/Voiture écolo A.png" 
                    alt="Image voiture écolo"
                    class="img-fluid">
            </div>
        </div>
</div>

<!-- Mobile content -->

    <div class="mobile-only">
    
    <div class="carousel-custom carousel-mobile">
        <id="carouselMobile" class="carousel slide h-100">

            <div class="carousel-inner h-100">
            <div class="carousel-item active h-100">
                <img src="assets/images/Paysage 7.png" class="d-block w-100 h-100" alt="image chemin dans forêt">
            </div>
            <div class="carousel-item h-100">
                <img src="assets/images/Paysage 1.png" class="d-block w-100 h-100" alt="image colline">
             </div>
            <div class="carousel-item h-100">
                <img src="assets/images/Paysage 4.png" class="d-block w-100" alt="image village">
            </div>  
        </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselDesktop" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Précédent</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouseldesktop" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Suivant</span>
    </button>
    
    </div>

        

<?php require_once APP_ROOT . "/public/templates/layout/footer.php" ?>









