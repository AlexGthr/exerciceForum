// Recupération éléments nav menu burger

let icons = document.querySelector('#icons');
let nav = document.querySelector('.nav_burger');
let links = document.querySelectorAll('nav li');

icons.addEventListener("click", () => {
    nav.classList.toggle("active");
})

links.forEach((link) => {
    link.addEventListener("click", () => {
        nav.classList.remove("active");
    })
})

let msgSession = document.querySelector('.value_session');
let boxSession = document.querySelector('.box_session');

function showReaction(type) {
    boxSession.classList.add(type);
    setTimeout(function () {
        boxSession.classList.remove(type);
    }, 8000);
}

if (msgSession) {
    if (msgSession.textContent === "Success !") {
        showReaction("session_success");
    } else if (msgSession.textContent !== "") {
        showReaction("session_error");
    } else {
        boxSession.classList.remove('session_error');
        boxSession.classList.remove('session_success');
    }
}


// Récupération éléments pour le "push" boutton d'ajout de message
let buttonAddPost = document.querySelector('.show_boxPost');
let boxPost = document.querySelector('.boxPost');
let addNewPost = document.querySelector('.addActive') ? document.querySelector('.addActive') : false;

let buttonEditAvatar = document.querySelector('.show_boxPostAvatar');
let editAvatar = document.querySelector('.addActiveAvatar') ? document.querySelector('.addActiveAvatar') : false;

let buttonEditPassword = document.querySelector('.show_boxPostPassword');
let editPassword = document.querySelector('.addActivePassword') ? document.querySelector('.addActivePassword') : false;


if (addNewPost) {
    addNewPost.addEventListener("click", () => {
        buttonAddPost.classList.toggle("active");
        })
}

if (editAvatar) {
    editAvatar.addEventListener("click", () => {
        buttonEditAvatar.classList.toggle("active");
        })
}

if (editPassword) {
    editPassword.addEventListener("click", () => {
        buttonEditPassword.classList.toggle("active");
        })
}


// JQUERY pour le slideToggle
$(document).ready(function() {
    $('.addActive').click(function() {
        $('.boxPost').slideToggle();
    })
});

$(document).ready(function() {
    $('.addActiveAvatar').click(function() {
        $('.show_editAvatar').slideToggle();
    })
});

$(document).ready(function() {
    $('.addActivePassword').click(function() {
        $('.show_editPassword').slideToggle();
    })
});

document.addEventListener("DOMContentLoaded", function () {
    const btnToggleTheme = document.querySelector(".btn-toggle");

    if (!localStorage.getItem("theme")) {
        document.body.classList.add("dark-theme");
    }
  
    // Vérifier que l'élément .btn-toggle existe avant d'attacher l'événement
    const currentTheme = localStorage.getItem("theme");
    if (currentTheme == "dark") {
        document.body.classList.add("dark-theme");
    } 
    
    if (btnToggleTheme) {
      btnToggleTheme.addEventListener("click", function () {
        document.body.classList.toggle("dark-theme");
  
        let theme = "light";
        if (document.body.classList.contains("dark-theme")) {
          theme = "dark";
        }
        localStorage.setItem("theme", theme);
        })
    }
});

const buttonDelTopic = document.getElementById("delTopic");
const popUp = document.querySelector('.boxPopUp_delTopic');
const removePopUp = document.getElementById('no');

if (buttonDelTopic && popUp && removePopUp) {
    buttonDelTopic.addEventListener("click", function() {
        popUp.classList.add("active");
    })

    removePopUp.addEventListener("click", function() {
        popUp.classList.remove("active");
    })
}

const buttonDelPost = document.querySelectorAll(".delPost");
const popUpPost = document.querySelector('.boxPopUp_delPost');
const removePopUpPost = document.getElementById('noPost');

if (buttonDelPost && popUpPost && removePopUpPost) {
    buttonDelPost.forEach(button => {
        button.addEventListener("click", function() {
            popUpPost.classList.add("active");
        });
    });

    removePopUpPost.addEventListener("click", function() {
        popUpPost.classList.remove("active");
    })
}