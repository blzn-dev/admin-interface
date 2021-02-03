<?php
//Création de session
session_start();

//Vérification des identifiants entrés pour la connexion
if(!empty($_POST)){

    $mail = $_POST['mail'];
    $password = $_POST['password'];
    $fichier_csv = "comptes.csv";

    //ouverture du fichier en mode "r" (lecture seule)
    $fichier = fopen($fichier_csv, "r");

    while(($tableau_comptes = fgetcsv($fichier, 1000, ";"))!== FALSE)
    {
        if(($tableau_comptes[3] == $mail) AND ($tableau_comptes[4] == $password))
        {
            $_SESSION["mail"] = $mail;
            header("location:inscription.php");
            die;
        }
        else
        {
            $erreur = "Pour vous connecter, veuillez entrer vos identifiants d'administrateur système.";
        }
    }
    fclose($fichier);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Connexion</title>
</head>
<body class="conteneur_principal">
    <h1>Connexion à votre compte</h1>
    <form action="login.php" method="POST">

        <?php
            if (isset($erreur))
            {
                echo("<p style =\"color:red;\">".$erreur."</p>");
            }
        ?>

        <div>
            <label for="mail">E-mail <span>*</span></label>
            <input type="email" name="mail" id="mail" required>
        </div>

        <div>
            <label for="password">Mot de passe <span>*</span></label>
            <input type="password" name="password" id="password" required>
        </div>

        <div class="center">
            <input type="submit" value="Se connecter">
        </div>
    </form>
</body>
</html>