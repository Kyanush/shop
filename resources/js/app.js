/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Роутеры
import router from './router'

//Функции
import Helper from './packages/Helper';
Vue.use(Helper);

//Vuex
import store from './store';

axios.interceptors.response.use(function (response) {
    //console.log(response);

    var res = response;

    if(res.data === '')
        Vue.helper.swalError('Пустой результат');
    else if(!res.data)
        Vue.helper.swalError('Ошибка!');

    return response;
}, function (error) {

    //console.log(error.response);


    var status =  error.response.status
    var res    = error.response;

    if(status == 404 || status == 403 || status == 401){
        Vue.helper.swalError(res.data, status);

    }else if(status == 422){
        store.dispatch('SetErrors', res.data.errors);
        Vue.helper.swalError(store.getters.ListErrors);

    }else if(status == 500){
        if(res.data.message.indexOf('foreign key') !== -1){
            Vue.helper.swalError("Вы не можете удалить, есть привязанные элементы!", 500);
        }else
            Vue.helper.swalError("Ошибка сервера! Сообщите об этой проблеме администратором сайта", 500);

    }else if(status == 200){
        if(res.data === '')
            Vue.helper.swalError('Пустой результат');
        else if(!res.data)
            Vue.helper.swalError('Ошибка!');
    }

    return error;
});

//Попап
import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);

//mask input
const VueInputMask = require('vue-inputmask').default
Vue.use(VueInputMask);

router.beforeEach((to, from, next) => {
    if (to.name)
        document.title = to.name;
    store.dispatch('SetErrors', null);
    return next();
});

const app = new Vue({
    el: '#app',
    router,
    store
});