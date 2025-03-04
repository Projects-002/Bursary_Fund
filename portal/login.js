const loginForm = document.querySelector("form");
const passWord = document.querySelector(".password");
const userName = document.querySelector(".username");

const user = "ke430@gmail.com";
const pass = "123456789";


loginForm.addEventListener('submit', (e) => {
    e.preventDefault();

 if(passWord.value === pass && userName.value === user){
        window.location="index.html"   
    }
    else{
        alert("Invalid password or username!") 
    }
});








