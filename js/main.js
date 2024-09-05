window.onload = init;

function init(){
	setInterval(function(){ 
		checkLogin();
	}, 3000);
}

function checkLogin() {
	fetch('Controller/LoginController.php?function=checkLogin').then(response => response.json()).then(function (data){
		if(data.saida == 'logout'){
            window.location.href = 'Controller/LoginController.php?function=logout';
        }
	});
}