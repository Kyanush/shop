<template>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <router-link :to="{path: '/products'}">
                <i class="fa fa-angle-double-left"></i>
                Вернуться к списку всех <span>товаров</span>
            </router-link>

            <br><br>

            <form v-on:submit="productSave">

                <div class="box">

                    <div class="box-header with-border">
                        <h3 class="box-title">Добавить новый товар</h3>
                    </div>
                    <div class="box-body row">

                        <div class="tab-container col-md-12">
                            <div class="nav-tabs-custom" id="form_tabs">
                                <ul class="nav nav-tabs">
                                    <li v-bind:class="{'active' : tab_active == 'tab_general'}" @click="setTab('tab_general')">
                                        <a>Общий</a>
                                    </li>
                                    <li v-bind:class="{'active' : tab_active == 'tab_product_description_and_photo'}" @click="setTab('tab_product_description_and_photo')">
                                        <a>Описание и фото товара</a>
                                    </li>
                                    <li v-bind:class="{'active' : tab_active == 'tab_attributes'}" @click="setTab('tab_attributes')">
                                        <a>Атрибуты</a>
                                    </li>
                                    <li v-bind:class="{'active' : tab_active == 'tab_pictures'}" @click="setTab('tab_pictures')">
                                        <a>Картинки</a>
                                    </li>
                                    <li v-bind:class="{'active' : tab_active == 'tab_specificprice'}" @click="setTab('tab_specificprice')">
                                        <a>Конкретная цена</a>
                                    </li>
                                    <li v-bind:class="{'active' : tab_active == 'tab_product_groups'}" @click="setTab('tab_product_groups')">
                                        <a>Группа товаров</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-content col-md-12">
                            <div v-bind:class="{'active' : tab_active == 'tab_general'}" role="tabpanel" class="tab-pane" id="tab_general">

                                <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('product.name')}">
                                    <label>Название <span class="red">*</span></label>
                                    <input type="text" v-model="product.name" class="form-control">
                                    <span v-if="IsError('product.name')" class="help-block" v-for="e in IsError('product.name')">
                                         {{ e }}
                                    </span>
                                </div>

                                <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('categories')}">
                                    <label>Категории <span class="red">*</span></label>
                                    <Select2 v-model="categories"
                                             :settings="{ multiple: true }"
                                             :options="convertDataSelect2(categories_list)"/>
                                    <p class="help-block">Вы можете выбрать одну или несколько категорий, где будет отображаться продукт</p>
                                    <span v-if="IsError('categories')" class="help-block" v-for="e in IsError('categories')">
                                         {{ e }}
                                    </span>
                                </div>

                                <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('product.sku')}">
                                    <label>SKU</label>
                                    <input type="text" v-model="product.sku" class="form-control"/>
                                    <span v-if="IsError('product.sku')" class="help-block" v-for="e in IsError('product.sku')">
                                         {{ e }}
                                    </span>
                                </div>


                                <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('product.stock')}">
                                    <label for="stock">Количество на складе</label>
                                    <input id="stock" type="text" v-model="product.stock" class="form-control"/>
                                    <span v-if="IsError('product.stock')" class="help-block" v-for="e in IsError('product.stock')">
                                         {{ e }}
                                    </span>
                                </div>

                                <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('product.price')}">
                                    <label for="price">Цена <span class="red">*</span></label>
                                    <input id="price" type="number" v-model="product.price" class="form-control"/>
                                    <span v-if="IsError('product.price')" class="help-block" v-for="e in IsError('product.price')">
                                         {{ e }}
                                    </span>
                                </div>

                                <div class="form-group col-md-12">
                                    <label>Цена без НДС</label>
                                    <input type="text" readonly="readonly" class="form-control">
                                </div>

                                <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('product.tax_id')}">
                                    <label>Налог</label>
                                    <Select2 v-model="product.tax_id" :options="convertDataSelect2(taxes_list)"/>
                                    <span v-if="IsError('product.tax_id')" class="help-block" v-for="e in IsError('product.tax_id')">
                                         {{ e }}
                                    </span>
                                </div>

                                <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('product.active')}">
                                    <label>Статус</label>
                                    <select v-model="product.active" class="form-control">
                                        <option value="1">Активный</option>
                                        <option value="0">Неактивный</option>
                                    </select>
                                    <span v-if="IsError('product.active')" class="help-block" v-for="e in IsError('product.active')">
                                         {{ e }}
                                    </span>
                                </div>

                            </div>


                            <div v-bind:class="{'active' : tab_active == 'tab_product_description_and_photo'}" role="tabpanel" class="tab-pane" id="tab_product_description_and_photo">

                                <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('product_photo')}">
                                    <label>Фото товара <span class="red" v-if="!product.id">*</span></label>
                                    <p>
                                        <img v-bind:src="product_photo" id="photo-view"/>
                                    </p>
                                    <label class="btn btn-primary btn-file">
                                        <i class="fa fa-file-image-o" aria-hidden="true"></i>  Фото товара
                                        <input type="file" accept="image/*"  @change="setPhoto($event)"/>
                                    </label>

                                    <span v-if="IsError('product_photo')" class="help-block" v-for="e in IsError('product_photo')">
                                         {{ e }}
                                    </span>
                                </div>

                                <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('product.description')}">
                                    <label>Описание <span class="red">*</span></label>
                                    <textarea v-model="product.description" class="form-control" rows="10"></textarea>
                                    <span v-if="IsError('product.description')" class="help-block" v-for="e in IsError('product.description')">
                                         {{ e }}
                                    </span>
                                </div>
                            </div>


                            <div v-bind:class="{'active' : tab_active == 'tab_attributes'}" role="tabpanel" class="tab-pane" id="tab_attributes">

                                <div class="form-group col-md-12">
                                    <label>Наборы атрибутов <span class="red">*</span></label>
                                    <Select2 @change="selectAttributeSetId($event)"
                                             v-if="tab_active == 'tab_attributes'"
                                             v-model="product.attribute_set_id"
                                             :options="convertDataSelect2(attributes_sets_more_info)"/>
                                </div>


                                <div id="render-attributes" v-for="item in attributes_sets_more_info" v-if="item.id == product.attribute_set_id && attributes.length > 0">

                                    <div class="row">
                                        <div class="col-md-12 well" style="margin: 15px 0px !important;">
                                            <h3 style="margin: 0;" v-for="item in attributes_sets_more_info" v-if="product.attribute_set_id == item.id">
                                                {{ item.text }}
                                            </h3>
                                        </div>
                                    </div>

                                    <span v-for="(attribute, index) in item.attributes">

                                        <div class="form-group col-md-12" v-if="attribute.type == 'text'" v-bind:class="{'has-error' : IsError('attributes' + index + '.value')}">
                                            <label>{{ attribute.name }}</label>
                                            <input type="text" v-model="attributes[index].value" class="form-control">
                                            <p class="help-block">Текст</p>
                                            <span v-if="IsError('attributes' + index + '.value')" class="help-block" v-for="e in IsError('attributes' + index + '.value')">
                                                 {{ e }}
                                            </span>
                                        </div>

                                        <div class="form-group col-md-12" v-if="attribute.type == 'textarea'">
                                            <label>{{ attribute.name }}</label>
                                            <textarea v-model="attributes[index].value" class="form-control"></textarea>
                                            <p class="help-block">Текстовая область</p>
                                        </div>

                                        <div class="form-group col-md-12" v-if="attribute.type == 'date'">
                                            <label>{{ attribute.name }}</label>
                                            <input type="date" v-model="attributes[index].value" class="form-control"/>
                                            <p class="help-block">Дата</p>
                                        </div>

                                        <div class="form-group col-md-12" v-if="attribute.type == 'multiple_select'">
                                            <label>{{ attribute.name }}</label>
                                            <Select2 v-model="attributes[index].value" :settings="{ multiple: true }" :options="convertDataSelect2(attribute.values, 'value', 'value')"/>
                                            <p class="help-block">Множественный выбор</p>
                                        </div>

                                        <div class="form-group col-md-12" v-if="attribute.type == 'media'">
                                            <label>{{ attribute.name }}</label>
                                            <div class="row">
                                                <div class="col-sm-6" style="margin-bottom: 20px;">
                                                    <img id="attribute-view-img" style="width: 100%" v-bind:src="'/uploads/attributes/' + attributes[index].value"/>
                                                </div>
                                            </div>
                                            <input type="hidden" v-model="attributes[index].value"/>
                                            <label class="btn btn-primary btn-file">
                                                Загрузить
                                                <input type="file" class="form-control" @change="setAttributeImage($event, index)"/>
                                            </label>
                                            <p class="help-block">Картинка</p>
                                        </div>

                                        <div class="form-group col-md-12" v-if="attribute.type == 'dropdown'">
                                            <label>{{ attribute.name }}</label>
                                            <Select2 v-model="attributes[index].value" :options="convertDataSelect2(attribute.values, 'value', 'value')"/>
                                            <p class="help-block">Выбор</p>
                                        </div>
                                    </span>
                                </div>
                            </div>

                            <div v-bind:class="{'active' : tab_active == 'tab_pictures'}" role="tabpanel" class="tab-pane" id="tab_pictures">

                                <upload-images @return_images="setImages" :images="product_images" :error_variable="'product_images'"></upload-images>

                            </div>

                            <div v-bind:class="{'active' : tab_active == 'tab_specificprice'}" role="tabpanel" class="tab-pane" id="tab_specificprice">
                                <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('specific_price.discount_type')}">
                                    <label>Тип скидки</label>
                                    <select v-model="specific_price.discount_type" class="form-control">
                                        <option value="sum">Сумма</option>
                                        <option value="percent">Процент</option>
                                    </select>
                                    <span v-if="IsError('specific_price.discount_type')" class="help-block" v-for="e in IsError('specific_price.discount_type')">
                                         {{ e }}
                                    </span>
                                </div>
                                <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('specific_price.reduction')}">
                                    <label for="reduction">Снижение</label>
                                    <input type="number" v-model="specific_price.reduction" id="reduction" class="form-control">
                                    <span v-if="IsError('specific_price.reduction')" class="help-block" v-for="e in IsError('specific_price.reduction')">
                                         {{ e }}
                                    </span>
                                </div>
                                <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('specific_price.start_date')}">
                                    <label>Дата начала <span class="red" v-if="specific_price.reduction > 0">*</span></label>
                                    <div class="input-group date">
                                        <datetime class="form-control" v-model="specific_price.start_date" type="datetime" zone="Asia/Almaty" format="yyyy-MM-dd HH:mm:ss"></datetime>
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </div>
                                    </div>
                                    <span v-if="IsError('specific_price.start_date')" class="help-block" v-for="e in IsError('specific_price.start_date')">
                                         {{ e }}
                                    </span>
                                </div>
                                <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('specific_price.expiration_date')}">
                                    <label>Дата окончания срока <span class="red" v-if="specific_price.reduction > 0">*</span></label>
                                    <div class="input-group date">
                                        <datetime class="form-control" v-model="specific_price.expiration_date" type="datetime" zone="Asia/Almaty" format="yyyy-MM-dd HH:mm:ss"></datetime>
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </div>
                                    </div>
                                    <span v-if="IsError('specific_price.expiration_date')" class="help-block" v-for="e in IsError('specific_price.expiration_date')">
                                         {{ e }}
                                    </span>
                                </div>
                            </div>








                            <div v-bind:class="{'active' : tab_active == 'tab_product_groups'}" role="tabpanel" class="tab-pane" id="tab_product_groups">

                                <div class="col-md-12">
                                    <h2>Товары</h2>
                                    <div id="group-products">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Название</th>
                                                <th>SKU</th>
                                                <th>Цена</th>
                                                <th>Статус</th>
                                                <th>Действия</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="tr-current-product" v-for="(item, index) in productGroup.list">
                                                <td>{{ item.id }}</td>
                                                <td>{{ item.name }}</td>
                                                <td>{{ item.sku }}</td>
                                                <td>{{ item.price }}</td>
                                                <td>
                                                    <i class="fa fa-times-circle"
                                                       aria-hidden="true"
                                                       v-bind:class="{ 'fa-times-circle red': !item.active, 'fa-check-circle green': item.active }"></i>
                                                </td>
                                                <td>
                                                    <router-link :to="{ path: '/products/edit/' + item.id}" class="btn btn-xs btn-default" v-if="product.id != item.id" target="_blank">
                                                        <i class="fa fa-edit"></i> Изменить
                                                    </router-link>

                                                    <a class="btn btn-xs btn-default btn-remove-from-group" v-if="product.id != item.id" @click="productGroupDelete(index)">
                                                        <i class="fa fa-times"></i> Удалить из группы
                                                    </a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <hr/>

                                    <h3>Добавить товар в группу</h3>
                                    <div id="ungrouped_products">
                                        <Select2
                                                 @select="productGroupAdd($event)"
                                                 :settings="productGroup.settings"
                                                 :options="productGroup.options"
                                                 />
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div><!-- /.box-body -->
                    <div class="box-footer">

                        <div id="saveActions" class="form-group">

                            <input type="hidden" name="save_action" value="save_and_back">

                            <div class="btn-group">

                                <button type="submit" class="btn btn-success" @click="setMethodRedirect('save_and_back')">
                                    <span class="fa fa-save" role="presentation" aria-hidden="true"></span> &nbsp;
                                    <span data-value="save_and_back">Сохранить и назад</span>
                                </button>

                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aira-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">▼</span>
                                </button>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a @click="setMethodRedirect('save_and_continue')">
                                            <button type="submit" class="btn-transparent">Сохранить и продолжить</button>
                                        </a>
                                    </li>
                                    <li>
                                        <a @click="setMethodRedirect('save_and_new')">
                                            <button type="submit" class="btn-transparent">Сохранить и новый</button>
                                        </a>
                                    </li>
                                </ul>

                            </div>

                            <router-link :to="{path: '/products'}" class="btn btn-default">
                                <span class="fa fa-ban"></span> &nbsp;
                                Отменить
                            </router-link>

                        </div>
                    </div><!-- /.box-footer-->

                </div><!-- /.box -->
            </form>
        </div>


    </div>
</template>


<script>
    import Paginate from 'vuejs-paginate';

    //https://select2.org/configuration/options-api
    import Select2 from 'v-select2-component';

    //https://mariomka.github.io/vue-datetime/
    import { Datetime } from 'vue-datetime';
    import 'vue-datetime/dist/vue-datetime.css';

    import UploadImages from '../plugins/UploadImages';

    import { mapGetters } from 'vuex';
    import { mapActions } from 'vuex';

    import  moment  from 'moment';

    export default {
        components:{
            Paginate,
            Select2,
            UploadImages,
            datetime: Datetime
        },
        data () {
            return {
                product:{
                    id: this.$route.params.id ? this.$route.params.id : 0,
                    attribute_set_id: 0,
                    name: '',
                    description: '',
                    tax_id: 1,
                    price: 0,
                    sku: '',
                    stock: 0,
                    active: 1,
                },
                product_photo: '',
                attributes: [],
                product_images: [],
                specific_price:{
                    reduction: 0,
                    discount_type: 'percent',
                    start_date: '',
                    expiration_date: ''
                },
                categories: [],

                method_redirect: 'save_and_back',
                tab_active: 'tab_general',
                categories_list: [],
                taxes_list: [],
                attributes_sets_more_info: [],






                productGroup:{
                    list: [],
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
                                    results.push({
                                        id:     item.id,
                                        text:   item.name,
                                        name:   item.name,
                                        sku:    item.sku,
                                        price:  item.price,
                                        active: item.active,
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
        mounted() {

        },
        methods:{
            productGroupAdd({id, name, sku, price, active}){
                var add = true;
                this.productGroup.list.forEach(function (item, index){
                    if(id == item.id)
                    {
                        add = false;
                        return;
                    }
                });
                if(add)
                {
                    this.productGroup.list.push({
                        id: id,
                        name: name,
                        sku: sku,
                        price: price,
                        active: active
                    });
                }else{
                    this.$helper.swalError('Товар уже добавлен');
                }
                this.productGroup.options = [];
            },
            productGroupDelete(index){
                this.$delete(this.productGroup.list, index);
            },
            setMethodRedirect(value){
                this.method_redirect = value;
            },
            setAttributeImage(event, index){
                this.$helper.setImgSrc(event.target.files[0], '#attribute-view-img');
                this.$set(this.attributes[index], 'value' , event.target.files[0]);
            },
            setPhoto(){
                this.$helper.setImgSrc(event.target.files[0], '#photo-view');
                this.product_photo = event.target.files[0];
            },
            setImages(files){
                this.product_images = files;
            },
            setTab(tab){
                this.tab_active = tab;
            },
            selectAttributeSetId(id){
                this.attributes = [];
                var self = this;
                this.attributes_sets_more_info.forEach(function (item, index) {
                    if(item.id == id)
                    {
                        item.attributes.forEach(function (attribute, attribute_index) {
                            if(['text', 'textarea', 'date', 'media'].indexOf(attribute.type) != -1)
                            {
                                self.attributes.push({
                                    value: attribute.values[0].value,
                                    attribute_id: attribute.id
                                });
                            }else{
                                self.attributes.push({
                                    value: '',
                                    attribute_id: attribute.id
                                });
                            }
                        });
                    }
                });
            },
            convertDataSelect2(values, column_id, column_text){
                return this.$helper.convertDataSelect2(values, column_id, column_text);
            },
            productSave(event){
                event.preventDefault();
                this.SetErrors(null);

                var data = new FormData();
                $.each(this.product, function(column, value) {
                    data.append('product[' + column + ']', value);
                });


                $.each(this.specific_price, function(column, value) {
                    if(column == 'start_date' || column == 'expiration_date')
                        value = moment(value).format('YYYY-MM-DD HH:mm:ss');
                    data.append('specific_price[' + column + ']', value);
                });



                if(Array.isArray(this.categories)){
                    for(var i = 0; i < this.categories.length; i++)
                        data.append('categories[' + i + ']', this.categories[i]);
                }else
                    data.append('categories', this.categories);



                $.each(this.product_images, function(index, item) {
                    data.append('product_images[' + index + '][id]',        item.id);
                    data.append('product_images[' + index + '][is_delete]', item.is_delete);
                    data.append('product_images[' + index + '][value]',     item.value);
                });


                $.each(this.attributes, function(index, item) {
                    data.append('attributes[' + index + '][attribute_id]', item.attribute_id);

                    if(Array.isArray(item.value)){
                        for(var i = 0; i < item.value.length; i++)
                            data.append('attributes[' + index + '][value][' + i + ']', item.value[i]);
                    }else
                        data.append('attributes[' + index + '][value]', item.value);
                });

                $.each(this.productGroup.list, function(index, item) {
                    data.append('products_ids_group[' + index + ']', item.id);
                });

                data.append('product_photo', this.product_photo);


                axios.post('/admin/product-save', data).then((res)=>{
                    if(res.data)
                    {
                        this.$helper.swalSuccess(this.product.id ? 'Успешно изменено' : 'Успешно создано');

                        if(this.method_redirect == 'save_and_back'){
                            this.$router.push('/products');

                        }else if(this.method_redirect == 'save_and_continue'){
                            var product_id = res.data;
                            if(!this.product.id)
                                this.$router.push('/products/edit/' + product_id);

                            this.getProduct(product_id);
                        }else if(this.method_redirect == 'save_and_new'){
                            this.$router.push('/products/create');
                        }
                    }
                });
            },
            getProduct(product_id){

                axios.get('/admin/product-view/' + product_id).then((res)=>{
                    document.querySelector('input[type=file]').value = '';

                    var data = res.data;
                    this.selectAttributeSetId(data.attribute_set_id);
                    this.groupProducts(data.group_id);

                    this.product.id               = data.id;
                    this.product.attribute_set_id = data.attribute_set_id;

                    this.product.name             = data.name;
                    this.product.description      = data.description;
                    this.product.tax_id           = data.tax_id;
                    this.product.price            = parseInt(data.price);
                    this.product.sku              = data.sku;
                    this.product.stock            = data.stock;
                    this.product.active           = data.active;

                    this.categories = data.categories;
                    this.product_images = data.images;
                    this.product_photo = data.product_photo;



                    var self = this;
                    $.each(data.attribute_product_value, function(attribute_id, value) {
                        self.attributes.forEach(function (item, index) {
                            if(attribute_id == item.attribute_id)
                                self.$set(self.attributes[index], 'value' , value);
                        });
                    });

                    this.specific_price.reduction       = data.specific_price.reduction;
                    this.specific_price.discount_type   = data.specific_price.discount_type;
                    this.specific_price.start_date      = moment(data.specific_price.start_date).format("YYYY-MM-DDTHH:mm:ss.000Z");
                    this.specific_price.expiration_date = moment(data.specific_price.expiration_date).format("YYYY-MM-DDTHH:mm:ss.000Z");

                });
            },
            groupProducts(group_id){
                axios.get('/admin/group-products/' + group_id).then((res)=>{
                    this.productGroup.list = res.data;
                });
            },
            ...mapActions(['SetErrors'])
        },
        created(){
            axios.get('/admin/attribute-sets-more-info').then((res)=>{
                this.attributes_sets_more_info = res.data;
            });

            var params = {per_page: 100};
            axios.get('/admin/categories-list', {params:  params}).then((res)=>{
                this.categories_list = res.data.data;
            });

            axios.get('/admin/taxes-list').then((res)=>{
                this.taxes_list = res.data;
            });

            if(this.product.id > 0)
                this.getProduct(this.product.id);
        },
        computed:{
            ...mapGetters([
                'IsError'
            ])
        },
        watch: {
            '$route'() {
                this.getProduct(this.$route.params.id);
            }
        },
    }
</script>

<style>
    .nav-tabs li{
        cursor: pointer;
    }
    .vdatetime-input{
        width: 100%;
        border: 0;
    }
    .vdatetime{
        z-index: unset!important;
    }
    .select2{
        width: 100%!important;
    }
    #photo-view{
        width: 200px;
        margin-bottom: 5px;
        border: 1px solid #d9cece;
        padding: 2px;
    }

</style>