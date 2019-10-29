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

	document.getElementById("submit").addEventListener('click', e => {
		var email = document.getElementById("email").value;
		var password = document.getElementById("password").value;
		const auth = firebase.auth();

		const promise = auth.signInWithEmailAndPassword(email, password);
		promise.catch(e => console.log(e.message));
	});
	
	firebase.auth().onAuthStateChanged(firebaseUser => {
		if (firebaseUser) {
			window.location = "login.html";
			console.log(firebaseUser);
		} else {
			console.log('Failed Login')
		}
	});
}());