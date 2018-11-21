<template>
         <div class="col-md-8 col-md-offset-2">

             <router-link :to="{path: '/categories'}">
                 <i class="fa fa-angle-double-left"></i>
                 Вернуться ко всем <span>категориям</span>
             </router-link>

             <br><br>


             <form v-on:submit="categorySave">
                 <div class="box">
                     <div class="box-header with-border">
                         <h3 class="box-title">{{ category.id ? 'Редактировать' : 'Создать категорию'}}</h3>
                     </div>
                     <div class="box-body row">
                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('category.name')}">
                             <label>Название <span class="red">*</span></label>
                             <input v-model="category.name" type="text" class="form-control">
                             <span v-if="IsError('category.name')" class="help-block" v-for="e in IsError('category.name')">
                                 {{ e }}
                             </span>
                         </div>
                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('category.slug')}">
                             <label>Slug <span class="red">*</span></label>
                             <input v-model="category.slug" type="text" class="form-control">
                             <span v-if="IsError('category.slug')" class="help-block" v-for="e in IsError('category.slug')">
                                 {{ e }}
                             </span>
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

    export default {
        data () {
            return {
                method_redirect: 'save_and_back',
                category:{
                    id: this.$route.params.id ? this.$route.params.id : 0,
                    name: '',
                    slug: ''
                }
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

                    this.category.name = res.name;
                    this.category.slug = res.slug;
                });
            }
        },
        methods:{
            setMethodRedirect(value){
                this.method_redirect = value;
            },
            categorySave(event){
                event.preventDefault();
                this.SetErrors(null);


                var url = this.category.id ? '/admin/category-update/' + this.category.id : '/admin/category-create'
                var data = this.$helper.formData(this.category, 'category');

                axios.post(url, data).then((res)=>{
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

                            this.category.id = 0;
                            this.category.name = '';
                            this.category.slug = '';
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
