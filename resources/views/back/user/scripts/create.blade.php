<!-- PAGE LEVEL SCRIPTS -->

<script type="text/javascript">

    let form = $('#store-post');
    //let submit = $('#submit-category');

    cv.init({
        dropzone: {
            dropzones: form.find("div.dropzone"),
            url: '{{ route('dropzone-store') }}',
            urlDelete: '{{ route('dropzone-delete') }}',
            autoPQ: true,
            maxFiles: 1,
            maxFilesize: 1,
            acceptedFiles: 'image/*',
            thmbn_h: 160,
            thmbn_w: null,
            mode: 'create',
        },

        {{--method: 'post',--}}
        {{--form: form,--}}
        //submit: submit,
    });

</script>