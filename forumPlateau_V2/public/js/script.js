let icons = document.querySelector('#icons')
let nav = document.querySelector('.nav_burger')
let links = document.querySelectorAll('nav li')

let buttonAddPost = document.querySelector('.show_boxPost')
let boxPost = document.querySelector('.boxPost');
let addNewPost = document.querySelector('.addActive')

icons.addEventListener("click", () => {
    nav.classList.toggle("active");
})

links.forEach((link) => {
    link.addEventListener("click", () => {
        nav.classList.remove("active");
    })
})

addNewPost.addEventListener("click", () => {
    buttonAddPost.classList.toggle("active");
    })

$(document).ready(function() {
    $('.addActive').click(function() {
        $('.boxPost').slideToggle();
    })
});