if(document.getElementById('passwordForm')) {
    document.getElementById('passwordForm').style.display ='none';
}

function showPasswordInput(){
    document.getElementById('passwordForm').style.display ='block';
    document.getElementById('none').style.display ='none';
}
function hidePasswordInput(){
    document.getElementById('passwordForm').style.display = 'none';
    document.getElementById('none').style.display ='none';
}

function showNoneText(){
    document.getElementById('none').style.display ='block';
}
