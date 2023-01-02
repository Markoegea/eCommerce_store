var login_form = document.getElementById("LoginForm");
var reg_form = document.getElementById("RegForm");
var indicator = document.getElementById("Indicator");

function register(){
    reg_form.style.transform = "translateX(0px)";
    login_form.style.transform = "translateX(0px)";
    indicator.style.transform = "translateX(100px)";
}

function login(){
    reg_form.style.transform = "translateX(400px)";
    login_form.style.transform = "translateX(400px)";
    indicator.style.transform = "translateX(0px)";
}