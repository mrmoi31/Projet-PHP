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
        <label for="pet-select">Medecin :</label>

        <select name="pets" id="pet-select">
          <option value="">--Please choose an option--</option>
          <option value="dog">Dog</option>
          <option value="cat">Cat</option>
          <option value="hamster">Hamster</option>
          <option value="parrot">Parrot</option>
          <option value="spider">Spider</option>
          <option value="goldfish">Goldfish</option>
        </select><br>

        <label>Date RDV :</label>
        <input type="date" name="date" id="date"><br>

        <label>Heure RDV :</label>
        <input type="number" name="heure" id="heure"><br>

        <label>Patient :</label>
        <input type="number" name="patient" id="patient"><br>

        <button type="submit" name="send" value="send">Envoyer</button>
        <button type="reset" name="reset" value="reset">Reset</button>
        </form>
</body>

<?php include "fonction.php";
if (isset($_POST['send'])) {
    ajoutConsultation();
} ?>
   
</html>
