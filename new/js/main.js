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

    let hover_enable = true;
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

        // timer = setTimeout(showSlides, 5000);
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
        // slideIndex--;
        showSlides();
    }

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

    larrow.addEventListener('click', larrowClick);
    rarrow.addEventListener('click', rarrowClick);

    window.addEventListener('resize', function(event){
        if (window.innerWidth <= 839) {
            hover_enable = false;
        } else {
            hover_enable = true;
        }
        setSliderHeight();
    });

    /* Protfolio part */

    function showProject(project) {
        project.classList.toggle('hide');
        if (!hover_enable) project.children[2].classList.toggle('hide');
    }

    function hideProject(project) {
        project.classList.toggle('hide');
        if (!hover_enable) project.children[2].classList.toggle('hide');
    }

    project1.onmouseenter = function(event) {
        
        console.log(hover_enable);
        if (hover_enable) onMouseEnter(0);
        
    };

    project1.onmouseleave = function(event) {
        
        if (hover_enable) onMouseLeave(0)
       
    };

    project1.onclick = function(event) {
        if (hover_enable) {
            window.open("https://lemadior.pp.ua", "_blank");
        } else {
            // console.log(window.innerWidth);
            // modal.classList.toggle('premodal');     
            // modal.classList.toggle('modal');
            // document.body.style.overflow="hidden";

            // viewProject.classList.toggle('hide');
            // viewProject.classList.remove('view_project');
            // viewProject.classList.toggle('hide');
            // let project = viewProject.children[0];
            // showProject(project);
            onMouseEnter(0);
        }
    }

    close1.onclick = function(event) {
        // modal.classList.toggle('premodal');     
        // modal.classList.toggle('modal');
        // document.body.style.removeProperty('overflow');
        // viewProject.classList.remove('view_project');
        // viewProject.classList.add('view_project_modal');
        // let project = viewProject.children[0];
        // hideProject(project);
        // viewProject.classList.toggle('hide');
        onMouseLeave(0)
    }

    project2.onmouseenter = function(event) {
        console.log('Project 2 IN')
        if (!hover_enable) return;
        // viewProject.classList.toggle('hide');
        // let project = viewProject.children[1];
        // showProject(project);
        onMouseEnter(1);
    };

    project2.onmouseleave = function(event) {
        console.log('Project 2 OUT')
        if (!hover_enable) return;
        // let project = viewProject.children[1];
        // hideProject(project);
        // viewProject.classList.toggle('hide');
        onMouseLeave(1);
    };

    project2.onclick = function(event) {
        if (hover_enable) {
            window.open("https://lemadior.pp.ua/nikos/start.html", "_blank");
        } else {
            console.log(window.innerWidth);
            onMouseEnter(1);
        }
        
    }

    close2.onclick = function(event) {
        onMouseLeave(1)
    }

    project3.onmouseenter = function(event) {
        console.log('Project 3 IN');
        if (!hover_enable) return;
        // viewProject.classList.toggle('hide');
        // let project = viewProject.children[2];
        // showProject(project);
        onMouseEnter(2);
    };

    project3.onmouseleave = function(event) {
        console.log('Project 3 OUT');
        if (!hover_enable) return;
        // let project = viewProject.children[2];
        // hideProject(project);
        // viewProject.classList.toggle('hide');
        onMouseLeave(2);
    };

    project3.onclick = function(event) {
        if (hover_enable) {
            window.open("https://olliplus.com.ua", "_blank");
        } else {
            console.log(window.innerWidth);
            onMouseEnter(2);
        }
        
    }

    close3.onclick = function(event) {
        onMouseLeave(2)
    }

}