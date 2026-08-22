const modalsContainer = document.getElementById("modals-cnt");

const editModal = {
    element: document.getElementById("edit-modal"),

    id: document.getElementById("edit-id"), 
    name: document.getElementById("edit-name"),

    img: document.getElementById("edit-img"),
    img_container: document.getElementById("edit-img_container"),
    img_input: document.getElementById("edit-img_input"),

    start_city: document.getElementById("edit-start_city"),
    start_cap: document.getElementById("edit-start_cap"),
    destination: document.getElementById("edit-destination"),
}
const createModal = {
    element: document.getElementById("create-modal"),

    img: document.getElementById("create-img"),
    img_container: document.getElementById("create-img_container"),
    img_input: document.getElementById("create-img_input"),

    start_cap: document.getElementById("create-start_cap"),
}
const deleteModal = {
    element: document.getElementById("delete-modal"),

    id: document.getElementById("delete-id")
}
let currentModal = null;



/**
 * Opens the edit boat modal
 * @param {HTMLElement} button Button containing infos
 */
function openEditModal(button) {
    openModalDefault(editModal.element);

    const id = button.dataset.id;
    const name = button.dataset.name;
    const img = button.dataset.img;
    const start_city = button.dataset.start_city;
    const start_cap = button.dataset.start_cap;
    const destination = button.dataset.destination;

    editModal.id.value = id;
    editModal.name.value = name;
    editModal.img.src = img;
    editModal.start_city.value = start_city;
    editModal.start_cap.value = start_cap;
    editModal.destination.value = destination;
}
/**
 * Opens the create boat modal
 */
function openCreateModal() {
    openModalDefault(createModal.element);
}
/**
 * Opens the delete boat modal
 * @param {HTMLElement} button Button containing infos
 */
function openDeleteModal(button) {
    openModalDefault(deleteModal.element);

    const id = button.dataset.id;
    deleteModal.id.value = id;
}

/**
 * Checks if the CAP is valid (if there are letter/symbols this will remove them)
 * @param {HTMLElement} element 
 */
function checkCap(element) {
    const value = element.value;
    let isNum = value.match(/\D/) == null;

    if (!isNum) {
        element.value = value.replace(/\D/g,'');;
    }
}

/**
 * Default Function that NEEDS to be executed after opening a modal
 * @param {HTMLElement} modalElement 
 */
function openModalDefault(modalElement) {
    modalsContainer.classList.add("open");
    modalElement.classList.add("open");

    currentModal = modalElement;
    modalElement.value = name;
}

/** 
 * Close any open modal
*/
function closeModal() {
    modalsContainer.classList.remove("open")

    if (currentModal) {
        currentModal.classList.remove("open")
        currentModal = null;
    }
}


// Events
// Edit Modal
editModal.start_cap.addEventListener("input", () => {
    checkCap(editModal.start_cap);
});

editModal.img_container.addEventListener("click", () => {
    editModal.img_input.click();
});
editModal.img_input.addEventListener("change", () => {
    const file = editModal.img_input.files[0];
    if (file == undefined)
        return

    const reader = new FileReader();
    reader.onload = (e) => {
        editModal.img.src = e.target.result;
    }
    reader.readAsDataURL(file);
});

// Create Modal
createModal.start_cap.addEventListener("input", () => {
    checkCap(createModal.start_cap);
});

createModal.img_container.addEventListener("click", () => {
    createModal.img_input.click();
});
createModal.img_input.addEventListener("change", () => {
    const file = createModal.img_input.files[0];
    if (file == undefined)
        return

    const reader = new FileReader();
    reader.onload = (e) => {
        createModal.img.src = e.target.result;
    }
    reader.readAsDataURL(file);
});