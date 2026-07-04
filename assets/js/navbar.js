const navbarLinks = document.getElementById("nav-link");

const elements = navbarLinks.children;

let isIndex = true;
let indexElement;

for (let i = 0; i < elements.length; i++) {
    if (elements[i].tagName != "A")
        continue;
    if (elements[i].href == "")
        continue;

    if (elements[i].href.includes("index.php")) 
        indexElement = elements[i];

    if (window.location.href != elements[i].href)
        continue

    isIndex = false;
    elements[i].classList.add("active");
}

if (isIndex && indexElement) {
    indexElement.classList.add("active")
}