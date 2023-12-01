<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="index.css">
        <title>Medecins - Cabinet Médical</title>
    </head>
<body>
<?php
if(isset($_POST['selectedRow'])){
    $selectedRowId = $_POST['selectedRow'];
    echo "Ligne sélectionnée : " . $selectedRowId;
}
?>
    </body>
</html>