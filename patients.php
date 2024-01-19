<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="index.css">
        <title>Patients - Cabinet Médical</title>
    </head>
    <?php require "header.html";?>

    <body>

        <h2>Patients</h2>

        <div class="tablo">
        <table>
            <thead>
                <tr>
                    <th colspan="11" class="titre">Patients</th>
                </tr>
                <tr>
                    <td>Id_Patient</td>
                    <td>Nom</td>
                    <td>Prenom</td>
                    <td>Civilite</td>
                    <td>Adresse</td>
                    <td>Ville</td>
                    <td>Code postal</td>
                    <td>Date de naissance</td>
                    <td>Lieu de naissance</td>
                    <td>Numéro de sécurité sociale</td>
                    <td>Medecin</td>
                    <td>Sélection</td>
                </tr>
            </thead>
            <tbody>
            <?php

            include 'connexionBd.php';
                $query = $linkpdo->prepare("SELECT * FROM patient");
                $query-> execute();
                
                while ($row = $query->fetch()) {?>
                   <tr>
                   <td><?php echo $row['id_patient'];?></td>
                   <td><?php echo $row['nom'];?></td>
                   <td><?php echo $row['prenom'];?></td>
                   <td><?php echo $row['civilite'];?></td>
                   <td><?php echo $row['adresse'];?></td>
                   <td><?php echo $row['codePostal'];?></td>
                   <td><?php echo $row['ville'];?></td>
                   <td><?php echo $row['dateNaissance'];?></td>
                   <td><?php echo $row['lieuNaissance'];?></td>
                   <td><?php echo $row['numSecu'];?></td>
                   <td><?php echo $row['id_medecin'];?></td>
                   <td> <form method="post">
                    <button type="submit" name="selectedRow" value="<?php echo $row['id_patient']; ?>">Supprimer</button></form></td>
                   </tr>
                  
                   
                
                <?php  } ?>

            </tbody>
        </table>
    </div>
    
        <form action="formAjoutPatient.php" method="post">
        <button type="submit" name="choix" value="AjouterPatient">Ajouter</button>
        </form>
        <form>
        <button type="submit" name="choix" value="ModifierPatient">Modifier</button>
        </form>
        </body>
</html>

<?php include "fonction.php";
if (isset($_POST['selectedRow'])) {
    $id_patient = $_POST['selectedRow'];
    supprimerPatient($id_patient);}
    ?>