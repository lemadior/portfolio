'use strict';

let active = document.getElementById('EN');

function setLang(elem) {

    active.classList.remove("active");
    elem.classList.add("active");
    
    document.getElementById(active.id + '-MSG').classList.add('hide');
    document.getElementById(elem.id + '-MSG').classList.remove('hide');

    active = elem;

}