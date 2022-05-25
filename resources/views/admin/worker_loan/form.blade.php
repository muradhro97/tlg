@include('partials.validation-errors')


@inject('worker','App\Worker')
@inject('safe','App\Safe')

<?php



$safes = $safe->oldest()->pluck('name', 'id')->toArray();


$workers = $worker->where('working_status','work')->latest()->pluck('name', 'id')->toArray();
?>

<div class="row">
    <div class="col-md-6">

        {!! Field::date('date' , trans('main.date') ) !!}
    </div>
    <div class="col-md-6">
        {!! Field::floatOnly('amount' , trans('main.amount') ) !!}

    </div>

</div>


<div class="row">
    <div class="col-md-6">

        {!! Field::multiSelect('worker_ids' , trans('main.workers'),$workers,trans('main.select_workers')) !!}
    </div>
    <div class="col-md-6">

        {!! Field::select('safe_id' , trans('main.safe'),$safes,trans('main.select_safe')) !!}
    </div>


</div>


{!! Field::textarea('details' , trans('main.details') ) !!}
<hr>
<div class="table-responsive">
    <table class="data-table table table-bordered">
        <thead>

        <th>#</th>
        <th>{{trans('main.name')}}</th>


        </thead>
        <tbody class="item-append-area">

        </tbody>
    </table>
</div>
<hr>
