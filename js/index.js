function addListenersToClass(className, clickFunction) {
    var elements = document.getElementsByClassName(className);

    for (var i = 0; i < elements.length; i++) {
        elements[i].addEventListener('click', clickFunction, false);
    }
}

addListenersToClass("anzeige", function () {
    window.location.href = 'editFood.php?id=' + this.id;
});

let lightBox = document.getElementById("lightbox");
let cross = document.getElementById("cross");
let plus = document.getElementById("plus");

function swapClass(element) {
    if (element.classList.contains("visible")) {
        element.classList.remove("visible");
        element.classList.add("hidden");
        return;
    }
    element.classList.remove("hidden");
    element.classList.add("visible");
}

addListenersToClass("cross", function () {
    swapClass(lightBox);
    swapClass(cross);
    swapClass(plus);
});

addListenersToClass("imageHolder", function () {
    document.getElementById("recipeImg").src = this.getAttribute('recipeLink');
    swapClass(lightBox);
    swapClass(cross);
    swapClass(plus);
});

addListenersToClass("cookButton", function () {
    let cookbutton = this;
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        cookbutton.classList.add("plannedToCook");
    }
    xhttp.open("GET", "sql/updateDate.php?foodId=" + cookbutton.getAttribute('foodid'));
    xhttp.send();
});
