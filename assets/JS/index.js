var loginModal = document.getElementById("loginModal");
var signupModal = document.getElementById("signupModal");
var bookNowBtn = document.getElementById("bookNowBtn");
var spanClose = document.getElementsByClassName("close");
var showSignup = document.getElementById("showSignup");
var showLogin = document.getElementById("showLogin");

bookNowBtn.onclick = function() {
        loginModal.style.display = "block";
}

for (var i = 0; i < spanClose.length; i++) {
        spanClose[i].onclick = function() {
                loginModal.style.display = "none";
                signupModal.style.display = "none";
        }
}

window.onclick = function(event) {
        if (event.target == loginModal) {
                loginModal.style.display = "none";
        }
        if (event.target == signupModal) {
                signupModal.style.display = "none";
        }
}

showSignup.onclick = function(event) {
        event.preventDefault();
        loginModal.style.display = "none";
        signupModal.style.display = "block";
}

showLogin.onclick = function(event) {
        event.preventDefault();
        signupModal.style.display = "none";
        loginModal.style.display = "block";
}



