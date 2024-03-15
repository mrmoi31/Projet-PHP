<?php

    $server = "localhost";
    $db = "projet-apii";
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