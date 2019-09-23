<template>
    <div class="modal" role="dialog" id="show-product-add-form">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Выберите товар</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input placeholder="Поиск..." type="text" class="form-control" v-model="q"/>
                    <br/>
                    <ul>
                        <li v-for="item in results">
                            <img :src="'https://onepoint.kz/uploads/products/300/7ac06a52180dc211596bc3b056d09801.jpeg'" width="50"/>
                            {{ item.product.id }}, {{ item.product.name }}
                            <a class="pull-right" @click="selected(item.product)">Выбрать</a>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    ul li{
        border-bottom: 1px solid #d6d2d2;
        padding: 5px 0;
    }
</style>

<script>
    export default {
        data () {
            return {
                q: '',
                results: []
            }
        },
        updated () {
        },
        methods:{
            searchProducts(q){
                axios.get('/admin/search-products?search=' + q).then((res)=>{
                    this.results = res.data;
                });
            },
            selected(item){
                console.log(item);
            }
        },
        watch: {
            q: {
                handler: function (val, oldVal) {
                   this.searchProducts(val);
                },
                deep: true
            }
        }
    }
</script>

