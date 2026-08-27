const messages = document.getElementById("messages");

function randomLimit(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

window.addEventListener("load", () => {
    messages.scrollTo({ top: messages.scrollHeight })
    let refreshTime = randomLimit(15, 20) * 1000 // ms
    console.log(refreshTime);
    setTimeout(() => {
        location.reload();
    }, refreshTime);
})
