<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un nouvel article</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.css" media="screen">
    <link rel="stylesheet" href="https://bootswatch.com/_assets/css/custom.min.css">
</head>
<body>
<div class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
    <div class="container">
        <a href="./" class="navbar-brand">Accueil</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link" href="?p=create" title="Ajouter un article">Création d'un nouvel article</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?p=disconnect">Déconnexion</a>
                </li>

            </ul>

        </div>
    </div>
</div>

<div class="container">

    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-8 col-md-7 col-sm-6">
                <h1>Administration</h1>
                <p class="lead">Bienvenue <?=$_SESSION['thename']?>, vous êtes <?=$_SESSION['droit_name']?></p>
                <h2>Supprimer un article</h2>
                <p class="lead"><a href="./">Retournez à l'accueil de l'admin</a></p>
                <?php
                if(isset($erreur)):
                    ?>

                    <h2><?=$erreur?></h2>


                <?php
                else:
                    ?>
                    <h3>Voulez vous vraiment supprimer:  <br><?=$title?> écrit par <?=$author?></h3>
                <a href="?p=delete&id=<?=$id?>&ok"<button type="button">OUI</button><a/> |  <button type="button" onclick="history.go(-1);">NON</button>
                <?php
                endif;
                ?>
                <hr>

            </div>

        </div>
    </div>

    <script src="https://bootswatch.com/_vendor/jquery/dist/jquery.min.js"></script>
    <script src="https://bootswatch.com/_vendor/popper.js/dist/umd/popper.min.js"></script>
    <script src="https://bootswatch.com/_vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="https://bootswatch.com/_assets/js/custom.js"></script>
</body>
</html>