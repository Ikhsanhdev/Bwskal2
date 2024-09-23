//  Setup sidebar
let sidemenuSC = document.querySelector('#smScroll');
if (sidemenuSC) {
    window.smScroll = new BScroll(sidemenuSC, {
        tap: true,
        click: true,
        preventDefaultException: {
            tagName: /^(INPUT|TEXTAREA|BUTTON|SELECT)$/,
            className: /(^|\s)menu\-item(\s|$)/
        },
        scrollbar: {
            fade: true,
            interactive: true
        },
        mouseWheel: {
            speed: 20,
            invert: false
        }
    });
}

window._sidebarInit = function () {
    $('.menu-item.active').removeClass('active');
    let m = $('.sidebar-menu a')
    m.filter((idx, elem) => {
        let subLink = window.location.href.replace(elem.href, "");
        if (subLink[0] == "-") return false;
        if (subLink[0] == "/") subLink = subLink.substring(1);
        let hasil = elem.href == window.location.origin + window.location.pathname || (window._activemenu && elem.href == window._activemenu) || (window.location.href.indexOf(elem.href) == 0 && elem.href !== baseurl + 'admin');
        if (hasil && elem.dataset.ignoreSub) {
            let ignoreList = elem.dataset.ignoreSub.split('|');
            for (let il of ignoreList) {
                if (subLink.indexOf(il) > -1) {
                    hasil = false;
                    break;
                }
            };
        }
        return hasil;
    })
        .each((idx, nav) => {
            $(nav).parent('.menu-item').addClass('active');
            let b = $(nav).parents('.has-submenu');
            b.children('a').attr('aria-expanded', true);
            b.children('.submenu').addClass('show');
            setTimeout(() => {
                if ($(nav).offset().top > ($('#smScroll').outerHeight() / 2)) {
                    smScroll.scrollToElement(nav, 600);
                }
            }, 300);
        });
    $('.menu-item.has-submenu > a').on('click', function (e) {
        e.preventDefault();
        $(this).attr('aria-expanded', !$(this).next('.submenu').hasClass('show'));
        $(this).next('.submenu').collapse('toggle');
    });
};
