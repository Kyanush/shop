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
                                        <i class="fa fa-times-circle" aria-hidden="true" v-bind:class="{ 'fa-times-circle red': !item.active, 'fa-check-circle green': item.active }"></i>
                                    </td>
                                    <td>
                                        <router-link :to="{ path: '/products/edit/' + item.id}" class="btn btn-xs btn-default">
                                            <i class="fa fa-edit"></i> Изменить
                                        </router-link>

                                        <a class="btn btn-xs btn-default" @click="deleteProduct(item, index)">
                                            <i class="fa fa-remove"></i> Удалить
                                        </a>

                                        <a class="btn btn-xs btn-default clone-btn">
                                            <i class="fa fa-clone"></i> Создать дубликат
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

        {{ productsList }}

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
                products: [],
                filter:{
                    page:   (this.$route.query.page   ? this.$route.query.page : 1),
                    search: (this.$route.query.search ? this.$route.query.search : '')
                }
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
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

        },
        computed:{
            productsList(){
                var params = {};
                if(this.filter.page > 1 && !this.filter.search)
                    params['page'] = this.filter.page;

                if(this.filter.search)
                    params['search'] = this.filter.search;

                axios.get('/admin/products-list', {params:  params}).then((res)=>{
                    this.products = res.data;
                    console.log(this.products);
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
