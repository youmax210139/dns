import Popper from 'popper.js/dist/umd/popper.js';
try {
  window.$ = window.jQuery = require('jquery');
  window.Popper = Popper;
  require('bootstrap');
} catch (e) {
  log.error(e);
}

import Vue from 'vue'
import VueMeta from 'vue-meta'
import { InertiaApp } from '@inertiajs/inertia-vue'
import store from '@/Store'

Vue.config.productionTip = false
Vue.mixin({ methods: { route: window.route } })
Vue.use(InertiaApp)
Vue.use(VueMeta)

let app = document.getElementById('app')

new Vue({
  metaInfo: {
    titleTemplate: (title) => title ? `${title} - DNS` : 'DNS'
  },
  store,
  render: h => h(InertiaApp, {
    props: {
      initialPage: JSON.parse(app.dataset.page),
      resolveComponent: name => import(`@/Pages/${name}`).then(module => module.default),
    },
  }),
}).$mount(app)
