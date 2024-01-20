// Variable générale nécessaire pour la récupération de certaines données et l'initialisation des compteurs
const limitChamp = 4;
let nbChampAdress = {
    completeAddress: 2,
    citySearch: 2
};
let nbChampAdressReal = 1;
let nbChampCitySearch = 2;
const divAdressForm = document.querySelector(".adressForm");
const divCityForm = document.querySelector(".cityForm");

// Fonction qui ajoute un champ en fonction de plusieurs paramètres
function addField(container, type, name, placeholder, className) {
    if (container) {
        const newField = document.createElement("input");
        newField.type = type;
        newField.placeholder = placeholder;
        newField.name = name;
        newField.className = className;
        newField.required = true;
        container.appendChild(newField);
        return newField;
    }
    throw new DOMException("Container doesn't exist");
}

// Ajout une adresse complète dans la div adressForm
function addCompleteAddress() {
    if (nbChampAdress.completeAddress < limitChamp) {
        try {
            const newDiv = document.createElement("div");
            newDiv.className = "adressFormTemplate";

            const title = document.createElement("p");
            title.textContent = `Adresse ${nbChampAdressReal + 1}`;
            nbChampAdressReal++;
            newDiv.appendChild(title);

            const formRow = document.createElement("div");
            formRow.className = "form-row";

            addField(formRow, "text", "cp[]", "Code Postal", "form-control col-md-3");
            addField(formRow, "text", "address[]", "Adresse d'habitation", "form-control col-md-6");
            addField(formRow, "text", "cityCandidate[]", "Ville", "form-control col-md-3");

            newDiv.appendChild(formRow);

            // Ajoutez la nouvelle adresse complète à la div adressForm
            divAdressForm.appendChild(newDiv);

            nbChampAdress.completeAddress++;
        } catch (error) {
            console.error(error.message);
        }
    }
}

// Ajoute une div citySearch
function addResearchZone() {
    var newDiv = document.createElement("div");
    newDiv.classList.add("form-group", "cityForm");

    newDiv.innerHTML = `
        <div id="citySearch${nbChampCitySearch}" name="citySearch${nbChampCitySearch}">
            <label for="citySearch" class="form-label">Zone ${nbChampCitySearch}</label>
            <input type="text" class="form-control" id="citySearch" name="citySearch[]" placeholder="Zone ${nbChampCitySearch}" required>

            <div class="input-group">
                <input type="number" id="rayon" name="rayon[]" class="form-control" min="0" step="1" placeholder="Rayon en Km" required>
                <div class="input-group-append">
                    <span class="input-group-text">Km</span>
                </div>
            </div>
        </div>
    `;

    nbChampCitySearch++;

    // Ajoutez la nouvelle zone de recherche à la div cityForm
    divCityForm.appendChild(newDiv);

    nbChampAdress.citySearch++;
}

function delAdressInput() {
    if (delLastChild(divAdressForm)) {
        nbChampAdress.completeAddress--; // Decrement completeAddress count
        nbChampAdressReal--; // Decrement the real address count
    }
}

// Supprime le dernier enfant de la div cityForm
function delReserchZone() {
    if (delLastChild(divCityForm)) {
        nbChampCitySearch--; // Decrement citySearch count
    }
}

// Fonction générique qui supprime le dernier enfant d'un élément
function delLastChild(element) {
    let firstChild = element.firstElementChild;
    let lastChild = element.lastElementChild;
    if (firstChild !== lastChild) {
        element.removeChild(lastChild);
        return true;
    }
    return false;
}
