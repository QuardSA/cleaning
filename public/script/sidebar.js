const navBar = document.querySelector("nav");
const menuButtons = document.querySelectorAll(".menu-icon");
const overlay = document.querySelectorAll(".overlay_admin");
console.log(navBar,menuButtons,overlay);

menuButtons.forEach((menuButton)=>{
    menuButton.addEventListener("click",() =>{
        navBar.classList.toggle("open");
    });
});

overlay.addEventListener("click", () =>{
    navBar.classList.remove("open");
});
