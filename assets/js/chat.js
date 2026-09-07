const messages = document.getElementById("messages");
const msgId = document.getElementById("msg-input");

function randomLimit(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

window.addEventListener("load", () => {
    messages.scrollTo({ top: messages.scrollHeight })
    let refreshTime = randomLimit(15, 20) * 1000 // ms
    setTimeout(() => {
        if (msgId.value != "")
            return;
        location.reload();
    }, refreshTime);
})
