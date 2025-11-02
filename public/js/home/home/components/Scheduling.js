Vue.component('scheduling-component', {
    directives: {
        initCalendar: {
            inserted: function (el, binding, vnode, vm, arg) {

                var paramsInput = binding.value;
                paramsInput.init(
                    paramsInput
                );
            },
            bind: function (el, binding, vnode, vm, arg) {


            }
        },

    },
    template: '#scheduling-template',
    created: function () {

    },
    mounted: function () {
        componentThisRoute = this;
        this.initCurrentComponent();
        $vD = this.$v;
        currentValuesR = this;
    },

    computed: {},
    data: function () {

        var dataManager = {
            message: 'hello!',
            configParams: {},
            events: [
                {
                    title: 'event1',
                    start: '2010-01-01',
                },
                {
                    title: 'event2',
                    start: '2010-01-05',
                    end: '2010-01-07',
                },
                {
                    title: 'event3',
                    start: '2010-01-09T12:30:00',
                    allDay: false,
                },
            ]
        };
        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        initCurrentComponent: function () {

        },
        getActions: function (action) {
            var result = '';

            switch (action) {
                case "calendarViewData":
                    break;
            }
            return result;
        }, initCalendar: function (params) {
            var initialLocaleCode = 'es';

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['interaction', 'dayGrid', 'timeGrid', 'list', 'resourceTimeline'],

                header: {
                    left: 'prevYear,prev,next,nextYear today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth,listDay,listWeek,resourceTimelineWeek'
                },
                locale: initialLocaleCode,
                // otherwise they'd all just say "list"
                views: {
                    listDay: {buttonText: 'list day'},
                    listWeek: {buttonText: 'list week'}
                },
                resources: [
                    {id: 'a', title: 'Room A'},
                    {id: 'b', title: 'Room B'},
                    {id: 'c', title: 'Room C'}
                ],
                defaultDate: '2019-08-12',
                navLinks: true, // can click day/week names to navigate views
                businessHours: true, // display business hours
                editable: true,
                selectable: true,
                selectMirror: true,
                //LOAD
                eventLimit: true, // allow "more" link when too many events
                eventClick: function (arg) {
                    if (confirm('delete event?')) {

                    }
                },
                select: function (arg) {
                    var title = prompt('Event Title:');
                    if (title) {
                        calendar.addEvent({
                            title: title,
                            start: arg.start,
                            end: arg.end,
                            allDay: arg.allDay
                        });
                    }
                    calendar.unselect();
                },
                dateClick: function (info) {
                    console.log(info);
                  /*  alert('clicked ' + info.dateStr + ' on resource ' + info.resource.id);*/
                },
                events: {
                    'url': $urlBase+'/business/scheduling/exampleDiaryData',
                    failure: function () {
                        console.log('warning not results');
                    }
                }, loading: function (bool) {
                    console.log('loading ready', bool);

                }
            });

            calendar.render();
        }

    },
    props: {
        parentData: {
            type: String,
            default: function () {
                return '';
            }
        }

    },
    beforeMount: function () {
        this.configParams = this.params;

    }
});

