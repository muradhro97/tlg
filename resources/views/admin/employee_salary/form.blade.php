@include('partials.validation-errors')


@inject('worker','App\Worker')
@inject('safe','App\Safe')

<?php



$safes = $safe->oldest()->pluck('name', 'id')->toArray();


$workers = $worker->latest()->pluck('name', 'id')->toArray();
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

        {!! Field::select('worker_id' , trans('main.workers'),$workers,trans('main.select_worker')) !!}
    </div>
    <div class="col-md-6">

        {!! Field::select('safe_id' , trans('main.safe'),$safes,trans('main.select_safe')) !!}
    </div>


</div>


{!! Field::textarea('details' , trans('main.details') ) !!}

