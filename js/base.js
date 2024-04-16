console.log('Base script loaded...');

let error = document.getElementById('page_error');
let errorMsg = document.getElementById('error-message');

error.addEventListener("click", (event) => {
    error.classList.toggle('hide');
    errorMsg.innerHTML = '';
});