let SubMenu = document.getElementById("SubMenu");

function mostrar() {
    SubMenu.classList.toggle("open-menu")
}

function toggleCorazon() {
    var corazonBtn = document.querySelector('.corazon-btn');
    corazonBtn.classList.toggle('clicked');
}