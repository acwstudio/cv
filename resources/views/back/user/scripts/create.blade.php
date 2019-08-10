<!-- PAGE LEVEL SCRIPTS -->

<script type="text/javascript">

    let form = $('#store-user');

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
            dictDefaultMessage: '{{ __('forms.dropzone.dictDefaultMessage') }}',
            dictFileTooBig: '{{ __('forms.dropzone.dictFileTooBig') }}',
            dictInvalidFileType: '{{ __('forms.dropzone.dictInvalidFileType') }}',
        },

        swal: {
            translations: JSON.parse('{!! $transSwal !!}'),
        },

        sets: {
            mode: 'create',
        }

    });

</script>