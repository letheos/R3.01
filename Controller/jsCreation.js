document.addEventListener('DOMContentLoaded', function() {
    // on génère les variables
    const selectRole = document.getElementById('idRole');
    const selectFormation = document.getElementById('divFormation');
    const formations = document.getElementById('formations')
    selectRole.addEventListener('change', function() {
        const activeRole = selectRole.value;
        if (activeRole === '1') {
            selectFormation.style.display = 'block'// Activer le menu de formation
            formations.style.display = 'none'
        } else{
            if(activeRole ==='2' || activeRole === '3'){
                selectFormation.style.display = 'none'
                formations.style.display = 'block'
            }

        }
    });
});


// selectionnerTout.js

document.addEventListener("DOMContentLoaded", function () {
    const formationChecxboxes = document.querySelectorAll(".choices input[type=checkbox]");
    const selectAllCheckbox = document.getElementById("select-all");

    const selectedFormations = [];

    // Ajoutez un gestionnaire d'événements au bouton "Sélectionner tout"
    selectAllCheckbox.addEventListener('change', function (event) {
        const isChecked = selectAllCheckbox.checked;
        formationChecxboxes.forEach(function (checkbox) {
            checkbox.checked = isChecked;
        });
        if (count(selectedFormations) != count(formationChecxboxes)){

        }
        // Mettez à jour l'affichage de la liste déroulante et de l'étiquette d'ordre en fonction de l'état de "Sélectionner tout"
        updateFormationsDisplay();
    });

    formationChecxboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function (event) {
            //const checkedCheckboxes = document.querySelectorAll(".choices input[type=checkbox]:checked");
            // Mettez à jour l'affichage de la liste déroulante et de l'étiquette d'ordre en fonction de la sélection des cases individuelles
            updateFormationsDisplay();
        });
    });

    function updateFormationsDisplay() {
            selectedFormations.length = 0;
            const checkedCheckboxes = document.querySelectorAll(".choices input[type=checkbox]:checked");

            checkedCheckboxes.forEach(function (checkCheckbox) {
                selectedFormations.push(checkCheckbox.value);
            });



    }
});
