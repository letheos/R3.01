//On passe la valeur a null si elle n'existe pas
if(!isset($_SESSION["login"])){
    $_SESSION['login'] = null;
}
//On passe la valeur a null si elle n'existe pas
if(!isset($_SESSION["password"])){
    $_SESSION['password'] = null;
}
//Cette condition sert à verifier que la personne accedant a la page d'accueil
if ($_SESSION['login'] == null || $_SESSION['password'] == null) {
    //$_SESSION['provenance'] = 'Accueil';
    echo '<script>
    alert("Veuillez vous connecter");
    window.location.href = "../View/PageConnexion.php";
</script>';
}

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
    window.location.href='PageModifierCompte.php';
}
/*
function close(){
    disconnect();
}

window.addEventListener('beforeunload',close);

 */