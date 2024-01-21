// Définir un tableau global pour stocker les indices

function addText() {
    var formation = document.getElementById("formation");
    var parcours = document.getElementById("parcours");
    var year = document.getElementById("year");
    var fromCV = document.getElementById("fromCV");
    var form = document.getElementById("send-form");


    if (formation.value !== "" && parcours.value !== "" && year.value !== "") {
        var isUnique = isElementUnique(fromCV, formation.value, parcours.value, year.value);


        if (isUnique) {
            var modal = createModal(parcours.value, year.value);
            document.body.appendChild(modal);

            // Création des éléments utiles
            var li = document.createElement("li");
            var text = document.createTextNode("Vous envoyez le CV des " + formation.value + " du Parcours : " + parcours.value + " des " + year.value);
            var del = document.createElement("button");
            var detail = document.createElement("button");
            var hidden = document.createElement("input");

            // Config de hidden
            hidden.type = "hidden";
            hidden.name = "infos[]";
            hidden.value = JSON.stringify({formation: formation.value, parcours: parcours.value, year: year.value});

            // Config du bouton supprimer
            del.name = "del";
            del.id = "del";
            del.className = "btn btn-danger";
            del.innerHTML = "X";
            del.onclick = () => delText(del);

            // Config du bouton, voir les détails
            detail.name = "sendTo";
            detail.id = "sendTo";
            detail.type = "button";
            detail.className = "btn btn-primary";
            detail.innerHTML = "Choisir les candidats";
            detail.onclick = () => displayModal(modal);

            var hiddenDl = document.createElement("input");
            hiddenDl.type = "hidden";
            hiddenDl.name = "dl";
            hiddenDl.value = "0";
            form.appendChild(hiddenDl);


            // Ajout des enfants
            li.appendChild(text);
            li.appendChild(hidden);
            li.appendChild(del);
            li.appendChild(detail);
            fromCV.appendChild(li);
            form.appendChild(modal);
        }
    }
}

function createModal(parcours, year, candidateData) {
    var modal = document.createElement("div");
    modal.className = "modal";
    modal.id = "modal" + parcours + year;

    var modalContent = document.createElement("div");
    modalContent.className = "modal-content";

    var modalHeader = document.createElement("div");
    modalHeader.className = "modal-header";
    modalHeader.style.backgroundColor = "#0f94b4";
    var headerText = document.createTextNode(parcours + " " + year);
    modalHeader.appendChild(headerText);

    var modalBody = document.createElement("div");
    modalBody.className = "modal-body";

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (this.readyState === 4) {
            if (this.status === 200) {
                var responseData = this.response;

                if (responseData.length > 0) {
                    var table = document.createElement("table");
                    table.className = "table table-striped";

                    // Créer l'en-tête du tableau
                    var headerRow = table.insertRow();
                    var checkboxHeader = document.createElement("th");
                    checkboxHeader.textContent = "Choisir";
                    headerRow.appendChild(checkboxHeader);

                    var nameHeader = document.createElement("th");
                    nameHeader.textContent = "Nom";
                    headerRow.appendChild(nameHeader);

                    var firstNameHeader = document.createElement("th");
                    firstNameHeader.textContent = "Prénom";
                    headerRow.appendChild(firstNameHeader);

                    var typeHeader = document.createElement("th");
                    typeHeader.textContent = "Type d'entreprise";
                    headerRow.appendChild(typeHeader);

                    responseData.forEach(candidate => {
                        var row = table.insertRow();

                        // Checkbox
                        var checkboxCell = row.insertCell();
                        var candidateCheckbox = document.createElement("input");
                        candidateCheckbox.type = "checkbox";
                        candidateCheckbox.name = "candidateCheckbox[]";
                        candidateCheckbox.value = candidate.idCandidate;
                        checkboxCell.appendChild(candidateCheckbox);

                        // Nom du candidat
                        var nameCell = row.insertCell();
                        var candidateName = document.createTextNode(candidate.name);
                        nameCell.appendChild(candidateName);

                        var firstNameCell = row.insertCell();
                        var candidatefirstName = document.createTextNode(candidate.firstName);
                        firstNameCell.appendChild(candidatefirstName);


                        var typeCell = row.insertCell();
                        if (candidate.typeCompanySearch) {
                            var typeText = document.createTextNode(candidate.typeCompanySearch);
                            typeCell.appendChild(typeText);
                        } else {
                            typeCell.textContent = "N/A"; // Ou tout autre texte par défaut
                        }
                    });

                    modalBody.appendChild(table);
                } else {
                    var noCandidateInfo = document.createElement("p");
                    noCandidateInfo.textContent = "No candidate information available.";
                    modalBody.appendChild(noCandidateInfo);
                }
            } else {
                console.error('Error:', this.status, this.statusText);
            }
        }
    };
    xhr.open("POST", "../Controller/AjaxDisplayCandidate.php", true);
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.send(JSON.stringify({ parcours: parcours, year: year }));

    var selectAllButton = document.createElement("button");
    var unselectAllButton = document.createElement("button");
    unselectAllButton.type="button";
    unselectAllButton.className = "btn btn-primary";
    unselectAllButton.textContent = "Tout décocher";
    unselectAllButton.onclick = function () {
        uncheckAllCandidates(modalBody);
    };

    selectAllButton.type = "button";
    selectAllButton.className = "btn btn-primary";
    selectAllButton.textContent = "Tout cocher";
    selectAllButton.onclick = function () {
        // Appeler la fonction pour cocher tous les checkboxes
        checkAllCandidates(modalBody);
    };

    modalHeader.appendChild(selectAllButton);
    modalHeader.appendChild(unselectAllButton);

    var modalClose = document.createElement("span");
    modalClose.className = "close";
    modalClose.innerHTML = "&times;";
    modalClose.onclick = function () {
        modal.style.display = "none";
    };

    modalHeader.appendChild(modalClose);
    modalContent.appendChild(modalHeader);
    modalContent.appendChild(modalBody);
    modal.appendChild(modalContent);

    modal.style.display = "none";

    return modal;
}

function checkAllCandidates(container) {
    var checkboxes = container.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(function (checkbox) {
        checkbox.checked = true;
    });
}

function uncheckAllCandidates(container) {
    var checkboxes = container.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(function (checkbox) {
        checkbox.checked = false;
    });
}



function displayModal(modal){
    modal.style.display = "block";
}



function delText(button) {
    var elementLi = button.parentNode;
    var listeUl = elementLi.parentNode;

    // Extract parcours and year information from the hidden input in the li
    var hiddenInput = elementLi.querySelector('input[name="infos[]"]');
    var info = JSON.parse(hiddenInput.value);
    var parcours = info.parcours;
    var year = info.year;

    // Construct the modal id based on parcours and year
    var modalId = "modal" + parcours + year;

    // Remove the modal associated with the deleted element
    removeAssociatedModal(modalId);

    // Remove the li element
    listeUl.removeChild(elementLi);
}

function removeAssociatedModal(modalId) {
    var modalToRemove = document.getElementById(modalId);
    if (modalToRemove) {
        modalToRemove.parentNode.removeChild(modalToRemove);
    }
}


function isElementUnique(ulElement, formationValue, parcoursValue, yearValue) {
    var lis = ulElement.getElementsByTagName("li");

    for (var i = 0; i < lis.length; i++) {
        var hiddenInput = lis[i].querySelector("input[type='hidden']");
        if (hiddenInput) {
            var jsonData = JSON.parse(hiddenInput.value);
            if (
                jsonData.formation === formationValue &&
                jsonData.parcours === parcoursValue &&
                jsonData.year === yearValue

            ) {
                // Element déjà présent, non unique
                return false;
            }
        }
    }

    // Aucun élément identique trouvé, l'élément est unique
    return true;
}


function dl(){
    var form = document.getElementById("send-form");
    var dlInput = document.querySelector('input[name="dl"]');
    dlInput.value = "1";
    form.submit();
}
