$(document).ready(function() {
    $(".button-collapse").sideNav();
  });

document.getElementById('search').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        document.getElementById('searchForm').submit();
    }
});