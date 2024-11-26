$(document).ready(function() {
    // Inicialização do sideNav no Materialize
    $('.sidenav').sidenav();

    // Submeter o formulário de busca ao pressionar Enter
    document.getElementById('search').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            document.getElementById('searchForm').submit();
        }
    });
});
