<!-- PAGE LEVEL SCRIPTS -->

<script type="text/javascript">

    let form = $('#store-post');
    //let submit = $('#submit-category');

    let swalTrans = {
        titleConfirm: "{{ __('swal.global.title-confirm') }}",
        titleDenied: "{{ __('swal.global.title-denied') }}",
        titleCanceled: "{{ __('swal.global.title-canceled') }}",
        titleDeleted: "{{ __('swal.global.title-deleted') }}",
        titleActive: "{{ __('swal.global.title-active') }}",
        titleInactive: "{{ __('swal.global.title-inactive') }}",
        textConfirm: "{{ __('swal.user.text-confirm') }}",
        textDenied: "{{ __('swal.user.text-denied') }}",
        textCanceled: "{{ __('swal.user.text-canceled') }}",
        textDeleted: "{{ __('swal.user.text-deleted') }}",
        textActive: "{{ __('swal.user.text-active') }}",
        textInactive: "{{ __('swal.user.text-inactive') }}",
        cancel: "{{ __('swal.global.cancel') }}",
        ok: "{{ __('swal.global.ok') }}",
    };

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

        translations: {
            swal: swalTrans,
        },

    });

</script>