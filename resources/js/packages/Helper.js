export default function(Vue){
    Vue.helper = {
        convertDataSelect2(values, column_text, column_id){
            var data = [];
            values.forEach(function(item, index){
                data.push({
                    id:   item[column_id   ? column_id   : 'id'],
                    text: item[column_text ? column_text : 'name']
                });
            });
            return data;
        },
        setImgSrc(event, attr){
            var reader = new FileReader();
            reader.onload = function(e) {
                $(attr).attr('src', e.target.result);
            }
            reader.readAsDataURL(event);
        },
        clear(value){
            return value == null ? '' : value;
        },
        isMobile() {
            return window.screen.width < 800 ? true : false;
        },
        formData(data, variable){
            var form_data = new FormData();

            Object.keys(data).forEach(function (column){
                if($.isArray(data[column]))
                {
                    if(data[column])
                    {
                        if(Object.keys(data[column]).length)
                        {
                            Object.keys(data[column]).forEach(function (index){
                                var value = data[column][index] === undefined ? '' : data[column][index];

                                if(variable)
                                    form_data.append(variable + '[' + column + '][' + index + ']', value);
                                else
                                    form_data.append(column + '[' + index + ']', value);
                            });
                        }else{
                            if(variable)
                                form_data.append(variable + '[' + column + ']', []);
                            else
                                form_data.append(column, []);
                        }
                    }
                }else{

                    var value = data[column] === undefined ? '' : data[column];

                    if(variable)
                        form_data.append(variable + '[' + column + ']', value);
                    else
                        form_data.append(column, value);
                }
            });
            return form_data;
        },
        swalSuccess(title, type, timer){
            if(title){
                const toast = Vue.swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: timer ? timer :3000,
                    width: '300px'
                });
                toast({
                    type: type ? type : 'success',
                    title: title,
                });
            }
        },
        swalError(errors, title){
            if(errors)
            {
                var swal_html = '';

                if($.isArray(errors) || typeof errors === 'object')
                {
                    Object.keys(errors).forEach(function (key){
                        if($.isArray(errors[key])){
                            errors[key].forEach(error => {
                                swal_html += error + '<br/>';
                            });
                        }else{
                            swal_html += errors[key] + '<br/>';
                        }
                    });
                }else{
                    swal_html = errors;
                }

                if(swal_html){
                    swal_html  = '<span class="error">' + swal_html + '</span>';
                    Vue.swal({
                        type:  'error',
                        title: title ? title : 'Ошибка',
                        html:  swal_html
                    });
                }
            }
        },
        datetimeFormat(dateString){
            if(!dateString) return '';

            console.log(dateString);

            var reggie = /(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/;
            var dateArray = reggie.exec(dateString);

            if(!dateArray) return 'f';

            //текущая дата
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1;
            var yyyy = today.getFullYear();
            var current_date = dd + '.' + (mm > 10 ? mm : '0'+ mm)  + '.' + yyyy;

            if((dateArray[3] + '.' + dateArray[2] + '.' + dateArray[1]) == current_date){
                return dateArray[4] +':'+ dateArray[5]
            }else{
                return dateArray[3] + '.' + dateArray[2] + '.' + dateArray[1]
                    + ' ' +
                    dateArray[4] + ':' + dateArray[5];
            }
        },
        dateFormat(dateString){
            if(!dateString) return '';
            var reggie = /(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/;
            var dateArray = reggie.exec(dateString);

            if(dateArray){
                return dateArray[3] + '.' + dateArray[2] + '.' + dateArray[1]
                        + ' ' +
                        dateArray[4] + ':' + dateArray[5];
            }else{
                return '';
            }
        }
    }

    Object.defineProperties(Vue.prototype,{
        $helper:{
            get(){
                return Vue.helper;
            }
        }
    });
}