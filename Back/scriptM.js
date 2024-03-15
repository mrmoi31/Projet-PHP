//URL de base de l'API

const baseUrl = 'localhost';
const ressource = 'Projet-PHP/medecin_api.php';

function getAllMedecin(){
    
    fetch(`${baseUrl}${ressource}`)
    .then(response => response.json()) //Convertir la réponse en JSON
    .then(data => {
        let infoReponse = {
            status : data.status,
            status_code : data.status_code,
            status_message : data.status_message
        };
        displayInfoReponse(document.getElementById('infoGetAllMedecin'), infoReponse);
        displayData(data.data);
    })
    .catch(error => console.error('Erreur : ', error));
}

function addMedecin(){

    var medecin = document.getElementById('newMedecin').value;

    const requestOptions = {
        methiod: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({nom: medecin})};
        fetch(baseUrl+ressource, requestOptions)
        .then(response => response.json())
        .then(data => {let infoReponse = {
            status : data.status,
            status_code : data.status_code,
            status_message : data.status_message
        };
        displayInfoReponse(document.getElementById('infoAddMedecin'), infoReponse);
        displayData(data.data);

})
.catch(error => console.error('Erreur : ', error));
}

function updateMedecin(){}

function deleteMedecin(){}

function displayData(medecin){}

function displayInfoReponse(element, infoReponse){}
    