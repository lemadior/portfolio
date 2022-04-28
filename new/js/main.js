'use strict';

window.onload = function() {

    let copyright = document.getElementById('copyright');
    copyright.innerHTML = "Copyright &copy; " + (new Date()).getFullYear() + " | ";

    let currImage = null;
    let currSlider = null;
    let img = null;
  
    let expand = null;
    let collapse = null;
    let content = null;
    let span = null;

    let slideIndex = 0;
    let timer = null;

    let larrow = document.getElementById('arrow-left');
    let rarrow = document.getElementById('arrow-right');

    let dots =  document.getElementsByClassName("dot");

    for (let dot = 0; dot < dots.length; dot++) {
        dots[dot].addEventListener('click', dotClick);
    }

    showSlides();

    function showSlides() {

        let i;
        let slides = document.getElementsByClassName("image-sliderfade");
        let dots = document.getElementsByClassName("dot");
        
        for (i=0; i < slides.length; i++) {
            if (slides[i].classList.contains('hide')) {
                slides[i].classList.remove('hide');
            }
            slides[i].style.display = 'none';
        }

        if (expand !== null) {
            expand.removeEventListener('click', onExpand);
        }
        if (collapse !== null) {
            collapse.removeEventListener('click', onCollapse);
        }
        if (currSlider !== null) {
            currSlider.classList.toggle('hide');
        }

        slideIndex++;
        //console.log(slideIndex);
        if (slideIndex > slides.length) {
            slideIndex = 1;
        }

        currImage = slides[slideIndex-1];
        currImage.style.display = "flex";
        
        currSlider = currImage.children[0];
        currSlider.classList.toggle('hide');
        img = currImage.children[1];

      span = currSlider.children[0];

        for (let i=0;i<currSlider.childElementCount;i++) {
        
            if (currSlider.children[i].className.includes('expand')) {
                 expand=currSlider.children[i];
                 expand.addEventListener('click', onExpand);
            } else if (currSlider.children[i].className.includes('collapse')) {
                 collapse = currSlider.children[i];
                 collapse.addEventListener('click', onCollapse);
            } else if (currSlider.children[i].className.includes('content')) {
                 content = currSlider.children[i];
            } 

         }

        for (i=0; i<dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }

      //  slides[slideIndex-1].style.display = "flex";
        dots[slideIndex-1].className += " active";

        timer = setTimeout(showSlides, 5000);
    }

    function stopSlides() {
        if (timer === null) {
            return;
        }
        
        clearTimeout(timer);
        timer = null;
        slideIndex--;
    }

    function dotClick() {
        let num = this.id.replace('dot','');
        if (expand.className.includes('hide')) {
            onCollapse();
        }
        stopSlides();
        slideIndex = num-1;
        showSlides();
    }

    function rarrowClick() {
        console.log('rarrow');
        if (expand.className.includes('hide')) {
            onCollapse();
        }
        stopSlides();
        slideIndex++;
        showSlides();
    }

    function larrowClick() {
        if (expand.className.includes('hide')) {
            onCollapse();
        }
        stopSlides();
        slideIndex--;

        if (slideIndex < 0) slideIndex = 3;

        showSlides();
    }

    function setSliderHeight() {
        if (!expand.className.includes('hide')) {
            console.log('expand-c');
            currSlider.style.height = '';
            currSlider.style.marginBottom = '';
        } else {
            console.log('collapse-c');
            let height = img.offsetHeight;
            currSlider.style.height = height+"px";
            currSlider.style.marginBottom = -height+"px";
        }
    }

    function onExpand() {
        console.log('expand');
        span.classList.toggle('hide');
        expand.classList.toggle('hide');
        collapse.classList.toggle('hide');
        currImage.classList.remove('sbtn__expand');
        currImage.classList.add('sbtn__collapse');
        currSlider.classList.remove('sl__expand');
        currSlider.classList.add('sl__collapse');
        setSliderHeight();
        content.classList.toggle('hide');
        stopSlides();
    }

    function onCollapse() {
        console.log('collapse');
        span.classList.toggle('hide');
        expand.classList.toggle('hide');
        collapse.classList.toggle('hide');
        currImage.classList.add('sbtn__expand');
        currImage.classList.remove('sbtn__collapse');
        currSlider.classList.add('sl__expand');
        currSlider.classList.remove('sl__collapse');
        setSliderHeight();
        content.classList.toggle('hide');
        showSlides();
    }

    larrow.addEventListener('click', larrowClick);
    rarrow.addEventListener('click', rarrowClick);

    window.addEventListener('resize', function(event){
        setSliderHeight();
    });

}