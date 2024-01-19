<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="index.css">
        <title>Consultations - Cabinet Médical</title>
    </head>
<body>
    <h2>Consultations</h2>
    <div class="tablo">
<form action="test.php" method="post" class="tab-med">
    <table>
        <thead>
            <tr>
                <th>Medecin</th>
                <th>Date RDV</th>
                <th>Heure RDV</th>
                <th>Patient</th>
                <th>Sélection</th>
            </tr>
        </thead>
        <tbody>
           <?php

            include 'connexionBd.php';
                $query = $linkpdo->prepare("SELECT * FROM rdv");
                
                $queryMedecin = $linkpdo->prepare("SELECT NOM FROM medecin WHERE id_medecin = ?");
                $queryMedecin->bindParam(1, $idMedecin, PDO::PARAM_INT);
                $queryMedecin->execute();
                $nomMedecin = $queryMedecin->fetchColumn();

                $queryPatient = $linkpdo->prepare("SELECT NOM FROM patient WHERE id_patient = ?");
                $queryPatient->bindParam(1, $idPatient, PDO::PARAM_INT);
                $queryPatient->execute();
                $nomPatient = $queryPatient->fetchColumn();
             
                while ($row = $query -> fetch()) {?>
                   <tr>
                   <td><?php echo $nomMedecin;?></td>
                   <td><?php echo $row['dateRDV'];?></td>
                   <td><?php echo $row['heureRDV'];?></td>
                   <td><?php echo $nomPatient;?></td>
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