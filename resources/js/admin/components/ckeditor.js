//  Custom Upload
class AKCKEditorUploadAdapter {
  constructor(loader, config) {
    this.loader = loader;
    this.config = Object.assign({
      url: `${window.baseurl}/ckeditor-upload`,
      max: 5000, // in kilobyte (5 MB)
    }, config);

    this.requestController = null;
  }

  upload() {
    //  Get the file
    return this.loader.file
      .then(file => {
        //  Validasi ukuran file
        if (file.size > this.config.max * 1024) {
          throw new Error(`Gambar maksimal berukuran ${this.config.max / 1000}MB.`);
        }

        this.requestController = new AbortController();

        let formData = new FormData();
        formData.append('image', file);

        return axios.post(this.config.url, formData, {
          signal: this.requestController.signal
        })
          .then(res => {
            return {
              default: res.data.url,
            };
          });
      });
  }

  abort() {
    if (this.requestController) {
      this.requestController.abort();
    }
  }
}

window.AKCKEditorPlugin = (editor) => {
  //  custom upload
  editor.plugins.get('FileRepository').createUploadAdapter = (loader) => new AKCKEditorUploadAdapter(loader, editor.config.get('imageUpload'));

  //  word count
  setTimeout(() => {
    const wordCountPlugin = editor.plugins.get('WordCount');
    let counter = document.createElement('div');
    counter.className = 'bg-light border border-top-0 px-3 py-1 text-right fz-md fw-600'
    counter.innerHTML = `Jumlah Kata: ${wordCountPlugin.words} &nbsp; Karakter: ${wordCountPlugin.characters}`;
    editor.ui.element.insertAdjacentElement('afterend', counter);
    wordCountPlugin.on('update', (evt, stats) => {
      counter.innerHTML = `Jumlah Kata: ${stats.words} &nbsp; Karakter: ${stats.characters}`;
    });
  }, 300);
};

window.AKCKEditorMake = (selector, opt = {}) => {
  let options = Object.assign({
    ui: {
      viewportOffset: {
        top: document.querySelector('.admin-header').offsetHeight,
      }
    },
    extraPlugins: [
      AKCKEditorPlugin,
    ],
  }, opt)

  return ClassicEditor
    .create(selector, options);
}
