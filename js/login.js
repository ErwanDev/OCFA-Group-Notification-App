function login() {
	var username = document.getElementById("username").value;
	var password = document.getElementById("password").value;
	if (username == "admin" && password == "password") {
		window.location = "index.html";
		return false;
	}

}