console.log('Main script is loading...');

function delete_product() {
    console.log('Deleting');
    let checkboxes = document.getElementsByClassName('delete-checkbox');
   
    if (checkboxes.length == 0) return;

    let node;
    let xhr = new XMLHttpRequest();
    let mForm =  new FormData();

    let checkbox;
    let arr = [];

    xhr.open('POST','/');

    for (let i = 0; i < checkboxes.length; i++) {
        checkbox=checkboxes[i];

        if (checkbox.checked) {
           mForm.append(i, checkbox.id);
        }
    }

   xhr.send(mForm);

   xhr.onload = () => {

        console.log('Return=',xhr.response);
        if (xhr.response == "SUCCESS") {
            mForm.forEach((chk) => {
                node = document.getElementById(chk).parentNode.parentNode;
                node.parentNode.removeChild(node); 
            });
        };
    
    }   
}