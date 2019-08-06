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

    @if(session()->has('sw-success'))
    swal({
        title: 'Create User',
        text: '{{ session()->get('sw-success') }}',
        icon: 'success',
    });
    @endif

</script>