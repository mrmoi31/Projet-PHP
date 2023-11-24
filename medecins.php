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
        <form action="test.php" method="post" class="tab-med">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <!-- ... autres en-têtes ... -->
                <th>Sélection</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td>john@example.com</td>
                <!-- ... autres cellules ... -->
                <td><input type="radio" name="selectedRow" value="1"></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Jane Smith</td>
                <td>jane@example.com</td>
                <!-- ... autres cellules ... -->
                <td><input type="radio" name="selectedRow" value="2"></td>
            </tr>
            <!-- ... autres lignes ... -->
        </tbody>
    </table>
    <button type="submit" name="submit">Envoyer</button>
</form>

    <div class="ams">
        <form action="test.php" method="post">
        <button type="submit" name="choix" value="Ajouter">Ajouter</button>
        <button type="submit" name="choix" value="Modifier" class="amsbouton">Modifier</button>
        <button type="submit" name="choix" value="Supprimer" class="amsbouton">Supprimer</button>
        </form>
    </div>
    </body>
</html>