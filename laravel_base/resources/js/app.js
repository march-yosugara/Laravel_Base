/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//   el: '#app',
// });

(function () {
  const app_urls = _app_urls;
  const app_js_mes = _app_js_mes;

  $(window).on('load', () => {

    $('select[name="lang"]').val($('html').attr('lang'));

    $('select[name="lang"]').on('change', function () {
      localeChange();
    });
  });

  $('#btn_logout').on('click', function () {
    axios.post(app_urls.url_logout)
      .then(res => {
        alert(app_js_mes.mes_logged_out);
        window.location.href = app_urls.url_welcome;
      })
      .catch(err => {
        alert(err);
      });
  });

  function localeChange() {
    var locale = $('select[name="lang"]').val();
    if (locale === 'ja') {
      window.location.href = app_urls.url_ja;
    }
    else {
      window.location.href = app_urls.url_en;
    }
  }
})();
