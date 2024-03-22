const baseUrl = 'localhost';
const ressource = 'Projet-PHP/auth_api.php';

function verifUser(){

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
        displayInfoReponse(document.getElementById('send'), infoReponse);
        displayData(data.data);

})
.catch(error => console.error('Erreur : ', error));
}