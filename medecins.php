<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
        <title>Medecins - Cabinet Médical</title>
    </head>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    const tableRows = document.querySelectorAll('#med tbody tr');

    tableRows.forEach(function(row) {
        row.addEventListener('click', function() {
            tableRows.forEach(function(row) {
                row.classList.remove('selected');
            });
            this.classList.add('selected');
        });
    });
});</script>
<body>
        <h2>Médecins</h2>
        <?php require "header.html";?>
        <div class="tablo">
        <!--<form action="script.php" method="post" class="tab-med">-->
        <table id="med">
            <thead>
                <tr>
                    <th colspan="4" class="titre">Médecins</th>
                </tr>
                <tr>
                    <td>Id_Medecin</td>
                    <td>Nom</td>
                    <td>Prenom</td>
                    <td>Civilite</td>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td>test1</td>
                <td>test1</td>
                <td>test1</td>
                <td>test1</td>
            </tr>
            <tr>
                <td>test2</td>
                <td>test2</td>
                <td>test2</td>
                <td>test2</td>
                <?php //echo '<td><input type="checkbox" name="selectedRows[]" value="' . $row['Id_Patient'] . '"></td>'; ?>
            </tr>
            <tr>
                <td>test3</td>
                <td>test3</td>
                <td>test3</td>
                <td>test3</td>
            </tr>
            </tbody>
        </table>
    <!--</form>-->
    </div>
    <div class="ams">
        <form action="ajout.php" method="post">
        <button type="submit" name="choix" value="Ajouter">Ajouter</button>
        <button type="submit" name="choix" value="Modifier" class="amsbouton">Modifier</button>
        <button type="submit" name="choix" value="Supprimer" class="amsbouton">Supprimer</button>
        </form>
    </div>
    </body>
</html>