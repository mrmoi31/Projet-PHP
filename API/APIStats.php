<?php

// Fonction pour récupérer les statistiques des médecins
    function getStatMedecin(){
        $conn = connexionBD::getInstance();
        $sql = "SELECT medecin.nom, medecin.prenom, sum(consultation.duree_consult)/60 as nb_heure
        FROM consultation, medecin
        WHERE consultation.id_medecin = medecin.id_medecin 
        GROUP BY medecin.id_medecin";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

// Fonction pour récupérer les statistiques des usagers
    function getStatUsager(){
        $conn = connexionBD::getInstance();
        $sql = "SELECT civilite, CASE 
        WHEN TIMESTAMPDIFF(YEAR, date_nais, CURDATE()) < 25 THEN 'Moins de 25 ans'
        WHEN TIMESTAMPDIFF(YEAR, date_nais, CURDATE()) BETWEEN 25 AND 50 THEN 'Entre 25 et 50 ans'
        ELSE 'Plus de 50 ans' 
        END AS age_group, COUNT(*) AS count
        FROM usager
        GROUP BY civilite, age_group";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

?>