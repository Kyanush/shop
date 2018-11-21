<template>
    <div class="col-md-8 col-md-offset-2">
        <!-- Default box -->


        <router-link :to="{path: '/attributes'}">
            <i class="fa fa-angle-double-left"></i>
            Вернуться ко всем <span>атрибутам</span>
        </router-link>


        <br><br>


        <form v-on:submit="attributeSave">
            <div class="box">

                <div class="box-header with-border">
                    <h3 class="box-title">Добавить новый атрибут</h3>
                </div>
                <div class="box-body row">

                    <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('attribute.name')}">
                        <label>Название <span class="red">*</span></label>
                        <input type="text" name="name" value="" class="form-control" v-model="attribute.name"/>
                        <span v-if="IsError('attribute.name')" class="help-block" v-for="e in IsError('attribute.name')">
                            {{ e }}
                        </span>
                    </div>

                    <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('attribute.required')}">
                        <label>Обязательные поля <span class="red">*</span></label>
                        <select class="form-control" v-model="attribute.required">
                            <option value="0">Нет</option>
                            <option value="1">Да</option>
                        </select>
                        <span v-if="IsError('attribute.required')" class="help-block" v-for="e in IsError('attribute.required')">
                            {{ e }}
                        </span>
                    </div>

                    <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('attribute.type')}">
                        <label>Тип <span class="red">*</span></label>
                        <select name="type" id="attribute_type" class="form-control" v-model="attribute.type" v-on:change="clearDefaultValues" v-bind:disabled="attribute.id > 0">
                            <option v-for="type in types" v-bind:value="type.value">
                                {{ type.name }}
                            </option>
                        </select>
                        <span v-if="IsError('attribute.type')" class="help-block" v-for="e in IsError('attribute.type')">
                            {{ e }}
                        </span>
                    </div>



                    <div class="form-group col-md-12 attr-field attr-type-media image" v-if="attribute.type == 'media'" v-bind:class="{'has-error' : IsError('attribute.values.0.value')}">
                        <div>
                            <label>Картина по умолчанию</label>
                        </div>
                        <div class="row">
                            <div class="col-sm-6" style="margin-bottom: 20px;">
                                <img id="mainImage" src="" v-bind:src="attribute.values[0].value ? '/uploads/attributes/' + attribute.values[0].value : ''">
                            </div>
                        </div>
                        <div class="btn-group">
                            <label class="btn btn-primary btn-file">
                                Загрузить
                                <input type="file" accept="image/*" id="uploadImage" class="hide" @change="setFile($event)"/>
                            </label>
                            <button class="btn btn-danger" id="remove" type="button" @click="clearDefaultValues">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                        <div class="btn-group">
                            <span v-if="IsError('attribute.values.0.value')" class="help-block" v-for="e in IsError('attribute.values.0.value')">
                                    {{ e }}
                            </span>
                        </div>
                    </div>


                    <div class="form-group attr-field attr-type-text col-md-12" v-if="attribute.type == 'text'" v-bind:class="{'has-error' : IsError('attribute.values.0.value')}">
                        <label>Текст по умолчанию</label>
                        <input type="text" name="text" class="form-control" v-model="attribute.values[0].value">
                        <span v-if="IsError('attribute.values.0.value')" class="help-block" v-for="e in IsError('attribute.values.0.value')">
                            {{ e }}
                        </span>
                    </div>

                    <div class="form-group attr-field attr-type-textarea col-md-12" v-if="attribute.type == 'textarea'" v-bind:class="{'has-error' : IsError('attribute.values.0.value')}">
                        <label>Текстовая область по умолчанию</label>
                        <textarea name="textarea" class="form-control" v-model="attribute.values[0].value"></textarea>
                        <span v-if="IsError('attribute.values.0.value')" class="help-block" v-for="e in IsError('attribute.values.0.value')">
                            {{ e }}
                        </span>
                    </div>

                    <div class="form-group attr-field attr-type-date col-md-12" v-if="attribute.type == 'date'" v-bind:class="{'has-error' : IsError('attribute.values.0.value')}">
                        <label>Дата по умолчанию</label>
                        <input type="date" name="date" class="form-control" v-model="attribute.values[0].value">
                        <span v-if="IsError('attribute.values.0.value')" class="help-block" v-for="e in IsError('attribute.values.0.value')">
                            {{ e }}
                        </span>
                    </div>

                    <div class="form-group attr-field attr-type-dropdown col-md-12"  v-if="attribute.type == 'multiple_select' || attribute.type == 'dropdown'">
                        <label>{{ attribute.type == 'multiple_select' ? 'Множественный выбор' : 'Выбор' }}</label>
                        <div class="well">
                            <a @click="addOption" id="add_option">
                                <i class="fa fa-plus"></i>
                                Создать вариант
                            </a>
                            <hr>
                            <div class="options">

                                <div class="form-group option" v-for="(item, index) in attribute.values">
                                    <label>вариант #{{ index + 1}}</label>
                                    <div class="input-group">
                                        <input  type="text" v-model="attribute.values[index].value" class="form-control" v-bind:disabled="item.is_delete == 1" placeholder="Значение">
                                        <span class="input-group-addon">
                                            <a @click="deleteOption(index)" class="remove-option">
                                                <i class="fa fa-remove"></i>
                                            </a>
                                        </span>
                                    </div>
                                    <span v-if="IsError('attribute.values.' + index + '.value')" class="help-block required" v-for="e in IsError('attribute.values.' + index + '.value')">
                                            {{ e }}
                                    </span>
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

                        <router-link :to="{path: '/attributes'}" class="btn btn-default">
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

    export default {
        data () {
            return {
                method_redirect: 'save_and_back',
                attribute: this.attributeDefault(),
                types:[
                    {
                        value: '',
                        name: ''
                    },
                    {
                        value: 'text',
                        name: 'Текст - Text'
                    },
                    {
                        value: 'textarea',
                        name: 'Текстовая область - Text Area'
                    },
                    {
                        value: 'date',
                        name: 'Дата - Date'
                    },
                    {
                        value: 'multiple_select',
                        name: 'Множественный выбор - Multiple Select'
                    },
                    {
                        value: 'dropdown',
                        name: 'Выбор - Dropdown'
                    },
                    {
                        value: 'media',
                        name: 'Картинка - Image'
                    }
                ]
            }
        },
        created(){
            if(this.$route.params.id > 0)
            {
                axios.get('/admin/attribute-view/' + this.$route.params.id).then((res)=>{
                    this.attribute = res.data;
                });
            }
        },
        methods:{
            attributeDefault(){
                return {
                    id: 0,
                    name: '',
                    type: '',
                    required: 0,
                    values: [{
                        id: 0,
                        value: '',
                        is_delete: 0
                    }]
                };
            },
            setFile(event){
                this.$set(this.attribute.values[0],'value', event.target.files[0]);
                this.$helper.setImgSrc(event.target.files[0], '#mainImage');
            },
            clearDefaultValues(){
                if(this.attribute.type != 'multiple_select' && this.attribute.type != 'dropdown')
                    this.attribute.values = [{
                        id: 0,
                        value: '',
                        is_delete: 0
                    }];

                $('#mainImage').attr('src', null);
                $('#uploadImage').val(null);
            },
            addOption(){
                this.attribute.values.push({
                    id: 0,
                    value: '',
                    is_delete: false
                });
            },
            deleteOption(index){
                    if(this.attribute.values[index].id){
                        this.$set(this.attribute.values[index], 'is_delete', this.attribute.values[index].is_delete ? 0 : 1);
                    }else
                        this.$delete(this.attribute.values, index);
            },
            setMethodRedirect(value){
                this.method_redirect = value;
            },
            attributeSave(event){
                event.preventDefault();
                this.SetErrors(null);

                var form_data = new FormData();

                form_data.append('attribute[id]', this.attribute.id);
                form_data.append('attribute[name]', this.attribute.name);
                form_data.append('attribute[type]', this.attribute.type);
                form_data.append('attribute[required]', this.attribute.required);

                this.attribute.values.forEach(function (value, i) {
                    form_data.append('attribute[values]['+i+'][id]', value.id);
                    form_data.append('attribute[values]['+i+'][value]', value.value);
                    form_data.append('attribute[values]['+i+'][is_delete]', value.is_delete);
                });

                axios.post('/admin/attribute-save', form_data).then((res)=>{
                    if(res.data)
                    {
                        console.log(res.data);

                        this.$helper.swalSuccess(this.attribute.id ? 'Успешно изменено' : 'Успешно создано');

                        if(this.method_redirect == 'save_and_back'){
                            this.$router.push('/attributes');

                        }else if(this.method_redirect == 'save_and_continue'){
                            if(!this.attribute.id)
                            {
                                this.attribute.id = res.data;
                                this.$router.push('/attributes/edit/' + this.attribute.id);
                            }
                        }else if(this.method_redirect == 'save_and_new'){
                            this.$router.push('/attributes/create');

                            this.attribute = this.attributeDefault();
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
    #add_option, .remove-option{
        cursor: pointer;
    }
    img {
        max-width: 100%;
    }
</style>