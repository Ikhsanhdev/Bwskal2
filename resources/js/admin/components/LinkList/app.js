let listApp = require('./ListApp.vue').default;

window.initListApp = function (selector, opt = {}) {
  return   new Vue({
    el: selector,
    data: {
      judul: document.querySelector(selector).dataset.judul,
      judulIcon: document.querySelector(selector).dataset.judulIcon,
      url: document.querySelector(selector).dataset.url,
      classTambahan: document.querySelector(selector).dataset.class,
      opt: opt,
    },
    components: {
      listApp,
    },
    methods: {
      getData() {
        return this.$refs.app.getData();
      },
    },
    template: `<list-app 
      :judul="judul" 
      :judulIcon="judulIcon" 
      :url="url" 
      :class="[classTambahan]"
      :opt="opt"
      ref="app"
      >
      ${opt && opt.slot && opt.slot.item ? '<template v-slot:itemtpl="s">' + opt.slot.item + '</template>' : ''}
      </list-app>`,
  });
};
