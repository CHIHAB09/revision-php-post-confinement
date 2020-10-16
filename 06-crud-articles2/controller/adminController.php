<?php
// Dependencies
require_once "model/articlesModel.php";
require_once "model/usersModel.php";
require_once "model/cutTheTextModel.php";
require_once "model/paginationModel.php";
require_once "model/functionDateModel.php";
// disconnect
require_once "model/disconnectModel.php";

// on veut se déconnecter
if(isset($_GET['p'])&&$_GET['p']=="disconnect"){
    disconnectModel();
    header("Location: ./");
    exit;
}

// Mise en place de la pagination

// existence de la variable get "pg" | toujours 1 par défaut
if(isset($_GET['pg'])){
    $pgactu = (int) $_GET['pg'];
    // si la conversion échoue ($pgactu===0)
    if(!$pgactu) $pgactu=1;
}else{
    $pgactu = 1;
}
// calcul pour la requête - nombre d'articles totaux, sans erreurs SQL ce sera toujours un int, de 0 à ...
$nbTotalArticles = countAllArticles($db);

$nb_per_pages_admin= 10;

// Calcul pour avoir la première partie du LIMIT *, 10 dans la requête stockée dans articlesModel.php nommée articlesLoadResumePagination()
$debut_tab = ($pgactu-1)*$nb_per_pages_admin;

// requête avec le LIMIT appliqué
$recupPagination = articlesLoadResumePagination($db,$debut_tab,$nb_per_pages_admin);

// pas d'articles
if(!$recupPagination){
    $erreur = "Pas encore d'article";
}else {
    // nous avons des articles, création de la pagination si nécessaire
    $pagination = paginationModel($nbTotalArticles, $pgactu, $nb_per_pages_admin);
}

// Default View
require_once "view/adminIndexView.php";