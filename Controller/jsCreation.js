document.addEventListener('DOMContentLoaded', function() {
    // on génère les variables
    const selectRole = document.getElementById('idRole');
    const selectFormation = document.getElementById('idFormation');

    selectRole.addEventListener('change', function() {
        const activeRole = selectRole.value;
        if (activeRole === '1') {
            selectFormation.disabled = false; // Activer le menu de formation

        } else {
            selectFormation.disabled = true; // Désactiver le menu de formation
            selectFormation.selectedIndex = 0;
        }
    });
});
