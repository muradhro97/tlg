<div class="input-field">
    <label class="active">{{trans('main.documents')}}</label>

    <div class="input-images-1" style="padding-top: .5rem;"></div>
</div>


@push('style')
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <link rel="stylesheet" type="text/css"
          href="{{asset('assets/admin/plugins/jquery-image-uploader-preview-and-delete/image-uploader.min.css')}}"/>

@endpush
@push('script')


    <script type="text/javascript"
            src="{{asset('assets/admin/plugins/jquery-image-uploader-preview-and-delete/image-uploader.min.js')}}"></script>

    <script>

        $('.input-images-1').imageUploader({
            label: "{{trans('main.drag_drop_files')}}",
//            imagesInputName: 'Custom Name',
        });

    </script>
@endpush