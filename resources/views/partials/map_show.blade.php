
<?php
$lat = $row->lat ?? 31.9539;
$lon =$row->lon ?? 35.9106;
?>

@push('location-picker')

<script type="text/javascript"
        src='https://maps.google.com/maps/api/js?libraries=places&key={{ env('Google_MAP_KEY')}}'></script>
<script src="{{asset('assets/admin/plugins/locationpicker/locationpicker.jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('#us3').locationpicker({
            location: {
                latitude: {{$lat}},
                longitude: {{$lon}}
            },
            radius: 300,
//            inputBinding: {
//                latitudeInput: $('#us3-lat'),
//                longitudeInput: $('#us3-lon'),
//                radiusInput: $('#us3-radius'),
//                locationNameInput: $('#us3-address')
//            },
            enableAutocomplete: true,

        });
    });
</script>
@endpush

<div class="form-group">
    {{--<label>الموقع</label>--}}
    <div class="row">

        {{--<div class="col-md-12">--}}
            {{--<input type="text" class="form-control" id="us3-address"/>--}}
        {{--</div>--}}

        <div class="col-md-12 ">
            <div id="us3" class="form-control " style="width: 90%; height: 400px; margin: 30px;"></div>
        </div>
        <div class="clearfix">&nbsp;</div>
        {{--<div class="m-t-small">--}}

            {{--<label class="p-r-small col-sm-1 control-label">Lat.:</label>--}}
            {{--<div class="col-sm-3">--}}

                {{--{{Form::hidden('lat',null,[--}}
                        {{--'class'=>'form-control',--}}
                        {{--'id'=>'us3-lat',--}}
                        {{--'style'=>'width: 110px',--}}
                {{--])}}--}}
            {{--</div>--}}

            {{--<label class="p-r-small col-sm-2 control-label">Long.:</label>--}}
            {{--<div class="col-sm-3">--}}
                {{--{{Form::hidden('lon',null,[--}}
                       {{--'class'=>'form-control',--}}
                       {{--'id'=>'us3-lon',--}}
                       {{--'style'=>'width: 110px',--}}
                   {{--])}}--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="clearfix"></div>--}}


    </div>
</div>




