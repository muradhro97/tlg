<!-- client Modal -->
<div class="modal fade" id="clientModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-700">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center text-dark-blue font-20"
                    id="exampleModalLongTitle">Add Project</h4>
            </div>
            <div class="modal-body">

                {!! Form::open([
                               'action'=>'Admin\AjaxController@saveProject',

                               'class'=>'form-horizontal ',
                               'id'=>'client_form',
                               'method'=>'POST'
                               ])!!}
                <div class="form-group">

                    <label for="name">Name</label>
                    {{Form::text('name',null,[
                           'class'=>'form-control',
                           'placeholder' => 'Name'
                           ])}}
                    <span class="help-block"><strong></strong></span>
                </div>

                <div class="col-sm-6 col-sm-push-3">
                    <div class="text-center">
                        <a href="javascript:void(0)" id="btnSave" class="btn btn-success"
                           onclick="saveClient()">Save
                        </a>
                    </div>
                </div>
                <div class="clearfix"></div>
                {!! Form::close()!!}

                {{--</form>--}}
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->


@push('script')
    <script>
        $('form input').keydown(function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                return false;
            }
        });
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': "{{ csrf_token() }}"


            }

        });

        function saveClient() {
//alert();
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#btnSave').attr('disabled', true); //set button disable

            let url = $("#client_form").attr("action");
//            console.log($("#client_form"));

            $.ajax({
//                statusCode: {
//                    500: function() {
//                        alert("Script exhausted");
//                    }
//                },
                url: url,
                type: "POST",
                data: $('#client_form').serialize(),
                dataType: "JSON",
                success: function (data) {
//                    console.log(data.status);
                    if (data.status) {
{{--                        alertify.alert("{{trans('main.alert')}}", "{{trans('main.save_done_successfully')}}", function(){ alertify.success('Ok'); });--}}

                        alertify.alert()
                            .setting({
                                'label':"{{trans('main.ok')}}",
                                'title':"{{trans('main.alert')}}",
                                'message': "{{trans('main.save_done_successfully')}}" ,

                            }).show();
{{--                        alert("{{trans('main.save_done_successfully')}}");--}}
                        $('select#project_id').append(`<option value="${data.data.id}">${data.data.name}</option>`);
                    } else {
                        alertify.alert()
                            .setting({
                                'label':"{{trans('main.ok')}}",
                                'title':"{{trans('main.alert')}}",
                                'message': "{{trans('main.server_error')}}" ,

                            }).show();
                    }


                    document.getElementById("client_form").reset();

                    $('#btnSave').attr('disabled', false); //set button enable

                    $('#clientModal').modal('hide');

                },
                error: function (data) {
//                     alert("error");
                    $('.form-group').removeClass('has-error'); // clear error class
                    $('.help-block').empty(); // clear error string
                    var errors = data.responseJSON.errors;
//                        console.log(errors);

                    // errorsHtml = '<div class="alert alert-danger"><ul>';

                    $.each(errors, function (key, value) {
//                             console.log(key);
                        // console.log($('[name="' + key + '"]'));
                        $('[name="' + key + '"]').parent().addClass('has-error ');

                        $('[name="' + key + '"]').next().text(value);


                    });
                    // $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable

                }



                // }
            });
        }
    </script>

@endpush