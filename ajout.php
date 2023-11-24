<?php

    include "connexionBd.php";
        if (include "connexionBd.php" != true){
            echo "La connexion n'est pas effectuée";
        }
    function ajoutPatient(){
        //Recupérer les données
        $civilite = $_POST["civilite"];
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $adresse = $_POST["adresse"];
        $ville = $_POST["ville"];
        $code_postal = $_POST["code_postal"];
        $dateN = $_POST["dateN"];
        $lieuxN = $_POST["lieuxN"];
        $numSecu = $_POST["numSecu"];


    }
    
    function ajoutMedecin(){
        //Recupérer les données
        $civilite = $_POST["civilite"];
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];

    }

    function ajoutConsultation(){

    }
?>