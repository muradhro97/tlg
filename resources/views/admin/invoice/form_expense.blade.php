@include('partials.validation-errors')


@inject('employee','App\Employee')
@inject('expenseItem','App\ExpenseItem')

@inject('safe','App\Safe')
@inject('project','App\Project')
@inject('organization','App\Organization')
<?php



$safes = $safe->oldest()->pluck('name', 'id')->toArray();

$employees = $employee->latest()->pluck('name', 'id')->toArray();
$expenseItems = $expenseItem->latest()->pluck('name', 'id')->toArray();

$organizations = $organization->latest()->pluck('name', 'id')->toArray();
$projects = $project->latest()->pluck('name', 'id')->toArray();


?>
<div class="tabs-container">
    <ul class="nav nav-tabs">
        @can('addInvoice')
            <li class=""><a href="{{url('admin/invoice/create')}}"> {{trans('main.invoices')}}</a></li>
        @endcan
        @can('addExpense')
            <li class="active"><a href="#">{{trans('main.expenses')}}</a></li>
        @endcan

    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <div class="panel-body">

                <input type="hidden" name="total" id="total">
                <input type="hidden" name="items" id="items">
                <div class="row">
                    <div class="col-md-6">

                        {!! Field::date('date' , trans('main.date') ) !!}
                    </div>
                    {{--<div class="col-md-6">--}}

                    {{--{!! Field::select('organization_id' , trans('main.organization'),$organizations,trans('main.select_organization')) !!}--}}
                    {{--</div>--}}


                </div>
                <div class="row">
                    <div class="col-md-6">

                        {!! Field::select('project_id' , trans('main.project'),$projects,trans('main.select_project')) !!}
                    </div>

                    <div class="col-md-6">

                        {!! Field::select('organization_id' , trans('main.organization'),$organizations,trans('main.select_organization')) !!}
                    </div>


                </div>


                {{--<div class="row">--}}
                {{--<div class="col-md-6">--}}

                {{--{!! Field::select('labors_department_id' , trans('main.labors_departments'),$labors_departments,trans('main.labors_departments')) !!}--}}
                {{--</div>--}}
                {{--<div class="col-md-6">--}}
                {{--{!! Field::select('labors_type' , trans('main.labors_type'),$laborsTypeOptions,trans('main.labors_type')) !!}--}}

                {{--</div>--}}

                {{--</div>--}}


                <div class="row">
                    <div class="col-md-6">
                        {!! Field::select('employee_id' , trans('main.submitted_by'),$employees,trans('main.select_employee')) !!}
                        <label for="is_on_custody">{{trans('main.is_on_custody')}}</label>
                        <input id="is_on_custody" type="checkbox" name="is_on_custody" value="1">
                    </div>

                    <div class="col-md-6">

                        {!! Field::select('safe_id' , trans('main.payment_type'),$safes,trans('main.select_payment_type')) !!}
                    </div>


                </div>


                <div class="row">

                    <div class="col-md-6">


                        {!! Field::textarea('details' , trans('main.details') ) !!}
                    </div>


                </div>


                <div class=" row">
                    <div class="col-xs-3" style="padding-right: 5px;">

                        {{Form::select('expense_item_id', $expenseItems, null, [
                                                         "class" => "form-control select2 " ,
                                                         "id" => "expense_item_id" ,

                                                         "placeholder" =>trans('main.expense_item')
                                                     ])}}
                    </div>
                    <div class="col-xs-3" style="padding-right: 5px;">

                        {{--<input type="text" class="form-control">--}}
                        {{Form::text('item_name', null, [   "placeholder" => trans('main.item_name'),"class" => "form-control ",   ])}}
                        <span class="help-block text-danger"><strong></strong></span>
                    </div>
                    <div class="col-xs-2" style="padding-right: 5px;">

                        {{--<input type="text" class="form-control">--}}
                        {{Form::text('quantity', null, [   "placeholder" => trans('main.quantity'),"class" => "form-control floatonly",   ])}}
                        <span class="help-block text-danger"><strong></strong></span>
                    </div>
                    <div class="col-xs-2" style="padding-right: 5px;">
                        {{Form::text('price', null, [  "placeholder" =>trans('main.price'), "class" => "form-control floatWithNegative", ])}}
                        <span class="help-block text-danger"><strong></strong></span>
                    </div>
                    <div class="col-xs-2" style="padding-right: 5px;">

                    </div>
                    <div class="col-xs-2" style="padding-right: 5px;">
                        <button type="button" class="btn btn-success" id="add-item">{{trans('main.add')}}</button>
                    </div>

                </div>
                <hr>
                <div class="table-responsive">
                    <table class="data-table table table-bordered">
                        <thead>
                        {{--<th>#</th>--}}
                        <th>{{trans('main.expense_item')}}</th>
                        <th>{{trans('main.item_name')}}</th>
                        <th>{{trans('main.quantity')}}</th>
                        <th>{{trans('main.price')}}}</th>
                        <th>{{trans('main.total')}}</th>

                        <th class="text-center">{{trans('main.delete')}}</th>
                        </thead>
                        <tbody class="item-append-area">

                        <tr>

                        </tr>

                        <tr style=" border: 2px dashed #3c8dbc;">
                            <td colspan="4">Net</td>
                            <td colspan="2" class="total">0</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <hr>


                @include('partials.images_uploader')
            </div>
        </div>
        <div id="tab-2" class="tab-pane">
            <div class="panel-body">

                Expenses area by hatem
            </div>
        </div>
    </div>


</div>



