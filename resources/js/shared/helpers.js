//  Parse axios form error
window.parseAxiosFormError = function (res) {
    let error = null;
    if (res &&
        res.status == 400 &&
        res.data &&
        res.data.error &&
        res.data.error.type == 'input_validation' &&
        res.data.error.data &&
        res.data.error.data.errors) {
        error = res.data.error.data.errors;
    }

    return error;
};

//  Bootstrap multi model helper
window.bsmultimodal_check = function () {
    if ($('.modal.show').length) {
        $('body').addClass('modal-open');
    }

    let h = null;
    $('.modal-open .modal.show').each((idx, item) => {
        if (!h || h.z <= item.style.zIndex) {
            h = {
                elem: item, z: item.style.zIndex
            };
        }
        item.style.overflowX = "hidden";
        item.style.overflowY = "hidden";
    });
    if (h) {
        h.elem.style.overflowX = "hidden";
        h.elem.style.overflowY = "auto";
    }
};
window.bsmultimodal_hide_all = function () {
    $('.modal.show').each((idx, item) => {
        $(item).modal('hide');
        item.style.overflowX = "";
        item.style.overflowY = "";
    });
};

window.formatByte = function (num) {
    if (isNaN(parseFloat(num)) || !isFinite(num)) return '-';
    var units = ['bytes', 'kB', 'MB', 'GB', 'TB', 'PB'],
        number = Math.floor(Math.log(num) / Math.log(1024));
    return (num / Math.pow(1024, Math.floor(number))).toFixed(2) + ' ' + units[number];
}

window.$.fn.truncate = function (lines, readmore) {
    lines = typeof lines !== 'undefined' ? lines : 1;
    readmore = typeof readmore !== 'undefined' ? readmore : '.readmore';
    var lineHeight = window.lineHeight(this[0]);
    if (this.attr('title')) {
        this.text(this.attr('title'));
    }
    if (!this.attr('data-link') && this.find('a' + readmore).length > 0) {
        this.attr('data-link', this.find('a' + readmore)[0].outerHTML);
    }
    var link = this.attr('data-link');
    if (this.height() > lines * lineHeight) {
        if (!this.attr("title")) {
            this.attr("title", this.html());
        }
        var words = this.attr("title").split(" ");
        var str = "";
        var prevstr = "";
        this.text("");
        for (var i = 0; i < words.length; i++) {
            if (this.height() > lines * lineHeight) {
                this.html(prevstr.trim() + "&hellip; " + (typeof link !== 'undefined' ? ' ' + link : ''));
                break;
            }
            prevstr = str;
            str += words[i] + " ";
            this.html(str.trim() + "&hellip;" + (typeof link !== 'undefined' ? ' ' + link : ''));
        }
        if (this.height() > lines * lineHeight) {
            this.html(prevstr.trim() + "&hellip; " + (typeof link !== 'undefined' ? ' ' + link : ''));
        }
    }
    return this;
}

window.TextTruncateInit = function () {
    $(window).on('load resize', function () {
        $('[data-maxline]').each(function () {
            $(this).truncate($(this).data('maxline'));
        });
    });
}

window.get_blank_image = function () {
    return `data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAACWCAYAAAA8AXHiAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAABuSURBVHgB7cAxAQAAAMKg9U9tCy8oAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAfgZgNQAB5OrvAAAAAABJRU5ErkJggg==`;
}

//  Youtube
window.ytregex = /https?:\/\/(?:youtu\.be\/|(?:[a-z]{2,3}\.)?youtube\.com\/(?:embed\/|watch(?:\?|#\!)v=))([\w-]{11}).*/gmi;
window.isYoutubeUrl = (st) => {
    return _.clone(window.ytregex).test(st);
};
