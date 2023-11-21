document.addEventListener('DOMContentLoaded', function() {
    // Sélectionnez le lien avec l'id "maPage"
    var maPageLink = document.getElementById('maPage');

    // Empêchez le lien "maPage" d'être cliquable
    maPageLink.addEventListener('click', function(event) {
    event.preventDefault();
});
});

/**
 * This function redirect to the home page
 */
function goBackHomePage(){
    window.location.href='PageAccueil.php'
}

/**
 * This function redirect to the connection page
 */
function disconnect(){
    document.getElementById("disconnect").addEventListener("click",function (){
        window.location.href="../Controller/logout.php";
    })
}

/**
 * This function redirect to the password modification page
 */
function modificate(){
    window.location.href='PageModifierCompte.php'
}
