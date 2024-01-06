

function checked(isPermis,isIne,isAddress,isPhone,id){
    var ineShow = document.getElementById('ine');
    var addressShow =  document.getElementById('address');
    var phoneShow = document.getElementById('phone');
    var permisShow = document.getElementById('permis');
    if(isPermis){
        permisShow.checked = true;
    } if(isIne){
        ineShow.checked = true;
    } if(isPhone){
        phoneShow.checked = true;
    } if(isAddress){
        permisShow.checked = true;
    }


}
