<template>
    <div class="box">

                    <div class="box-header with-border">

                        <router-link :to="{ path: '/products/create'}" class="btn btn-primary ladda-button">
                            <span class="ladda-label">
                                <i class="fa fa-plus"></i> Добавить товар
                            </span>
                        </router-link>

                        <input id="filter-search" type="search" class="form-control input-sm pull-right" placeholder="Поиск" v-model="filter.search">
                    </div>


                   <table class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Название</th>
                                    <th>Категории</th>
                                    <th>SKU</th>
                                    <th>Цена</th>
                                    <th>Количество на складе</th>
                                    <th>Статус</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd even" v-for="(item, index) in products.data">
                                    <td>{{ item.id }}</td>
                                    <td>{{ item.name }}</td>
                                    <td>
                                        <p v-for="category in item.categories" class="margin-padding-none">
                                            {{ category.name }}
                                        </p>
                                    </td>
                                    <td>{{ item.sku }}</td>
                                    <td>{{ item.price }}</td>
                                    <td>{{ item.stock }}</td>
                                    <td>
                                        <i class="fa fa-times-circle" aria-hidden="true" v-bind:class="{ 'fa-times-circle red': item.deleted_at, 'fa-check-circle green': !item.deleted_at }"></i>
                                    </td>
                                    <td>
                                        <router-link :to="{ path: '/products/edit/' + item.id}" class="btn btn-xs btn-default">
                                            <i class="fa fa-edit"></i> <!--Изменить-->
                                        </router-link>

                                        <a class="btn btn-xs btn-default" @click="deleteProduct(item, index)">
                                            <i class="fa fa-remove"></i> <!--Удалить-->
                                        </a>

                                        <a class="btn btn-xs btn-default clone-btn" @click="cloneShow(item.id)">
                                            <i class="fa fa-clone"></i> <!--Создать дубликат-->
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Название</th>
                                    <th>Категории</th>
                                    <th>SKU</th>
                                    <th>Цена</th>
                                    <th>Количество на складе</th>
                                    <th>Статус</th>
                                    <th>Действия</th>
                                </tr>
                            </tfoot>
                   </table>

        <div class="text-center">
            <paginate
                    v-if="products.last_page > 1"
                    v-model="products.current_page"
                    :page-count="products.last_page"
                    :click-handler="SetPage"
                    :prev-text="'<<'"
                    :next-text="'>>'"
                    :container-class="'pagination'"
                    :page-class="'page-item'"></paginate>
        </div>





        <div class="clone-product-modal modal fade" id="clone" role="dialog" style="display: none;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title">
                            <i class="fa fa-clone"></i> Клонирование товара
                        </h4>
                    </div>
                    <form v-on:submit="cloneProduct">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('clone_product.name')}">
                                    <label>Название <span class="red">*</span></label>
                                    <input type="text" class="form-control" v-model="clone_product.name"/>
                                    <span>Должно быть уникальным</span>
                                    <span v-if="IsError('clone_product.name')" class="help-block" v-for="e in IsError('clone_product.name')">
                                        {{ e }}
                                    </span>
                                </div>
                                <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('clone_product.sku')}">
                                    <label>SKU <span class="red">*</span></label>
                                    <input type="text" class="form-control" v-model="clone_product.sku"/>
                                    <span>Должно быть уникальным</span>
                                    <span v-if="IsError('clone_product.sku')" class="help-block" v-for="e in IsError('clone_product.sku')">
                                        {{ e }}
                                    </span>
                                </div>
                                <div class="form-group col-md-12"  v-bind:class="{'has-error' : IsError('clone_product.images')}">
                                    <label>Клонировать еще ?</label>

                                    <ul>
                                            <li>
                                                <label>
                                                    <input type="checkbox" v-model="clone_product.attributes"/>
                                                    Атрибуты
                                                </label>
                                            </li>
                                            <li>
                                                <label>
                                                    <input type="checkbox" v-model="clone_product.photo"/>
                                                    Фото товара
                                                </label>
                                            </li>
                                            <li>
                                                <label>
                                                    <input type="checkbox" v-model="clone_product.product_images"/>
                                                    Картинки
                                                </label>
                                            </li>
                                            <li>
                                                <label>
                                                    <input type="checkbox" v-model="clone_product.specific_price"/>
                                                    Конкретная цена
                                                </label>
                                            </li>
                                            <li>
                                                <label>
                                                    <input type="checkbox" v-model="clone_product.group"/>
                                                    Группа товаров
                                                </label>
                                            </li>
                                        </ul>
                                        <span v-if="IsError('clone_product.images')" class="help-block" v-for="e in IsError('clone_product.images')">
                                            {{ e }}
                                        </span>
                                </div>


                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
                            <button type="submit" class="btn btn-primary">Создать дубликат</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</template>


<script>
    import Paginate from 'vuejs-paginate';
    import { mapGetters } from 'vuex';
    import { mapActions } from 'vuex';

    export default {
        components:{
            Paginate
        },
        data () {
            return {
                products: [],
                filter:{
                    page:   (this.$route.query.page   ? this.$route.query.page : 1),
                    search: (this.$route.query.search ? this.$route.query.search : '')
                },
                clone_product:{
                    product_id: 0,
                    name: '',
                    sku: '',
                    attributes: true,
                    photo: false,
                    product_images: false,
                    specific_price: true,
                    group: true
                }
            }
        },
        created() {
            this.productsList();
        },
        watch: {
            filter: {
                handler: function (val, oldVal) {
                    this.productsList();
                },
                deep: true
            }
        },
        methods:{
            cloneShow(product_id){
                this.clone_product.product_id = product_id;
                $('#clone').modal('show');
            },
            cloneProduct(event){
                event.preventDefault();
                this.SetErrors(null);

                axios.post('/admin/clone-product', {clone_product : this.clone_product}).then((res)=>{
                    if(res.data)
                    {
                        this.productsList();
                        $('#clone').modal('hide');
                    }
                });
            },
            SetPage(page){
                this.filter.page = page;
            },
            deleteProduct(item, index){
                this.$swal({
                    title: 'Вы действительно хотите удалить' + ' "' + item.name + '"?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Да',
                    cancelButtonText: 'Нет'
                }).then((result) => {
                    if (result.value) {
                        axios.post('/admin/product-delete/' + item.id).then((res)=>{
                            if(res.data)
                            {
                                this.$helper.swalSuccess('Успешно удален');
                                this.$delete(this.products.data, index);
                            }
                        });
                    }
                });
            },
            productsList(){
                var params = {};
                if(this.filter.page > 1 && !this.filter.search)
                    params['page'] = this.filter.page;

                if(this.filter.search)
                    params['search'] = this.filter.search;

                axios.get('/admin/products-list', {params:  params}).then((res)=>{
                    this.products = res.data;
                    this.$router.push({query: params});
                });
            },
            ...mapActions(['SetErrors'])
        },
        computed:{
            ...mapGetters([
                'IsError'
            ])
        }

    }
</script>


<style scoped>
    #filter-search{
        max-width: 300px;
    }
</style>
