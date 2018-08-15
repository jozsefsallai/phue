import Vue from 'vue';
import router from './router';
import store from 'state/store';

import 'components/Root';

const vm = new Vue({
  store,
  router
});

vm.$mount('#root');
