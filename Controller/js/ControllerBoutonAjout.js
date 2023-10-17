const limitChamp = 4;
let nbChamp = 2;
const divAdressForm = document.querySelector(".adressForm");

function addAdressInput() {

    if (nbChamp < limitChamp) {

        // Créez un nouvel élément d'entrée de texte
        const nouvelInput = document.createElement("input");
        nouvelInput.type = "text";
        nouvelInput.placeholder = "Adresse " + nbChamp;
        nouvelInput.name = "adress[]";
        nouvelInput.className = "form-control";

        // Ajoutez le nouvel champ à la div
        divAdressForm.appendChild(nouvelInput)

        nbChamp++;
    }
}

function delAdressInput(){
    let lastChild = divAdressForm.lastElementChild;
    let firstChild = divAdressForm.firstElementChild;
    if (firstChild !== lastChild) {
        divAdressForm.removeChild(lastChild);
        nbChamp--;
    }

}

function addResearchZone(){

}