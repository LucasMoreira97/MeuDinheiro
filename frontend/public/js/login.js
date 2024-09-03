
const container = document.getElementById('container');
const register_btn = document.getElementById('register');
const login_btn = document.getElementById('login');

register_btn.addEventListener('click', () =>{
    container.classList.add("active");
});

login_btn.addEventListener('click', () =>{
    container.classList.remove("active");
});