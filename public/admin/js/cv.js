let cv = (function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    Dropzone.autoDiscover = false;

    let initDataTable = function (param) {

        let table = param.table.DataTable({
            "language": param.test,
        });

        table.page(param.page).draw('page');

    };

    let activitySwitcher = function (checkboxes) {

        let checkers = checkboxes.checker;

        let handler = function (e) {
            $.ajax({
                url: checkboxes.url,
                type: 'post',
                data: {
                    id: e.currentTarget.id,
                    model: checkboxes.model,
                    active: $(e.currentTarget).prop('checked') ? 1 : 0,
                },

                success: function (data) {
                    console.log(data);
                },
            });
        };

        checkers.on('click', handler);
    };

    let initDropzone = function (props) {
        console.log(props);

        let dropzones = props.dropzones;

        let i;
        console.log(dropzones);
        dropzones.each(function (index, value) {
            $(value).dropzone({
                thumbnailHeight: props.thmbn_h,
                thumbnailWidth: props.thumbn_w,
                autoProcessQueue: true,
                url: props.urlStore,
                maxFiles: props.maxFiles,
                maxFilesize: 1,
                acceptedFiles: 'image/*',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });

        });

        createItem(props);

    };

    let createItem = function (props) {

        let file_id = null;

        props.dropzones.each(function (index, element) {
            console.log(element.id);
            element.dropzone.on("maxfilesreached", function (file) {

                $(element).css("pointer-events", "none");

                if (file.name !== 'mockfile') {
                    // swal({
                    //     text: "You reached limit!",
                    //     icon: "warning"
                    // });
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
                        if (props.mode === 'edit') {
                            let mockFile = {name: "mockfile", size: 12345};
                            createMockFile(element.dropzone, props, mockFile);
                        }
                        $.ajax({
                            url: props.urlDelete,
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

                for (const [key, value] of Object.entries(props.pathMockFile)) {

                    if (element.id === key) {
                        element.dropzone.emit("addedfile", mockFile);
                        element.dropzone.emit("maxfilesreached", mockFile);
                        element.dropzone.emit("thumbnail", mockFile, value);
                        element.dropzone.emit("complete", mockFile);
                    }
                }

                $(".dz-image img").css('height', param.thmbn_h);

            };

            if (props.mode === 'edit') {
                let mockFile = {name: "mockfile", size: 12345};
                createMockFile(element.dropzone, props, mockFile);
            }

        });

    };

    return {
        datatable: initDataTable,
        dropzone: initDropzone,
        active: activitySwitcher,
    }

})();