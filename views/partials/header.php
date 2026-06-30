<!-- VERSION DESKTOP -->
<div class="d-none d-lg-block">

    <!-- Barre principale -->
    <nav class="navbar navbar-duo fixed-top">
        <div class="container-fluid">
            <div class="nav-section success-section">
                <a class="navbar-brand" href="/">Covoiturage2026</a>
            </div>

            <div class="nav-section secondary-section">
                <!--  -->
            </div>
        </div>
    </nav>

    <!-- Barre navigation -->
    <nav class="navbar navbar-second">
        <div class="container-fluid justify-content-end">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/trajets">Trajets</a>
                </li>

                <?php if (!empty($_SESSION['user_id'])) : ?>
                    <!-- CONNECTÉ -->
                    <li class="nav-item">
                        <a class="nav-link" href="/<?= strtolower($_SESSION['role_name']) ?>/dashboard">
                            Mon espace (<?= htmlspecialchars($_SESSION['username']) ?>)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/auth/logout">Déconnexion</a>
                    </li>

                <?php else : ?>
                    <!-- VISITEUR -->
                    <li class="nav-item">
                        <a class="nav-link" href="/auth/register">Inscription</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/auth/login">Connexion</a>
                    </li>

                <?php endif; ?>

            </ul>
        </div>
    </nav>

</div>


<!-- VERSION MOBILE -->
<nav class="navbar navbar-mobile fixed-top d-lg-none">
    <div class="container-fluid">

        <!-- Logo -->
        <a class="navbar-brand mobile-brand" href="/">
            Covoiturage2026
        </a>

        <!-- Bouton burger -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMobile">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbarMobile">
            <ul class="navbar-nav ms-3">
                <li class="nav-item">
                    <a class="nav-link" href="/">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/covoiturage">Covoiturage</a>
                </li>

                <?php if (!empty($_SESSION['user_id'])) : ?>
                    <!-- CONNECTÉ -->
                    <li class="nav-item">
                        <a class="nav-link" href="/<?= strtolower($_SESSION['role_name']) ?>/dashboard">
                            Mon espace (<?= htmlspecialchars($_SESSION['username']) ?>)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/auth/logout">Déconnexion</a>
                    </li>

                <?php else : ?>
                    <!-- VISITEUR -->
                    <li class="nav-item">
                        <a class="nav-link" href="/auth/register">Inscription</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/auth/login">Connexion</a>
                    </li>

                <?php endif; ?>
                
            </ul>
        </div>

    </div>
</nav>


<!-- ESPACE POUR NAVBAR FIXED -->
<div class="header-spacer d-lg-none"></div>
<div class="header-spacer-desktop d-none d-lg-block"></div>

<main class="main-content">