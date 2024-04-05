<?php  

//require_once 'ConnexionBdGen.php';

function deliver_response($status_code, $status_message, $data=null){
    /// Paramétrage de l'entête HTTP
    http_response_code($status_code); //Utilise un message standardisé en fonction du code HTTP
    //header("HTTP/1.1 $status_code $status_message"); //Permet de
    //personnaliser le message associé au code HTTP
    header("Content-Type:application/json; charset=utf-8");//Indique au client le format de la réponse
    $response['status_code'] = $status_code;
    $response['status_message'] = $status_message;
    $response['data'] = $data;
    /// Mapping de la réponse au format JSON
    $json_response = json_encode($response);
    if($json_response===false)
    die('json encode ERROR : '.json_last_error_msg());
    /// Affichage de la réponse (Retourné au client)
    echo $json_response;
    }

function getAllConsult()
    {
    //$linkpdo = connexionBdGen::getInstance();
        $base_url = "mysql:host=%s;dbname=%s";
        $url = sprintf($base_url, "localhost", "api_cabinet");
        $linkpdo = new PDO($url, "root", "omgloltrol");
        
        $stmt = $linkpdo->prepare("SELECT * FROM `consultation`;");
        $stmt->execute();
        $res = ($stmt->fetchAll(PDO::FETCH_ASSOC));
        if ($res) {
            $consult  = array(
                'id_medecin' => $res['id_medecin'],
                'id_usager' => $res['id_usager'],
                'date_nais' => $res['date_nais'],
                'lieu_nais' => $res['lieu_nais'],
                'duree_consult' => $res['duree_consult']
             );
            return $consult;
        } elseif (!$res) {
            $res = "vide";
            return $res;
        } else {
            $res = $linkpdo->errorInfo();
            return $res;
        }
    
    }

function getConsultById($id)
    {
        //$linkpdo = connexionBdGen::getInstance();
        $base_url = "mysql:host=%s;dbname=%s";
        $url = sprintf($base_url, "localhost", "api_cabinet");
        $linkpdo = new PDO($url, "root", "omgloltrol");

        $stmt = $linkpdo->prepare("SELECT * FROM `consultation` where id_consult = :id;");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $res = ($stmt->fetchAll(PDO::FETCH_ASSOC));
        if (!$res) {
            $res = "vide";
        } else {
            $res = $linkpdo->errorInfo();
        }
        $linkpdo = null;
        return $res;
    }

function ajoutConsultation($id_medecin, $id_patient, $dateRDV, $heureRDV, $dureeCons){
    //$linkpdo = connexionBdGen::getInstance();
    $base_url = "mysql:host=%s;dbname=%s";
    $url = sprintf($base_url, "localhost", "api_cabinet");
    $linkpdo = new PDO($url, "root", "omgloltrol");
    $sql = "SELECT * FROM consultation WHERE id_medecin = '$id_medecin' AND date_consult = '$dateRDV' AND    heure_consult = '$heureRDV' AND id_usager = '$id_patient' AND duree_consult = '$dureeCons'; ";
    $result = $linkpdo->prepare($sql);
    if ($result->rowCount() > 0 ){
        $status = "existant";
        return $status;
    }else{
     $insertSql = "INSERT INTO consultation(id_medecin, date_consult, heure_consult, id_usager, duree_consult)   VALUES('$id_medecin', '$dateRDV', '$heureRDV', '$id_patient', '$dureeCons')";
        if ($linkpdo->exec($insertSql) !== false){
            $status = "good";
            return $status;
        }else{
            $status = $linkpdo->errorInfo();
            return $status;
       }
   } 
    
}

function supprimerConsultation($id_consult) {
    //$linkpdo = connexionBdGen::getInstance();
    $base_url = "mysql:host=%s;dbname=%s";
    $url = sprintf($base_url, "localhost", "api_cabinet");
    $linkpdo = new PDO($url, "root", "omgloltrol");

    $sql = getConsultById($id_consult);

    if ($sql === "vide") {
        $status = "vide";
        return $status;
    } else {

        $sql = "DELETE FROM consultation WHERE id_consult = :id_consult";
        $stmt = $linkpdo->prepare($sql);
        $stmt->bindParam(':id_consult', $id_consult, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            $status = "good";
            return $status;
        } else {
            $status = $linkpdo->errorInfo();
            return $status;
        }
    }
}

function patchConsultation($id_consult, $dataPatch){

        $base_url = "mysql:host=%s;dbname=%s";
        $url = sprintf($base_url, "localhost", "api_cabinet");
        $linkpdo = new PDO($url, "root", "omgloltrol");

        $ancienConsult = getConsultById($_GET['id']);

        if ($ancienConsult === "vide") {
            $status = "vide";
            return $status;
        }

            if (isset($dataPatch['id_usager'])) {
                $ancienConsult['id_usager'] = $dataPatch['id_usager'];
            }
            if (isset($dataPatch['id_medecin'])) {
                $ancienConsult['id_medecin'] = $dataPatch['id_medecin'];
            }
            if (isset($dataPatch['date_consult'])) {
                $ancienConsult['date_consult'] = $dataPatch['date_consult'];
            }
            if (isset($dataPatch['heure_consult'])) {
                $ancienConsult['heure_consult'] = $dataPatch['heure_consult'];
            }
            if (isset($dataPatch['duree_consult'])) {
                $ancienConsult['duree_consult'] = $dataPatch['duree_consult'];
            }

        $updateSql = "UPDATE `consultation` SET id_usager = :id_usager, id_medecin = :id_medecin, date_consult =:date_consult, heure_consult = :heure_consult, duree_consult = :duree_consult  WHERE id_consult = :id";

        $stmt = $linkpdo->prepare($updateSql);
        $stmt->bindParam(":id_usager", $ancienConsult['id_usager'], PDO::PARAM_INT);
        $stmt->bindParam(":id_medecin", $ancienConsult['id_medecin'], PDO::PARAM_INT);
        $stmt->bindParam(":date_consult", $ancienConsult['date_consult'], PDO::PARAM_INT);
        $stmt->bindParam(":heure_consult", $ancienConsult['heure_consult'], PDO::PARAM_INT);
        $stmt->bindParam(":duree_consult", $ancienConsult['duree_consult'], PDO::PARAM_INT);
        $stmt->bindParam(":id", $_GET['id'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            $status = "good";
            return $status;
        } else {
            $status = $linkpdo->errorInfo();
            return $status;
        }

}
    
?>