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

let app = document.getElementById('app')
let page = JSON.parse(app.dataset.page)
console.log(page.props)

Vue.mixin({
  methods: {
    copy() {
      Vue.prototype.$toasted.success(this.__('copy_success'));
    },
    alert(message, route, method, success, error = (err) => { }) {
      if (confirm(message)) {
        this.$http({
          url: route,
          method: method
        })
          .then(res => {
            success(res)
          }).catch(err => {
            console.error(err)
            Vue.prototype.$toasted.error(this.__("error"))
            error(err)
          }
          );
      }
    },
    // Translate the given key.
    __(key, replace = {}) {
      var translation = this.$page.language[key]
        ? this.$page.language[key]
        : key

      Object.keys(replace).forEach(function (key) {
        translation = translation.replace(':' + key, replace[key])
      });
      return translation
    },
    // Translate the given key with basic pluralization. 
    __n(key, number, replace = {}) {
      var options = key.split('|');

      key = options[1];
      if (number == 1) {
        key = options[0];
      }
      return tt(key, replace);
    },
    urlTransform(url) {
      if (!/^https?:\/\//i.test(url)) {
        return "http://" + url;
      }
      return url;
    },
    getStatusClass(code) {
      if (code >= 200 && code < 300) {
        return { "text-success": true };
      } else if (code >= 300 && code < 400) {
        return { "text-info": true };
      } else if (code >= 400 && code < 500) {
        return { "text-danger": true };
      } else if (code >= 500 && code < 600) {
        return { "text-danger": true };
      } else {
        return {};
      }
    },
  }
});

new Vue({
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
