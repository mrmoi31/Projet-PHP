<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="index.css">
        <title>Medecins - Cabinet Médical</title>
    </head>
    <?php require "header.html";?>
<body>
        <h2>Médecins</h2>
        <div class="tablo">
        <form action="test.php" method="post" class="tab-med">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Civilite</th>
                <th>Sélection</th>
            </tr>
        </thead>
        <tbody>
           <?php

            include 'connexionBd.php';
                $query = $linkpdo->prepare("SELECT * FROM medecin");
                $query-> execute();
             
                while ($row = $query -> fetch()) {?>
                   <tr>
                   <td><?php echo $row['id_medecin'];?></td>
                   <td><?php echo $row['nom'];?></td>
                   <td><?php echo $row['prenom'];?></td>
                   <td><?php echo $row['civilite'];?></td>
                   <td><input type="radio" name="selectedRow" value="1"></td>
                   </tr>
                <?php  } ?>
        </tbody>
    </table>
    
</form>

    <div class="ams">
        <form action="formAjoutMedecin.php" method="post">
        <button type="submit" name="choix" value="Ajouter" >Ajouter</button>
        </form>
        <form method="post">
        <button type="submit" name="choix" value="Modifier" class="amsbouton">Modifier</button>
        <button type="submit" name="choix" value="Supprimer" class="amsbouton">Supprimer</button>
        </form>
    </div>
    </body>
</html>

<?php 
include "connexionBd.php";
if (isset($_POST['Supprimer'])) {
    if (isset($_POST["selectedRow"])) {
        $idMedecinASupprimer = $_POST["selectedRow"];
        $query = $linkpdo->prepare("DELETE FROM medecin WHERE id_medecin = ?");
        $query->execute([$idMedecinASupprimer]);
    }


   
} ?>