const submitActionBtn = document.getElementById("action-submit");
const typeActionInput = document.getElementById("action-type");
const changeActionBtn = document.getElementById("action-change");


function changeAction() {
    switch (typeActionInput.value) {
        case "login":
            typeActionInput.value = "register";
            submitActionBtn.innerText = "REGISTRATI";
            changeActionBtn.innerHTML = 'Hai un account? <a onclick="changeAction()">Accedi</a>';
            break;
        case "register":
            typeActionInput.value = "login";
            submitActionBtn.innerText = "ACCEDI";
            changeActionBtn.innerHTML = 'Non hai un account? <a onclick="changeAction()">Registrati</a>';
            break;
    }
}