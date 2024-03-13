<?php

function connexionUser()
{
    $server = "localhost";
    $db = "projet-api-bd";
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
}

function connexionGen()
{
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
}
?>