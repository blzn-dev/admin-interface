<?php
//inclusion de la NavBar
include("nav.php");

//vérification de la connexion sinon renvoi en page de connexion
session_start();

if (!isset($_SESSION["mail"]))
{
    header("location:login.php");
}

//SECURITE

$nombre = array("0","1","2","3","4","5","6","7","8","9");
$caracterespe = array("'","\"",",",";","?",".",":","/","\\","!","§","ù","%","£","$","¤","^","¨","{","}","=","+","[","]","(",")","°","@","à","_","`","-","|","#","~","&","²","*","µ","€","<",">"," ");
$mailconforme = array("hotmail","outlook","gmail","eemi","yahoo","zoho","icloud","tutanota","proton","gmx","qualiente");
$maillangue = array("fr","com",);

 //On vérifie si l'utilisateur vient sur la page sans avoir rempli la page inscription.php
if (empty($_POST)) {
    $civility ="";
    $forname = "";
    $name = "";
    $mail = "";
    $password = "";
}else {
    // On réaffecte les valeurs que l'utilisateur à déjà rempli lors d'une session précedente
    $civility = $_POST["civilite"];
    $forname = $_POST["nom"];
    $name = $_POST["prenom"];
    $mail = $_POST["mail"];
    $password = $_POST["password"];
    //On vérifie si l'utilisateur à cocher une case "Civilité"
    if (!isset($civility) or $civility == "") {
        $probleme = "Vous devez saisir votre civilité !";
    }
    //On vérifie si l'utilisateur n'a pas modifié le code source et à mit une information éroné
    elseif (!is_numeric($civility)){
        $probleme = "Civilité incorecte!";
    }
    //On vérifie si l'utilisateur n'a pas modifié le code source et mit une autre valeur numérique que celle attendu
    elseif ($civility < 1 or $civility > 2){
        $probleme = "Civilité incorecte! !";
    }
    //On vérifie si l'utilisateur à rempli le  champ "Nom"
    elseif ($forname == "") {
        $probleme = "Vous devez saisir votre nom !";
    }
    //On vérifie si l'utilisateur à mit des chiffres dans le champ "Nom"
    foreach($nombre as $chiffre) {
        if (strpos($forname,$chiffre) !== false) {
            $probleme = "Vous ne pouvez pas mettre de chiffres dans votre nom !";
        }
    }
    //On vérifie si l'utilisateur à mit des caractères spéciaux dans le champ "Nom"
    foreach($caracterespe as $caractere) {
        if (strpos($forname,$caractere) !== false) {
            $probleme = "Vous ne pouvez pas mettre de caractères spéciaux dans votre nom !";
        }
    }
    //On vérifie si l'utilisateur à rempli le  champ "Prénom"
    if ($name == "") {
        $probleme = "Vous devez saisir votre prénom !";
    }
    //On vérifie si l'utilisateur à mit des chiffres dans le champ "Prénom"
    foreach($nombre as $chiffre) {
        if (strpos($name,$chiffre) !== false) {
            $probleme = "Vous ne pouvez pas mettre de chiffres dans votre nom !";
        }
    }
    //On vérifie si l'utilisateur à mit des caractères spéciaux dans le champ "Prénom"
    foreach($caracterespe as $caractere) {
        if (strpos($name,$caractere) !== false) {
            $probleme = "Vous ne pouvez pas mettre de caractères spéciaux dans votre prénom !";
        }
    }
    //On vérifie si l'utilisateur à rempli le  champ "E-mail"
    if ($mail == "") {
        $probleme = "Vous devez saisir votre e-mail !";
    }elseif (strpos($mail,";") !== false) {
        $probleme = "Votre email ne doit pas contenir de \";\" !";
    }
    //On vérifie si l'utilisateur ne met pas plusieurs "@" dans le  champ "E-mail"
    elseif (mb_substr_count($mail,"@") >= 2) {
        $probleme = "Vous devez saisir une adresse e-mail valide !";
    }
    //On vérifie si l'utilisateur à mit au moins un "@" et un "." dans le champ "E-mail"
    elseif ((strpos($mail,"@") !== false) and (strpos($mail,".") !== false)) {
        $email = explode("@",$mail);
        $email = explode(".",$email[1]);
        //On vérifie si l'utilisateur à un mail existant
        if (!in_array($email[0],$mailconforme)) {
            $probleme = "Vous devez saisir une adresse mail contenant : hotmail, outlook, gmail, eemi, yahoo, zoho, icloud, tutanota, proton, gmx ou qualiente";
        }
        elseif (!in_array($email[1],$maillangue)) {
            $probleme = "Vous devez saisir une adresse mail contenant : .fr ou .com";
        } 
    }
    //On vérifie si l'utilisateur à rempli le  champ "Mot de passe"
    elseif ($password == "") {
        $probleme = "Vous devez saisir votre mot de passe !";
    }
    //On vérifie si l'utilisateur à mit au moins 8 caractères dans le  champ "Mot de passe"
    elseif (strlen($password) < 8) {
        $probleme = "Votre mot de passe doit contenir au moins 8 caractères";
    }
    //On vérifie si l'utilisateur à mit au moins une lettre minuscule dans le  champ "Mot de passe"
    elseif(strtoupper($password) == $password) {
        $probleme = "Votre mot de passe doit contenir au moins une lettre en minuscule";
    }
    //On vérifie si l'utilisateur à mit au moins une lettre majuscule dans le  champ "Mot de passe"
    elseif(strtolower($password) == $password) {
        $probleme = "Votre mot de passe doit contenir au moins une lettre en majuscule";
    }
    //On vérifie si l'utilisisaur n'a pas mit de ";" dans le champ "Mot de passe" car sinon il pourrait créé un problème avec le fichier CSV
    elseif (strpos($password,";") !== false) {
        $probleme = "Votre mot de passe ne doit pas contenir de \";\" !";
    }
    //On vérifie si l'utilisateur à mit au moins un chiffre dans le  champ "Mot de passe"
    $test = 0;
    foreach($nombre as $caractere) {
        if (strpos($password,$caractere) !== false) {
            $test = 1;
        }
    }
    if($test == 0){
        $probleme = "Votre mot de passe doit contenir au moins un chiffre";
    }
    //On vérifie si l'utilisateur à mit au moins un caractère spécial dans le  champ "Mot de passe"
    $test = 0;
    foreach($caracterespe as $caractere) {
        if (strpos($password,$caractere) !== false) {
            $test = 1;
        }
    }
    if($test == 0){
        $probleme = "Votre mot de passe doit contenir au moins un caractère spécial";
    }
    //On vérifie si l'utilisateur à bien mit une image
    elseif (isset($_FILES["document"])) {
        // Récupération des informations
        $imagename = $_FILES["document"]["name"];
        $temp = $_FILES["document"]["tmp_name"];
        $size = $_FILES["document"]["size"];
        $type = $_FILES["document"]["type"];
        $error = $_FILES["document"]["error"];
        // Extension : solution 1
        $pos = strrpos($imagename,".");
        $index = $pos + 1;
        $extension = substr($imagename,$index);
        // Extension : solution 2
        $tab = explode(".",$imagename);
        $index = count($tab) - 1;
        $extension = $tab[$index];
        $accept = array("jpg","jpeg","png","gif");
        // Gestion des erreurs
        if ($error != 0)
        {
            $probleme = "Le fichier n'a pas été uploadé";
        }elseif ($size > (4000 * 4000))
        {
            $probleme = "La taille est trop importante";
        }elseif (!in_array($extension,$accept))
        {
            $probleme = "Extension non supportée";
        }else {
            $imagename = "photo-".$name."_".$forname.".".$extension; // changement du nom
            $destination = "images/".$imagename;
            move_uploaded_file($temp,$destination);
            $succes = "Votre nouveau compte a bien été créé.";
        }
        $data = array(
            $civility, 
            $forname, 
            $name, 
            $mail, 
            $password, 
            $imagename
        );
    
        if(isset($_POST['submit'])) {
            $fp = fopen("comptes.csv","a+");
            fputcsv($fp, $data, ";");
            fclose($fp);
        }
        else{
            echo("Veuillez entrer vos informations d'inscription");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Nouveau compte</title>
</head>

<body>
    <main class="conteneur_principal">
        <h1>Créer un nouveau compte administrateur</h1>
        <form action="inscription.php" method="post" enctype="multipart/form-data">
            <div>
                <label for="civilite">Civilité <span>*</span></label>
                <input type="radio" name="civilite" value="1" <?php if ($civility == 1) {echo("checked");}?>>Madame
                <input type="radio" name="civilite" value="2" <?php if ($civility == 2) {echo("checked");}?>>Monsieur
            </div>
            <div>
                <label for="nom">Nom <span>*</span></label>
                <input type="text" name="nom" id="nom" value="<?php echo($forname)?>">
            </div>
            <div>
                <label for="prenom">Prénom <span>*</span></label>
                <input type="text" name="prenom" id="prenom" value="<?php echo($name)?>">
            </div>
            <div>
                <label for="mail">E-mail <span>*</span></label>
                <input type="email" name="mail" id="mail" value="<?php echo($mail)?>">
            </div>
            <div>
                <label for="password">Mot de passe <span>*</span></label>
                <input type="password" name="password" id="password" value="<?php echo($password)?>">
            </div>
            <div>
                <label for="file">Photo de profil <span>*</span></label>
                <input type="file" name="document" id="document" required />
            </div>
            <?php 
            if (isset($probleme))
            {
                echo("<p style =\"color:red;\">".$probleme."</p>");
            }
            elseif (isset($succes))
            {
                echo("<p style =\"color:green;\">".$succes."</p>");
            }
            ?>
            <div>
                <input type="submit" name="submit" value="Valider l'inscription">
            </div>
        </form>
    </main>
</body>

</html>