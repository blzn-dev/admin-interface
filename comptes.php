<?php
//inclusion de la NavBar
include("nav.php");

//vérification de la connexion sinon renvoi en page de connexion
session_start();

if (!isset($_SESSION["mail"]))
{
    header("location:login.php");
}

$test = 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
    <title>Liste des comptes</title>
</head>
<body>
    <main class="conteneur_principal">
        <h1 class="userlistTitle">Liste d'utilisateurs</h1>
        <?php
        if(($handle = fopen("comptes.csv", "r")) !== FALSE)
        {      
            while(($column = fgetcsv($handle, 1000, ';', '"')) !== FALSE)
            {
                echo("<section class=\"userlist\">");
                echo("<div>");
            if ($column[0] == 1) {
                echo ("<p>Sexe : Femme</p>");
            }elseif ($column[0] == 2) {
                echo ("<p>Sexe : Homme</p>");
            }
            echo ("<p>Nom : ".$column[1]."</p>");
            echo ("<p>Prénom : ".$column[2]."</p>");
            echo ("<p>Mail : ".$column[3]."</p>");
            echo ("<p>Mot de passe : ".$column[4]."</p>");
            echo("</div>");
            echo("<figure>");
            echo ("<img src=\"./images/".$column[5]."\" alt=\"client-n".$test."\" class=\"photo_profil\">");
            echo("</figure>");
            echo("</section>");
            $test = $test + 1;
            }
        }
        ?>
    </main>
</body>
</html>