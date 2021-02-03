<?php
//inclusion de la NavBar
include("nav.php");

//vérification de la connexion sinon renvoi en page de connexion
session_start();

if (!isset($_SESSION["mail"]))
{
  header("location:login.php");
}

//si le formulaire est rempli alors
if(!empty($_POST))
{
  //on vient chercher les données rentrées dans le formulaire
  $nom_fichier = strip_tags($_POST["nom_fichier"]);
  $title = strip_tags($_POST["title"]);
  $description = strip_tags($_POST["description"]);
  $h1 = strip_tags($_POST["h1"]);
  $contenu_textarea = $_POST["contenu_textarea"];

  //on vérifie que tous les champs sont bien remplis
  if (($nom_fichier == "") or ($title == "") or ($h1 == "") or ($contenu_textarea == "") or ($description == ""))
    {
      $erreur = "Veuillez remplir tous les champs.";
    }

  else
  {
    //emplacement du fichier
    $file = "html/".$nom_fichier.".html";
    //ouverture du fichier
    $ecriture_fichier = fopen($file,"a+");

    $contenu = "<!DOCTYPE html>
    <html lang=\"fr\">
    <head>
        <meta charset=\"UTF-8\">
        <meta name =\"description\" content=\"".$description."\">
        <title>".$title."</title>
    </head>

    <body>
    <h1>".$h1."</h1>
    <main>".$contenu_textarea."</main>
    </body></html>";

    //gestion des erreurs
    if(!fwrite($ecriture_fichier, $contenu))
    {
        echo("Erreur fwrite");
    }

    if(!fclose($ecriture_fichier))
    {
        echo("Erreur fclose");
    } 

    //gestion des succes
    $succes = "Votre fichier HTML a bien été créé.";
  }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Générer une page HTML</title>
  <script src="https://cdn.tiny.cloud/1/k9umcl9u065vp0g7qahe21j0ohspg5nw5qtwmfowrlwugd5y/tinymce/5/tinymce.min.js" 
  referrerpolicy="origin"></script>
</head>

<body>
  <main class="conteneur_principal">
    <?php
    //affichage des erreurs
    if (isset($erreur))
    {
      echo("<p style =\"color:red;\">".$erreur."</p>");
    }
    //affichage des succes
    if (isset($succes))
    {
      echo("<p style =\"color:green;\">".$succes."</p>");
    }
    ?>

    <h1>Générer une page HTML</h1>

    <!-- Formulaire de génération de la page html -->
    <form action="generation.php" method="POST">

      <div>
        <label for="nom_fichier">Nom du fichier</label>
        <input type="text" name="nom_fichier" id="nom_fichier">
      </div>

      <div>
        <label for="title">Titre</label>
        <input type="text" name="title" id="title">
      </div>

      <div>
        <label for="description">Description</label>
        <input type="text" id="description" name="description">
      </div>

      <div>
        <label for="h1">H1</label>
        <input type="text" name="h1" id="h1">
      </div>

      <div>
        <textarea name="contenu_textarea">Ecrivez votre contenu...</textarea>
      </div>

      <!-- script pour transformer le textarea en espace d'écriture avec TinyMCE -->
      <script>tinymce.init({selector: 'textarea'});</script>

      <div class="center">
        <input type="submit" value="Valider">
      </div>
      
    </form>   
</main>
</body>
</html>