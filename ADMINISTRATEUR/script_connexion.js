/* voir mot de passe */

const togglePassword = document.getElementById('togglePassword');
const togglePasswor = document.getElementById('togglePasswor');
const passwordInput = document.getElementById('password');
const passwordConfirmInput = document.getElementById('password_confirm');

passwordInput.addEventListener('input', (event) => {  
    togglePassword.style.display='block';
});
passwordConfirmInput.addEventListener('input', (event) => {  
    togglePasswor.style.display='block';
});
togglePassword.addEventListener('click', function() {

const type = passwordInput.type === 'password' ? 'text' : 'password';
passwordInput.type = type;
this.textContent = type === 'password' ? '👁️' : '👁️‍🗨️';
});
togglePasswor.addEventListener('click', function() {

const type = passwordConfirmInput.type === 'password' ? 'text' : 'password';
passwordConfirmInput.type = type;
this.textContent = type === 'password' ? '👁️' : '👁️‍🗨️';
});
document.addEventListener('click', (event) =>{
      togglePassword.style.display='none';
      togglePasswor.style.display='none';
});