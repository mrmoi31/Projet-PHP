<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
        <title>Medecins - Cabinet Médical</title>
    </head>
<body>
<?php
if(isset($_POST['selectedRow'])){
    $selectedRowId = $_POST['selectedRow'];
    // Traitez les données de la ligne sélectionnée ici
    echo "Ligne sélectionnée : " . $selectedRowId;
    // Effectuez votre logique de traitement avec les données sélectionnées
}
?>
    </body>
</html>