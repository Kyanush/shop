<template>
    <div>

        <header class="main-header">

            <!-- Logo -->
            <router-link :to="{ path: '/main'}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">SKUS</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">SKUS</span>
            </router-link>

            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <!--
                include('backpack::inc.menu')
                -->

                <div class="navbar-custom-menu pull-left">
                    <ul class="nav navbar-nav">
                        <!-- =================================================== -->
                        <!-- ========== Top menu items (ordered left) ========== -->
                        <!-- =================================================== -->

                        <!-- <li><a href="http://estarter-ecommerce-for-laravel"><i class="fa fa-home"></i> <span>Home</span></a></li> -->

                        <!-- ========== End of top menu left items ========== -->
                    </ul>
                </div>


                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- ========================================================= -->
                        <!-- ========== Top menu right items (ordered left) ========== -->
                        <!-- ========================================================= -->

                        <!-- <li><a href="http://estarter-ecommerce-for-laravel"><i class="fa fa-home"></i> <span>Home</span></a></li> -->

                        <li>
                            <a @click="logout" class="logout">
                                <i class="fa fa-btn fa-sign-out"></i> Выйти
                            </a>
                        </li>

                        <!-- ========== End of top menu right items ========== -->
                    </ul>
                </div>





            </nav>
        </header>

        <!-- =============================================== -->

        <!--include('backpack::inc.sidebar')-->


        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar" style="height: auto;">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="http://www.gravatar.com/avatar/1e22faa0f24a974c9188289c9e2a74e1.jpg?s=80&amp;d=mm&amp;r=g" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p>{{ UserName }}</p>
                        <p class="role-desc">{{ RoleDesc }}</p>
                        <small>
                            <small>
                                <router-link :to="{ path: '/my-account'}">
                                    <span>
                                        <i class="fa fa-user-circle-o"></i> Мой аккаунт
                                    </span>
                                </router-link>&nbsp;
                                <a @click="logout" class="logout">
                                    <i class="fa fa-sign-out"></i>
                                    <span>Выйти</span>
                                </a>
                            </small>
                        </small>
                    </div>
                </div>
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">

                    <!-- ================================================ -->
                    <!-- ==== Recommended place for admin menu items ==== -->
                    <!-- ================================================ -->
                    <li><a href="http://estarter-ecommerce-for-laravel/admin/dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>


                    <li v-bind:class="{'active' : menu_active('/categories/')}">
                        <router-link :to="{ path: '/categories'}">
                            <i class="fa fa-bars"></i>
                            <span>Категории</span>
                        </router-link>
                    </li>

                    <li v-bind:class="{'active' : menu_active('/products/')}">
                        <router-link :to="{ path: '/products'}">
                            <i class="fa fa-bars"></i>
                            <span>Товары</span>
                        </router-link>
                    </li>


                    <li><a href="http://estarter-ecommerce-for-laravel/admin/orders"><i class="fa fa-list-ul"></i> <span>Orders</span></a></li>

                    <li><a href="http://estarter-ecommerce-for-laravel/admin/clients"><i class="fa fa-users"></i> <span>Clients</span></a></li>

                    <li v-bind:class="{'active' : menu_active('/attributes/')}">
                        <router-link :to="{ path: '/attributes'}">
                            <i class="fa fa-bars"></i>
                            <span>Атрибуты</span>
                        </router-link>
                    </li>

                    <li v-bind:class="{'active' : menu_active('/attributes-sets/')}">
                        <router-link :to="{ path: '/attributes-sets'}">
                            <i class="fa fa-bars"></i>
                            <span>Наборы атрибутов</span>
                        </router-link>
                    </li>

                    <li><a href="http://estarter-ecommerce-for-laravel/admin/currencies"><i class="fa fa-usd"></i> <span>Currencies</span></a></li>

                    <li><a href="http://estarter-ecommerce-for-laravel/admin/carriers"><i class="fa fa-truck"></i> <span>Carriers</span></a></li>

                    <li><a href="http://estarter-ecommerce-for-laravel/admin/taxes"><i class="fa fa-balance-scale"></i> <span>Taxes</span></a></li>

                    <li><a href="http://estarter-ecommerce-for-laravel/admin/order-statuses"><i class="fa fa-list-ul"></i> <span>Order Statuses</span></a></li>

                    <li><a href="http://estarter-ecommerce-for-laravel/admin/cart-rules"><i class="fa fa-shopping-cart"></i> <span>Cart rules</span></a></li>

                    <li><a href="http://estarter-ecommerce-for-laravel/admin/specific-prices"><i class="fa fa-money"></i> <span>Specific prices</span></a></li>

                    <li><a href="http://estarter-ecommerce-for-laravel/admin/notification-templates"><i class="fa fa-list"></i> <span>Notification Templates</span></a></li>

                    <li class="treeview">
                        <a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Permissions</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="http://estarter-ecommerce-for-laravel/admin/users"><i class="fa fa-user"></i> <span>Users</span></a></li>
                            <li><a href="http://estarter-ecommerce-for-laravel/admin/role"><i class="fa fa-group"></i> <span>Roles</span></a></li>
                            <li><a href="http://estarter-ecommerce-for-laravel/admin/permission"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
                        </ul>
                    </li>




                    <!-- ======================================= -->

                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <breadcrumbs></breadcrumbs>

            <!-- Main content -->
            <section id="content">

                <router-view></router-view>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                Powered by <a target="_blank" href="http://backpackforlaravel.com?ref=panel_footer_link">Backpack for Laravel</a>
            </div>
            Handcrafted by <a target="_blank" href="http://updivision.com">updivision</a>.
        </footer>
    </div>
</template>


<script>
    import { mapGetters } from 'vuex';
    import { mapActions } from 'vuex';
    import  breadcrumbs   from './plugins/Breadcrumbs.vue';

    export default {
        components:{
            breadcrumbs
        },
        props: ['user'],
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            this.SetUser(this.user);
        },
        methods:{
            menu_active(url){
                var current_url = this.$router.currentRoute.path + '/';
                return current_url.indexOf(url) >= 0 ? true : false;
            },
            ...mapActions(['SetUser']),
            logout(){
                axios.post('/logout').then((res)=>{
                    window.location.href = "/";
                });
            }
        },
        computed:{
            ...mapGetters([
                'UserName', 'RoleDesc', 'RoleName'
            ])
        }

    }
</script>

<style>
    #content {
        height: auto;
        display: table;
        width: 100%;
    }
    .role-desc{
        font-size: 10px;
    }
    .logout{
        cursor: pointer;
    }
</style>
