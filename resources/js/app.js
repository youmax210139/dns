import Popper from 'popper.js'
import moment from 'moment'
import '@fortawesome/fontawesome-free/css/all.css'

try {
  window.$ = window.jQuery = require('jquery')
  window.Popper = Popper;
  window.moment = moment;
  require('bootstrap');
} catch (e) {
  console.error(e);
}

import Vue from 'vue'
import VueMeta from 'vue-meta'
import { InertiaApp } from '@inertiajs/inertia-vue'
import PortalVue from 'portal-vue'
import clipboard from 'clipboard'
import Toasted from 'vue-toasted'
import Axios from 'axios'
import store from '@/Store'
import Layout from '@/Layout/Master/Layout'

Vue.config.productionTip = false
Vue.prototype.clipboard = clipboard
Vue.use(Toasted, {
  position: 'top-center',
  theme: 'toasted-primary',
  duration: 3000
})
Axios.defaults.withCredentials = true;
Axios.interceptors.response.use(function (response) {
  return response;
}, function (error) {
  return Promise.reject(error.response.data.errors);
});
Vue.prototype.$http = Axios
Vue.mixin({ methods: { route: window.route } })
Vue.use(InertiaApp)
Vue.use(PortalVue)
Vue.use(VueMeta)

let app = document.getElementById('app')
let page = JSON.parse(app.dataset.page)
console.log(page.props)

Vue.mixin({
  methods: {
    copy() {
      Vue.prototype.$toasted.success("复制成功");
    },
  }
});

new Vue({
  metaInfo: {
    title: `${page.props['app']['name']} - ${page.props['title']}`
  },
  store,
  render: h => h(InertiaApp, {
    props: {
      initialPage: page,
      resolveComponent: name => {
        const componentOptions = require(`./Pages/${name}`).default;
        if (componentOptions.layout == undefined) {
          componentOptions.layout = (h, page) => h(Layout, [page]);
        }
        return componentOptions;
      },
    },
  }),
}).$mount(app)
