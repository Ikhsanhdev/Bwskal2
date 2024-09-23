//  Setup vue dan kawan kawan
const Teleport = require('vue2-teleport');
window.Vue = require('vue').default;

Vue.component('Teleport', Teleport.default);
Vue.component('ak-text', require('./components/AkText.vue').default);
Vue.component('ak-switch', require('./components/AkSwitch.vue').default);
Vue.component('ak-checkbox', require('./components/AkCheckbox.vue').default);
Vue.component('ak-file', require('./components/AkFile.vue').default);
