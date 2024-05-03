const navBar = document.querySelector("nav");
const menuButtons = document.querySelectorAll(".menu-icon");

menuButtons.forEach((menuButton)=>{
    menuButton.addEventListener("click",() =>{
        navBar.classList.toggle("open");
    });
});
