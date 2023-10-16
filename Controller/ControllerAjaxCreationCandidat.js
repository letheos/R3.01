//Variable générale nécessaire pour la gestion
const formationList = document.getElementById("formation-list"); //Balise de la liste drag & drop
const roundedBox = document.querySelector(".formation-list-zone");
const formationCheckboxes = document.querySelectorAll(".choices-formation"); //Checkboxes des formations
const formationCheckboxeAll = document.getElementById("select-all"); //Checkbox selectAll
let orderForm = []; //Liste des ordres choisi dans la formation

/**
 * Ajout d'évènement sur le bouton inscription d'un profil candidat afin d'envoyer les données de manières asynchrone
 */
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




/**
 * Fonction qui coche toute les cases
 */
function checkAll(){
    formationCheckboxeAll.addEventListener('change', function (event) {
        let isChecked = this.checked;
        formationCheckboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
        });
        updateFormationList();
    });
}


/**
 * Fonction qui update l'affichage de la drag & drop list
 */
function updateFormationList() {
    formationList.innerHTML = ""; // Efface la liste actuelle
    let idCounter = 0; // Initialise un compteur pour les ID
    const checkedCheckboxes = Array.from(formationCheckboxes).filter(checkbox => checkbox.checked);

    if (checkedCheckboxes.length >= 2) {
        formationList.style.display = "inline";
        roundedBox.style.display = "block"; // Affiche la rounded-box
    } else {
        formationList.style.display = "none";
        roundedBox.style.display = "none";
    }

    checkedCheckboxes.forEach(checkbox => {
        const formationId = `formation-${idCounter++}`;
        const formationName = checkbox.value;
        const formationItem = document.createElement("li");
        formationItem.id = formationId;
        formationItem.setAttribute("name", formationName);
        formationItem.draggable = true;
        formationItem.textContent = formationName;
        formationList.appendChild(formationItem);
    });
    getArrayFormationOrder();
}

/**
 * Fonction qui manipule orderForm pour ajouter dans une liste les élements de la drag & drop list pour gérer l'ordre
 */
function getArrayFormationOrder() {
    var olElement = document.getElementById("formation-list");
    var olChildren = olElement.children;
    var newOrderForm = [];

    for (var i = 0; i < olChildren.length; i++) {
        var elementId = olChildren[i];
        var elementName = elementId.getAttribute("name");
        if (!newOrderForm.includes(elementName)) {
            newOrderForm.push(elementName);
        }
    }

    orderForm = newOrderForm;
    console.log(orderForm)
}





/**
 * On définit les évenements
 */
formationCheckboxes.forEach(checkbox => {
    checkbox.addEventListener("change", updateFormationList);

});

formationCheckboxeAll.addEventListener("change", checkAll);

//Début du drag
formationList.addEventListener("dragstart", e => {
    e.dataTransfer.setData("text", e.target.id);
});

//Durant le drag
formationList.addEventListener("dragover", e => {
    e.preventDefault();
});

//Durant le drop
formationList.addEventListener("drop", e => {
    e.preventDefault();

    var data = e.dataTransfer.getData("text");
    var draggedElement = document.getElementById(data);
    var origin = draggedElement.parentElement;
    var dropTarget = e.target;
    var isDraggedBeforeDropTarget = draggedElement.compareDocumentPosition(dropTarget) & Node.DOCUMENT_POSITION_PRECEDING;
    if (isDraggedBeforeDropTarget) {
        origin.insertBefore(draggedElement, dropTarget);
    } else {
        origin.insertBefore(draggedElement, dropTarget.nextSibling);
    }
    getArrayFormationOrder();
});













