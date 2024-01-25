document.addEventListener('DOMContentLoaded', function() {
    // we generate the variables
    const selectRole = document.getElementById('idRole');
    const selectFormation = document.getElementById('idFormation');
    const formations = document.getElementById('formations')
    selectRole.addEventListener('change', function() {
        const activeRole = selectRole.value;
        //we change how we display the formations inputs based on what role the user chose
        if (activeRole === '1') {
            selectFormation.style.display = 'none'
            formations.style.display = 'none'
            labelFormation.style.display = 'none'
        }
        else if(activeRole === '4'){
            selectFormation.style.display = 'block'
            formations.style.display = 'none'
            labelFormation.style.display = 'block'
        }
        else{if(activeRole ==='2' || activeRole === '3'){
            selectFormation.style.display = 'none'
            formations.style.display = 'block'
            labelFormation.style.display = 'block'
        }
        }
    });
});




document.addEventListener("DOMContentLoaded", function () {
    const formationChecxboxes = document.querySelectorAll(".choices input[type=checkbox]");
    const selectAllCheckbox = document.getElementById("select-all");
    const selectedFormations = [];
    //we generate all the variables
    selectAllCheckbox.addEventListener('change', function (event) {
        const isChecked = selectAllCheckbox.checked;
        formationChecxboxes.forEach(function (checkbox) {
            checkbox.checked = isChecked;
        });
        if (count(selectedFormations) != count(formationChecxboxes)){

        }
        updateFormationsDisplay();
    });

    formationChecxboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function (event) {
            //const checkedCheckboxes = document.querySelectorAll(".choices input[type=checkbox]:checked");

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