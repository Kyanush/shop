<template>
    <div class="box">

                    <div class="box-header with-border">

                        <router-link :to="{ path: '/orders/create'}" class="btn btn-primary ladda-button">
                            <span class="ladda-label">
                                <i class="fa fa-plus"></i> Создать заказ
                            </span>
                        </router-link>


                        <input id="filter-search" type="search" class="form-control input-sm pull-right" placeholder="Поиск" v-model="filter.search">
                    </div>

        <div class="box-header with-border">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered ">
                        <tbody>
                        <tr class="odd even">
                            <td><b>Номер заказа №:</b></td>
                            <td>
                                <input type="text" class="form-control" v-model="filter.order_id"/>
                            </td>
                        </tr>
                        <tr class="odd even">
                            <td><b>Статус:</b></td>
                            <td>
                            </td>
                        </tr>
                        <!--
                        <tr class="odd even">
                            <td><b>ID карты доступа:</b></td>
                            <td>
                                <input type="text" class="form-control" v-model="filter.access_card_id"/>
                            </td>
                        </tr>
                        <tr class="odd even">
                            <td><b>Столовая:</b></td>
                            <td>
                                <Select2 v-model="filter.canteen_id" :options="convertDataSelect2(canteens, false, false, false, true)"/>
                            </td>
                        </tr>
                        <tr class="odd even">
                            <td><b>План питания:</b></td>
                            <td>
                                <Select2 v-model="filter.nutrition_plan_id" :options="convertDataSelect2(nutrition_plans, false, false, false, true)"/>
                            </td>
                        </tr>-->
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <!--
                    <table class="table table-bordered ">
                        <tbody>
                        <tr class="odd even">
                            <td><b>Дата:</b></td>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <date-picker :config="datetimepicker" v-model="filter.date_start"></date-picker>
                                    </div>
                                    <div class="col-md-6">
                                        <date-picker :config="datetimepicker" v-model="filter.date_end"></date-picker>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="odd even">
                            <td><b>Статус:</b></td>
                            <td>
                                <select class="form-control" v-model="filter.status">
                                    <option value="">Все</option>
                                    <option value="ОК">ОК (Проходит по плану питания и процент совпадения >= 60%)</option>
                                    <option value="NONE FACE">NONE FACE (Когда процент совпадения <60%, но вход по карте разрешен)</option>
                                    <option value="NO RESIDENT">NO RESIDENT (Не найден пользователь)</option>
                                    <option value="ANTIPASSBACK">ANTIPASSBACK (Вход запрещен когда по этой карте нельзя заходить в эту столовую в это время)</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="odd even">
                            <td><b>Камера:</b></td>
                            <td>
                                <Select2 v-model="filter.camera_id" :options="convertDataSelect2(cameras, false, false, false, true)"/>
                            </td>
                        </tr>
                        <tr class="odd even">
                            <td><b>Компания:</b></td>
                            <td>
                                <Select2 v-model="filter.company_id" :options="convertDataSelect2(companies, false, false, false, true)"/>
                            </td>
                        </tr>

                        </tbody>
                    </table>-->
                </div>
            </div>
        </div>

                   <table class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th>Номер заказа №</th>
                                    <th>Клиент</th>
                                    <th>Статус</th>
                                    <th>Оплачен</th>
                                    <th>Сумма</th>
                                    <th>Дата</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd even" v-for="(item, index) in orders.data">
                                    <td>{{ item.id }}</td>
                                    <td>
                                        <router-link :to="{ path: '/users/edit/' + item.user_id}">
                                            {{ item.user.name }}
                                        </router-link>
                                    </td>
                                    <td>
                                        <i v-bind:class="item.status.class"></i>
                                        {{ item.status.name }}
                                    </td>
                                    <td>
                                        <span v-if="item.paid == 1"><i class="fa fa-check-circle status-completed"></i>&nbsp;Да</span>
                                        <span v-else><i class="fa fa-check-circle status-canceled"></i>&nbsp;Нет</span>
                                    </td>
                                    <td>{{ item.total }}</td>
                                    <td>{{ item.created_at }}</td>
                                    <td>
                                        <router-link :to="{ path: '/orders/' + item.id}" class="btn btn-xs btn-default">
                                            <i class="fa fa-eye"></i> Посмотреть
                                        </router-link>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Номер заказа №</th>
                                    <th>Клиент</th>
                                    <th>Статус</th>
                                    <th>Сумма</th>
                                    <th>Дата</th>
                                    <th>Действия</th>
                                </tr>
                            </tfoot>
                   </table>

        <div class="text-center">
            <paginate
                    v-if="orders.last_page > 1"
                    v-model="orders.current_page"
                    :page-count="orders.last_page"
                    :click-handler="SetPage"
                    :prev-text="'<<'"
                    :next-text="'>>'"
                    :container-class="'pagination'"
                    :page-class="'page-item'"></paginate>
        </div>


    </div>
</template>


<script>
    import Paginate from 'vuejs-paginate';

    export default {
        components:{
            Paginate
        },
        data () {
            return {
                orders: [],
                filter:{
                    order_id:   (this.$route.query.order_id   ? this.$route.query.order_id : ''),
                    page:   (this.$route.query.page   ? this.$route.query.page : 1),
                    search: (this.$route.query.search ? this.$route.query.search : '')
                }
            }
        },
        watch: {
            filter: {
                handler: function (val, oldVal) {
                    this.ordersList();
                },
                deep: true
            }
        },
        created(){
            this.ordersList();
        },
        methods:{
            SetPage(page){
                this.filter.page = page;
            },
            ordersList(){
                var params = {};
                if(this.filter.page > 1 && !this.filter.search)
                    params['page'] = this.filter.page;

                if(this.filter.search)
                    params['search'] = this.filter.search;

                axios.get('/admin/orders-list', {params:  params}).then((res)=>{
                    this.orders = res.data;
                    this.$router.push({query: params});
                });
            }
        }

    }
</script>


<style scoped>
    #filter-search{
        max-width: 300px;
    }
</style>
