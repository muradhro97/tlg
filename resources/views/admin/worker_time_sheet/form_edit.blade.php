@include('partials.validation-errors')


@include('flash::message')
<div class="row">
    <div class="col-sm-2">
        <div class="form-group">
            <label class="control-label" for="attendance">{{trans('main.attendance')}}</label>
            {{Form::select('attendance', ['yes'=>trans('main.yes'),'no'=>trans('main.no')], null, [
                "class" => "form-control select2 " ,
                "id" => "attendance",
                "placeholder" => trans('main.attendance')
            ])}}
            {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
        </div>
    </div>
    @if($model->type == 'productivity')
        <div class="col-sm-2">
            <div class="form-group">
                <label class="control-label" for="overtime">{{trans('main.productivity')}}</label>
                {{Form::text('productivity', null, [
            "placeholder" => trans('main.productivity'),
            "class" => "form-control floatonly",
            "id" => 'productivity' ])}}
                <span class="help-block text-danger"><strong></strong></span>
            </div>
        </div>
    @else
        <div class="col-sm-2">
            <div class="form-group">
                <label class="control-label" for="overtime">{{trans('main.overtime')}}</label>
                {{Form::text('overtime', null, [
            "placeholder" => trans('main.overtime'),
            "class" => "form-control floatonly",
            "id" => 'overtime' ])}}
                <span class="help-block text-danger"><strong></strong></span>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label class="control-label" for="additional_overtime">{{trans('main.overtime')}}2</label>
                {{Form::text('additional_overtime', null, [
            "placeholder" => trans('main.overtime'),
            "class" => "form-control floatonly",
            "id" => 'additional_overtime' ])}}
                <span class="help-block text-danger"><strong></strong></span>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label class="control-label" for="deduction_hrs">{{trans('main.deduction_hrs')}}</label>
                {{Form::text('deduction_hrs', null, [
            "placeholder" => trans('main.deduction_hrs'),
            "class" => "form-control floatonly",
            "id" => 'deduction_hrs' ])}}
                <span class="help-block text-danger"><strong></strong></span>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label class="control-label" for="deduction_value">{{trans('main.deduction_value')}}</label>
                {{Form::text('deduction_value', null, [
            "placeholder" => trans('main.deduction_value'),
            "class" => "form-control floatonly",
            "id" => 'deduction_value' ])}}
                <span class="help-block text-danger"><strong></strong></span>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label class="control-label" for="safety">{{trans('main.safety')}}</label>
                {{Form::text('safety', null, [
            "placeholder" => trans('main.safety'),
            "class" => "form-control floatonly",
            "id" => 'safety' ])}}
                <span class="help-block text-danger"><strong></strong></span>
            </div>
        </div>
    @endif
    <div class="col-sm-2">
        <div class="form-group">
            <label class="control-label" for="details">{{trans('main.details')}}</label>
            {{Form::text('details', null, [
        "placeholder" => trans('main.details'),
        "class" => "form-control ",
        "id" => 'details' ])}}
            <span class="help-block text-danger"><strong></strong></span>
        </div>
    </div>
</div>

