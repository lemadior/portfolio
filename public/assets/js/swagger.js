const swagger = document.getElementById('swagger-ui');
const footer = document.getElementById('footer');

// Create Observer to track change in the Node tree to determine appears 'button' elements
// It needs to properly change style 'position' parameter on the 'footer' class
const resizeObserver = new ResizeObserver(swaggerHeight)

resizeObserver.observe(swagger);

window.addEventListener("resize", (event) => {
    swaggerHeight();
});

/**
 * If height of the div with class='swagger-ui' is greater than height of the viewport
 * then switch 'position' style parameter to the 'relative' value to stay footer on the bottom
 */
function swaggerHeight() {
    const swaggerHeight = swagger.offsetHeight + 34;
    const viewHeight = window.innerHeight - 25;

    if (viewHeight < swaggerHeight) {
        footer.style.position = 'relative';
    } else {
        footer.style.position = 'absolute';
    }
}
