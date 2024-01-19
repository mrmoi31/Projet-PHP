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
                   <td> <form method="post">
                    <button type="submit" name="supprimer" value="<?php echo $row['id_medecin']; ?>">Supprimer</button></form></td>
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
      
        </form>
    </div>
    </body>
</html>


<?php include "fonction.php";
if (isset($_POST['supprimer'])) {
    $id_medecin = $_POST['supprimer'];
    supprimerMedecin($id_medecin);}
    ?> 