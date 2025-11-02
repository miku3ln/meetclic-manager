var firebase_obj;
// Initialize Firebase
var config = {
    apiKey: "AIzaSyDyB8uBLqp5h2amhqqcP_TkyizdaFb1sgU",
    authDomain: "wulpy-migu3ln.firebaseapp.com",
    databaseURL: "https://wulpy-migu3ln.firebaseio.com",
    projectId: "wulpy-migu3ln",
    storageBucket: "wulpy-migu3ln.appspot.com",
    messagingSenderId: "100341506081"
};
firebase_obj = firebase.initializeApp(config);
function createUser(params) {
    var email = params["email"];
    var password = params["password"];
    var type = params["firebase"];
    var data_user_value = {"userEmail": email, userPassword: password};
    var data_result = {};
    var promiseResult = new Promise((resolve, reject) => {
        firebase.auth().createUserWithEmailAndPassword(email
            , password).then(function (regUser) {
            resolve(regUser);

        }).catch(function (error) {

            reject(error);
        });

    });
    return promiseResult;
}

function errorsLogin(code) {

    var msj = "";
    switch (code) {
        case "auth/wrong-password":
            msj = "Password Incorrecto.";
            break;
        case "auth/invalid-email":
            msj = "Correo Invalido";
            break;
        case "auth/user-disabled":
            msj = "Usuario Desabilitado";
            break;
        case "auth/user-not-found":
            msj = "El Usuario no esta registrado.";
            break;
        case "auth/email-already-in-use":
            msj = "El email esta en uso en otra cuenta.";
            break;
        case "auth/weak-password":
            msj = "Password debe tener al menos 6 characters";
            break;

    }

    return msj;

}

function signInWithEmailAndPassword(params) {

    var email = params["email"];
    var password = params["password"];
    var data_user_value = {"userEmail": email, userPassword: password};
    var data_result = {};
    var promiseResult = new Promise((resolve, reject) => {
        firebase.auth().signInWithEmailAndPassword(email
            , password).then(function (regUser) {
            resolve(regUser);

        }).catch(function (error) {
            var code = error.code;
            reject({msj: code});
        });

    });
    return promiseResult;
}

var currentUser;

function initEventsFirebase() {

    firebase.auth().onAuthStateChanged(function (user) {
        if (user) {
            currentUser = user;
        } else {
            currentUser = null;

        }
    });
}

function updateProfileUser(params) {
    var user = firebase.auth().currentUser;
    var promiseResult = new Promise((resolve, reject) => {

        user.updateProfile(params).then(function (data) {
            resolve(data);
            // Update successful.
        }).catch(function (error) {

            reject(error);
        });
    });
    return promiseResult;

}

function signOut() {
    var promiseResult = new Promise((resolve, reject) => {

        firebase.auth().signOut().then(function () {
            // Sign-out successful.

            resolve({'logout': true});

        }, function (error) {
            // An error happened.

            reject({'logout': false});


        });
    });
    return promiseResult;

}

function signInWithFacebook() {
    var promiseResult = new Promise((resolve, reject) => {

        var provider = new firebase.auth.FacebookAuthProvider();
        firebase.auth().signInWithPopup(provider).then(function (result) {
            // This gives you a Facebook Access Token. You can use it to access the Facebook API.
            var token = result.credential.accessToken;
            // The signed-in user info.
            var user = result.user;
            resolve(result);
            // ...
        }).catch(function (error) {
            // Handle Errors here.
            var errorCode = error.code;
            var errorMessage = error.message;
            // The email of the user's account used.
            var email = error.email;
            // The firebase.auth.AuthCredential type that was used.
            var credential = error.credential;
            reject(error);

        });
    });
    return promiseResult;

}
