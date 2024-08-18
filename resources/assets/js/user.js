'use strict';


$(function() {

    let url = $('#routeData').data('url');
    let dt_adv_filter_table = $('.dt-advanced-search');


    // Advanced Search Functions Starts
    // --------------------------------------------------------------------

    // Datepicker for advanced filter
    let rangePicker = $('.flatpickr-range'),
        dateFormat = 'MM/DD/YYYY';

    if (rangePicker.length) {
        rangePicker.flatpickr({
            mode: 'range',
            dateFormat: 'm/d/Y',
            orientation: isRtl ? 'auto right' : 'auto left',
            locale: {
                format: dateFormat
            },
            onClose: function(selectedDates, dateStr, instance) {
                var startDate = '',
                    endDate = new Date();
                if (selectedDates[0] !== undefined) {
                    startDate = moment(selectedDates[0]).format('MM/DD/YYYY');
                    startDateEle.val(startDate);
                }
                if (selectedDates[1] !== undefined) {
                    endDate = moment(selectedDates[1]).format('MM/DD/YYYY');
                    endDateEle.val(endDate);
                }
                $(rangePicker).trigger('change').trigger('keyup');
            }
        });
    }


    // Advance filter function
    // We pass the column location, the start date, and the end date
    $.fn.dataTableExt.afnFiltering.length = 0;
    let filterByDate = function(column, startDate, endDate) {
        // Custom filter syntax requires pushing the new filter to the global filter array
        $.fn.dataTableExt.afnFiltering.push(function(oSettings, aData, iDataIndex) {
            let rowDate = normalizeDate(aData[column]),
                start = normalizeDate(startDate),
                end = normalizeDate(endDate);

            // If our date from the row is between the start and end
            if (start <= rowDate && rowDate <= end) {
                return true;
            } else if (rowDate >= start && end === '' && start !== '') {
                return true;
            } else if (rowDate <= end && start === '' && end !== '') {
                return true;
            } else {
                return false;
            }
        });
    };

    // converts date strings to a Date object, then normalized into a YYYYMMMDD format (ex: 20131220). Makes comparing dates easier. ex: 20131220 > 20121220
    let normalizeDate = function(dateString) {
        let date = new Date(dateString);
        return date.getFullYear() + '' + ('0' + (date.getMonth() + 1)).slice(-2) + '' + ('0' + date.getDate()).slice(-2);
    };
    // Advanced Search Functions Ends

    // Filter column wise function
    let name = null;

    function filterColumn(i, val) {
        console.log(i, val);

        if (i == 1) {
            name = val;
        }

        if (i === 5) {
            const startDate = startDateEle.val(),
                endDate = endDateEle.val();
            if (startDate !== '' && endDate !== '') {
                $.fn.dataTableExt.afnFiltering.length = 0; // Reset datatable filter
                dt_adv_filter_table.dataTable().fnDraw(); // Draw table after filter
                filterByDate(i, startDate, endDate); // We call our filter function
            }
            dt_adv_filter_table.dataTable().fnDraw();
        } else {
            dt_adv_filter_table.DataTable().column(i).search(val, false, true).draw();
        }
    }


    // Advanced Search
    // --------------------------------------------------------------------

    // Advanced Filter table
    if (dt_adv_filter_table.length) {
        let dt_adv_filter = dt_adv_filter_table.DataTable({
            dom: '<\'row\'<\'col-sm-12\'tr>><\'row\'<\'col-sm-12 col-md-6\'i><\'col-sm-12 col-md-6 dataTables_pager\'p>>',
            processing: true,
            serverSide: true,
            ajax: {
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: function(d) {
                    // You can optionally include additional data in the request payload
                    // For example, you can pass parameters or additional data here
                    if (name !== null) {
                        d.name = name;
                    }
                }
            },
            columns: [
                { data: '' },
                { data: 'name' },
                { data: 'status' },
                {
                    // Actions
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    data: 'action',
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return (
                            '<div class="d-inline-block">' +
                            '<a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                            '<i class="text-primary ti ti-dots-vertical"></i></a>' +
                            '<ul class="dropdown-menu dropdown-menu-end m-0">' +
                            '<li><a href="#" class="dropdown-item text-danger delete-record" data-delete="' + data + '">Delete</a></li>' +
                            '</ul>' +
                            '</div>' +
                            '<a href="/admin/user/edit/' + data + '" class="btn btn-sm btn-icon item-edit"><i class="text-primary ti ti-pencil"></i></a>'
                        );
                    }
                }
            ],
            columnDefs: [
                {
                    className: 'control',
                    orderable: false,
                    targets: 0,
                    render: function(data, type, full, meta) {
                        return '';
                    }
                }
            ],
            buttons: [
                {
                    text: '<i class="ti ti-plus me-sm-1"></i> <span class="d-sm-inline-block">Add New Record</span>',
                    className: 'create-new btn btn-primary waves-effect waves-light'
                }
            ],
            orderCellsTop: true,
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function(row) {
                            let data = row.data();
                            return 'Details of ' + data['name'];
                        }
                    }),
                    type: 'column',
                    renderer: function(api, rowIdx, columns) {
                        let data = $.map(columns, function(col, i) {
                            return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                                ? '<tr data-dt-row="' +
                                col.rowIndex +
                                '" data-dt-column="' +
                                col.columnIndex +
                                '">' +
                                '<td>' +
                                col.title +
                                ':' +
                                '</td> ' +
                                '<td>' +
                                col.data +
                                '</td>' +
                                '</tr>'
                                : '';
                        }).join('');

                        return data ? $('<table class="table"/><tbody />').append(data) : false;
                    }
                }
            }
        });
    }

    function deleteDataWithId(id) {

        let csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '/admin/user/delete', // Update this with your actual delete route
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the request headers
            },
            data: {
                id: id // Pass the deleteData value to the server
            },
            success: function(response) {
                // Handle the success response here
                console.log(response.status_code);

                if (response.status_code === 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: response.message,
                        customClass: {
                            confirmButton: 'btn btn-success waves-effect waves-light'
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Cancelled',
                        text: response.message,
                        icon: 'error',
                        customClass: {
                            confirmButton: 'btn btn-success waves-effect waves-light'
                        }
                    });
                }
                dt_adv_filter_table.dataTable().fnDraw();
            },
            error: function(xhr, status, error) {
                // Handle errors here
                console.error(xhr.responseText);

                Swal.fire({
                    title: 'Cancelled',
                    text: xhr.responseText.message,
                    icon: 'error',
                    customClass: {
                        confirmButton: 'btn btn-success waves-effect waves-light'
                    }
                });
            }
        });
    }


    // on key up from input field
    $('input.dt-input').on('keyup', function() {
        filterColumn($(this).attr('data-column'), $(this).val());
    });
    $(document).on('click', '.delete-record', function(event) {
        // Prevent the default action (e.g., following the href)
        event.preventDefault();
        // Get the value of the data-delete attribute
        let deleteData = $(this).data('delete');


        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            customClass: {
                confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                cancelButton: 'btn btn-label-secondary waves-effect waves-light'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                deleteDataWithId(deleteData);
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: 'Cancelled',
                    text: 'Your imaginary file is safe :)',
                    icon: 'error',
                    customClass: {
                        confirmButton: 'btn btn-success waves-effect waves-light'
                    }
                });
            }
        });


        // Use the deleteData value as needed (e.g., for deletion)
        console.log('Data to delete:', deleteData);
    });


    // Filter form control to default size
    // ? setTimeout used for multilingual table initialization
    setTimeout(() => {
        $('.dataTables_filter .form-control').removeClass('form-control-sm');
        $('.dataTables_length .form-select').removeClass('form-select-sm');
    }, 200);
});
