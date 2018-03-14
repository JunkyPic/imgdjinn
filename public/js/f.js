document.getElementById('delete-album-div').style.display ='none';
document.getElementById('tokenForm').style.display ='none';
document.getElementById('passwordForm').style.display ='none';
document.getElementById('btn').style.display ='block';

function toggleShow() {
    var div = document.getElementById('delete-album-div');
    div.style.display = div.style.display == "none" ? "block" : "none";
    return false;
}

function showTokenForm(){
    document.getElementById('tokenForm').style.display ='block';
    document.getElementById('passwordForm').style.display ='none';
}

function showPasswordForm(){
    document.getElementById('tokenForm').style.display ='none';
    document.getElementById('passwordForm').style.display ='block';
}
