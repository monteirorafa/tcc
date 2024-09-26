document.addEventListener('DOMContentLoaded', function() {
    
    var elems = document.querySelectorAll('.fixed-action-btn');
    var instances = M.FloatingActionButton.init(elems);

    var tooltips = document.querySelectorAll('.tooltipped');
    M.Tooltip.init(tooltips);

    var submitBtns = document.querySelectorAll('.btn-floating');
    submitBtns.forEach(function(btn) {
        btn.addEventListener('click', function(event) {
            event.preventDefault();
            var formId = 'productForm-' + btn.id.split('-')[1];
            document.getElementById(formId).submit();
        });
    });
});
