document.addEventListener("DOMContentLoaded", function () {
    const formationChecxboxes = document.querySelectorAll(".choices input[type=checkbox]");
    const formationOrderSelect = document.getElementById("formationOrder");
    const labelOrder = document.getElementById("labelOrder");
    const selectAllCheckbox = document.getElementById("select-all");

    const selectedFormations = [];

    // Ajoutez un gestionnaire d'événements au bouton "Sélectionner tout"
    selectAllCheckbox.addEventListener('change', function (event) {
        const isChecked = selectAllCheckbox.checked;
        formationChecxboxes.forEach(function (checkbox) {
            checkbox.checked = isChecked;
        });
        // Mettez à jour l'affichage de la liste déroulante et de l'étiquette d'ordre en fonction de l'état de "Sélectionner tout"
        updateFormationsDisplay(isChecked);
    });


    formationChecxboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function (event) {
            const checkedCheckboxes = document.querySelectorAll(".choices input[type=checkbox]:checked");
            // Mettez à jour l'affichage de la liste déroulante et de l'étiquette d'ordre en fonction de la sélection des cases individuelles
            updateFormationsDisplay(checkedCheckboxes.length >= 2);
        });
    });


    function updateFormationsDisplay(isDisplayed) {
        if (isDisplayed) {
            labelOrder.style.display = "block";
            formationOrderSelect.style.display = "block";
            formationOrderSelect.innerHTML = "";

            const checkedCheckboxes = document.querySelectorAll(".choices input[type=checkbox]:checked");

            checkedCheckboxes.forEach(function (checkCheckbox) {
                selectedFormations.push(checkCheckbox.value);
            });

            selectedFormations.forEach(function (formation, index) {
                const option = document.createElement("option");
                option.value = index + 1;
                option.text = index + 1 + ")" + " " + formation;
                formationOrderSelect.appendChild(option);
            });

        } else {
            formationOrderSelect.style.display = "none";
            labelOrder.style.display = "none";
        }
    }
});
