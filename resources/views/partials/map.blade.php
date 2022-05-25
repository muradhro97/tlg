<?php
$lat = ($model->lat == '') ? 31.0409483 : $model->lat;
$lon = ($model->lon == '') ? 31.3784704 : $model->lon;
?>

@push('location-picker')

    <script type="text/javascript"
            src='https://maps.google.com/maps/api/js?libraries=places&key={{ env('Google_MAP_KEY')}}'></script>
    <script src="{{asset('assets/admin/plugins/locationpicker/locationpicker.jquery.min.js')}}"></script>
    <script>
        $(document).ready(function () {
//        var lat="";
//        var lon="";
//            console.log(navigator.geolocation);
            getLocation();

            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition, errorFunction);
//         var bb= aa.position.coords.latitude;
//         console.log(aa);
                } else {
                    alert("show location is not supported by this browser");
//                    alert();

//                lat= 31.9539;
//                lon= 35.9106;
//                x.innerHTML = "Map is not supported by this browser.";
                }
            }

            function errorFunction() {
                $("#set_lat").val("{{$lat}}");
                $("#set_lon").val("{{$lon}}");
                showMap();
            }

            function showPosition(position) {
                $("#set_lat").val(position.coords.latitude);
                $("#set_lon").val(position.coords.longitude);
                showMap();
//             lat= position.coords.latitude;
//             lon= position.coords.longitude;
//             console.log(lat);

//            x.innerHTML = "Latitude: " + position.coords.latitude +
//                "<br>Longitude: " + position.coords.longitude;
            }

            function showMap() {


                $('#us3').locationpicker({
                    location: {
                        latitude: $("#set_lat").val(),
                        longitude: $("#set_lon").val()
                    },
                    radius: 300,
                    inputBinding: {
                        latitudeInput: $('#us3-lat'),
                        longitudeInput: $('#us3-lon'),
                        radiusInput: $('#us3-radius'),
                        locationNameInput: $('#us3-address')
                    },
                    enableAutocomplete: true,

                });
            }
        });
    </script>
@endpush
<input type="hidden" name="set_lat" id="set_lat">
<input type="hidden" name="set_lon" id="set_lon">
<div class="form-group">
    <label>{{trans('main.location')}}</label>
    <div class="row">

        <div class="col-md-12">
            <input type="text" class="form-control" id="us3-address"/>
        </div>

        <div class="col-md-12 ">
            <div id="us3" class="form-control " style="width: 90%; height: 400px; margin: 30px;"></div>
        </div>
        <div class="clearfix">&nbsp;</div>
        <div class="m-t-small">

            {{--<label class="p-r-small col-sm-1 control-label">Lat.:</label>--}}
            <div class="col-sm-3">

                {{Form::hidden('lat',null,[
                        'class'=>'form-control',
                        'id'=>'us3-lat',
                        'style'=>'width: 110px',
                ])}}
            </div>

            {{--<label class="p-r-small col-sm-2 control-label">Long.:</label>--}}
            <div class="col-sm-3">
                {{Form::hidden('lon',null,[
                       'class'=>'form-control',
                       'id'=>'us3-lon',
                       'style'=>'width: 110px',
                   ])}}
            </div>
        </div>
        <div class="clearfix"></div>


    </div>
</div>




