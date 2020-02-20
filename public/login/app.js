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

// noinspection JSUnresolvedFunction
Vue.component('escritorio', require('./components/Escritorio').default);
Vue.component('almacen-categorias',require("./components/Almacen/Categorias").default);
Vue.component('almacen-articulos',require("./components/Almacen/Articulos").default);
Vue.component('compras-ingresos',require("./components/Compras/Ingresos").default);
Vue.component('compras-proveedores',require("./components/Compras/Proveedores").default);
Vue.component('ventas-clientes',require("./components/Ventas/Clientes").default);
Vue.component('ventas-ventas',require("./components/Ventas/Ventas").default);
Vue.component('accesso-usuarios',require("./components/Accesso/Usuarios").default);
Vue.component('accesso-roles',require("./components/Accesso/Roles").default);
Vue.component('reportes-ingreso',require("./components/Reportes/RIngresos").default);
Vue.component('reportes-ventas',require("./components/Reportes/RVentas").default);
Vue.component('ayuda',require("./components/Ayuda").default);
Vue.component('acerca-de',require("./components/Acerca-de").default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data:{
        menu:0,
        menus:1,
    }

});

