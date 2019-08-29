<template>
    <div class="box">

        <div class="box-header with-border">
            <button class="btn btn-primary btn-file">
                <i class="fa fa-download" aria-hidden="true"></i> Загрузить Excel
                <input id="readExcel" type="file" accept=".xlsx, .xls, .csv" @change="readExcel($event)">
            </button>
            <button class="btn btn-primary" :disabled="!data.length" @click="send">
                <i class="fa fa-paper-plane" aria-hidden="true"></i>
                Отправить
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th width="130" v-for="number in data_max_length">
                            <select class="form-control">
                                <option></option>
                                <option v-for="column in columns" :value="column.column">
                                    {{ column.title }}
                                </option>
                            </select>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in data">
                        <td>
                            <input type="checkbox" v-model="selected[ index ]"/>
                        </td>
                        <td width="130" v-for="number in data_max_length">
                            {{ item[ number - 1 ] }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>

<script>
    export default {
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
                ],
                data: [],
                data_max_length: 0,
                selected: []
            }
        },
        created() {
        },
        methods:{
            send(){

            },
            readExcel(event){

                var oFile = event.target.files[0];

                document.getElementById("readExcel").value = "";

                var sFilename = oFile.name;

                var reader = new FileReader();
                var result = {};
                var self = this;

                reader.onload = function (e) {
                    var data = e.target.result;
                    data = new Uint8Array(data);
                    var workbook = XLSX.read(data, {type: 'array'});
                    console.log(workbook);
                    var result = {};
                    workbook.SheetNames.forEach(function (sheetName) {
                        var roa = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], {header: 1});
                        if (roa.length) result[sheetName] = roa;
                    });
                    // see the result, caution: it works after reader event is done.

                    self.data = result[ workbook.SheetNames ];
                    self.data.forEach(function (item, index) {
                        self.selected[index] = true;
                        if(item.length > self.data_max_length)
                            self.data_max_length = item.length;
                    });

                    for (var number = 0; number < self.data_max_length; number++)
                    {
                        self.data.forEach(function (item, index) {
                            if(!self.data[ index ][ number ])
                                 self.data[ index ][ number ] = '';
                        });
                    }

                    console.log(self.data);

                };
                reader.readAsArrayBuffer(oFile);

            }
        }
    }
</script>

<style scoped>
    table {
        max-height: 500px;
        overflow: auto;
        display:inline-block;
    }
</style>
