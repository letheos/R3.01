// Fonction pour afficher les détails du candidat en utilisant JavaScript

/**
 * Fonction qui affiche une alerte box qui demande une confirmation de suppression
 * @param button Le bouton cliqué
 */
function showAlert(button) {
    var confirmation = window.confirm("Voulez-vous supprimer ce candidat ?");
    if (confirmation) {
        var candidateId = button.getAttribute("data-id");

        // Récupérer le champ de formulaire caché pour l'ID du candidat
        var candidateIdInput = document.getElementById('candidateId');
        candidateIdInput.value = candidateId;

        // Soumettre le formulaire
        document.getElementById('delete-form').submit();
    }
}
