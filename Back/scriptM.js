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
        method: 'POST',
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

function updateMedecin(){

    var medecinId = document.getElementById('idMedecin').value;
    var mdecinNom = document.getElementById('nomMedecin').value;
    var medecinPrenom = document.getElementById('prenomMedecin').value;
    var medecinCivilite = document.getElementById('civiliteMedecin').value;

    if 
}

function deleteMedecin(){

    var medecinId = document.getElementById('deleteIdMedecin').value;

    const requestOptions = {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
        }}
    fetch(`²{baseUrl}${ressource}/${medecinId}`, requestOptions)
    .then(response => response.json())
    .then(data => {let infoReponse = {
        status : data.status,
        status_code : data.status_code,
        status_message : data.status_message
    };
    displayInfoReponse(document.getElementById('infoDeleteMedecin'), infoReponse); 
})
.catch(error => console.error('Erreur : ', error));
    
}

function displayData(medecin){}

function displayInfoReponse(element, infoReponse){}
    