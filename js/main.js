'use strict';

window.onload = function() {
    // Do nothing if we're not on the home page
    if (document.title.includes('comments')) {
        return;
    }

    const copyright = document.getElementById('copyright');
    copyright.innerHTML = "Copyright &copy; " + (new Date()).getFullYear() + " ";

    const projectLinks = {
        project1: "https://lemadior.pp.ua",
        project2: "https://lemadior.pp.ua/nikos/start.html",
        project3: "https://olliplus.com.ua"
    }

    const slider = {
    	image: null,
    	current: null,
    	expand: null,
    	collapse: null,
    	content: null,
    	img: null,
    	span: null,
    	index: 0,
    	timer: null
    }

    const lArrow = document.getElementById('arrow-left');
    const rArrow = document.getElementById('arrow-right');

    const dots =  Array.prototype.slice.call(document.getElementsByClassName("dot"));

    const project1 = document.getElementById('first__project');
    const project2 = document.getElementById('second__project');
    const project3 = document.getElementById('third__project');

    const modal = document.getElementsByClassName("premodal")[0];
    const viewProject = document.getElementsByClassName("view_project")[0];

    const close1 = document.getElementById('close1');
    const close2 = document.getElementById('close2');
    const close3 = document.getElementById('close3');

    const hover_enable = () => window.innerWidth > 839; // Flag changes behaviour of hover effect for 'circle' buttons

    dots.forEach(dot => dot.addEventListener('click', dotClick));

    showSlides();

    function showSlides() {
        const firstSliderNum = 1;
        const slides = Array.prototype.slice.call(document.getElementsByClassName("image-sliderfade"));

        slides.forEach(slide => {
            slide.classList.remove('hide');

            slide.style.display = 'none';
        });

        slider.expand?.removeEventListener('click', onExpand);

        slider.collapse?.removeEventListener('click', onCollapse);

        slider.current?.classList.toggle('hide');

        slider.index = slider.index + 1 <= slides.length ? slider.index + 1 : firstSliderNum;

        slider.image = slides[slider.index - 1];
        slider.image.style.display = "flex";
        
        slider.current = slider.image.children[0];
        slider.current.classList.toggle('hide');

        slider.img = slider.image.children[1];
    
        slider.span = slider.current.children[0];

	    Array.prototype.slice.call(slider.current.children).forEach(child => {
            if (child.className.includes('expand')) {
                slider.expand=child;
                slider.expand.addEventListener('click', onExpand);
            } else if (child.className.includes('collapse')) {
                slider.collapse = child;
                slider.collapse.addEventListener('click', onCollapse);
            } else if (child.className.includes('content')) {
                slider.content = child;
            }
         })

        dots.forEach(dot => dot.className = dot.className.replace(" active", ""));

        dots[slider.index - 1].className += " active";

        slider.timer = setTimeout(showSlides, 5000);
    }

    function stopSlides() {
        if (!slider.timer) {
            return;
        }

        clearTimeout(slider.timer);

        slider.timer = null;

        slider.index--;
    }

    function dotClick() {
        const num = this.id.replace('dot','');

        if (slider.expand.className.includes('hide')) {
            onCollapse();
        }

        stopSlides();

        slider.index = num - 1;

        showSlides();
    }

    function rArrowClick() {
        if (slider.expand.className.includes('hide')) {
            onCollapse();
        }

        stopSlides();

        slider.index++;

        showSlides();
    }

    function lArrowClick() {
        const lastSliderNumber = 3;

        if (slider.expand.className.includes('hide')) {
            onCollapse();
        }

        stopSlides();
        
        slider.index = slider.index - 1 >= 0 ? slider.index - 1 : lastSliderNumber;

        showSlides();
    }

    function setSliderHeight() {
        if (!slider.expand.className.includes('hide')) {
            slider.current.style.height = '';
            slider.current.style.marginBottom = '';
        } else {
            const height = slider.img.offsetHeight;

            slider.current.style.height = height+"px";
            slider.current.style.marginBottom = -height+"px";
        }
    }

    function onExpand() {
        slider.span.classList.toggle('hide');
        slider.expand.classList.toggle('hide');
        slider.collapse.classList.toggle('hide');
        slider.image.classList.remove('sbtn__expand');
        slider.image.classList.add('sbtn__collapse');
        slider.current.classList.remove('sl__expand');
        slider.current.classList.add('sl__collapse');

        setSliderHeight();

        slider.content.classList.toggle('hide');

        stopSlides();
    }

    function onCollapse() {
        slider.span.classList.toggle('hide');
        slider.expand.classList.toggle('hide');
        slider.collapse.classList.toggle('hide');
        slider.image.classList.add('sbtn__expand');
        slider.image.classList.remove('sbtn__collapse');
        slider.current.classList.add('sl__expand');
        slider.current.classList.remove('sl__collapse');

        setSliderHeight();

        slider.content.classList.toggle('hide');

        showSlides();
    }

    lArrow.addEventListener('click', lArrowClick);
    rArrow.addEventListener('click', rArrowClick);

    /* Protfolio part */

    function onMouseEnter(num) {
        if (!hover_enable()) {
            modal.classList.toggle('premodal');     
            modal.classList.toggle('modal');
            document.body.style.overflow="hidden";
            viewProject.classList.remove('view_project');
            viewProject.classList.add('view_project_modal');
        }

        viewProject.classList.toggle('hide');

        showProject(viewProject.children[num]);
    }

    function onMouseLeave(num) {
        if (!hover_enable()) {
            modal.classList.toggle('premodal');     
            modal.classList.toggle('modal');
            document.body.style.removeProperty('overflow');
            viewProject.classList.remove('view_project_modal');
            viewProject.classList.add('view_project');
        }

        const project = viewProject.children[num];

        hideProject(project);

        viewProject.classList.toggle('hide');
     }

    function showProject(project) {
        project.classList.toggle('hide');
        
        hover_enable() || project.children[2].classList.toggle('hide');
    }

    function hideProject(project) {
        project.classList.toggle('hide');
        
        if (!hover_enable()) {
            project.children[2].classList.toggle('hide');
        }
    }

    project1.onmouseenter = () => {
        hover_enable() && onMouseEnter(0);
    };

    project1.onmouseleave = () => {
        hover_enable() && onMouseLeave(0);
    };

    project1.onclick = () => {
        if (hover_enable()) {
            window.open(projectLinks.project1, "_blank");
        } else {
            onMouseEnter(0);
        }
    }

    close1.onclick = () => onMouseLeave(0);

    project2.onmouseenter = () => {
        hover_enable() && onMouseEnter(1);
    }

    project2.onmouseleave = () => {
        hover_enable() && onMouseLeave(1);
    }

    project2.onclick = () => {
        if (hover_enable()) {
            window.open(projectLinks.project2, "_blank");
        } else {
            onMouseEnter(1);
        }  
    }

    close2.onclick = () => onMouseLeave(1);

    project3.onmouseenter = () => {
         hover_enable() && onMouseEnter(2);
    };

    project3.onmouseleave = () => {
        hover_enable() && onMouseLeave(2);
    };

    project3.onclick = () => {
        if (hover_enable()) {
            window.open(projectLinks.project3, "_blank");
        } else {
            onMouseEnter(2);
        }
    }

    close3.onclick = () => onMouseLeave(2);

    /* Global section */
    window.addEventListener('resize', setSliderHeight);
}
