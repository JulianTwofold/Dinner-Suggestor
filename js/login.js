document.addEventListener('click', function (event) {
    if (event.target.matches("#login")) {
        makeRequest(document.getElementById('emailLogin').value, document.getElementById('passwordLogin').value, 'sql/login.php', 'replyLogin');
    }
    if (event.target.matches("#register")) {
        makeRequest(document.getElementById('emailRegister').value, document.getElementById('passwordRegister').value, 'sql/register.php', 'replyRegister');
    }
    if (event.target.matches("#requestPassword")) {
        makeRequest(document.getElementById('email').value, "a", 'sql/reset.php', 'reply');
    }
    if (event.target.matches("#changePassword")) {
        makeRequest("a@a.ch", document.getElementById('password').value, 'sql/change.php?token=' + document.getElementById('token').value, 'reply');
    }
    if (event.target.matches("#resetButton")) {
        window.location.href = "reset.php";
    }
});

function makeRequest(email, password, sqlFile, replyId) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.responseText);
            let messageElement = document.getElementById(replyId);
            if (response.success) {
                messageElement.style.color = 'green';
            } 
            if (!response.success) {
                messageElement.style.color = 'red';
            } 
            if(response.destination !== ""){
                window.location.href = response.destination;
            }
            messageElement.innerHTML = response.message;
        }
    };
    xhttp.open("POST", sqlFile, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("email=" + email + "&password=" + password);
}