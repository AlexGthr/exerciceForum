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