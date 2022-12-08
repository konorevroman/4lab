const btn = document.querySelector('.enter');

const array = document.getElementsByClassName("required-field");
for(i = 0; i < array.length; i++){
    array[i].addEventListener('focusout', function(e){
        checkNameAndCost();
    });
}

function checkNameAndCost(){
    for(i = 0; i < array.length; i++){
        if(array[i].value == ''){
            if(!btn.hasAttribute('disabled')){
                btn.setAttribute('disabled', true);
            }
            return;
        }
    }
    btn.removeAttribute('disabled');
}

function exist(){
    alert("Ошибка: товар уже существует");
}