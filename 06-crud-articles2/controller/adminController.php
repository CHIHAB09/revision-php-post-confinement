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
// si on est sur le détail d'un article
if(isset($_GET["detailArticle"])){
    // conversion en int, vaut 0 si la conversion échoue
    $idArticles = (int) $_GET["detailArticle"];
    // si la convertion échoue redirection sur l'accueil
    if(!$idArticles) {
        header("Location: ./");
        exit();
    }
    // appel de la fonction du modèle articlesModel.php
    $recup = articleLoadFull($db,$idArticles);

    // pas d'article, la page n'existe pas
    if(!$recup){
        $erreur = "Cet article n'existe plus";
    }



    // view
    require_once "view/adminDetailArticleView.php";
    exit();

}
//on a cliqué sur crée un article

if(isset($_GET['p'])&&$_GET['p']=="create"){

    // si on a envoier le formulaire ( toutes les variables POST attendues existent)
    if(isset($_POST['titre'],$_POST['texte'],$_POST['idusers'])){

        // traitement des variables
        $titre= htmlspecialchars(strip_tags(trim($_POST['titre'])),ENT_QUOTES);
        //execption pour le strip_tags qui va accepter
        $texte= htmlspecialchars(strip_tags(trim($_POST['texte']),'<p><br><a><img><h4><h5><b><i><strong><ul><li>'),ENT_QUOTES);
        $idusers= (int) $_POST['idusers'];

        //si un des champs est vide (n'a pas reussi la validation des variables POST)

        if(empty($titre) || empty($texte) ||empty($idusers)){
            $erreur= "Format des champs non valides";
        }else{
          //insertion d'article
            $insert= insertArticle($db,$titre,$texte,$idusers);
            if($insert){
                header("location: ./");
                exit;
            }else{




                $erreur = "Probleme lors de l'insertion";
            }

        }

    }


    //on recupere tous les auteurs potentiels
    $recup_auteurs = Alluser($db);

    require_once "view/adminInsertArticleView.php";
    exit();
}


//on a cliqué sur supprimer un article

if(isset($_GET['p'])&&$_GET['p']=="delete"){

    // si la variable d id existe et est une chaine de caractere ne contenant qu' un entier positif non signé
    if(isset($_GET['id'])&&ctype_digit($_GET['id'])){

        //conversion en numerique entier
        $id=(int) $_GET['id'];


        //on recupere l'article
        $recup= articleLoadFull($db,$id);

        //pas de recuperation
        if(!$recup){
            $erreur = "Article introuvable";

        }else{
            $titltle=  $recup['titre'];
            $author= $recup['thename'];
            //on clique sur confirmation de suppression
            if(isset($_GET['ok'])){

                // on tente de supprimer l'article
                if(deleteArticle($db,$id)){
                    $erreur="Suppression effectuée, vous allez etre rediriger dans 5 seconde <script>setTimeout(function(){ document.location.href = './' }, 5000);</script>";
                }else{
                    $erreur="Echec de la suppression, erreur inconnu,veuillez recommencer!";
                }

            }

        }




    }else{
        $erreur ="Format de l'ID non valable";
    }
    require_once "view/adminDeleteArticleView.php";
    exit();
}


//on a cliqué sur modifier un article

if(isset($_GET['p'])&&$_GET['p']=="update"){

    // si la variable d id existe et est une chaine de caractere ne contenant qu' un entier positif non signé
    if(isset($_GET['id'])&&ctype_digit($_GET['id'])){

        //conversion en numerique entier
        $id=(int) $_GET['id'];


        //on recupere l'article
        $recupArticle= articleLoadFull($db,$id);
        // on recupere tous les auteurs
        $recupUsers= AllUser($db);

    }else{
        $erreur ="Format de l'ID non valable";
    }
    require_once "view/adminUpdateArticleView.php";
    exit();
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