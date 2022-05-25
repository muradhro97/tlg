@if(isset($errors) && sizeof($errors))

    <p class="alert alert-danger col-md-12">

    @foreach($errors->all() as $error)
        * {{$error}} <br>
    @endforeach
    </p>
@endif

