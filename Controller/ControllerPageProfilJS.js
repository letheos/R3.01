document.addEventListener('DOMContentLoaded', function() {
    // Sélectionnez le lien avec l'id "maPage"
    var maPageLink = document.getElementById('maPage');

    // Empêchez le lien "maPage" d'être cliquable
    maPageLink.addEventListener('click', function(event) {
    event.preventDefault();
});
});

function goBackHomePage(){
    window.location.href='PageAccueil.php'
}

function disconnect(){
    document.getElementById("disconnect").addEventListener("click",function (){
        window.location.href="../Controller/logout.php";
    })
}
