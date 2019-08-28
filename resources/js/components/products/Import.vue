<template>
    <div class="box">

        <div class="box-header with-border">
            <button type="button" class="btn btn-danger pull-right">
                <i class="fa fa-times" aria-hidden="true"></i>
                Очистить
            </button>

        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-sort" id="products-list">
                <thead>
                    <tr>
                        <th v-for="column in columns">
                            {{ column.title }}
                            <select class="form-control">
                                <option></option>
                                <option v-for="column2 in columns" :value="column2.column">
                                    {{ column2.title }}
                                </option>
                            </select>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td v-for="column in columns">132</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th v-for="column in columns">
                            {{ column.title }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <input type="file" id="input" @change="setValue($event)"/>

    </div>
</template>


<script>



    export default {
        components:{

        },
        data () {
            return {
                columns:[
                    { column: 'name',             title: 'Название' },
                    { column: 'description',      title: 'Описание' },
                    { column: 'description_mini', title: 'Краткое описание' },
                    { column: 'price',            title: 'Цена' },
                    { column: 'sku',              title: 'SKU' },
                    { column: 'stock',            title: 'Кол-во на складе' },
                    { column: 'seo_keywords',     title: 'SEO keywords' },
                    { column: 'seo_description',  title: 'SEO description' },
                    { column: 'active',           title: 'Статус(1-Активный, 0-Неактивный)' },
                    { column: 'youtube',          title: 'Youtube ссылка' },
                    { column: 'view_count',       title: 'Кол-во просмотров' },
                ]
            }
        },
        created() {
        },
        methods:{
            setValue(event){

                var oFile = event.target.files[0];



            }
        }
    }
</script>

<style scoped>
</style>
