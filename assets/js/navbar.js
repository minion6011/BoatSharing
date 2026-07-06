const navbarLinks = document.getElementById("nav-link");

const elements = navbarLinks.children;


for (let i = 0; i < elements.length; i++) { // To-Do: improve the code
    if (elements[i].tagName != "A")
        continue;
    if (elements[i].href == "")
        continue;

    if (elements[i].href.includes("index.php") && !window.location.pathname.endsWith(".php")) {
        elements[i].classList.add("active");
        break;
    }

    if (window.location.href != elements[i].href)
        continue;

    elements[i].classList.add("active");
}