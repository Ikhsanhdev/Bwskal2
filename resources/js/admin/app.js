require('./bootstrap');
require('@/shared/helpers');
require('./vue');

window.TextTruncateInit();

//  On Ready
$(function() {
    //  handle sidebar
    window._sidebarInit();

    //  Handle glightbox
    if (window.GLightbox != undefined && document.querySelector('.glb')) {
        window.glb = GLightbox({
            selector: '.glb',
        });
    }
});
