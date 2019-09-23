<template>
    <div class="modal" role="dialog" id="search-products">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Поиск товара</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input placeholder="Поиск..." type="text" class="form-control" v-model="search"/>
                    <br/>
                    <ul>
                        <li v-for="item in results">
                            <img :src="item.photo_path" width="50"/>
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

<script>
    export default {
        data () {
            return {
                search: '',
                results: []
            }
        },
        updated () {
        },
        methods:{
            searchProducts(search){
                axios.get('/admin/search-products?search=' + search).then((res)=>{
                    this.results = res.data;
                });
            },
            selected(product){
                this.$emit('productSelected', product);
            }
        },
        watch: {
            search: {
                handler: function (val, oldVal) {
                   this.searchProducts(val);
                },
                deep: true
            }
        }
    }
</script>

<style scoped>
    ul li{
        border-bottom: 1px solid #d6d2d2;
        padding: 5px 0;
    }
</style>