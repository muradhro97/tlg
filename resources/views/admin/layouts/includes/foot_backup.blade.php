</div>

<!-- Mainly scripts -->
<script src="{{asset('assets/admin/js/jquery-2.1.1.js')}}"></script>
<script src="{{asset('assets/admin/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
<script src="{{asset('assets/admin/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

<!-- Custom and plugin javascript -->
<script src="{{asset('assets/admin/js/inspinia.js')}}"></script>
<script src="{{asset('assets/admin/js/plugins/pace/pace.min.js')}}"></script>
<script src="{{asset('assets/admin/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{asset('assets/admin/plugins/toastr/toastr.min.js')}}"></script>
{{--<script src="{{asset('assets/admin/plugins/lobibox/dist/js/lobibox.js')}}"></script>--}}
{{--<script src="{{asset('assets/admin/plugins/lobibox/dist/js/messageboxes.min.js')}}"></script>--}}
{{--<script src="{{asset('assets/admin/plugins/lobibox/dist/js/notifications.min.js')}}"></script>--}}
<script src="{{asset('assets/admin/plugins/jquery-ui-1.12.1/jquery-ui.min.js')}}"></script>

<script src="{{asset('assets/admin/js/script.js')}}"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>


    toastr.options = {
        "closeButton": true,
        "debug": false,
        "progressBar": false,
        "preventDuplicates": false,
        "positionClass": "toast-top-left",
        "onclick": null,
        "showDuration": "40000",
        "hideDuration": "1000",
        "timeOut": "700000",
        "extendedTimeOut": "100000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        rtl: true,
        sounds: {

            info: "https://res.cloudinary.com/dxfq3iotg/video/upload/v1557233294/info.mp3",
// path to sound for successfull message:
            success: "https://res.cloudinary.com/dxfq3iotg/video/upload/v1557233524/success.mp3",
// path to sound for warn message:
            warning: "https://res.cloudinary.com/dxfq3iotg/video/upload/v1557233563/warning.mp3",
// path to sound for error message:
            error: "https://res.cloudinary.com/dxfq3iotg/video/upload/v1557233574/error.mp3",
        },
    }
    Command: toastr["success"]("السلام عليكم","حاتم")
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('f801d5fd7d691aaaa000', {
        cluster: 'eu'
    });

    var channel = pusher.subscribe('admin');
    channel.bind('admin', function(data) {
        alert(JSON.stringify(data));
    });
</script>
@stack('script')
</body>

</html>
