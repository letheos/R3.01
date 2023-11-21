const aDejaVisite = sessionStorage.getItem('aDejaVisite');
//Verifie si la page a deja ete visitee
if (!aDejaVisite) {
    window.location.href = 'PageProfil.php';
    sessionStorage.setItem('aDejaVisite','true');
}