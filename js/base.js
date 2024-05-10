console.log('Base script loaded...');

const error = document.getElementById('page_error');
const errorMsg = document.getElementById('error-message');

error.addEventListener('click', (event) => {
    error.classList.toggle('hide');
    errorMsg.innerHTML = '';
});
