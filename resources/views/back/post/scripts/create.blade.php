<!-- PAGE LEVEL SCRIPTS -->

<script type="text/javascript">

    let form = $('#store-post');
    let category = $('#form_category');
    let tag = $('#form_tag');

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
        },

        select2: {
            placeholder: {
                category: '{{ __('forms.ph-post.category') }}',
                tag: '{{ __('forms.ph-post.tag') }}',
            },

        },

        swal: {
            translations: JSON.parse('{!! $transSwal !!}'),
        },

        sets: {
            mode: 'create',
        },

        elems: {
            /* Select2 elements */
            select: {
                category: category,
                tag: tag,
            },
        },

    });

</script>