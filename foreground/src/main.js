import Vue from 'vue'
import App from './App.vue'
import router from './router'
import axios from 'axios'
import qs from 'qs'
import layer from 'vue-layer'
import 'vue-layer/lib/vue-layer.css';
 
Vue.prototype.$layer = layer(Vue);

Vue.prototype.axios = axios
Vue.prototype.qs = qs

Vue.config.productionTip = false

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')
