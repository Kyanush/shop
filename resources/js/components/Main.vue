<template>
    <div class="box">
        <full-calendar :config="config" :events="events"/>
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
                events: function(start, end, timezone, callback) {

                    var params = {
                        start: start.format("YYYY-MM-DD"),
                        end: end.format("YYYY-MM-DD"),
                    };

                    axios.get('/admin/calendar-orders', {params:  params}).then((res)=>{
                        callback(res.data);
                    });

                },
                config: {
                    monthNames: ['Январь','Февраль','Март','Апрель','Май','οюнь','οюль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
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