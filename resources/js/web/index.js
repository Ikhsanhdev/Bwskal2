require('./bootstrap');
require('@/shared/helpers');
require('./wa-floating-contact');

window.TextTruncateInit();

$(function () {
  if ($('#header-search-btn').length) {
    $('#header-search-btn').on('click', function () {
      $('.header-search-popup').toggleClass('show')
      $('#header-search-input').focus();
    });
    $('#header-search-input').on('blur', function () {
      $('.header-search-popup').removeClass('show')
    });
  }
});
