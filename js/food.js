document.addEventListener('click', function(event) {
    if (event.target.matches("#addFood")) {
        makeRequest("addFood.php");
    }
    if (event.target.matches("#editFood")) {
        makeRequest("editFood.php");
    }
});

function makeRequest(sqlFile){
    let recipe = document.getElementById("recipe").files[0];
    let food = document.getElementById("food").files[0];

    let formData = new FormData();
    formData.append('recipe', recipe);
    formData.append('food', food);
    formData.append('name', document.getElementById("name").value);
    formData.append('cooktime', document.getElementById("cooktime").value);
    
    if(document.getElementById("foodId") && document.getElementById("recipeName") && document.getElementById("foodName")){
      formData.append('foodId', document.getElementById("foodId").value);
      formData.append('recipeName', document.getElementById("recipeName").value);
      formData.append('foodName', document.getElementById("foodName").value);
    }

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("reply").innerHTML = this.responseText;
        let response = JSON.parse(this.responseText);
        let messageElement = document.getElementById("reply");
        if (response.success) {
            messageElement.style.color = 'green';
        } 
        if (!response.success) {
            messageElement.style.color = 'red';
        } 
        messageElement.innerHTML = response.message;
      }
    };
    xhttp.open("POST", "sql/"+sqlFile);
    xhttp.send(formData);
}