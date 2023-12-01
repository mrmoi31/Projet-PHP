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
                    <td>Sélection</td>
                </tr>
            </thead>
            <tbody>
            <?php

            include 'connexionBd.php';
                $query = $linkpdo->prepare("SELECT * FROM patient");
                $query-> execute();
                $array = $query -> fetchAll();
                while ($row = $array) {?>
                   <tr>
                   <td><?php echo $row['Id_Patient'];?></td>
                   <td><?php echo $row['nom'];?></td>
                   <td><?php echo $row['prenom'];?></td>
                   <td><?php echo $row['civilite'];?></td>
                   <td><?php echo $row['adresse'];?></td>
                   <td><?php echo $row['code_postal'];?></td>
                   <td><?php echo $row['ville'];?></td>
                   <td><?php echo $row['dateN'];?></td>
                   <td><?php echo $row['lieuxN'];?></td>
                   <td><?php echo $row['numSecu'];?></td>
                   <td>><input type="radio" name="selectedRow" value="1"></td>
                   </tr>
                <?php  } ?>

            </tbody>
        </table>
    </div>
    
        <form action="script.php" method="post">
        <button type="submit" name="choix" value="AjouterPatient">Ajouter</button>
        <button type="submit" name="choix" value="ModifierPatient">Modifier</button>
        <button type="submit" name="choix" value="SupprimerPatient">Supprimer</button>
        </form>
    </body>
</html>