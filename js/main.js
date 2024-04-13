'use strict';

window.onload = function() {
    let copyright = document.getElementById('copyright');
    copyright.innerHTML = "Copyright &copy; " + (new Date()).getFullYear() + " | ";

    let currImage = null;   // Current image in the slider
    let currSlider = null;  // Current slider itself
    let img = null;
  
    let expand = null;      // Button for expand information blok within slider
    let collapse = null;    // Button for collapse information blok within slider
    let content = null;     // Content area for the information blok within slider
    let span = null;        // Header of content area for the information blok within slider

    let slideIndex = 0;
    let timer = null;

    let hover_enable = true; // Flag changes behaviour of hover effect for 'circle' buttons

    if (window.innerWidth <= 839) {
        hover_enable = false;
    }

    let larrow = document.getElementById('arrow-left');
    let rarrow = document.getElementById('arrow-right');

    let dots =  document.getElementsByClassName("dot");

    let project1 = document.getElementById('first__project');
    let project2 = document.getElementById('second__project');
    let project3 = document.getElementById('third__project');

    let modal = document.getElementsByClassName("premodal")[0];;
    let viewProject = document.getElementsByClassName("view_project")[0];

    let close1 = document.getElementById('close1');
    let close2 = document.getElementById('close2');
    let close3 = document.getElementById('close3');

    for (let dot = 0; dot < dots.length; dot++) {
        dots[dot].addEventListener('click', dotClick);
    }

    showSlides();

    function showSlides() {
        let i = null;
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
            currSlider.style.height = '';
            currSlider.style.marginBottom = '';
        } else {
            let height = img.offsetHeight;
            currSlider.style.height = height+"px";
            currSlider.style.marginBottom = -height+"px";
        }
    
    }

    function onExpand() {
        
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

    /* Protfolio part */

    function onMouseEnter(num) {

        if (!hover_enable) {
            modal.classList.toggle('premodal');     
            modal.classList.toggle('modal');
            document.body.style.overflow="hidden";
            viewProject.classList.remove('view_project');
            viewProject.classList.add('view_project_modal');
        }

        viewProject.classList.toggle('hide');
        let project = viewProject.children[num];
        showProject(project);
    }

    function onMouseLeave(num) {

        if (!hover_enable) {
            modal.classList.toggle('premodal');     
            modal.classList.toggle('modal');
            document.body.style.removeProperty('overflow');
            viewProject.classList.remove('view_project_modal');
            viewProject.classList.add('view_project');
        }

        let project = viewProject.children[num];
        hideProject(project);
        viewProject.classList.toggle('hide');
 
    }

    function showProject(project) {
        
        project.classList.toggle('hide');
        
        if (!hover_enable) {
            project.children[2].classList.toggle('hide');
        }

    }

    function hideProject(project) {
        project.classList.toggle('hide');
        
        if (!hover_enable) {
            project.children[2].classList.toggle('hide');
        }
    }

    project1.onmouseenter = function(event) {
        if (hover_enable) {
            onMouseEnter(0);
        }
    };

    project1.onmouseleave = function(event) {
        if (hover_enable) {
            onMouseLeave(0);
        }  
    };

    project1.onclick = function(event) {
        
        if (hover_enable) {
            window.open("https://lemadior.pp.ua", "_blank");
        } else {
            onMouseEnter(0);
        }

    }

    close1.onclick = function(event) {
        onMouseLeave(0)
    }

    project2.onmouseenter = function(event) {
        if (hover_enable) {
            onMouseEnter(1);
        }
    }

    project2.onmouseleave = function(event) {
        if (hover_enable) {
            onMouseLeave(1);
        }
    }

    project2.onclick = function(event) {
        if (hover_enable) {
            window.open("https://lemadior.pp.ua/nikos/start.html", "_blank");
        } else {
            onMouseEnter(1);
        }  
    }

    close2.onclick = function(event) {
        onMouseLeave(1)
    }

    project3.onmouseenter = function(event) {
         if (hover_enable) {
            onMouseEnter(2);
        }
    };

    project3.onmouseleave = function(event) {

        if (hover_enable) onMouseLeave(2);

    };

    project3.onclick = function(event) {
        
        if (hover_enable) {
            window.open("https://olliplus.com.ua", "_blank");
        } else {
            onMouseEnter(2);
        }

    }

    close3.onclick = function(event) {

        onMouseLeave(2)

    }

    /* Global section */

    window.addEventListener('resize', function(event){
        
        if (window.innerWidth <= 839) {
            hover_enable = false;
        } else {
            hover_enable = true;
        }
        
        setSliderHeight();

    });

}