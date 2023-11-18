<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
        <title>Patients - Cabinet Médical</title>
    </head>

    <body>

        <h2>Patients</h2>
        <?php require "header.html";?>

        <div class="tablo">
        <table>
            <thead>
                <tr>
                    <th colspan="10" class="titre">Patients</th>
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
                </tr>
            </thead>
            <tbody>
            <?php
            include "index.php";
                if (include "index.php"!= true) {
                    echo "erreur de chargement du fichier php";
                }
                $query = mysql_query("SELECT * FROM patient");

                while ($row = mysql_fetch_array($query)) {?>
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
                   </tr>
                <?php  } ?>

            </tbody>
        </table>
    </div>
    
        <form action="index.php" method="get">
        <button type="submit" name="choix" value="Ajouter">Ajouter</button>
        <button type="submit" name="choix" value="Modifier">Modifier</button>
        <button type="submit" name="choix" value="Supprimer">Supprimer</button>
        </form>
    </body>
</html>