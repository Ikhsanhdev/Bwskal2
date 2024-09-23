@section('cssBeforeMain')
  <link rel="stylesheet" href="{{ url('libs/summernote/summernote-bs4.css') }}">
  <style>
    .note-editable {
      font-family: "Source Sans Pro";
      color: #616161;
      font-size: 1rem;
      line-height: 1.6;
    }
    .note-editor.note-frame .note-editing-area .note-editable {
      color: #616161;
    }
    .card .card-header {
      display: block !important;
      height: auto !important;
    }
    </style>
  @parent
@endsection

@section('jsBeforeMain')
  <script src="{{ url('libs/summernote/summernote-bs4.min.js') }}"></script>
  <script src="{{ url('libs/summernote/plugin/image-attributes/summernote-image-attributes.js') }}"></script>
  @parent
@endsection
@section('jsAfterMain')
  <script>
  $.extend($.summernote.plugins, {
    'imagePostion': function (context) {
      let ui = $.summernote.ui;
      let editable = context.layoutInfo.editable;
      context.memo('button.imagePositionLeft', function() {
        var button = ui.button({
          contents: '<i class="mdi mdi-format-align-left"/>',
          tooltip:  'Posisi Gambar Kiri',
          container: 'body',
          click: function () {
            var $img=$(editable.data('target'));
            $img.parent().removeClass('text-center text-right text-justify').addClass('text-left');
            context.invoke('editor.afterCommand');
          }
        });
        return button.render();
      });
      context.memo('button.imagePositionCenter', function() {
        var button = ui.button({
          contents: '<i class="mdi mdi-format-align-center"/>',
          tooltip:  'Posisi Gambar Tengah',
          container: 'body',
          click: function () {
            var $img=$(editable.data('target'));
            $img.parent().removeClass('text-left text-right text-justify').addClass('text-center');
            context.invoke('editor.afterCommand');
          }
        });
        return button.render();
      });
      context.memo('button.imagePositionRight', function() {
        var button = ui.button({
          contents: '<i class="mdi mdi-format-align-right"/>',
          tooltip:  'Posisi Gambar Kanan',
          container: 'body',
          click: function () {
            var $img=$(editable.data('target'));
            $img.parent().removeClass('text-center text-left text-justify').addClass('text-right');
            context.invoke('editor.afterCommand');
          }
        });
        return button.render();
      });
  
      this.initialize = function () {
      };
  
      this.destroy = function () {
        
      };
    },
  });
  //  Gambar Picker
  let akImagePickerButton = function (context) {
    let ui = $.summernote.ui;
    let button = ui.button({
      contents: '<i class="mdi mdi-image"/>',
      tooltip: 'Pilih Gambar',
      container: 'body',
      click: function () {
        context.invoke('editor.saveRange');
        AKModal.open({
          url: "{{ route('admin.mediapicker.index') }}",
          size: 'lg',
        }, function (e) {
          if (window.__mp_terpilih) {
            context.invoke('editor.restoreRange');
            context.invoke('editor.insertImage', window.__mp_terpilih, function($img) {
              $img.addClass('img-fluid');
            });
            window.__mp_terpilih = null;
          }
        });
      }
    });
    return button.render();
  }
  let akGuestImagePickerButton = function (context) {
    let ui = $.summernote.ui;
    let button = ui.button({
      contents: '<i class="mdi mdi-image"/>',
      tooltip: 'Pilih Gambar',
      container: 'body',
      click: function () {
        context.invoke('editor.saveRange');
        AKModal.open({
          url: "{{ route('guest.mediapicker.index') }}",
          size: 'lg',
        }, function (e) {
          if (window.__mp_terpilih) {
            context.invoke('editor.restoreRange');
            context.invoke('editor.insertImage', window.__mp_terpilih, function($img) {
              $img.addClass('img-fluid');
            });
            window.__mp_terpilih = null;
          }
        });
      }
    });
    return button.render();
  }
  //  Register Button
  $.extend($.summernote.options.buttons, {
    akImagePicker: akImagePickerButton,
    akGuestImagePicker: akGuestImagePickerButton,
  });//  Setting options
  $.extend($.summernote.options, {
    imageAttributes: {
      icon: '<i class="mdi mdi-square-edit-outline"/>',
      removeEmpty: true,
      disableUpload: true,
    }
  });
  $.summernote.options.toolbar = [
    ['style', ['style']],
    ['font', ['bold', 'italic', 'underline', 'clear']],
    ['fontname', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['table', ['table']],
    ['insert', ['link', {!! Auth::check() && in_array(Auth::user()->role, ['admin','supermin', 'sistem_informasi', 'panitia', 'rumah_tangga']) ? "'akImagePicker'" : '' !!}]], // video
    ['view', ['fullscreen', 'codeview', 'help']],
  ];
  $.summernote.options.popover.image = [
    ['custom', ['imageAttributes']],
    ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
    // ['float', ['floatLeft', 'floatRight', 'floatNone']],
    ['image', ['imagePositionLeft', 'imagePositionCenter', 'imagePositionRight']],
    ['remove', ['removeMedia']]
  ];
  </script>
  @parent
@endsection