import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
    {
      path: '/vue/home',
        component: require('./views/HomePanel.vue')
    },
    {
      path: '/products',
        component: require('./components/ExampleComponent.vue')
    },
    {
      path: '/vue/contents',
        component: require('./components/ExampleComponent.vue')
    }
]

export default new VueRouter({
  mode: 'history',
  base: __dirname,
  routes: routes
})
