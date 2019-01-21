<template>
    <div class="row">
        <div class="col-md-12">

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
                                        <a>Скидки</a>
                                    </li>
                                    <li v-bind:class="{'active' : tab_active == 'tab_product_groups'}" @click="setTab('tab_product_groups')">
                                        <a>Группа товаров</a>
                                    </li>
                                    <li v-bind:class="{'active' : tab_active == 'tab_with_this_product_buy'}" @click="setTab('tab_with_this_product_buy')">
                                        <a>С этим товаром покупают</a>
                                    </li>
                                    <li v-bind:class="{'active' : tab_active == 'tab_seo'}" @click="setTab('tab_seo')">
                                        <a>SEO</a>
                                    </li>
                                    <li v-bind:class="{'active' : tab_active == 'tab_reviews'}" @click="setTab('tab_reviews')" v-if="product.id > 0">
                                        <a>Отзывы</a>
                                    </li>
                                    <li v-bind:class="{'active' : tab_active == 'tab_questions_answers'}" @click="setTab('tab_questions_answers')" v-if="product.id > 0">
                                        <a>Вопросы-ответы</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-content col-md-12">
                            <div v-bind:class="{'active' : tab_active == 'tab_general'}" role="tabpanel" class="tab-pane" id="tab_general">

                                <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('product.name')}">
                                    <label>Название <span class="red">*</span></label>
                                    <input type="text" v-model="product.name" class="form-control">
                                    <span v-if="IsError('product.name')" class="help-block" v-for="e in IsError('product.name')">
                                         {{ e }}
                                    </span>
                                </div>

                                <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('product.url')}">
                                    <label>Ссылка</label>
                                    <input type="text" v-model="product.url" class="form-control">
                                    <span v-if="IsError('product.url')" class="help-block" v-for="e in IsError('product.url')">
                                         {{ e }}
                                    </span>
                                    <p class="help-block pull-right">
                                        Если пустая ссылка, генерируются автоматически
                                    </p>
                                </div>


                                <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('categories')}">
                                    <label>Категории <span class="red">*</span></label>
                                    <Select2 v-model="categories"
                                             :settings="{ multiple: true }"
                                             :options="convertDataSelect2(categories_list)"/>
                                    <p class="help-block pull-right">
                                        Вы можете выбрать одну или несколько категорий, где будет отображаться товар
                                    </p>
                                    <span v-if="IsError('categories')" class="help-block" v-for="e in IsError('categories')">
                                         {{ e }}
                                    </span>

                                </div>

                                <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('product.sku')}">
                                    <label>SKU</label>
                                    <input type="text" v-model="product.sku" class="form-control"/>
                                    <span v-if="IsError('product.sku')" class="help-block" v-for="e in IsError('product.sku')">
                                         {{ e }}
                                    </span>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group col-md-4" v-bind:class="{'has-error' : IsError('product.stock')}">
                                            <label for="stock">Количество на складе</label>
                                            <input id="stock" type="text" v-model="product.stock" class="form-control"/>
                                            <span v-if="IsError('product.stock')" class="help-block" v-for="e in IsError('product.stock')">
                                                 {{ e }}
                                            </span>
                                        </div>


                                        <div class="form-group col-md-4" v-bind:class="{'has-error' : IsError('product.price')}">
                                            <label for="price">Цена <span class="red">*</span></label>
                                            <input id="price" type="number" v-model="product.price" class="form-control"/>
                                            <span v-if="IsError('product.price')" class="help-block" v-for="e in IsError('product.price')">
                                                 {{ e }}
                                            </span>
                                        </div>

                                        <div class="form-group col-md-4" v-bind:class="{'has-error' : IsError('product.active')}">
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
                                </div>
                            </div>

                            <div v-bind:class="{'active' : tab_active == 'tab_product_description_and_photo'}" role="tabpanel" class="tab-pane" id="tab_product_description_and_photo">
                                <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('product.photo')}">
                                    <label>Фото товара <span class="red" v-if="!product.id">*</span></label>
                                    <p>
                                        <img v-bind:src="product.pathPhoto ? product.pathPhoto : ''" class="img" id="photo-img" width="100"/>
                                    </p>
                                    <label class="btn btn-primary btn-file">
                                        <i class="fa fa-file-image-o" aria-hidden="true"></i>  Фото товара
                                        <input type="file" accept="image/*"  @change="setProductPhoto($event)"/>
                                    </label>
                                    <span v-if="IsError('product.photo')" class="help-block" v-for="e in IsError('product.photo')">
                                         {{ e }}
                                    </span>
                                </div>
                                <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('product.description')}">
                                    <label>Описание <span class="red">*</span></label>

                                    <VueCkeditor v-model="product.description" :config="ckeditor_config"></VueCkeditor>

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

                                        <div class="form-group col-md-12" v-if="attribute.type == 'text'" v-bind:class="{'has-error' : IsError('attributes.' + index + '.value')}">
                                            <label>{{ attribute.name }}</label>
                                            <input type="text" v-model="attributes[index].value" class="form-control">
                                            <p class="help-block">Текст</p>
                                            <span v-if="IsError('attributes.' + index + '.value')" class="help-block" v-for="e in IsError('attributes.' + index + '.value')">
                                                 {{ e }}
                                            </span>
                                        </div>

                                        <div class="form-group col-md-12" v-if="attribute.type == 'textarea'" v-bind:class="{'has-error' : IsError('attributes.' + index + '.value')}">
                                            <label>{{ attribute.name }} <span class="red" v-if="attribute.required == 1">*</span></label>
                                            <textarea v-model="attributes[index].value" class="form-control"></textarea>
                                            <p class="help-block">Текстовая область</p>
                                            <span v-if="IsError('attributes.' + index + '.value')" class="help-block" v-for="e in IsError('attributes.' + index + '.value')">
                                                 {{ e }}
                                            </span>
                                        </div>

                                        <div class="form-group col-md-12" v-if="attribute.type == 'date'" v-bind:class="{'has-error' : IsError('attributes.' + index + '.value')}">
                                            <label>{{ attribute.name }} <span class="red" v-if="attribute.required == 1">*</span></label>
                                            <input type="date" v-model="attributes[index].value" class="form-control"/>
                                            <p class="help-block">Дата</p>
                                            <span v-if="IsError('attributes.' + index + '.value')" class="help-block" v-for="e in IsError('attributes.' + index + '.value')">
                                                 {{ e }}
                                            </span>
                                        </div>

                                        <div class="form-group col-md-12" v-if="attribute.type == 'multiple_select'" v-bind:class="{'has-error' : IsError('attributes.' + index + '.value')}">
                                            <label>{{ attribute.name }} <span class="red" v-if="attribute.required == 1">*</span></label>
                                            <Select2 v-model="attributes[index].value" :settings="{ multiple: true }" :options="convertDataSelect2(attribute.values, 'value', 'value')"/>
                                            <p class="help-block">Множественный выбор</p>
                                            <span v-if="IsError('attributes.' + index + '.value')" class="help-block" v-for="e in IsError('attributes.' + index + '.value')">
                                                 {{ e }}
                                            </span>
                                        </div>

                                        <div class="form-group col-md-12" v-if="attribute.type == 'media'" v-bind:class="{'has-error' : IsError('attributes.' + index + '.value')}">
                                            <label>{{ attribute.name }} <span class="red" v-if="attribute.required == 1">*</span></label>
                                            <div class="row">
                                                <div class="col-sm-6" style="margin-bottom: 20px;">
                                                    <img width="100" id="attribute-img" class="img" v-bind:src="attributes[index].value ? '/uploads/attributes/' + attributes[index].value : ''"/>
                                                </div>
                                            </div>
                                            <input type="hidden" v-model="attributes[index].value"/>

                                            <div class="btn-group">
                                                <label class="btn btn-primary btn-file">
                                                    Загрузить
                                                    <input  type="file" accept="image/*" id="uploadImage" class="hide" @change="setAttributeImage($event, index)"/>
                                                </label>
                                                <button class="btn btn-danger" id="remove" type="button" @click="clearAttributeImage(index)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>

                                            <p class="help-block">Картинка</p>
                                            <span v-if="IsError('attributes.' + index + '.value')" class="help-block" v-for="e in IsError('attributes.' + index + '.value')">
                                                 {{ e }}
                                            </span>
                                        </div>

                                        <div class="form-group col-md-12" v-if="attribute.type == 'dropdown'" v-bind:class="{'has-error' : IsError('attributes.' + index + '.value')}">
                                            <label>{{ attribute.name }} <span class="red" v-if="attribute.required == 1">*</span></label>
                                            <Select2 v-model="attributes[index].value" :options="convertDataSelect2(attribute.values, 'value', 'value')"/>
                                            <p class="help-block">Выбор</p>
                                            <span v-if="IsError('attributes.' + index + '.value')" class="help-block" v-for="e in IsError('attributes.' + index + '.value')">
                                                 {{ e }}
                                            </span>
                                        </div>
                                    </span>
                                </div>
                            </div>

                            <div v-bind:class="{'active' : tab_active == 'tab_pictures'}" role="tabpanel" class="tab-pane" id="tab_pictures">

                                <upload-images @return_images="setImages" :images="product_images" :error_variable="'product_images'"></upload-images>

                            </div>

                            <div v-bind:class="{'active' : tab_active == 'tab_specificprice'}" role="tabpanel" class="tab-pane" id="tab_specificprice">
                                <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('specific_price.discount_type')}">
                                    <label>Тип скидки</label>
                                    <select v-model="specific_price.discount_type" class="form-control">
                                        <option value="sum">Сумма</option>
                                        <option value="percent">Процент</option>
                                    </select>
                                    <span v-if="IsError('specific_price.discount_type')" class="help-block" v-for="e in IsError('specific_price.discount_type')">
                                         {{ e }}
                                    </span>
                                </div>
                                <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('specific_price.reduction')}">
                                    <label for="reduction">Снижение</label>
                                    <input type="number" v-model="specific_price.reduction" id="reduction" class="form-control">
                                    <span v-if="IsError('specific_price.reduction')" class="help-block" v-for="e in IsError('specific_price.reduction')">
                                         {{ e }}
                                    </span>
                                </div>
                                <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('specific_price.start_date')}">
                                    <label>Дата начала</label>
                                    <div class="input-group date">
                                        <date-picker :config="datetimepicker" v-model="specific_price.start_date"></date-picker>
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </div>
                                    </div>
                                    <span v-if="IsError('specific_price.start_date')" class="help-block" v-for="e in IsError('specific_price.start_date')">
                                         {{ e }}
                                    </span>
                                </div>
                                <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('specific_price.expiration_date')}">
                                    <label>Дата окончания срока</label>
                                    <div class="input-group date">
                                        <date-picker :config="datetimepicker" v-model="specific_price.expiration_date"></date-picker>
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
                                            <tr class="tr-current-product" v-for="(item, index) in group_products">
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
                                                 :settings="productSearchSelect2.settings"
                                                 :options="productSearchSelect2.options"
                                                 />
                                    </div>
                                </div>
                            </div>

                            <div v-bind:class="{'active' : tab_active == 'tab_with_this_product_buy'}" role="tabpanel" class="tab-pane" id="tab_with_this_product_buy">
                                <div class="col-md-12">

                                    <div id="group-with_this_product_buy">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Товар ID</th>
                                                    <th>Название</th>
                                                    <th>Статус</th>
                                                    <th>Действия</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="tr-current-product" v-for="(item, index) in product_accessories">
                                                    <td>{{ item.id }}</td>
                                                    <td>{{ item.name }}</td>
                                                    <td>
                                                        <i class="fa fa-times-circle"
                                                           aria-hidden="true"
                                                           v-bind:class="{ 'fa-times-circle red'   : !item.active,
                                                                           'fa-check-circle green' : item.active }"></i>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-xs btn-default btn-remove-from-group" @click="deleteProductAccessory(index)">
                                                            <i class="fa fa-times"></i> Удалить
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <hr/>

                                    <h3>Добавить товар</h3>
                                    <div>
                                        <Select2
                                                @select="addProductAccessory($event)"
                                                :settings="productSearchSelect2.settings"
                                                :options="productSearchSelect2.options"
                                        />
                                    </div>

                                </div>
                            </div>

                            <div v-bind:class="{'active' : tab_active == 'tab_seo'}" role="tabpanel" class="tab-pane" id="tab_seo">

                                <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('product.seo_keywords')}">
                                    <label>Keywords</label>
                                    <textarea v-model="product.seo_keywords" class="form-control"></textarea>
                                    <span v-if="IsError('product.seo_keywords')" class="help-block" v-for="e in IsError('product.seo_keywords')">
                                         {{ e }}
                                    </span>
                                </div>

                                <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('product.seo_description')}">
                                    <label>Description</label>
                                    <textarea v-model="product.seo_description" class="form-control"></textarea>
                                    <span v-if="IsError('product.seo_description')" class="help-block" v-for="e in IsError('product.seo_description')">
                                         {{ e }}
                                    </span>
                                </div>

                            </div>

                            <div v-bind:class="{'active' : tab_active == 'tab_reviews'}" role="tabpanel" class="tab-pane" id="tab_reviews" v-if="product.id > 0">
                                    <reviews :product_id="product.id"></reviews>
                            </div>

                            <div v-bind:class="{'active' : tab_active == 'tab_questions_answers'}" role="tabpanel" class="tab-pane" id="tab_questions_answers" v-if="product.id > 0">
                                <questions_answers :product_id="product.id"></questions_answers>
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

    //https://www.npmjs.com/package/vue-ckeditor2#npm
    import VueCkeditor from 'vue-ckeditor2';


    import UploadImages from '../plugins/UploadImages';

    import { mapGetters } from 'vuex';
    import { mapActions } from 'vuex';


    import datePicker from 'vue-bootstrap-datetimepicker';
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';

    import reviews from '../reviews/reviews';
    import questions_answers from '../questions-answers/QuestionsAnswers';




    export default {
        components:{
            Paginate,
            Select2,
            UploadImages,
            datePicker,
            VueCkeditor,
            reviews,
            questions_answers
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

                ckeditor_config: {
                    name: 'ckeditor',
                    toolbar: [
                        { name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
                        { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                        { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                        { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                        '/',
                        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
                        { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                        { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                        { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
                        '/',
                        { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                        { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                        { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
                        { name: 'about', items: [ 'About' ] }
                    ],
                    height: 300,

                    filebrowserUploadUrl: '/ckeditor-upload-image?path=uploads/products/' + this.$route.params.id + '/',
                    filebrowserUploadMethod: 'form',

                    //allowedContent: 'p{text-align}(*); strong(*); em(*); b(*); i(*); u(*); sup(*); sub(*); ul(*); ol(*); li(*); a[!href](*); br(*); hr(*); img{*}[*](*); iframe(*)',
                    //disallowedContent: '*[on*]',

                    allowedContent: true,
                    extraAllowedContent: '*(*);*{*}',
                    extraAllowedContent: 'span;ul;li;table;td;style;*[id];*(*);*{*}'

                },

                product:{
                    id: this.$route.params.id ? this.$route.params.id : 0,
                    attribute_set_id: 0,
                    name: '',
                    url: '',
                    description: '',
                    photo: '',
                    pathPhoto: '',
                    price: 0,
                    sku: '',
                    stock: 0,
                    active: 1,
                    seo_keywords: '',
                    seo_description: ''
                },
                product_accessories: [],
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
                attributes_sets_more_info: [],


                group_products: [],


                productSearchSelect2:{
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

        methods:{
            deleteProductAccessory(index){
                 this.$delete(this.product_accessories, index);
            },
            addProductAccessory({id, name}){
                var add = true;
                this.product_accessories.forEach(function (item, index){
                    if(item.product_id == id)
                    {
                        add = false;
                        return;
                    }
                });

                if(add)
                    this.product_accessories.push({
                        id: id,
                        name: name,
                        is_delete: ''
                    });
                else{
                    this.$helper.swalError('Товар уже добавлен');
                }
            },


            productGroupAdd({id, name, sku, price, active}){
                var add = true;
                this.group_products.forEach(function (item, index){
                    if(id == item.id)
                    {
                        add = false;
                        return;
                    }
                });
                if(add)
                {
                    this.group_products.push({
                        id: id,
                        name: name,
                        sku: sku,
                        price: price,
                        active: active
                    });
                }else{
                    this.$helper.swalError('Товар уже добавлен');
                }
                this.productSearchSelect2.options = [];
            },
            productGroupDelete(index){
                this.$delete(this.group_products, index);
            },
            setMethodRedirect(value){
                this.method_redirect = value;
            },
            setAttributeImage(event, index){
                this.$helper.setImgSrc(event.target.files[0], '#attribute-img');
                this.$set(this.attributes[index], 'value' , event.target.files[0]);
            },
            clearAttributeImage(index){
                this.$set(this.attributes[index], 'value' , '');
            },
            setProductPhoto(event){
                this.$helper.setImgSrc(event.target.files[0], '#photo-img');
                this.product.photo = event.target.files[0];
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
                var self = this;

                var data = new FormData();

                //продукт
                $.each(this.product, function(column, value) {
                    data.append('product[' + column + ']', self.$helper.isNullClear(value));
                });

                $.each(this.specific_price, function(column, value) {
                    data.append('specific_price[' + column + ']', self.$helper.isNullClear(value));
                });

                //С этим товаром покупают
                $.each(this.product_accessories, function(index, item) {
                    data.append('accessories_product_ids[' + index + ']', item.id);
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

                $.each(this.group_products, function(index, item) {
                    data.append('products_ids_group[' + index + ']', item.id);
                });

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
                            this.$router.push('/product/create');
                        }
                    }
                });
            },
            getProduct(product_id){
                setTimeout(function () {
                        axios.get('/admin/product-view/' + product_id).then((res)=>{
                            document.querySelector('input[type=file]').value = '';

                            var data = res.data;
                            var product = data.product;

                            this.product.id               = product.id;
                            this.product.attribute_set_id = product.attribute_set_id;
                            this.product.name             = product.name;
                            this.product.url              = product.url;
                            this.product.description      = product.description;
                            this.product.seo_keywords     = product.seo_keywords;
                            this.product.seo_description  = product.seo_description;
                            this.product.photo            = product.photo;
                            this.product.pathPhoto        = product.pathPhoto;
                            this.product.price            = parseInt(product.price);
                            this.product.sku              = product.sku;
                            this.product.stock            = product.stock;
                            this.product.active           = product.active;


                            this.selectAttributeSetId(product.attribute_set_id);
                            this.groupProducts(product.group_id);


                            this.categories     = data.categories;
                            this.product_images = data.images;

                            var self = this;
                            $.each(data.attributes, function(attribute_id, value) {

                                    self.attributes.forEach(function (item, index) {
                                        if(attribute_id == item.attribute_id)
                                        {
                                            self.$set(self.attributes[index], 'value' , value);
                                        }
                                    });

                            });

                            this.product_accessories = data.product_accessories;


                            if(data.specific_price)
                            {
                                this.specific_price.reduction       = data.specific_price.reduction;
                                this.specific_price.discount_type   = data.specific_price.discount_type;
                                this.specific_price.start_date      = data.specific_price.start_date;
                                this.specific_price.expiration_date = data.specific_price.expiration_date;
                            }

                        });
                }.bind(this), 250);
            },
            groupProducts(group_id){
                axios.get('/admin/group-products/' + group_id).then((res)=>{
                    this.group_products = res.data;
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
    .select2{
        width: 100%!important;
    }
    .nav-tabs-custom>.nav-tabs>li {
        font-size: 12px;
    }
</style>