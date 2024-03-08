<?php
    $server = "localhost";
    $db = "medecin_projet_php";
    $login = "root";
    $mdp = "";

    //Connection base de donnée
    try{
        $linkpdo = new PDO("mysql:host=$server; dbname=$db", $login, $mdp);
    } 
    //Verification connection
    catch (Exception $e) {
        die('Erreur: ' . $e->getMessage());
    }
?>