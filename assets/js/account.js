const colorinput = document.getElementById("inputcolor");
const colorbutton = document.getElementById("btncolor");
const colorsvg = document.getElementById("svgcolor");

function calcY(hex) { // Y = Brightness
    if (!hex.startsWith("#"))
        return 0 // error
    hex = hex.replace("#","");
    let r = parseInt(hex.slice(0, 2), 16);
    let g = parseInt(hex.slice(2, 4), 16);
    let b = parseInt(hex.slice(4, 6), 16);

    const y = (0.299 * r + 0.587 * g + 0.114 * b);
    return y;
}

function checkColor() {
    const y = calcY(colorinput.value);
    colorbutton.style.backgroundColor = colorinput.value;
    colorsvg.style.filter = `invert(${y >= 190 ? 0 : 1})`;
}

colorbutton.addEventListener("click", () => {
    colorinput.click();
});
colorinput.addEventListener("input", () => {
    checkColor();
});

checkColor();



const accountCard = document.getElementById("account-card");
const chatsCard = document.getElementById("chats-card")

/**
 * Sets the parent height as the max height for every child element
 * @param {HTMLElement} parent 
 * @param  {HTMLElement} childs 
 */
function setHeight(parent, ...childs) {
    const parentHeight = parent.offsetHeight;
    childs.forEach(child => {
        child.style.height = parentHeight + "px";
    }); 
    return parentHeight + "px";
}

window.addEventListener("load", () => {
    setHeight(accountCard, chatsCard)
})