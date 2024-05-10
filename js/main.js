console.log('Main script is loading...');

function delete_product() {
    console.log('Delete');
    const checkboxes = document.getElementsByClassName('delete-checkbox');
   
    if (checkboxes.length === 0) {
        return;
    }

    let node;
    const xhr = new XMLHttpRequest();
    const mForm =  new FormData();

    xhr.open('POST','/');

    Array.prototype.slice.call(checkboxes).forEach((checkbox, index) => {
        if (checkbox.checked) {
            mForm.append(index, checkbox.id);
        }
    });

   xhr.send(mForm);

   xhr.onload = () => {
        console.log('Return=', xhr.response);

        if (xhr.response === 'SUCCESS') {
            mForm.forEach((chk) => {
                node = document.getElementById(chk).parentNode.parentNode;
                node.parentNode.removeChild(node); 
            });
        }
    }
}