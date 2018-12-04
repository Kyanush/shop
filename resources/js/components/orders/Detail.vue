<template>
    <div>





        <div class="row">
            <div class="col-md-12 well">
                <h2>Заказ #{{ order.id }} -
                    |
                    <router-link :to="{ path: '/users/edit/' + order.user_id}" v-if="order.user">
                        {{ order.user.name }} {{ order.user.surname }}
                    </router-link>
                    |
                    {{ datetimeFormat(order.created_at) }}

                </h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <span><i class="fa fa-ticket"></i> О заказе</span>
                        </h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped table-hover">
                            <tbody>
                            <tr>
                                <td>
                                    <b><p>Текущее состояние</p></b>
                                    <p>
                                        <select class="selectpicker form-control" v-model="order.status_id">
                                            <option v-for="os in order_statuses"
                                                    v-bind:value="os.id"
                                                    :data-icon="os.class">
                                                {{ os.name }}
                                            </option>
                                        </select>
                                    </p>
                                </td>
                                <td>
                                    <b><p>Оплачен</p></b>
                                    <div>
                                        <span v-if="order.paid == 1"><i class="fa fa-check-circle status-completed"></i>&nbsp;Да</span>
                                        <span v-else><i class="fa fa-check-circle status-canceled"></i>&nbsp;Нет</span>
                                    </div>
                                </td>
                                <td>
                                    <b><p>Дата заказа</p></b>
                                    <div class="input-group date standard-input">
                                        <date-picker :config="datetimepicker" v-model="order.created_at"></date-picker>
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </div>
                                    </div>
                                </td>
                                <td v-if="order.updated_at">
                                    <b><p>Дата изменение</p></b>
                                    <p>{{ datetimeFormat(order.updated_at) }}</p>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <hr>

                        <div class="box-body">
                            <table class="table table-striped table-hover">
                                <tbody>
                                <tr>
                                    <td>Комментарии</td>
                                    <td colspan="3">
                                        <textarea class="form-control" v-model="order.comment"></textarea>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <span><i class="fa fa-user"></i> Клиент</span>
                        </h3>
                    </div>

                    <div class="box-body">
                        <div class="col-md-12 well">
                            <table class="table table-condensed table-hover">
                                <tbody>
                                    <tr>
                                        <td>
                                            <i class="fa fa-user-circle-o"></i>
                                            Клиент:
                                        </td>
                                        <td>
                                            <Select2 v-model="order.user_id" :options="convertDataSelect2(users)"/>
                                        </td>
                                    </tr>
                                    <tr v-if="order.user">
                                        <td>
                                            <i class="fa fa-envelope"></i>
                                            E-mail:
                                        </td>
                                        <td>
                                            <a  v-bind:href="'mailto:' + order.user.email"  v-if="order.user">{{ order.user.email }}</a>
                                        </td>
                                    </tr>
                                    <tr v-if="order.user">
                                        <td>
                                            <i class="fa fa-phone"></i>
                                            Телефон
                                        </td>
                                        <td>
                                            <a v-bind:href="'tel:' + order.user.phone"  v-if="order.user">{{ order.user.phone }}</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <span><i class="fa fa-user"></i> Адреса доставки</span>
                        </h3>
                    </div>

                    <div class="box-body">
                        <div class="col-md-12 well">
                            <table class="table table-condensed table-hover">
                                <tbody>
                                    <tr>
                                        <td colspan="2">
                                            <select class="form-control" v-model="order.shipping_address_id" >
                                                <option v-bind:value="item.id" v-for="item in addresses">
                                                    {{ item.city }} {{ item.address }}
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr v-if=" order.shipping_address">
                                        <td>Адрес:</td>
                                        <td>{{ order.shipping_address.address }}</td>
                                    </tr>
                                    <tr v-if="order.shipping_address">
                                        <td>Город:</td>
                                        <td>{{ order.shipping_address.city }}</td>
                                    </tr>
                                    <tr v-if="order.shipping_address">
                                        <td>Комментарий:</td>
                                        <td>{{ order.shipping_address.comment }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div  class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <span><i class="fa fa-truck"></i> Курьер</span>
                        </h3>
                    </div>

                    <div class="box-body">
                        <table class="table table-condensed">
                            <thead>
                            <tr>
                                <th style="width: 150px;">Логотип</th>
                                <th>Курьер</th>
                                <th>Цена</th>
                                <th>Описание</th>
                                <td><b>Дата доставки</b></td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="vertical-align-middle">
                                    <router-link :to="{ path: '/carriers/edit/' + order.carrier_id}" v-if="order.carrier">
                                        <img v-bind:src="'/uploads/carriers/' + order.carrier.logo" class="photo"/>
                                    </router-link>
                                </td>
                                <td class="vertical-align-middle">
                                    <Select2 v-model="order.carrier_id" :options="convertDataSelect2(carriers)"/>
                                </td>
                                <td class="vertical-align-middle">{{ order.carrier ? order.carrier.price : '' }}</td>
                                <td class="vertical-align-middle">{{ order.carrier ? order.carrier.delivery_text : '' }}</td>
                                <td class="vertical-align-middle">
                                    <div class="input-group date">
                                        <date-picker :config="datetimepicker" v-model="order.delivery_date"></date-picker>
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <span><i class="fa fa-paypal"></i> Тип оплаты</span>
                        </h3>
                    </div>

                    <div class="box-body">
                        <table class="table table-condensed">
                            <thead>
                            <tr>
                                <th style="width: 150px;">Логотип</th>
                                <th>Оплачен</th>
                                <th>Тип оплаты</th>
                                <th>Дата оплаты</th>
                                <th>Результат оплаты</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="vertical-align-middle">
                                    <router-link :to="{ path: '/payments/edit/' + order.payment_id}" v-if="order.payment">
                                        <img v-bind:src="'/uploads/payments/' + order.payment.logo" class="photo"/>
                                    </router-link>
                                </td>
                                <td class="vertical-align-middle">
                                    <select class="selectpicker form-control paid" v-model="order.paid">
                                        <option value="1" data-icon="fa fa-check-circle status-completed">Да</option>
                                        <option value="0" data-icon="fa fa-check-circle status-canceled">Нет</option>
                                    </select>
                                </td>
                                <td class="vertical-align-middle">
                                    <Select2 class="standard-input" v-model="order.payment_id" :options="convertDataSelect2(payments)"/>
                                </td>
                                <td class="vertical-align-middle">
                                    <div class="input-group date standard-input">
                                        <date-picker :config="datetimepicker" v-model="order.payment_date"></date-picker>
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="vertical-align-middle">
                                    {{ order.payment_result }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <span><i class="fa fa-shopping-cart"></i> Товары</span>
                        </h3>

                        <a class="btn btn-primary ladda-button pull-right" @click="showProductAddForm">
                            <span class="ladda-label">
                                <i class="fa fa-plus"></i> Добавить товар
                            </span>
                        </a>

                    </div>

                    <div class="box-body">
                        <div class="col-md-12">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>Товар</th>
                                    <th>Цена</th>
                                    <th>Количество</th>
                                    <th class="text-right">Всего</th>
                                    <th class="text-right">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(product, index) in order.products">
                                    <td class="vertical-align-middle">
                                        <router-link :to="{ path: '/products/edit/' + product.pivot.product_id}">
                                            <img v-bind:src="'/uploads/products/' + product.pivot.product_id + '/' + product.photo" class="photo"/>
                                            {{ product.pivot.name }}
                                        </router-link>
                                        <p class="font-12"><b>SKU:</b> {{ product.pivot.sku }}</p>
                                    </td>
                                    <td class="vertical-align-middle">
                                        <input type="text" class="form-control pull-left product-price" v-model="product.pivot.price"/>
                                        &nbsp;&nbsp;
                                        <span class="pull-left">тг</span>
                                    </td>
                                    <td class="vertical-align-middle">
                                        <input min="1" type="number" class="form-control product-quantity" v-model="product.pivot.quantity"/>
                                    </td>
                                    <td class="vertical-align-middle text-right">{{ product.pivot.quantity * product.pivot.price }} тг</td>
                                    <td class="vertical-align-middle text-right">
                                        <a class="btn btn-xs btn-default" @click="productDelete(index)">
                                            <i class="fa fa-remove red"></i> Удалить
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6 col-md-offset-6">
                            <table class="table table-condensed">
                                <tbody><tr>
                                    <td class="text-right"><strong>Доставка:</strong></td>
                                    <td class="text-right" v-if="order.carrier">{{ order.carrier.price }} тг</td>
                                </tr>
                                <tr>
                                    <td class="text-right"><strong>ИТОГО:</strong></td>
                                    <td class="text-right"><strong>{{ order.total }} тг</strong></td>
                                </tr>
                                </tbody></table>
                        </div>

                    </div>
                </div>
            </div>
        </div>




        <div class="row" v-if="order.status_history">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <span><i class="fa fa-shopping-cart"></i> История статуса</span>
                        </h3>
                    </div>

                    <div class="box-body">
                        <div class="col-md-12">
                            <table class="table table-striped table-hover" id="status-table">
                                <thead>
                                <tr>
                                    <th>Статус</th>
                                    <th>Дата изменение</th>
                                    <th>Пользователь</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="h in order.status_history">
                                    <td>
                                        <i v-bind:class="h.status.class"></i>
                                        {{ h.status.name }}
                                    </td>
                                    <td>{{ h.created_at }}</td>
                                    <td>
                                        <router-link :to="{ path: '/users/edit/' + h.user_id}">
                                            {{ h.user.name }}
                                        </router-link>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal" tabindex="-1" role="dialog" id="show-product-add-form">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Выберите товар</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <Select2
                                @select="productAdd($event)"
                                :settings="products.settings"
                                :options="products.options"
                        />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>


<script>
    import datePicker from 'vue-bootstrap-datetimepicker';
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';

    //https://select2.org/configuration/options-api
    import Select2 from 'v-select2-component';

    export default {
        components:{
            datePicker, Select2
        },
        data () {
            return {
                datetimepicker: {
                    format: 'YYYY-MM-DD HH:mm:ss',
                    useCurrent: false,
                    showClear: true,
                    showClose: true,
                    locale: 'ru'
                },
                order: {
                    id: this.$route.params.id ? this.$route.params.id : 0,
                    created_at: '',
                    status_id: 1,
                    comment: '',
                    carrier_id: 2,
                    shipping_address_id: 0,
                    delivery_date: '',
                    paid: 0,
                    payment_id: 1,
                    payment_date: '',
                    user_id: 0,
                    products: [],
                },
                order_statuses: [],
                carriers: [],
                payments: [],
                users: [],

                products:{
                    options:  [],
                    settings: {
                        placeholder: "Поиск",
                        ajax: {
                            url: '/admin/products-list',
                            dataType: 'json',
                            data: function (params) {
                                var query = {
                                    search: params.term,
                                    perPage: 5
                                }
                                return query;
                            },
                            processResults: function (data) {
                                var results = [];
                                data.data.forEach(function (item, index){
                                    if(!item.deleted_at)
                                        results.push({
                                            id:    item.id,
                                            text:  item.name,
                                            sku:   item.sku,
                                            price: item.price,
                                            photo: item.photo,
                                        });
                                });
                                return {
                                    results: results
                                };
                            }
                        }
                    }
                }
            }
        },
        updated () {
            $('.selectpicker').selectpicker('refresh');
        },
        methods:{
            productDelete(index){

            },
            productAdd({id, text, sku, price, photo}){

                var self = this;
                var add  = true;

                this.order.products.forEach(function (item, index) {
                    if(item.pivot.product_id == id){
                        self.$set(self.order.products[index].pivot, 'quantity', self.order.products[index].pivot.quantity + 1);
                        add = false;
                        return;
                    }
                });

                if(add)
                    setTimeout(function () {
                        this.order.products.push({
                            photo: photo,
                            pivot:{
                                name:       text,
                                order_id:   this.order.id,
                                price:      price,
                                product_id: id,
                                quantity:   1,
                                sku:        sku
                            }
                        });
                    }.bind(this), 500);

                $('#show-product-add-form').modal('hide');
            },
            showProductAddForm(){
                $('#show-product-add-form').modal('show');
            },
            convertDataSelect2(values, column_text, column_id){
                return this.$helper.convertDataSelect2(values, column_text, column_id);
            },
            getOrder(){
                axios.get('/admin/order/' + this.order.id).then((res)=>{
                    this.order = res.data;
                });
            },
            //формат даты
            datetimeFormat(date){
                return this.$helper.datetimeFormat(date) ;
            },
        },
        created(){
            if(this.order.id > 0)
                this.getOrder();

            axios.get('/admin/order-statuses-list', {params:  {perPage: 1000}}).then((res)=>{
                this.order_statuses = res.data.data;
            });

            axios.get('/admin/carriers-list', {params:  {perPage: 1000}}).then((res)=>{
                this.carriers = res.data.data;
            });

            axios.get('/admin/payments-list', {params:  {perPage: 1000}}).then((res)=>{
                this.payments = res.data.data;
            });

            axios.get('/admin/order/users').then((res)=>{
                this.users = res.data;
            });



        },
        computed:{
            addresses(){
                var addresses = [];
                var self = this;
                this.users.forEach(function(item, index) {
                    if(self.order.user_id == item.id)
                    {
                        addresses = item.addresses;
                        return;
                    }
                });
                return addresses;
            }
        }

    }
</script>

<style>
    .red{
        color: red;
    }
    .photo{
        width: 70px;
        margin-bottom: 5px;
        border: 1px solid #d9cece;
        padding: 2px;
    }
    #status-table{
        overflow: scroll;
        max-height: 265px;
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
    #status-table tbody, #status-table thead{
        display: table;
        width: 100%;
    }
    .product-quantity{
        width: 70px;
    }
    .product-price{
        width: 100px;
    }
    .standard-input{
        width: 200px;
    }
    .paid{
        width: 85px!important;
    }
    #show-product-add-form .select2{
        width: 100%!important;
    }
</style>
