// Recupération éléments nav menu burger

let icons = document.querySelector('#icons')
let nav = document.querySelector('.nav_burger')
let links = document.querySelectorAll('nav li')

icons.addEventListener("click", () => {
    nav.classList.toggle("active");
})

links.forEach((link) => {
    link.addEventListener("click", () => {
        nav.classList.remove("active");
    })
})


// Récupération éléments pour le "push" boutton d'ajout de message
let buttonAddPost = document.querySelector('.show_boxPost')
let boxPost = document.querySelector('.boxPost');
let addNewPost = document.querySelector('.addActive') ? document.querySelector('.addActive') : false;


if (addNewPost) {
    addNewPost.addEventListener("click", () => {
        buttonAddPost.classList.toggle("active");
        })
}

// JQUERY pour le slideToggle
$(document).ready(function() {
    $('.addActive').click(function() {
        $('.boxPost').slideToggle();
    })
});