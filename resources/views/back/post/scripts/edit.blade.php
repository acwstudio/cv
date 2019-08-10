<!-- PAGE LEVEL SCRIPTS -->

<script type="text/javascript">

    let form = $('#edit-post');
    let category = $('#form_category');
    let tag = $('#form_tag');
    let summernote = $('#form_body');

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

        select2: {
            placeholder: {
                category: '{{ __('forms.ph-post.category') }}',
                tag: '{{ __('forms.ph-post.tag') }}',
            },

        },

        swal: {
            translations: JSON.parse('{!! $transSwal !!}'),
        },

        summernote: {
            lang: '{{ app()->getLocale() === 'ru' ? 'ru-RU' : '' }}'
        },

        sets: {
            mode: 'edit',
            pathMockFile: {
                post: '{{ $postItem->path }}',
            },
        },

        elems: {
            /* Select2 elements */
            select: {
                category: category,
                tag: tag,
            },
            /* Summernote elements */
            summernote: summernote,
        },

    });

</script>