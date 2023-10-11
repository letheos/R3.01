document.addEventListener("DOMContentLoaded", function () {
    //Variable utile pour l'affichage js
    const formationCheckboxes = document.querySelectorAll(".choices input[type=checkbox]");
    const formationOrderSelect = document.getElementById("formationOrder");
    const labelOrder = document.getElementById("labelOrder");
    const selectAllCheckbox = document.getElementById("select-all");
    const selectedFormations = [];


    /**
     * boolean isChecked -> Variable qui récupère l'etat de la checkbox
     * Fonction qui permet de cochée toute les cases si le bouton selectionner tout est coché
     */
    function checkAll() {
        verifyCheckAll(); //Utilisation de la vérification des cases cochées
        selectAllCheckbox.addEventListener('change', function (event) { //Ajout event change
            var isChecked = selectAllCheckbox.checked; //Récupération état checkbox selectionner tout
            formationCheckboxes.forEach(function (checkbox) { //Parcours des checkbox
                checkbox.checked = isChecked; //Changement état des checkbox
            });
            updateOrderSelectOptions(); // Mettre à jour les listes déroulantes
            updateOrderSelectVisibilty();
        });
    }

    /**
     * bool allChecked -> Une variable qui indique si toute les cases sont cochés où non
     * Fonction qui vérifie les cases cochées pour déselectionner le bouton selectionner tout si une seule case est décochée
     */

    function verifyCheckAll() {
        formationCheckboxes.forEach(function (checkbox) { //Boucle de parcours des checkbox
            checkbox.addEventListener('change',function(event) { //On ajout un event de changement d'etat
                var allChecked = true; // Initialisation variable
                formationCheckboxes.forEach(function(checkbox) { // Boucle de contrôle des checks
                    if (!checkbox.checked) {  // Si une seule checkbox n'est pas coché alors on change la variable
                        allChecked = false;
                    }
                    selectAllCheckbox.checked = allChecked; //Set de la variable
                    updateOrderSelectOptions(); // Mettre à jour les listes déroulantes
                    updateOrderSelectVisibilty(); // Mettre à jour les listes déroulantes
                });
            });
        });
    }

    /**
     * Fonction qui affiche un menu déroulant à partir de deux cases cochées.
     */
    function updateOrderSelectVisibilty() {
        let checkedCount = 0;
        const checkedCheckboxes = [];

        formationCheckboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                checkedCount++;
                checkedCheckboxes.push(checkbox)
            } else {
                const orderSelect = checkbox.parentElement.querySelector('.order-select');
                if (orderSelect) {
                    orderSelect.style.display = "none"; // Masquer la liste déroulante
                }
            }
        });

        if (checkedCount >= 2) {
            // Afficher les listes déroulantes pour les cases cochées
            checkedCheckboxes.forEach(function (checkbox) {
                const orderSelect = checkbox.parentElement.querySelector('.order-select');
                if (orderSelect) {
                    orderSelect.style.display = "inline"; // Afficher la liste déroulante
                }
            });
        }
    }

    function updateOrderSelectOptions() {

    }






    checkAll();
    formationCheckboxes.forEach(function (checkbox){
        checkbox.addEventListener('change', function(event ) {
            updateOrderSelectOptions();
            updateOrderSelectVisibilty();
        });
    });

});
