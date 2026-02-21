<?php

echo "Je suis sur covoiturage2026";

echo "<br>";


try{

    if(empty($_GET['page'])){
        $page ="accueil";
    } else {
        $path = explode(separator: "/", string: filter_var($_GET["page"], FILTER_SANITIZE_URL));
        $page = $path[0];
    }

    switch ($page) {
        case "accueil":
            require_once "homePage.php";
            break;

        case "connexion":
            require_once "loginPage.php";
            break;

        case "test":
            require_once "testPage.php";
            break;

        default: 
            throw new Exception (message: "La page n'existe pas !");
    
    }}catch(Exception $e){
        echo "Erreur : ".$e->getMessage();
    }


