const hamburger = document.querySelector(".hamburger");
const nav_menu = document.querySelector(".nav-menu")
const nav_link = document.querySelectorAll(".nav-link");
const video_content = document.getElementsByClassName(".video-content");

nav_link.forEach(n => n.addEventListener("click", closeMenu));

hamburger.addEventListener("click", mobileMenu) ;

function mobileMenu() {
    hamburger.classList.toggle("active");
    nav_menu.classList.toggle("active");
    console.log(video_content);
}

function closeMenu() {
    hamburger.classList.remove("active");
    nav_menu.classList.remove("active");
}