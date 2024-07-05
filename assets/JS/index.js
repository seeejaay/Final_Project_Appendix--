var modal = document.getElementById("myModal");
var loginBtn = document.getElementById("myBtn");
var bookNowBtn = document.getElementById("bookNowBtn");
var span = document.getElementsByClassName("close")[0];

loginBtn.onclick = function() {
modal.style.display = "block";
}

bookNowBtn.onclick = function() {
modal.style.display = "block";
}

span.onclick = function() {
modal.style.display = "none";
}

window.onclick = function(event) {
if (event.target == modal) {
        modal.style.display = "none";
}
}