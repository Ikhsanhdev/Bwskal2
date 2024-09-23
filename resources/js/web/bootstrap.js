//  Setup Bootstrap 4.6.x
try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    require('bootstrap');
} catch (e) { }

//  Setup axios
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

//  Handle Unauthenticated
axios.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response.status == 401) {
            location.href = baseurl + '/login';
            return;
        }
        return Promise.reject(error);
    }
);

//  Handle axios yang kadang csrf mismatch
axios.interceptors.request.use(
    config => {
        //  Handle csrf
        config.headers[`X-CSRF-TOKEN`] = $('meta[name="csrf-token"]').attr('content');
        if (!config.headers[`X-XSRF-TOKEN`]) {
            let csrf = RegExp('XSRF-TOKEN[^;]+').exec(document.cookie)
            csrf = decodeURIComponent(csrf ? csrf.toString().replace(/^[^=]+./, '') : '')

            if (csrf) {
                config.headers[`X-XSRF-TOKEN`] = csrf;
            }
        }
        config.headers['X-Requested-With'] = 'XMLHttpRequest';
        return config;
    },
);


$(function () {
    if (window.GLightbox != undefined && document.querySelector('.glb')) {
        window.glb = GLightbox({
            selector: '.glb',
        });
    }
});
