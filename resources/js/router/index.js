import Vue    from 'vue';
import Router from 'vue-router';


import main   from  '../components/Main.vue';
import categories_list    from  '../components/categories/List.vue';
import categories_reorder from  '../components/categories/Reorder.vue';
import categories_save    from  '../components/categories/Save.vue';

import attributes_list    from  '../components/attributes/List.vue';
import attributes_save    from  '../components/attributes/Save.vue';

import attributes_sets_list    from  '../components/attributes-sets/List.vue';
import attributes_sets_save    from  '../components/attributes-sets/Save.vue';

import products_list    from  '../components/products/List.vue';
import products_save    from  '../components/products/Save.vue';

Vue.component('layout', require('../components/Layout.vue'));


Vue.use(Router);

export default new Router({
    mode: 'history',
    base: '/admin',
    routes: [

        {
            path: '/',
            name: 'Главная страница',
            component: main
        },







        //Категория
        {
            path: '/categories',
            name: 'Категории',
            component: categories_list,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/categories/create',
            name: 'Создать категорию',
            component: categories_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Категории', link: '/categories' },
                ]
            }
        },
        {
            path: '/categories/reorder',
            name: 'Переупорядочить категории',
            component: categories_reorder,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Категории', link: '/categories' },
                ]
            }
        },
        {
            path: '/categories/edit/:id',
            name: 'Редактировать категорию',
            component: categories_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Категории', link: '/categories' },
                ]
            }
        },







        //Атрибуты
        {
            path: '/attributes',
            name: 'Атрибуты',
            component: attributes_list,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/attributes/create',
            name: 'Создать атрибут',
            component: attributes_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Атрибуты', link: '/attributes' },
                ]
            }
        },
        {
            path: '/attributes/edit/:id',
            name: 'Редактировать атрибут',
            component: attributes_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Атрибуты', link: '/attributes' },
                ]
            }
        },







        //Attribute Sets
        {
            path: '/attributes-sets',
            name: 'Наборы атрибутов',
            component: attributes_sets_list,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/attributes-sets/create',
            name: 'Добавить набор атрибутов',
            component: attributes_sets_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Наборы атрибутов', link: '/attributes-sets' },
                ]
            }
        },
        {
            path: '/attributes-sets/edit/:id',
            name: 'Редактировать набор атрибутов',
            component: attributes_sets_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Наборы атрибутов', link: '/attributes-sets' },
                ]
            }

        },







        //Товары
        {
            path: '/products',
            name: 'Товары',
            component: products_list,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                ]
            }
        },
        {
            path: '/products/create',
            name: 'Добавить товар',
            component: products_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Товары', link: '/products' },
                ]
            }
        },
        {
            path: '/products/edit/:id',
            name: 'Редактировать товар',
            component: products_save,
            meta: {
                breadcrumb: [
                    { name: 'Главная страница', link: '/main' },
                    { name: 'Товары', link: '/products' },
                ]
            }
        },

    ]
});