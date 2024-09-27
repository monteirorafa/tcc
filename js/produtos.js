document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.fixed-action-btn');
    var instances = M.FloatingActionButton.init(elems);

    var tooltips = document.querySelectorAll('.tooltipped');
    M.Tooltip.init(tooltips);

    var carrinho = document.querySelectorAll('.btn-floating');
    carrinho.forEach(function(btn) {
        btn.addEventListener('click', function(event) {
            event.preventDefault();
            var formId = 'productForm-' + btn.id.split('-')[1];
            var form = document.getElementById(formId);
            var formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(data => {
                M.toast({html: 'Item adicionado ao carrinho'});
            })
            .catch(error => {
                console.error('Erro:', error);
            });
        });
    });
});
