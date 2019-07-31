<template>
    <div class="row">

        <div class="col-md-4">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-cart-arrow-down"></i>
                        Заказ за месяц
                    </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Статус</th>
                                <th>Кол-во</th>
                                <th>Сумма</th>
                            </tr>
                            <tr v-for="(item, status_id) in total_status">
                                <td><i :class="item.class"></i> {{ item.title }}</td>
                                <td>{{ item.quantity }}</td>
                                <td>{{ item.total }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-phone"></i>
                        Обратный звонок за месяц
                    </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>Статус</th>
                            <th>Кол-во</th>
                        </tr>
                        <tr v-for="(item, status_id) in total_callbacks">
                            <td><i :class="item.class"></i> {{ item.title }}</td>
                            <td>{{ item.quantity }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="box">
                <full-calendar :config="config" :events="events"/>
            </div>
        </div>

    </div>
</template>

<script>
    import { FullCalendar } from "vue-full-calendar";
    import "fullcalendar-scheduler";
    import "fullcalendar/dist/fullcalendar.min.css";
    import "fullcalendar-scheduler/dist/scheduler.min.css";
    import 'fullcalendar/dist/locale/ru';

    export default {
        components:{
            FullCalendar
        },
        data() {
            return {
                total_status: [],
                total_callbacks: [],
                config: {
                    firstDay: 1,
                    firstDaymonthNames: ['Январь','Февраль','Март','Апрель','Май','οюнь','οюль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
                    monthNamesShort: ['Янв.','Фев.','Март','Апр.','Май','οюнь','οюль','Авг.','Сент.','Окт.','Ноя.','Дек.'],
                    dayNames: ["Воскресенье","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота"],
                    dayNamesShort: ["ВС","ПН","ВТ","СР","ЧТ","ПТ","СБ"],
                    buttonText: {
                        prev: "<",
                        next: ">",
                        prevYear: "<",
                        nextYear: ">",
                        today: "Сегодня",
                        month: "Месяц",
                        week: "Неделя",
                        day: "День"
                    },


                    lang: 'ru',
                    schedulerLicenseKey: "GPL-My-Project-Is-Open-Source",
                    eventRender: function(event, element) {
                             element.find(".fc-title").prepend("<i title='" + event.icon_title + "' class='" + event.icon_class + "'></i>&nbsp;");
                    },
                    defaultView: 'month',

                    eventLimit: true, // If you set a number it will hide the itens
                    eventLimitText: "еще", // Default is `more` (or "more" in the lang you pick in the option)
                    views: {
                        agenda: {
                            eventLimit: 3// adjust to 6 only for agendaWeek/agendaDay
                        }
                    }
                }
            }
        },
        methods:{
            events(start, end, timezone, callback) {

                var params = {
                    start: start.format("YYYY-MM-DD"),
                    end: end.format("YYYY-MM-DD"),
                }

                axios.get('/admin/calendar-orders', {params:  params}).then((res)=>{
                    var data = res.data;

                    this.total_status = data.total_status;
                    this.total_callbacks = data.total_callbacks;

                    callback(data.calendar);
                });

            },
        },
        updated(){

            /*
            $('#calendar').fullCalendar({
                firstDay: 1,
                height: 200,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                monthNames: ['Январь','Февраль','Март','Апрель','Май','οюнь','οюль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
                monthNamesShort: ['Янв.','Фев.','Март','Апр.','Май','οюнь','οюль','Авг.','Сент.','Окт.','Ноя.','Дек.'],
                dayNames: ["Воскресенье","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота"],
                dayNamesShort: ["ВС","ПН","ВТ","СР","ЧТ","ПТ","СБ"],
                buttonText: {
                    prev: "&nbsp;&#9668;&nbsp;",
                    next: "&nbsp;&#9658;&nbsp;",
                    prevYear: "&nbsp;&lt;&lt;&nbsp;",
                    nextYear: "&nbsp;&gt;&gt;&nbsp;",
                    today: "Сегодня",
                    month: "Месяц",
                    week: "Неделя",
                    day: "День"
                }
            });*/

        }
    }
</script>

<style>
  .fc-today {
      background:#CDDC39 !important;
      font-weight: bold;
  }
</style>