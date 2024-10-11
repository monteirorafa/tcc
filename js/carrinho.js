document.addEventListener("DOMContentLoaded", function () {
    const quantityContainers = document.querySelectorAll(".quantity");

    quantityContainers.forEach(function (quantityContainer) {
        const minusBtn = quantityContainer.querySelector(".minus");
        const plusBtn = quantityContainer.querySelector(".plus");
        const inputBox = quantityContainer.querySelector(".input-box");

        if (!minusBtn || !plusBtn || !inputBox) {
            console.error("Um dos elementos não foi encontrado no DOM.");
            return;
        }

        let previousValue = inputBox.value;

        updateButtonStates(inputBox, minusBtn, plusBtn);

        minusBtn.addEventListener("click", function () {
            decreaseValue(inputBox, minusBtn, plusBtn);
        });

        plusBtn.addEventListener("click", function () {
            increaseValue(inputBox, minusBtn, plusBtn);
        });

        inputBox.addEventListener("input", function () {
            handleQuantityChange(inputBox, minusBtn, plusBtn, previousValue);
        });

        inputBox.addEventListener("change", function () {
            validateMaxValue(inputBox, minusBtn, plusBtn);
        });

        inputBox.addEventListener("keydown", function (event) {
            previousValue = inputBox.value;
            preventInvalidCharacters(event);
        });
    });

    function updateButtonStates(inputBox, minusBtn, plusBtn) {
        const value = parseInt(inputBox.value);
        if (isNaN(value)) {
            console.error("Valor do input não é um número válido.");
            return;
        }
        minusBtn.disabled = value <= 1;
        plusBtn.disabled = value >= parseInt(inputBox.max);
    }

    function decreaseValue(inputBox, minusBtn, plusBtn) {
        let value = parseInt(inputBox.value);
        value = isNaN(value) ? 1 : Math.max(value - 1, 1);
        inputBox.value = value;
        updateButtonStates(inputBox, minusBtn, plusBtn);
        handleQuantityChange(inputBox, minusBtn, plusBtn, value);

        if (value <= 1) {
            window.location.reload();
        }
    }

    function increaseValue(inputBox, minusBtn, plusBtn) {
        let value = parseInt(inputBox.value);
        value = isNaN(value) ? 1 : Math.min(value + 1, parseInt(inputBox.max));
        inputBox.value = value;
        updateButtonStates(inputBox, minusBtn, plusBtn);
        handleQuantityChange(inputBox, minusBtn, plusBtn, value);

        if (value >= parseInt(inputBox.max)) {
            window.location.reload();
        }
    }

    function handleQuantityChange(inputBox, minusBtn, plusBtn, previousValue) {
        let value = parseInt(inputBox.value);
        if (isNaN(value)) {
            value = previousValue;
            inputBox.value = value;
            console.error("Valor do input não é um número válido.");
        } else {
            previousValue = value;
            setTimeout(function(){
                window.location.reload();
            }, 300);
        }

        console.log("Quantidade alterada:", value);
        updateButtonStates(inputBox, minusBtn, plusBtn);
        updateServerQuantity(inputBox);
    }

    function validateMaxValue(inputBox, minusBtn, plusBtn) {
        let value = parseInt(inputBox.value);
        let maxValue = parseInt(inputBox.max);

        if (value > maxValue) {
            inputBox.value = maxValue;
        }

        updateButtonStates(inputBox, minusBtn, plusBtn);
        handleQuantityChange(inputBox, minusBtn, plusBtn, inputBox.value);
    }

    function preventInvalidCharacters(event) {
        const invalidChars = ['-', '+', 'e', 'E'];

        if (invalidChars.includes(event.key)) {
            event.preventDefault();
        }
        setTimeout(() => {
            const newValue = event.target.value;
            if (isNaN(newValue)) {
                event.target.value = previousValue;
            }
        }, 0);
    }

    function updateServerQuantity(inputBox) {
        var form = inputBox.closest('form');
        var formData = new FormData(form);

        formData.set('quantidade', inputBox.value);
    
        console.log('Dados do formulário:', Array.from(formData.entries()));
    
        fetch(form.action, {
            method: 'POST',
            body: formData,
        })
        .then(response => response.text())
        .then(data => {
            M.toast({ html: 'Quantidade atualizada.' });
        })
        .catch(error => {
            console.error('Erro:', error);
        });
    }
    
});
