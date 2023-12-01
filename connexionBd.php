<?php
    $server = "localhost";
    $db = "projet-php";
    $login = "root";
    $mdp = "";

    //Connection base de donnée
    try{
        $linkpdo = new PDO("mysql: localhost=$server; dbname=$db", $login, $mdp);
    } 
    //Verification connection
    catch (Exception $e) {
        die('Erreur: ' . $e->getMessage());
    }
?>