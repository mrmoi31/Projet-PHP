
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="index.css">
        <title>Medecins - Cabinet Médical</title>
    </head>
    <?php require "header.html"; ?>
    <body>
        <form method="post">
        <label>Civilite :</label><br>
        <label>M :</label>
        <input type="radio" name="civilite" id="civilite" value="M">
        <label>Mme :</label>
        <input type="radio" name="civilite" id="civilite" value="Mme"><br>

        <label>Nom :</label>
        <input type="text" name="nom" id="nom"><br>

        <label>Prenom :</label>
        <input type="text" name="prenom" id="prenom"><br>

        <label>Adresse :</label>
        <input type="text" name="adresse" id="adresse"><br>

        <label>Ville :</label>
        <input type="text" name="ville" id="ville"><br>

        <label>Code Postal :</label>
        <input type="text" name="codepostal" id="codepostal"><br>

        <label>Date Naissance :</label>
        <input type="text" name="dateN" id="dateN"><br>

        <label>Lieux Naissance :</label>
        <input type="text" name="lieuxN" id="lieuxN"><br>

        <label>Numéro Sécu :</label>
        <input type="text" name="numSecu" id="numSecu"><br>

        <label>Medecin :</label>
        <input type="text" name="id_medecin" id="id_medecin" placeholder="Entrez l'id du medecin"><br>

        

        <button type="submit" name="send" value="send">Envoyer</button>
        <button type="reset" name="reset" value="reset">Reset</button>
        </form>


</body>

<?php include "fonction.php";
if (isset($_POST['send'])) {
    ajoutPatien();
} ?>


</html>


