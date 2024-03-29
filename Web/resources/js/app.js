/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
// Vue.config.devtools = false;
// Vue.config.productionTip = false;
// Vue.config.debug = false;
// Vue.config.silent = true;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

if (document.querySelector("meta[name='user-id']"))
    Vue.prototype.$userId = document.querySelector("meta[name='user-id']").getAttribute('content');


if (document.querySelector("meta[name='section-id']"))
    Vue.prototype.$sectionId = document.querySelector("meta[name='section-id']").getAttribute('content');

Vue.component('Words', require('./components/Words.vue').default);
Vue.component('Suggestion', require('./components/AddSuggestion.vue').default);
Vue.component('Sect', require('./components/Section.vue').default);
Vue.component('Adding', require('./components/CreatingSection.vue').default);
Vue.component('Editing', require('./components/EditingSection.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
