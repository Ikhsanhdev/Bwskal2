let appId = '#menuApp-AKsc';
let initMenuBuilder = function () {
  let MenuApp = require('./MenuApp.vue').default;
  let menuApp = new Vue({
    el: appId,
    components: {
      MenuApp,
    },
  });
};

$(document).ready(function () {
  //  Init jika ada app nya
  if ($(appId).length > 0) {
    initMenuBuilder();
  }
});