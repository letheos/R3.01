const aDejaVisite = sessionStorage.getItem('aDejaVisite');
//Verifie si la page a deja ete visitee
if (!aDejaVisite) {
    window.location.href = 'PageProfil.php';
    sessionStorage.setItem('aDejaVisite','true');
}
/*
window.addEventListener('beforeunload', function() {
    localStorage.removeItem("login");
    localStorage.removeItem("password");
});

function disconnect(){
    document.getElementById("disconnect").addEventListener("click",function (){
        window.location.href="../Controller/logout2.php";
    })
}

function close(){
    disconnect();
}

window.addEventListener('beforeunload',close);
 */