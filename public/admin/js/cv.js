let cv = (function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    Dropzone.autoDiscover = false;

    let dt = {};
    let dz = {};
    let sw = {};
    let sets = {};
    let elems = {};

    function cvInit(props) {

        dt = props.datatable;
        dz = props.dropzone;
        sw = props.swal.translations;
        sets = props.sets;
        elems = props.elems;

        dt ? initDatatable() : null;
        dz ? initDropzone() : null;

        elems.modal_wrap.on('hidden.bs.modal', manageModal);

    }

    let manageModal = function () {
        elems.modal_cont.html(sets.modal_default);
    };

    let initDatatable = function () {
        let table = elems.table.DataTable({
            "language": dt.transDataTable,
        });

        active();
        buttonsAction();
    };

    let initDropzone = function () {

        let dropzones = dz.dropzones;

        dropzones.each(function (index, value) {

            $(value).dropzone({
                thumbnailHeight: dz.thmbn_h,
                thumbnailWidth: dz.thumbn_w,
                autoProcessQueue: dz.autoPQ,
                url: dz.url,
                maxFiles: dz.maxFiles,
                maxFilesize: dz.maxFilesize,
                acceptedFiles: 'image/*',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });

        });

        dropzoneStart();
    };

    let active = function () {

        elems.checkers.on('click', function (e) {
            let parse_id = e.currentTarget.id.split('-');
            let user_id = parse_id[parse_id.length - 1];

            $.ajax({
                url: sets.urlActive,
                type: sets.typeActive,
                data: {
                    id: user_id,
                    model: sets.model,
                    active: $(e.currentTarget).prop('checked') ? 1 : 0,
                },

                success: function (data) {
                    swal({
                        title: data === "1" ? sw.titleActive : sw.titleInactive,
                        text: data === "1" ? sw.textActive : sw.textInactive,
                        icon: data === "1" ? "success" : "warning",
                    });
                },
            });
        });

    };

    let buttonsAction = function () {

        elems.buttons.on('click', function (e) {

            e.preventDefault();

            let parse_id = e.currentTarget.id.split('-');
            let btn_act = parse_id[0];
            let url = e.currentTarget.href;

            if (btn_act === "delete") {
                swal({
                    title: sw.titleConfirm,
                    text: sw.textConfirm,
                    icon: "warning",
                    dangerMode: true,
                    buttons: [
                        sw.cancel,
                        sw.ok,
                    ],
                }).then(function (result) {
                    if (result) {
                        $.ajax({
                            url: url,
                            type: "delete",
                            success: function (data) {
                                console.log(data);
                                if (data) {
                                    swal({
                                        title: sw.titleDeleted,
                                        text: sw.textDeleted,
                                        icon: 'success'
                                    }).then(function () {
                                        location.reload();
                                    });

                                } else {
                                    swal({
                                        title: sw.titleDenied,
                                        text: sw.textDenied,
                                        icon: 'warning'
                                    })
                                }
                            },
                        });
                    } else {
                        swal({
                            title: sw.titleCanceled,
                            text: sw.textCanceled,
                            icon: 'info',
                        })
                    }
                });

            }
            if (btn_act === "show") {

                elems.modal_wrap.modal('show');
                $.ajax({
                    url: url,
                    success: function (data) {
                        elems.modal_cont.html(data);
                    }
                });
            }
        });

    };

    let dropzoneStart = function () {

        let file_id = null;

        dz.dropzones.each(function (index, element) {

            element.dropzone.on("maxfilesreached", function (file) {

                $(element).css("pointer-events", "none");

                if (file.name !== 'mockfile') {
                    swal({
                        text: "You reached limit!",
                        icon: "warning"
                    });
                }

            });

            element.dropzone.on("addedfile", function (file) {
                file_id = Math.floor(Math.random() * 100001);
                // Create the remove button
                let removeButton = Dropzone.createElement("<button style='pointer-events: auto' " +
                    "id=" + file_id + " " +
                    "class='btn btn-sm btn-danger btn-block'>" + "Remove file</button>");

                // Listen to the click event
                removeButton.addEventListener("click", function (e) {

                    e.preventDefault();
                    e.stopPropagation();
                    // Remove the file preview and from server.
                    element.dropzone.removeFile(file);

                    if (file.name !== 'mockfile') {
                        if (dz.mode === 'edit') {
                            let mockFile = {name: "mockfile", size: 12345};
                            createMockFile(element.dropzone, dz, mockFile);
                        }
                        $.ajax({
                            url: dz.urlDelete,
                            type: 'post',
                            data: {
                                fileName: $(removeButton).data('fileName'),
                                useImage: element.id,
                            },

                            success: function (data) {
                                console.log(data);
                            },
                        });
                    }

                });

                file.previewElement.appendChild(removeButton);
            });

            element.dropzone.on("removedfile", function () {

                $(element).css("pointer-events", "auto");

            });

            element.dropzone.on('sending', function (data, xhr, formData) {

                formData.append("fileId", file_id);
                formData.append("useImage", element.id);

            });

            element.dropzone.on("success", function (file, response) {
                console.log(response);
                $('#' + file_id).data('fileName', response);

            });

            let createMockFile = function (dropzone, param, mockFile) {

                for (const [key, value] of Object.entries(dz.pathMockFile)) {

                    if (element.id === key) {
                        element.dropzone.emit("addedfile", mockFile);
                        element.dropzone.emit("maxfilesreached", mockFile);
                        element.dropzone.emit("thumbnail", mockFile, value);
                        element.dropzone.emit("complete", mockFile);
                    }
                }

                $(".dz-image img").css('height', dz.thmbn_h);

            };

            if (dz.mode === 'edit') {
                let mockFile = {name: "mockfile", size: 12345};
                createMockFile(element.dropzone, props, mockFile);
            }

        });
    };

    return {
        init: cvInit,
    }

})();