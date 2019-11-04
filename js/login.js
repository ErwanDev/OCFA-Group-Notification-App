(function() {
	const firebaseConfig = {
		apiKey: "AIzaSyCBTFnvStVgUQ1FL1B9DosuqiCGwgGFe0A",
		authDomain: "ocfa-group-notification-app.firebaseapp.com",
		databaseURL: "https://ocfa-group-notification-app.firebaseio.com",
		projectId: "ocfa-group-notification-app",
		storageBucket: "ocfa-group-notification-app.appspot.com",
		messagingSenderId: "11822023829",
		appId: "1:11822023829:web:3ccbef5017154d6c68479c",
		measurementId: "G-D2Y02FC2QH"
	};
	firebase.initializeApp(firebaseConfig);

	try {
		document.getElementById("submit").addEventListener('click', e => {
			var email = document.getElementById("email").value;
			var password = document.getElementById("password").value;
			const auth = firebase.auth();

			const promise = auth.signInWithEmailAndPassword(email, password);
			promise.catch(e => console.log(e.message));
		});
	} catch (e) {}
	
	try {
		document.getElementById("logout").addEventListener('click', e => {
			firebase.auth().signOut().then(function() {
				console.log("Sign-out successful.");
				window.location = "index.html";
			}).catch(function(error) {
				console.log("An error happened: " + error);
			});
		});
	} catch (e) {}
	
	firebase.auth().onAuthStateChanged(firebaseUser => {
		if (firebaseUser && (window.location.pathname.substring(window.location.pathname.length - 10, window.location.pathname.length) == "index.html" || window.location.pathname == "/")) {
			window.location = "login.html";
			console.log(firebaseUser);
			console.log('Successful Login');
		} else if (firebaseUser) {
			console.log('Successful Login');
		} else if (window.location.pathname.substring(window.location.pathname.length - 10, window.location.pathname.length) == "login.html" || window.location.pathname.substring(window.location.pathname.length - 17, window.location.pathname.length) == "notification.html") {
			console.log('Failed Login, redirecting');
			window.location.replace("index.html");
		} else {
			console.log('Failed Login, path: ' + window.location.pathname);
		}
	});
}());