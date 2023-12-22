// Définir un tableau global pour stocker les indices

function addText() {
    var formation = document.getElementById("formation");
    var parcours = document.getElementById("parcours");
    var year = document.getElementById("year");
    var fromCV = document.getElementById("fromCV");

    // Vérifiez si les valeurs sont non vides
    if (formation.value !== "" && parcours.value !== "" && year.value !== "") {
        var isUnique = isElementUnique(fromCV, formation.value, parcours.value, year.value);

        if (isUnique) {
            console.log("Ajoute");
            // Création des éléments utiles
            var li = document.createElement("li");
            var text = document.createTextNode("Vous envoyez le CV des " + formation.value + " du Parcours : " + parcours.value + " des " + year.value);
            var button = document.createElement("button");
            var hidden = document.createElement("input");

            // Config de hidden
            hidden.type = "hidden";
            hidden.name = "infos[]";
            hidden.value = JSON.stringify({formation: formation.value, parcours: parcours.value, year: year.value});

            // Config de button
            button.name = "del";
            button.id = "del";
            button.innerHTML = "X";
            button.onclick = () => delText(button);

            // Ajout des enfants
            li.appendChild(text);
            li.appendChild(hidden);
            li.appendChild(button);
            fromCV.appendChild(li);
        }
    }
}

function delText(button){
    var elementLi = button.parentNode;
    var listeUl = elementLi.parentNode;
    listeUl.removeChild(elementLi);
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