@include('partials.validation-errors')


@include('flash::message')
<div class="row">
    <div class="col-sm-2">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 35px;"
                   for="attendance">{{trans('main.attendance')}}</label>

            {{Form::select('attendance', [
                'yes'=>trans('main.yes'),
                'no'=>trans('main.no'),
                'official_vacation_yes'=>trans('main.official_vacation_yes'),
                'official_vacation_no'=>trans('main.official_vacation_no'),
                'normal_vacation'=>trans('main.normal_vacation'),
                'casual_vacation'=>trans('main.casual_vacation'),
                ], $model->attendance, [
                "class" => "form-control select2 " ,
                "id" => "attendance",
                "placeholder" => trans('main.attendance')
            ])}}
            {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
        </div>
    </div>
    <div class="col-sm-4 text-center">
        <label for="">period 1</label>
        <div class="col-sm-12">
            <div class="col-sm-6">
                <label class="control-label" for="from">{{trans('main.from')}}</label>
                <div class="input-group clockpicker" data-autoclose="true">
                    <input type="text" name="from1" class="form-control"
                           placeholder="{{trans('main.from')}}" value="{{$model->from1}}">
                    <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                </div>
            </div>
            <div class="col-sm-6">
                <label class="control-label" for="from">{{trans('main.to')}}</label>
                <div class="input-group clockpicker" data-autoclose="true">
                    <input type="text" name="to1" class="form-control"
                           placeholder="{{trans('main.to')}}" value="{{$model->to1}}">
                    <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                </div>
            </div>
        </div>

    </div>
    <div class="col-sm-4 text-center">
        <label for="">period 2</label>
        <div class="col-sm-12">
            <div class="col-sm-6">
                <label class="control-label" for="from">{{trans('main.from')}}</label>
                <div class="input-group clockpicker" data-autoclose="true">
                    <input type="text" name="from2" class="form-control"
                           placeholder="{{trans('main.from')}}" value="{{$model->from2}}">
                    <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                </div>
            </div>
            <div class="col-sm-6">
                <label class="control-label" for="from">{{trans('main.to')}}</label>
                <div class="input-group clockpicker" data-autoclose="true">
                    <input type="text" name="to2" class="form-control"
                           placeholder="{{trans('main.to')}}" value="{{$model->to2}}">
                    <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                </div>
            </div>
        </div>

    </div>
    <div class="col-sm-2">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 35px;" for="reward">{{trans('main.reward')}}</label>
            {{Form::number('reward', null, [
        "placeholder" => trans('main.reward'),
        "class" => "form-control ",
        "id" => 'reward' ])}}
            <span class="help-block text-danger"><strong></strong></span>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 35px;" for="details">{{trans('main.details')}}</label>
            {{Form::text('details', null, [
        "placeholder" => trans('main.details'),
        "class" => "form-control ",
        "id" => 'details' ])}}
            <span class="help-block text-danger"><strong></strong></span>
        </div>
    </div>
</div>

