<!-- PAGE LEVEL SCRIPTS -->

<script type="text/javascript">

    let form = $('#store-post');
    //let submit = $('#submit-category');

    cv.dropzone({
        dropzones: form.find("div.dropzone"),
        urlStore: '{{ route('dropzone-store') }}',
        urlDelete: '{{ route('dropzone-delete') }}',
        maxFiles: 1,
        thmbn_h: 160,
        thmbn_w: null,
        mode: 'create',
        method: 'post',
        form: form,
        //submit: submit,
    });

</script>