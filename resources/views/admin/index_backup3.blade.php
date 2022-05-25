@extends('admin.layouts.main')
@section('content')


    {{--<div class="row">--}}
    {{--<div class="col-md-12">--}}

    {{--<div id="full-calendar"></div>--}}
    {{--</div>--}}
    {{--</div>--}}
    <div class="row">
        <div class="col-md-12">
            <div id="map"  class="form-control " style="width: 90%; height: 400px; margin: 30px;"></div>
        </div>
        <div class="col-md-12">

            <div id="full-calendar"></div>
        </div>
    </div>
    @push('style')

        <link href="{{asset('assets/admin/plugins/fullcalendar/fullcalendar.min.css')}}" rel='stylesheet'/>
        <link href="{{asset('assets/admin/plugins/fullcalendar/fullcalendar.print.min.css')}}" rel='stylesheet'
              media='print'/>
    @endpush
    @push('script')


        <script src="{{asset('assets/admin/plugins/fullcalendar/lib/moment.min.js')}}"></script>
        {{--<script src="{{asset('assets/fullcalendar/lib/jquery.min.js')}}"></script>--}}
        <script src="{{asset('assets/admin/plugins/fullcalendar/fullcalendar.min.js')}}"></script>
        <script src="{{asset('assets/admin/plugins/fullcalendar/locale-all.js')}}"></script>
        <script src="{{asset('assets/admin/plugins/chartJs/Chart.min.js')}}"></script>
        <script>


            // start system calendar

            full_calendar = $('#full-calendar').fullCalendar({
                /*height: 650,*/
                displayEventTime: false,
                header: {
//                    left: 'prev,next today',
                    center: 'title',
                    //right: 'month,agendaWeek,agendaDay',
                    right: 'month,agendaWeek,agendaDay',
                },
//                dayNamesShort: ['الأحد', 'الأثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'],
//                monthNames: ['يناير', 'فبراير', 'مارس', 'إبريل', 'مايو', 'يونيو', 'يوليو', 'اغسطس', 'سبتمبر', 'اكتوبر', 'فبراير', 'ديسمبر'],
                selectable: true,
                selectHelper: true,
                select: function (start, end, allDay) {
                    bootbox.prompt("Event name?", function (result) {
                        if (result === null) {

                        } else {

                            full_calendar.fullCalendar('renderEvent',
                                {
                                    title: result,
                                    start: start,
                                    end: end,
                                },
                                true // make the event "stick"
                            );
                        }
                        full_calendar.fullCalendar('unselect');
                    });
                },
                editable: false,
                events: "{{url('admin/dates')}}",
                locale: 'ar-ly',
                isRTL: true,


                // eventDragStart: eventDragStart,
                /*events: "json-events.php",*/
                loading: function (bool) {
                    if (bool) $('#loading').show();
                    else $('#loading').hide();
                }


            });

            // end calender


        </script>
    @endpush

    @push('location-picker')

        <script type="text/javascript"
                src='https://maps.google.com/maps/api/js?libraries=places&key={{ env('Google_MAP_KEY')}}'></script>
        {{--        <script src="{{asset('assets/admin/plugins/locationpicker/locationpicker.jquery.min.js')}}"></script>--}}

        <script>
            //            var locations = [
            //                ['Bondi Beach', -33.890542, 151.274856, 4],
            //                ['Coogee Beach', -33.923036, 151.259052, 5],
            //                ['Cronulla Beach', -34.028249, 151.157507, 3],
            //                ['Manly Beach', -33.80010128657071, 151.28747820854187, 2],
            //                ['Maroubra Beach', -33.950198, 151.259302, 1]
            //            ];
            var locations = <?php print_r(json_encode($locations)) ?>;
            var bounds = new google.maps.LatLngBounds();
            var map = new google.maps.Map(document.getElementById('map'), {
//                zoom: 7,

//                center: map.getCenter(),
//                center: new google.maps.LatLng(30.0444196, 31.2357116),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            map.fitBounds(bounds);
            var infowindow = new google.maps.InfoWindow();

            var marker, i;
            $.each(locations, function (index, value) {
//            for (i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(value.lat, value.lon),
                    map: map
                });
                bounds.extend(marker.position);
                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        infowindow.setContent(value.name);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
//            }
            });
        </script>
    @endpush

@stop


