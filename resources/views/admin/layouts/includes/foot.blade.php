</div>

<!-- Mainly scripts -->
<script src="{{asset('assets/admin/js/jquery-2.1.1.js')}}"></script>
{{--<script src="{{asset('assets/admin/js/jquery-3.1.1.min.js')}}"></script>--}}
<script src="{{asset('assets/admin/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
<script src="{{asset('assets/admin/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

<!-- Custom and plugin javascript -->
<script src="{{asset('assets/admin/js/inspinia.js')}}"></script>
<script src="{{asset('assets/admin/js/plugins/pace/pace.min.js')}}"></script>
<script src="{{asset('assets/admin/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{asset('assets/admin/plugins/alertifyjs/alertify.min.js')}}"></script>
<script src="{{asset('assets/admin/plugins/toastr/toastr.min.js')}}"></script>
<script src="{{asset('assets/admin/js/jquery.repeater.min.js')}}"></script>

<!-- FooTable -->
<script src="{{asset('assets/admin/plugins/footable/footable.all.min.js')}}"></script>
{{--<script src="{{asset('assets/admin/plugins/lobibox/dist/js/lobibox.js')}}"></script>--}}
{{--<script src="{{asset('assets/admin/plugins/lobibox/dist/js/messageboxes.min.js')}}"></script>--}}
{{--<script src="{{asset('assets/admin/plugins/lobibox/dist/js/notifications.min.js')}}"></script>--}}
<script src="{{asset('assets/admin/plugins/jquery-ui-1.12.1/jquery-ui.min.js')}}"></script>

{{--<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>--}}
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

<script type="text/javascript" src="{{ url('assets/admin/plugins/axios/axios.js') }}"></script>
<script src="{{asset('assets/admin/js/script.js')}}"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<script>
    $(document).ready(function () {
        $('.repeater').repeater({
            // (Optional)
            // start with an empty list of repeaters. Set your first (and only)
            // "data-repeater-item" with style="display:none;" and pass the
            // following configuration flag
            /*initEmpty: true,*/
            // (Optional)
            // "defaultValues" sets the values of added items.  The keys of
            // defaultValues refer to the value of the input's name attribute.
            // If a default value is not specified for an input, then it will
            // have its value cleared.
            /*defaultValues: {
                'text-input': 'foo'
            },*/
            // (Optional)
            // "show" is called just after an item is added.  The item is hidden
            // at this point.  If a show callback is not given the item will
            // have $(this).show() called on it.
            show: function () {
                $(this).slideDown();
                $('.select2').each(function () {
                    var $this = $(this);
                    $this.siblings('.select2-container').remove();
                    $this.select2({
                    });
                });
            },
            // (Optional)
            // "hide" is called when a user clicks on a data-repeater-delete
            // element.  The item is still visible.  "hide" is passed a function
            // as its first argument which will properly remove the item.
            // "hide" allows for a confirmation step, to send a delete request
            // to the server, etc.  If a hide callback is not given the item
            // will be deleted.
            hide: function (deleteElement) {
                if(confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            },
            // // (Optional)
            // // You can use this if you need to manually re-index the list
            // // for example if you are using a drag and drop library to reorder
            // // list items.
            // ready: function (setIndexes) {
            //     $dragAndDrop.on('drop', setIndexes);
            // },
            // (Optional)
            // Removes the delete button from the first list item,
            // defaults to false.
            isFirstItemUndeletable: true
        })
    });
</script>

<script>
    $(document).ready( function () {
        // Using `buttons.buttons`
        var table = $('#myTable').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                { extend: 'copyHtml5', footer: true },
                { extend: 'excelHtml5', footer: true },
                { extend: 'pdfHtml5', footer: true }
            ]
        } );

        var table = $('.myTable').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                { extend: 'copyHtml5', footer: true },
                { extend: 'excelHtml5', footer: true },
                { extend: 'pdfHtml5', footer: true }
            ]
        } );


        $('#checkall').click(function(event) {  //on click
            var checked = this.checked;
            table.column(0).nodes().to$().each(function(index) {
                if (checked) {
                    $(this).find('.checkbox1').prop('checked', 'checked');
                } else {
                    $(this).find('.checkbox1').removeProp('checked');
                }
            });
            table.draw();
        });

        $('#myForm').on('submit', function(e){
            var form = this;

            // Iterate over all checkboxes in the table
            table.$('input[type="checkbox"]').each(function(){
                // If checkbox doesn't exist in DOM
                if(!$.contains(document, this)){
                    // If checkbox is checked
                    if(this.checked){
                        // Create a hidden element
                        $(form).append(
                            $('<input>')
                                .attr('type', 'hidden')
                                .attr('name', this.name)
                                .val(this.value)
                        );
                    }
                }
            });


        });
        $('#myForm').on('submit', function(e){
            var form = this;

            // Iterate over all checkboxes in the table
            table.$('input[type="number"]').each(function(){
                // If checkbox doesn't exist in DOM
                if(!$.contains(document, this)){
                    $(form).append(
                        $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', this.name)
                            .val(this.value)
                    );
                }
            });
        });

    } );
</script>
<script type="text/javascript">
    $(document).ready(function(){
        // ajax
        $('#organization_id').on('change', function (){
            var organization_id = $(this).val();
            $.ajax({
                url: `{{request()->getBaseUrl()}}/admin/organization/${organization_id}/projects`,
            }).done(function(data) {
                $('#sub_contract_container').html(data);
                $('.select2').select2();

                $('#sub_contract_id').on('change', function (){
                    console.log('sadsa');
                    var sub_contract_id = $(this).val();
                    $.ajax({
                        url: `{{request()->getBaseUrl()}}/admin/sub_contract/${sub_contract_id}/items`,
                    }).done(function(data) {
                        $('#items_container').html(data);
                        $('.select2').select2();
                    });
                })
            });

            $.ajax({
                url: `{{request()->getBaseUrl()}}/admin/organization/${organization_id}/contracts`,
            }).done(function(data) {
                $('#contract_container').html(data);
                $('.select2').select2();

                $('#contract_id').on('change', function (){
                    var contract_id = $(this).val();
                    $.ajax({
                        url: `{{request()->getBaseUrl()}}/admin/contract/${contract_id}/items`,
                    }).done(function(data) {
                        $('#items_container').html(data);
                        $('.select2').select2();
                    });
                })
            });

        })
    });

    $(document).ready(function(){
        // ajax
        $('#sub_contract_id').on('change', function (){
            console.log('sadsa');
            var sub_contract_id = $(this).val();
            $.ajax({
                url: `{{request()->getBaseUrl()}}/admin/sub_contract/${sub_contract_id}/items`,
            }).done(function(data) {
                $('#items_container').html(data);
                $('.select2').select2();
            });
        })
    });
</script>
<script>


    alertify.defaults.glossary.title = "{{trans('main.confirmation_message')}}";
    alertify.defaults.glossary.ok = "{{trans('main.yes')}}";
    alertify.defaults.glossary.cancel = "{{trans('main.no')}}";
    $(".delete").on("submit", function (event) {
        event.preventDefault();
        // console.log($(this)[0]);
        var form = $(this)[0];

        // alert("hatem");
        // return confirm('هل انت متاكد من الحذف ؟');
        alertify.confirm("{{trans('main.delete_confirmation')}}", function (e) {
            if (e) {
                // alert(1);
                form.submit();
                // $(this)[0].submit();
                return true;
            } else {
                return false;
            }
        });
        //
        // Run
        // Overloads
        // return confirm("Are you sure?");
    });
    $(".deleteGet").on("click", function (event) {
        event.preventDefault();
        // console.log($(this)[0]);
        var link = $(this);

        // alert("hatem");
        // return confirm('هل انت متاكد من الحذف ؟');
        alertify.confirm("{{trans('main.delete_confirmation')}}", function (e) {
            if (e) {
                // alert(1);
                window.location = link.attr('href');
                // $(this)[0].submit();
                return true;
            } else {
                return false;
            }
        });
        //
        // Run
        // Overloads
        // return confirm("Are you sure?");
    });
    $(".floatonly").keypress(function (event) {
//        console.log(event.which);
        //if the letter is not digit then display error and don't type anything
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            //display error message
            // console.log( $(this).next().next());
            $(this).next().text("{{trans('main.number_only')}}").show().fadeOut(2000);
            return false;
        }
    });
    $(".floatWithNegative").keypress(function (event) {
//        console.log($(this).val());
//        console.log(event.which);
        //if the letter is not digit then display error and don't type anything
        if (event.which == 45 && $(this).val() == "") {
            return true;
        }
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            //display error message
            // console.log( $(this).next().next());
            $(this).next().text("{{trans('main.number_only')}}").show().fadeOut(2000);
            return false;
        }
    });
    $(".numberonly").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            // console.log( $(this).next().next());
            $(this).next().text("{{trans('main.number_only')}}").show().fadeOut(2000);
            return false;
        }
    });

</script>
<?php
$channel = auth()->user()->id;
$event = 'notification';
?>
<script type="text/javascript">
    //loader
    $(function () {
        $('.loader-container').delay(500).fadeOut();
    });

    Pusher.logToConsole = true;

    var pusher = new Pusher('7e4fd4d8f2379a0f6132', {
        cluster: 'eu'
    });


    function playSound() {
        const audio = new Audio("{{url('assets/admin/sounds/notification.mp3')}}");
        audio.play();
    }

    let route = "{{url("admin/get-notifications")}}";

    var channel = pusher.subscribe("{{$channel}}");
    channel.bind("{{$event}}", function (data) {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "progressBar": true,
            "preventDuplicates": false,
            "positionClass": "toast-top-right",
//        "onclick": null,
            "showDuration": "400",
            "hideDuration": "1000",
            "timeOut": "7000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
//        rtl: true,

        };
        let link = data.link;

        toastr.options.onclick = function () {
            window.location.href = link;
        };
        playSound();
        Command: toastr["warning"](data.message, data.title);
        axios.post(route).then((response) => {
            let data = response.data;

            $(".notifications-area").html(data.html);
        });
    });

    {{--toastr.options.onclick = function () {--}}
    {{--window.location.href = "{{url("admin/employee")}}" ;--}}
    {{--};--}}

    {{--Command: toastr["info"]("ss", "dd");--}}
</script>

<script src="{{asset('assets/admin/js/printThis.js')}}"></script>
{{-- <script src="{{asset('assets/admin/js/jquery-2.1.1.js')}}"></script> --}}
<script>
    $(document).ready( function () {
$('#prinbtThis').on('click' , function (){
console.log('hi mr mohamed ')     
$('#tablePrint').printThis({
importCSS:true,
importStyle:true,
loadCSS:"../../public/css/custom.css",

})
})
})

</script>
@toastr_render
@stack('script')
@stack('script2')
@stack('location-picker')

</body>

</html>
