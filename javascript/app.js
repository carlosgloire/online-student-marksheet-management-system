let passwords = document.querySelector('.password');
let openIcon = document.querySelector('.open');
let closeIcon = document.querySelector('.close');

passwords.setAttribute('type', 'password');

openIcon.onclick = function() {
    passwords.setAttribute('type', 'text');
    openIcon.classList.add('hidden');
    closeIcon.classList.remove('hidden');
}

closeIcon.onclick = function() {
    passwords.setAttribute('type', 'password');
    openIcon.classList.remove('hidden');
    closeIcon.classList.add('hidden');
}