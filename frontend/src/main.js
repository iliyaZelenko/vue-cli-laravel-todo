import Vue from 'vue'
import App from '@/App.vue'
import router from '@/router'

import '@/styles/main.styl'
// Plugins
import './plugins/vue-plugin-axios'
import './plugins/bootstrap'

Vue.config.productionTip = false

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')
