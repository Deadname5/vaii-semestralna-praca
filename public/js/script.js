function openPopup(id) {
    let popup = document.getElementById(id);
    popup.classList.add("popup-visible");
    popup.classList.remove("popup");

}

function closePopup(id) {
    let popup = document.getElementById(id);
    popup.classList.add("popup");
    popup.classList.remove("popup-visible");

}