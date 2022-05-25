{{--@include('partials.validation-errors')--}}





{!! Field::image('image' , trans('main.logo'),'/'.$model->image) !!}

{!! Field::text('name' , trans('main.company_name')) !!}
{!! Field::text('phone' ,  trans('main.phone')) !!}
{!! Field::text('email' ,  trans('main.email')) !!}
{!! Field::textarea('address' ,  trans('main.address')) !!}



@push('style')
    <link rel="stylesheet" type="text/css"
          href="{{asset('assets/admin/plugins/jasny-bootstrap/css/jasny-bootstrap.min.css')}}"/>
@endpush
@push('script')

    <script type="text/javascript"
            src="{{asset('assets/admin/plugins/jasny-bootstrap/js/jasny-bootstrap.min.js')}}"></script>
@endpush
