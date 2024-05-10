console.log('add.js is loaded');

class Input 
{
    #valid;
    #obj;
    constructor (_name)
    {
        this.#obj = document.getElementById(_name);
        this.parentBlock = this.#obj.parentNode.parentNode.parentNode;
        this.#valid = false;
        this.#obj.addEventListener('input', this.check.bind(this));
    }

    /**
     * @param {boolean} value
     */
    set valid(value)
    {
        this.#valid = value;

        this.#obj.style.color = value ? 'green' : 'red';
    }

    get valid()
    {
        if (this.parentBlock.classList.contains('hide')) {
            this.#valid = true;  
        } else {
            this.check();   
        }

        return this.#valid;
    }

    /**
     * @param {HTMLElement} value
     */
    set obj(value)
    {
        this.#obj = value;
    }

    get obj() {
        return this.#obj;
    }

    getObj() 
    {
        return this.#obj;
    }

    check() {
        let elem = this.#obj;

        if (isNaN(parseInt(elem.value,10)) || parseInt(elem.value,10) === 0 || elem.value === '')  {
           console.log("Elem false");
           this.valid = false;
        } else {
            this.valid = true;   
            console.log("Elem true");
        }
    }
}

const sku = document.getElementById('sku');
const price = document.getElementById('price');
const _name = document.getElementById('name');

const size = new Input('size');
const weight = new Input('weight');
const width = new Input('width');
const height = new Input('height');
const _length = new Input('length');

const saveBtn = document.getElementById('save');
const type_select = document.getElementById('productType');
let current_block = document.getElementsByClassName(type_select.value.toLowerCase() + '__block')[0];
const error_msg = document.getElementById('error-message');
let SKU_list = [];

let sku_valid = false;
let price_valid = false;
let name_valid = false;

let allow_add = false;

window.setInterval( function(){

    if (sku_valid === false || 
        price_valid === false ||
        name_valid === false ||
        size.valid === false ||
        weight.valid === false ||
        width.valid === false ||
        height.valid === false ||
        _length.valid === false) {
        saveBtn.style.color = 'red';
        allow_add = false;
    } else {
        saveBtn.style.color = 'black';
        allow_add = true;
    }

  },10)

window.onload = () => {

    let xhr = new XMLHttpRequest();
    let mForm =  new FormData();

    xhr.open('POST','/add-product');
    mForm.append('UNIQUE', 'YES');

    xhr.send(mForm);

    xhr.onload = () => {

        if (xhr.response !== 'FAIL') {
            SKU_list = xhr.response.split(' ');
        } else {
            error_msg.innerHTML="ERROR: can't get identifiers list!";
            error_msg.parentNode.classList.toggle('hide');
        }
    }
};

function saving() {
    
    if (!allow_add) return;

    console.log('Adding');

    let xhr = new XMLHttpRequest();
    let mForm =  new FormData(document.getElementById('product_form'));
    
    xhr.open('POST','/add-product');

    xhr.send(mForm);

    xhr.onload = () => {

        if (xhr.response !== 'FAIL') {
            location.href='/';
        } else {
            error_msg.innerHTML='ERROR: can\'t get identifiers list!';
            error_msg.parentNode.classList.toggle('hide');
        };

    }   
}

type_select.addEventListener('change', (event) => {
    let type = type_select.value.toLowerCase();
    let add_block = document.getElementsByClassName(type + '__block')[0];
    current_block.classList.toggle('hide');
    add_block.classList.toggle('hide');
    current_block = add_block;
});

sku.addEventListener('input', (event) => {
    if (SKU_list.includes(event.target.value) || event.target.value === '') {
        sku.style.color = 'red';
        sku_valid = false;
    } else {
        sku.style.color = 'green';
        sku_valid = true;
    }
});

price.addEventListener('input', (event) => {
    if (isNaN(parseFloat(event.target.value)) ||
        parseFloat(event.target.value) === 0 ||
        event.target.value === '')  {
        price.style.color = 'red';
        price_valid = false;
    } else {
        price.style.color = 'green';
        price_valid = true; 
    }
});

_name.addEventListener('input', (event) => {
    name_valid = event.target.value !== '';
});
