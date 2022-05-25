@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>'المحافظات'])
@stop
@section('content')

    <div class="ibox ibox-primary">
        <div class="ibox-title">
            <h5>بحث </h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content m-b-sm border-bottom">

            {!! Form::open([
                  'method' => 'GET'
              ]) !!}
            <div class="row">



                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="name">الاسم</label>
                        <input type="text" id="name" name="name" value="{{request()->name}}"
                               placeholder="الاسم"
                               class="form-control">
                    </div>
                </div>





            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-sm-2 ">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        <button type="submit" class="btn btn-flat  btn-primary btn-md">بحث</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="ibox ibox-primary">
        <div class="ibox-title">
            <h5>المحافظات</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="pull-right">
                <a href="{{url('admin/state/create')}}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> اضافة جديد
                </a>
            </div>
            <div class="clearfix"></div>
            <br>


            @if($rows->count()>0)
                <div class="table-responsive">
                    <table class="data-table table table-bordered">
                        <thead>
                        <th>#</th>
                        <th>الاسم</th>

                        <th class="text-center">تعديل</th>
                        <th class="text-center">حذف</th>
                        </thead>
                        <tbody>
                        @php $count = 1; @endphp
                        @foreach($rows as $row)
                            <?php
                            $iteration = $loop->iteration + (($rows->currentPage() - 1) * $rows->perPage())
                            ?>
                            <tr>
                                <td>{{$iteration}}</td>
                                <td>{{$row->name}}</td>

                                <td class="text-center"><a href="{{url('admin/state/'.$row->id.'/edit')}}"
                                                           class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>
                                </td>
                                <td class="text-center">
                                    {{Form::open(array('method'=>'delete','class'=>'delete','url'=>url('admin/state/'.$row->id) )) }}
                                    <button type="submit" class="destroy btn btn-danger btn-xs"><i
                                                class="fa fa-trash-o"></i></button>
                                    {{Form::close()}}
                                </td>
                            </tr>
                            @php $count ++; @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    {!! $rows->appends(request()->except('page'))->links() !!}
                </div>
            @else
                <h2 class="text-center">لا يوجد بيانات</h2>
            @endif
            <div class="clearfix"></div>
        </div>
    </div>
@stop