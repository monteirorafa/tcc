window.onload = init;
function init(){
    atualizarQuantidade();
    }

function atualizarQuantidade(){
    var incrementButtons = document.querySelectorAll('.increment');
    var decrementButtons = document.querySelectorAll('.decrement');

    incrementButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var input = button.parentElement.querySelector('input[type="text"]');
            var Valuemax = button.parentElement.querySelector('label').textContent;
            if (input.value === "") {
                input.value = parseInt(input.placeholder) + 1;
            }else{
            if (parseInt(input.value) < parseInt(Valuemax)) {
                input.value = parseInt(input.value) + 1;
            }}
        });
    });

    decrementButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var input = button.parentElement.querySelector('input[type="text"]');
            if (input.value === "") {
                input.value = parseInt(input.placeholder) - 1;
            }else{
            if (parseInt(input.value) > 0) {
                input.value = parseInt(input.value) - 1;
            }}
        });
    });
}