<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
        <title>Medecins - Cabinet Médical</title>
    </head>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    const tableRows = document.querySelectorAll('#example tbody tr');

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
        <table id="example">
            <thead>
                <tr>
                    <th colspan="10" class="titre">Médecins</th>
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
            <tr>
                <td>test</td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
            </tr>
            <tr>
                <td>test</td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
            </tr>
            <tr>
                <td>test</td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="ams">
        <form action="index.php" method="get">
        <button type="submit" name="choix" value="Ajouter">Ajouter</button>
        <button type="submit" name="choix" value="Modifier" class="amsbouton">Modifier</button>
        <button type="submit" name="choix" value="Supprimer" class="amsbouton">Supprimer</button>
        </form>
    </div>
    </body>
</html>