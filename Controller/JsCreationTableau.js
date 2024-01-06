/**
 * Fichier js qui gère l'ajout et la suppression de champs dans la page Creation pageCreationTableau
 * @author Loïck Morneau
 * */

//TODO mettre le nom en glaouche de mettreEnEcouteSuppression
//+

//Variable générale nécessaire pour la récupération de certaine donnée et l'initialisation des compteurs
let blocCount = 0;
const maxBlocs = 3;




function réduitParam(){


}

/**
 *
 * @param formationId
 */
function deleteFormation(formationId) {
    // Mettez ici le code de suppression ou effectuez l'action souhaitée
    console.log("Suppression de la formation avec l'ID : " + formationId);
    // Ajoutez ici le code pour effectuer la suppression côté client ou faites une requête au serveur
}

/**
 *
 * @param formationid
 */
function hideformation(formationid){
    if (blocCount == 0){
        null
    }
    else{
        blocCount=-1
        actuel = formationid
        bloc = document.getElementById(actuel)
        bloc.style.display = "none"
    }
}


function changeselection(blocid){
    document.getElementById("formations"+blocid)
    for (x = 0;x<3;x++){
        if (x != blocid){
            actf= document.getElementById("formations"+x);


        }
    }
}

function toggleAccordion(checkboxId) {
    const checkbox = document.getElementById(checkboxId);
    const accordionItem = checkbox.closest(".accordion-item");
    const collapseTargetId = accordionItem.querySelector(".accordion-collapse").getAttribute("id");
    const collapseTarget = new bootstrap.Collapse(document.getElementById(collapseTargetId));

    // Ferme toutes les checkboxes à l'intérieur de la liste accordéon
    if (checkbox.checked) {
        const accordionBody = accordionItem.querySelector(".accordion-body");
        const checkboxesInsideList = accordionBody.querySelectorAll('.form-check-input');
        checkboxesInsideList.forEach(innerCheckbox => {
            innerCheckbox.checked = false;
        });
    }

    //
    const opened = accordionItem.dataset.opened === "true";
    accordionItem.dataset.opened = (!opened).toString();
}

/**
 *
 * @param blocid
 */
function optionsformations(blocid){
    document.getElementById(blocid)
    var xhr = new XMLHttpRequest();
    xhr.open("POST","/Controller/ControllerCreationTableau.php",true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("id="+blocid);
}

/**
 *
 * @param link
 * @param formation
 * @param parcours
 * @returns {boolean}
 */
function onChangeUpdateDisplayParcours(link,formation,parcours) {

    var selectedFormation = document.getElementById(formation).value;
    console.log(selectedFormation);
    var parcoursSelect = document.getElementById(parcours);
    console.log(parcoursSelect);
    //Initialisation de la requête
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (this.readyState === 4 && this.status === 200){
            // Efface toutes les options actuelles de la liste déroulante
            parcoursSelect.innerHTML = "";

            // Récupère les données JSON renvoyées par le serveur
            var parcoursData = this.response;
            console.log(parcoursData);

            var option = document.createElement("option");
            option.setAttribute("value", "");
            option.text = "Choisir le parcours";
            option.selected = true;
            option.disabled = true;
            parcoursSelect.appendChild(option);

            // Remplit la liste déroulante avec les options de parcours
            parcoursData.forEach(function (parcours)
            {
                var option = document.createElement("option");
                option.value = parcours.nameParcours;
                option.text = parcours.nameParcours;
                parcoursSelect.appendChild(option);
            });

        } else if (this.readyState === 4) {
            alert(console.log(this.response));

        }
    };
    xhr.open("POST", link, true);
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.send(JSON.stringify({ formation: selectedFormation }));

    return false

}
/*
function onchangeannéebyparcours(link,parcours,année){
    var selectedparcours = document.getElementById(parcours).getValue();
    var annéeselect = document.getElementById(année);

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (this.readystate == 4 && this.status  == 200){
            annéeselect.innerHTML = "";
            var années = this.response
            console.log(années)
            var option = document.createElement("option");
            option.setAttribute("value","");
            option.text = "choisir l'année";
            option.selected = true;
            option.disabled = true;
            annéeselect.appendChild(option)

            années.forEach(function(années){
                var option = document.createElement("option");
                option.value = années.name;
                option.text = parcours.nameParcours;
                parcoursSelect.appendChild(option);
            })
        }



    }
}*/
/**
 *
 * @param yearsDropdownId
 * @param parcoursDropdownId
 */

function updateYearsOptions(yearsDropdownId, parcoursDropdownId) {
    var yearsDropdown = document.getElementById(yearsDropdownId);
    var parcoursDropdown = document.getElementById(parcoursDropdownId);
    var selectedParcours = parcoursDropdown.value;
    for (var i = 1; i < 4; i++) {
        if (i != parcoursDropdownId.substr(-1)) { // Éviter la liste déroulante en cours de modification
            var otherParcoursDropdown = document.getElementById('parcours' + i);
            var otherYearsDropdown = document.getElementById('formAnnee' + i);

            if (otherParcoursDropdown.value === selectedParcours) {
                // Désactiver les options d'année pour la liste déroulante correspondante
                for (var j = 0; j < otherYearsDropdown.options.length; j++) {
                    otherYearsDropdown.options[j].disabled = true;
                }
            } else {
                // Activer les options d'année pour la liste déroulante non correspondante
                for (var j = 0; j < otherYearsDropdown.options.length; j++) {
                    otherYearsDropdown.options[j].disabled = false;
                }
            }
        }
    }
}

/**
 *
 */

/*
function onchangelockannée(){
    let buttonparcours0 = document.getElementById("parcours0")
    let buttonparcours1 = document.getElementById("parcours1")
    let buttonparcours2 = document.getElementById("parcours2")
    let buttonparcours3 = document.getElementById("parcours3")
    let buttonannee0 = document.getElementById("formAnnee0")
    let buttonannee1 = document.getElementById("formAnnee1")
    let buttonannee2 = document.getElementById("formAnnee2")
    let buttonannee3 = document.getElementById("formAnnee3")
    let buttonsparcours = [buttonparcours0,buttonparcours1,buttonparcours2,buttonparcours3]
    let buttonsannee0 = [buttonannee0,buttonannee1,buttonannee2,buttonannee3]

}*/
document.addEventListener('DOMContentLoaded', function () {

    var accordionState = sessionStorage.getItem('accordionState');
    if (accordionState) {

        var selectedFormations = JSON.parse(accordionState);
        selectedFormations.forEach(function (formation) {
            var checkbox = document.getElementById(formation);
            if (checkbox) {
                checkbox.checked = true;
                toggleAccordion(formation);
            }
        });
    }


    var checkboxes = document.querySelectorAll('input[name="selectedFormation[]"]');
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            saveAccordionState();
        });
    });

    function saveAccordionState() {

        var selectedFormations = [];
        checkboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                selectedFormations.push(checkbox.id);
            }
        });

        sessionStorage.setItem('accordionState', JSON.stringify(selectedFormations));
    }
});