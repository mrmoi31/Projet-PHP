<?php 

// Définir les informations à stocker dans le cookie
$login = "utilisateur123";
$motDePasse = "motdepasse123";

// Créer le cookie avec une durée de validité d'une heure (3600 secondes)
setcookie("login", $login, time() + 3600, "/");
setcookie("motDePasse", $motDePasse, time() + 3600, "/");

echo "Cookies créés avec succès!";

//code cookie a mettre au dessus de ce comm
header("Location: ./menu.php");
exit;
?>