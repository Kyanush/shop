<template>
         <div class="col-md-8 col-md-offset-2">

             <router-link :to="{path: '/categories'}">
                 <i class="fa fa-angle-double-left"></i>
                 Категории
             </router-link>

             <br><br>


             <form v-on:submit="categorySave">
                 <div class="box">
                     <div class="box-header with-border">
                         <h3 class="box-title">{{ category.id ? 'Редактировать' : 'Создать категорию'}}</h3>
                     </div>
                     <div class="box-body row">

                         <div class="tab-container col-md-12">
                             <div class="nav-tabs-custom" id="form_tabs">
                                 <ul class="nav nav-tabs">
                                     <li v-bind:class="{'active' : tab_active == 'tab_main'}" @click="setTab('tab_main')">
                                         <a>Главная</a>
                                     </li>
                                     <li v-bind:class="{'active' : tab_active == 'tab_link_filters'}" @click="setTab('tab_link_filters')">
                                         <a>Готовые фильтры по категорию</a>
                                     </li>
                                     <li v-bind:class="{'active' : tab_active == 'tab_seo'}" @click="setTab('tab_seo')">
                                         <a>SEO</a>
                                     </li>
                                 </ul>
                             </div>
                         </div>

                         <div class="tab-content col-md-12">
                             <div v-bind:class="{'active' : tab_active == 'tab_main'}" role="tabpanel" class="tab-pane" id="tab_main">
                                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('category.name')}">
                                             <label>Название <span class="red">*</span></label>
                                             <input v-model="category.name" type="text" class="form-control">
                                             <span v-if="IsError('category.name')" class="help-block" v-for="e in IsError('category.name')">
                                                 {{ e }}
                                             </span>
                                         </div>

                                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('category.description')}">
                                             <label>Описание</label>

                                             <VueCkeditor v-model="category.description" :config="ckeditor_config"></VueCkeditor>

                                             <span v-if="IsError('category.description')" class="help-block" v-for="e in IsError('category.description')">
                                                 {{ e }}
                                             </span>
                                         </div>

                                         <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('category.sort')}">
                                             <label>Сортировка <span class="red">*</span></label>
                                             <input v-model="category.sort" type="number" class="form-control">
                                             <span v-if="IsError('category.sort')" class="help-block" v-for="e in IsError('category.sort')">
                                                 {{ e }}
                                             </span>
                                         </div>

                                         <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('category.type')}">
                                             <label>Тип</label>
                                             <select v-model="category.type" class="form-control">
                                                 <option value=""></option>
                                                 <option value="hit">Hit</option>
                                                 <option value="new">New</option>
                                                 <option value="skor">Скоро</option>
                                             </select>
                                             <span v-if="IsError('category.type')" class="help-block" v-for="e in IsError('category.type')">
                                                 {{ e }}
                                             </span>
                                         </div>

                                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('category.image')}">
                                             <label>Фото <span class="red" v-if="!category.id">*</span></label>
                                             <p>
                                                 <img v-bind:src="category.path_image ? category.path_image : ''" class="img" id="image-img" width="100"/>
                                             </p>
                                             <label class="btn btn-primary btn-file">
                                                 <i class="fa fa-file-image-o" aria-hidden="true"></i>  Фото товара
                                                 <input type="file" accept="image/*"  @change="setImage($event)"/>
                                             </label>
                                             <span v-if="IsError('category.image')" class="help-block" v-for="e in IsError('category.image')">
                                                   {{ e }}
                                             </span>
                                         </div>

                                         <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('category.url')}">
                                             <label>Url</label>
                                             <input v-model="category.url" type="text" class="form-control">
                                             <span v-if="IsError('category.url')" class="help-block" v-for="e in IsError('category.url')">
                                                 {{ e }}
                                             </span>
                                         </div>

                                         <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('category.class')}">
                                             <label>Класс</label>
                                             <input v-model="category.class" type="text" class="form-control">
                                             <span v-if="IsError('category.class')" class="help-block" v-for="e in IsError('category.class')">
                                                 {{ e }}
                                             </span>
                                         </div>
                             </div>
                             <div v-bind:class="{'active' : tab_active == 'tab_link_filters'}" role="tabpanel" class="tab-pane" id="tab_link_filters">
                                 <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('category.class')}" style="margin-top:20px;">
                                     <h4><b>Готовые фильтры по категорию</b></h4>

                                     <table class="table table-bordered ">
                                         <thead>
                                         <tr>
                                             <th>Название</th>
                                             <th>Ссылка</th>
                                             <th>Сортировка</th>
                                             <th>Действия</th>
                                         </tr>
                                         </thead>
                                         <tbody>
                                         <tr v-for="(item, index) in category.category_filter_links">
                                             <td>{{ item.name }}</td>
                                             <td>{{ item.link }}</td>
                                             <td>{{ item.sort }}</td>
                                             <td>
                                                 <a class="btn btn-xs btn-default" @click="editCategoryFilterLink(item, index)">
                                                     <i class="fa fa-edit"></i>
                                                 </a>
                                                 <a class="btn btn-xs btn-default" @click="deleteCategoryFilterLink(index)">
                                                     <i class="fa fa-remove"></i>
                                                 </a>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td>
                                                 <input type="text" class="form-control" v-model="category_filter_link.name"/>
                                             </td>
                                             <td>
                                                 <input type="text" class="form-control" v-model="category_filter_link.link"/>
                                             </td>
                                             <td>
                                                 <input type="number" class="form-control" v-model="category_filter_link.sort"/>
                                             </td>
                                             <td>
                                                 <button type="button" class="btn btn-success" @click="saveCategoryFilterLink">
                                                     <i class="fa fa-save"></i>
                                                     {{ category_filter_link.index >= 0 ? 'Изменить' : 'Добавить'}}
                                                 </button>
                                                 <button type="button" class="btn btn-danger" @click="clearCategoryFilterLink">
                                                     <i class="fa fa-remove"></i>
                                                 </button>
                                             </td>
                                         </tr>
                                         </tbody>
                                         <tfoot>
                                         <tr>
                                             <th>Название</th>
                                             <th>Ссылка</th>
                                             <th>Сортировка</th>
                                             <th>Действия</th>
                                         </tr>
                                         </tfoot>
                                     </table>
                                 </div>
                             </div>
                             <div v-bind:class="{'active' : tab_active == 'tab_seo'}" role="tabpanel" class="tab-pane" id="tab_seo">
                                 <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('category.seo_keywords')}">
                                     <label>Keywords</label>
                                     <textarea v-model="category.seo_keywords" class="form-control"></textarea>
                                     <span v-if="IsError('category.seo_keywords')" class="help-block" v-for="e in IsError('category.seo_keywords')">
                                         {{ e }}
                                     </span>
                                 </div>
                                 <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('category.seo_description')}">
                                     <label>Description</label>
                                     <textarea v-model="category.seo_description" class="form-control"></textarea>
                                     <span v-if="IsError('category.seo_description')" class="help-block" v-for="e in IsError('category.seo_description')">
                                         {{ e }}
                                     </span>
                                 </div>
                             </div>
                         </div>


                     </div>
                     <div class="box-footer">
                         <div  class="form-group">
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

                             <router-link :to="{path: '/categories'}" class="btn btn-default">
                                 <span class="fa fa-ban"></span> &nbsp;
                                 Отменить
                             </router-link>

                         </div>
                     </div><!-- /.box-footer-->
                 </div><!-- /.box -->
             </form>
         </div>
</template>


<script>
    import { mapGetters } from 'vuex';
    import { mapActions } from 'vuex';
    //https://www.npmjs.com/package/vue-ckeditor2#npm
    import VueCkeditor from 'vue-ckeditor2';

    export default {
        components:{
            VueCkeditor
        },
        data () {

            return {
                method_redirect: 'save_and_back',
                category:{
                    id: this.$route.params.id ? this.$route.params.id : 0,
                    name: '',
                    url: '',
                    image: '',
                    class: '',
                    path_image: '',
                    type: '',
                    description: '',
                    seo_keywords: '',
                    seo_description: '',
                    category_filter_links: []
                },
                category_filter_link:{
                    index: -1,
                    name: '',
                    link: '',
                    sort: 0
                },
                tab_active: 'tab_main',
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
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            if(this.category.id > 0)
            {
                axios.get('/admin/category-view/' + this.category.id).then((res)=>{
                    var res = res.data;
                    console.log(res);

                    this.category.name = res.name;
                    this.category.url = res.url;
                    this.category.image = res.image;
                    this.category.class = res.class;
                    this.category.type = res.type;
                    this.category.description = res.description;
                    this.category.seo_keywords = res.seo_keywords;
                    this.category.seo_description = res.seo_description;
                    this.category.path_image = res.path_image;
                    this.category.category_filter_links = res.category_filter_links;
                });
            }
        },
        methods:{
            editCategoryFilterLink(item, index){
                this.category_filter_link.index = index;
                this.category_filter_link.name  = item.name;
                this.category_filter_link.link  = item.link;
                this.category_filter_link.sort  = item.sort;
            },
            deleteCategoryFilterLink(index){
                this.$delete(this.category.category_filter_links, index);
            },
            clearCategoryFilterLink(){
                this.category_filter_link.index = -1;
                this.category_filter_link.name  = '';
                this.category_filter_link.link  = '';
                this.category_filter_link.sort  = 0;
            },
            saveCategoryFilterLink(){
                var index = this.category_filter_link.index;

                if(index >= 0){
                    this.$set(this.category.category_filter_links[index], 'name', this.category_filter_link.name);
                    this.$set(this.category.category_filter_links[index], 'link', this.category_filter_link.link);
                    this.$set(this.category.category_filter_links[index], 'sort', this.category_filter_link.sort);
                }else{
                    this.category.category_filter_links.push({
                        name: this.category_filter_link.name,
                        link: this.category_filter_link.link,
                        sort: this.category_filter_link.sort,
                    });
                }
                this.clearCategoryFilterLink();
            },


            setTab(tab){
                this.tab_active = tab;
            },
            setImage(event){
                this.$helper.setImgSrc(event.target.files[0], '#image-img');
                this.category.image = event.target.files[0];
            },
            setMethodRedirect(value){
                this.method_redirect = value;
            },
            categorySave(event){
                event.preventDefault();
                this.SetErrors(null);

                var data = new FormData();
                var self = this;
                $.each(this.category, function(column, value) {

                    if(Array.isArray(value)) {

                      value.forEach(function (item, index) {
                          Object.keys(item).forEach(function (column) {
                              data.append('category[category_filter_links][' + index + '][' + column + ']', self.$helper.isNullClear(item[column]));
                          });
                      });

                    }else
                       data.append('category[' + column + ']', self.$helper.isNullClear(value));
                });

                axios.post('/admin/category-save', data).then((res)=>{
                    if(res.data)
                    {
                        this.$helper.swalSuccess(this.category.id ? 'Успешно изменено' : 'Успешно создано');

                        if(this.method_redirect == 'save_and_back'){
                            this.$router.push('/categories');

                        }else if(this.method_redirect == 'save_and_continue'){
                            if(!this.category.id)
                            {
                                this.category.id = res.data;
                                this.$router.push('/categories/edit/' + this.category.id);
                            }
                        }else if(this.method_redirect == 'save_and_new'){
                            this.$router.push('/categories/create');

                            this.category.id    = 0;
                            this.category.name  = '';
                            this.category.url  = '';
                            this.category.image = '';
                            this.category.class = '';
                            this.category.type = '';
                            this.category.description = '';
                            this.category.seo_keywords = '';
                            this.category.seo_description = '';
                            this.category.category_filter_links = [];
                        }

                    }
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

<style>
    table thead, table tfoot {
        background-color: #f6f6f6;
    }
</style>