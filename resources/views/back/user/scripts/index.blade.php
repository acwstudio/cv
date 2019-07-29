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