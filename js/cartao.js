document.addEventListener('DOMContentLoaded', function() {
    var today = new Date().toISOString().split('T')[0];
    document.getElementById('vencimento').setAttribute('min', today);
});

$(document).ready(function() {
    radioHandler = (e) => {
        if ($(e).prop("checked")) {
            $(".button").removeAttr('disabled');
        }
    }

    $('input[name="entrega"]').on('change', function() {
        if ($(this).val() === 'Entrega') {
            $('.form-1').addClass('active');
        } else {
            $('.form-1').removeClass('active');
        }
    });

    $('input[name="pagamento"]').on('change', function() {
        if ($(this).val() === 'Cartão') {
            $('.form-2').addClass('active');
            if (cartaoVazio === false) {
                $(".button").removeAttr('disabled');
            } else {
                $(".button").attr('disabled', 'disabled');
            }
        } else {
            $('.form-2').removeClass('active');
            $(".button").removeAttr('disabled');
            if (cartaoVazio === true) {
                $(".button").attr('disabled', 'disabled');
            }
        }
    });
});
