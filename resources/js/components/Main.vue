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
    import 'fullcalendar/dist/locale/ru'

    export default {
        components:{
            FullCalendar
        },
        name: "hello",
        data() {
            return {
                events: function(start, end, timezone, callback) {

                    var params = {
                        start: start.format("YYYY-MM-DD"),
                        end: end.format("YYYY-MM-DD"),
                    };

                    /*
                    axios.get('/panel/visitor1', {params:  params}).then((res)=>{
                        callback(res.data);
                    });*/
                },
                config: {
                    eventRender: function(event, element) {
                        /*
                        if(event.icon){
                            element.find(".fc-title").prepend("<i class='"+event.icon+"'></i> ");
                        }
                        if (event.rendering == 'background') {
                            element.append(event.title);
                        }*/
                    },

                    resourceAreaWidth: 130,
                    editable: false,
                    /*
                    slotDuration: '00:15:00',
                    slotLabelInterval: 15,
                    slotLabelFormat: 'h(:mm)',
                    */
                    //  lang: 'ru',
                    schedulerLicenseKey: "GPL-My-Project-Is-Open-Source",
                    defaultView: "timelineDay",
                    header: {
                        left: "prev,next",
                        center: "title",
                        right: "timelineDay"//,timelineWeek,timelineMonth
                    },
                    /*
                    olumnFormat: {
                        month: 'ddd',
                        week: 'ddd d/M',
                        day: 'dddd d/M'
                    },*/
                    resourceLabelText: "Посетители",
                    resources: function (callback) {
                        /*
                        axios.get('/panel/visitor2').then((res)=>{
                            callback(res.data); //return event data to the calendar via the provided callback function
                        });*/
                    }

                }
            }
        },
        created(){

        }
    }
</script>

<style>
    .fc-bgevent {
        opacity: .7;
        color: #000;
        text-align: center;
        padding-top: 19px;
        font-size: 11px;
    }
</style>