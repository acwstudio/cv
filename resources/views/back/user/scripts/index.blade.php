<!-- PAGE LEVEL SCRIPTS -->

<script type="text/javascript">

    let transDataTable = {
        "lengthMenu": "{{ __('tables.datatable.lengthMenu') }}",
        "zeroRecords": "{{ __('tables.datatable.zeroRecords') }}",
        "info": "{{ __('tables.datatable.info') }}",
        "infoEmpty": "{{ __('tables.datatable.infoEmpty') }}",
        "infoFiltered": "{{ __('tables.datatable.infoFiltered') }}",
        "search": "{{ __('tables.datatable.search') }}",
        "paginate": {
            "first": "{{ __('tables.datatable.paginate.first') }}",
            "previous": "{{ __('tables.datatable.paginate.previous') }}",
            "next": "{{ __('tables.datatable.paginate.next') }}",
            "last": "{{ __('tables.datatable.paginate.last') }}"
        },
    };

    let transActivator = {

    };

    let swalTrans = {
        titleConfirm: "{{ __('swal.user.title-confirm') }}",
        textConfirm: "{{ __('swal.user.text-confirm') }}",
        cancel: "{{ __('swal.user.cancel') }}",
        ok: "{{ __('swal.user.ok') }}",
    };

    cv.init({
        datatable: {
            translations: transDataTable,
            page: '{{ $user->page ? $user->page : 'first' }}',
            table: $('#dataTable'),
            checkers: $('td .custom-control-input'),
            buttons: $('td .btn'),
        },
        translations: {
            swal: swalTrans,
        },
        activator: {
            model: "user",
            url: "{{ route('activator') }}",
            type: 'post',
        },
    });

</script>