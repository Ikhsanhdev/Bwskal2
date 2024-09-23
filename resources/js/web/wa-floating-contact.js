function WaContactToggle() {
  if ($('#floating-wa-contact .window').hasClass('show')) {
    $('#floating-wa-contact .window').removeClass('show');
  } else {
    $('#floating-wa-contact .window').addClass('show');
    //  Cek apakah masih loading
    if ($('#floating-wa-contact .chat-item .loading').css('opacity') === '1') {
      setTimeout(() => {
        //  Hide
        $('#floating-wa-contact .chat-item .loading').css('opacity', 0);

        //  Set waktu
        let waktu = new Intl.DateTimeFormat('en-US', { hour: 'numeric', minute: 'numeric', hour12: false }).format(new Date());
        $('#floating-wa-contact .chat-item .content .time').html(waktu);

        //  Tampilkan chat
        $('#floating-wa-contact .chat-item .content').addClass('show');
      }, 2000);
    }
  }
}

$(function() {
  if ($('#floating-wa-contact').length == 0) {
    return;
  }

  $('#floating-wa-contact form').on('submit', function (e) {
    e.preventDefault();

    if ($('#floating-wa-contact input').val().length < 1) {
      return;
    }

    let target = new URL(`https://wa.me/${$('#floating-wa-contact form').data('phone')}`);
    target.searchParams.set('text', $('#floating-wa-contact input').val());
    
    window.open(target.href);

    $('#floating-wa-contact input').val('');
  });

  $('#floating-wa-contact div.wa-btn').on('click', function () {
    WaContactToggle();
  });
  $('#floating-wa-contact .close-btn').on('click', function () {
    $('#floating-wa-contact .window').removeClass('show');
  });
});
