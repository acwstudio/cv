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

    cv.datatable({
        test: transDataTable,
        page: '{{ $user->page ? $user->page : 'first' }}',
        table: $('#dataTable'),
    });

</script>