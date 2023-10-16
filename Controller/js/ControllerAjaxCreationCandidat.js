
function onClickSendCandidatesCreation(formId) {

    //Récupère les formations dans l'ordre définit
    var formationOrderData = JSON.stringify(orderForm);
    //Récupère les données des forms
    var data = new FormData(document.getElementById(formId));
    //Initialisation de la requête
    var xhr = new XMLHttpRequest();

    //Ajout de la variable qui contient les formations dans les données à envoyer
    data.append("formationOrder", formationOrderData);

    xhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            console.log(this.response);

            var result = xhr.response;

            if (result) {
                //Variable qui récupère le succes de l'opération
                var success = result["success"];

                //Variable qui récupère le message
                var msg = result["msg"];

                //Récupération des divs
                var alertError = document.getElementById("alertError");
                var alertSuccess = document.getElementById("alertSuccess");

                //Création d'une balise p
                var paragraph = document.createElement("p");

                alertError.style.display = "none";
                alertSuccess.style.display = "none";

                while (alertError.firstChild) {
                    alertError.removeChild(alertError.firstChild);
                }

                while (alertSuccess.firstChild) {
                    alertSuccess.removeChild(alertSuccess.firstChild);
                }

                if (success == 0) {
                    alertError.style.display = "block";
                    paragraph.innerHTML = msg;
                    alertError.appendChild(paragraph);
                } else if (success == 1) {
                    alertSuccess.style.display = "block";
                    paragraph.innerHTML = msg;
                    alertSuccess.appendChild(paragraph);
                }
            } else {
                console.error("Réponse JSON invalide ou manquante.");
            }

        } else if (this.readyState == 4) {
            alert("Une erreur est survenue...");
        }
    };



    //Envoie en méthode POST au controleur en JSON les données
    xhr.open("POST", "../Controller/ControllerCreationCompte.php", true);
    xhr.responseType = "json";
    xhr.send(data);

    return false;
}


















