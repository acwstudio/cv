<!-- PAGE LEVEL SCRIPTS -->

<script type="text/javascript">

    let form = $('#edit-user');

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

        swal: {
            translations: JSON.parse('{!! $transSwal !!}'),
        },

        sets: {
            mode: 'edit',
            pathMockFile: {
                user: '{{ $user->path }}',
                {{--map: '{{ $category->paths['map'] }}',--}}
                {{--image: '{{ $category->paths['image'] }}',--}}
            },
        }

    });

</script>