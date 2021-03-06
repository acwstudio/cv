<!-- PAGE LEVEL SCRIPTS -->

<script type="text/javascript">

    let modalContent = $('.modal-content');

    cv.init({
        datatable: {
            translations: JSON.parse('{!! $transDataTable !!}'),
        },

        swal: {
            translations: JSON.parse('{!! $transSwal !!}'),
        },

        elems: {
            /* DataTable elements */
            table: $('#dataTable'),
            checkers: $('td .custom-control-input'),
            buttons: $('td .btn'),
            /* Modal elements */
            modal_wrap: $('#myModal'),
            modal_cont: modalContent,
        },

        sets: {
            modal_default: modalContent.html(),
            model: "post",
            /* Ajaxes settings*/
            typeActive: 'post',
            urlActive: "{{ route('activator') }}",
        },
    });

    @if(session()->has('sw-title'))
    swal({
        title: '{{ session()->get('sw-title') }}',
        text: '{{ session()->get('sw-text') }}',
        icon: 'success',
    });
    @endif

</script>