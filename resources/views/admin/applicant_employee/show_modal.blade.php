
<div class="modal inmodal" id="cancelModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounce">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <i class="fa fa-warning modal-icon"></i>
                <h4 class="modal-title"></h4>
                <small class="font-bold"></small>
            </div>
            {!! Form::open([
                           'action'=>'Admin\ApplicantEmployeeController@cancelEmployeeApplicant',


                           'id'=>'cancelForm',

                           'method'=>'POST'
                           ])!!}
            <div class="modal-body">

                <input type="hidden" name="type">
                <input type="hidden" name="id" value="{{$row->id}}">

                <div class="form-group">

                    <label for="reason">{{trans('main.reason')}}</label>
                    {{Form::textarea('reason',null,[
                           'class'=>'form-control',
                            'rows'=>2,
                           'placeholder' => trans('main.reason')
                           ])}}
                    <span class="help-block"><strong></strong></span>
                </div>
                {{--<div class="form-group  ">--}}

                {{--<label for="driver_id" class="col-sm-3 control-label">اسم السائق</label>--}}
                {{--<div class="col-sm-9">--}}
                {{--{{--}}

                {{--Form::select('driver_id', $drivers, null, ['placeholder' => 'اختار','class'=>'form-control driverSelect ','id'=>'driver_id', 'style'=>'width:100%'])--}}
                {{--}}--}}


                {{--</div>--}}
                {{--</div>--}}


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">{{trans('main.close')}}</button>
                <button type="submit" class="btn btn-primary pull-right"
                        onclick="this.disabled=true;this.value='{{trans('main.saving')}}';this.form.submit();">{{trans('main.save')}}
                </button>
            </div>
            {!! Form::close()!!}
        </div>
    </div>
</div>




<script>
    function cancelOrder(type) {

//            $(".driverSelect").val(null).trigger('change');
        $('[name="type"]').val(type);
//        $('[name="id"]').val(type);
        if (type === "reject") {
            $('.modal-title').text(`{{trans('main.reject_applicant')}}`); // Set title to Bootstrap modal title
//            $('.font-bold').text(`برجاء كتابة سبب الالغاء`); // Set title to Bootstrap modal title
        } else if (type === "delay") {
            $('.modal-title').text(`{{trans('main.delay_applicant')}}`); // Set title to Bootstrap modal title
//            $('.font-bold').text(`برجاء كتابة سبب التاجيل`); // Set title to Bootstrap modal title
        }

        $('#cancelModal').modal('show'); // show bootstrap modal when complete loaded
    }
</script>