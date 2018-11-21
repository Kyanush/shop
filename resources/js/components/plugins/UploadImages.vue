<template>
    <label class="dropzone">

        <p>
            <a for="pictures">
                <i class="fa fa-upload green"></i> Загрузить фото
                <input type="file" multiple id="pictures" @change="setImages($event)"/>
            </a>
            &nbsp;
            <a v-if="images.length" @click="deleteAll($event)">
                <i class="fa fa-remove red"></i>
                Удалить все
            </a>
        </p>

        <div class="images-view">
            <div class="image" v-for="(item, index) in images" v-if="!item.is_delete">
                <img v-bind:src="item.image_view"/>
                <a @click="deleteImage($event, index)">
                    <i class="fa fa-remove"></i> Удалить
                </a>
                <p v-if="IsError(error_variable + '.' + index + '.value')" class="image-error" v-for="e in IsError(error_variable + '.' + index + '.value')">
                    {{ e }}
                </p>
            </div>
        </div>

    </label>
</template>


<script>
    import { mapGetters } from 'vuex';

    export default {
        props:['images', 'error_variable'],
        data () {
            return{

            }
        },
        methods:{

            setImages(event){
                var self = this;
                for(var i = 0; i < event.target.files.length; i++){
                    var value = event.target.files[i];
                    var reader = new FileReader();
                    reader.onload = function(e)  {
                        self.images.push({
                            id: 0,
                            is_delete: 0,
                            value: value,
                            image_view: e.target.result
                        });
                    }
                    reader.readAsDataURL(event.target.files[i]);
                }
                this.return_images();
            },
            deleteImage(event, index){

                if(this.images[index].id)
                    this.$set(this.images[index], 'is_delete', 1);
                else
                    this.$delete(this.images, index);


                event.preventDefault();
                this.return_images();
            },
            deleteAll(event){
                var self = this;
                $.each(this.images, function(index, item) {
                    self.deleteImage(event, index);
                });
            },
            return_images(){
                this.$emit('return_images', this.images);
            }
        },
        computed:{
            ...mapGetters([
                'IsError'
            ])
        }
    }
</script>

<style>
    .dropzone {
        min-height: 150px;
        border: 2px solid rgba(0, 0, 0, 0.3);
        background: white;
        padding: 20px 20px;
        width: 100%;
        height: 270px;
        box-sizing: border-box;
        text-align: center;
        overflow-y: scroll;
    }
    .dropzone input[type=file]{
        display: none;
    }
    .dropzone p{
        font-weight: normal;
    }
    .images-view{
        text-align: center;
    }
    .images-view .image{
        width: 100px;
        margin: 2px;
        border: 1px solid #d9cece;
        padding: 2px;
        display: inline-block;
    }
    .images-view .image img{
        max-width: 100%;
    }
    .images-view .image a{
        font-size: 12px;
    }
    .images-view .image a .fa{
        color: #e30b0b;
    }
    .image-error{
        font-size: 8px;
        color: red;
    }
</style>