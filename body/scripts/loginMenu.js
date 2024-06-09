const left = document.getElementById("left");
console.log(left);

const loginMenu = left.contentWindow.document.querySelector(".login-menu");
const loginCancel = left.contentWindow.document.querySelector(".login-cancel");
console.log(loginMenu);

loginMenu.addEventListener("click", function() {
    console.log("Click");
    console.log(left);
    left.classList.add("active");
});

loginCancel.addEventListener("click", function() {
    left.classList.remove("active");
});