import Vue from 'vue';
import VueRouter from 'vue-router';

import IndexPage from 'components/IndexPage';
import AboutPage from 'components/AboutPage';
import NotFound from 'components/NotFoundPage';

Vue.use(VueRouter);

export default new VueRouter({
  mode: 'history',
  routes: [
    { path: '/', component: IndexPage },
    { path: '/about', component: AboutPage },
    { path: '*', component: NotFound }
  ]
});
