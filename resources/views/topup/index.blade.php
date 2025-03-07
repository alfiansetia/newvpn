@extends('layouts.backend.template', ['title' => 'Data Topup'])
@push('csslib')
    <!-- DATATABLE -->
    <link href="{{ cdn('backend/src/plugins/datatable/datatables.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/plugins/src/table/datatable/datatables.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ cdn('backend/src/plugins/src/table/datatable/datatables.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/plugins/css/light/table/datatable/dt-global_style.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ cdn('backend/src/assets/css/light/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css"
        href="{{ cdn('backend/src/plugins/css/dark/table/datatable/dt-global_style.css') }}">
    <link href="{{ cdn('backend/src/assets/css/dark/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />


    <link href="{{ cdn('backend/src/plugins/src/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/plugins/src/noUiSlider/nouislider.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/plugins/css/light/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/plugins/css/dark/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">


    <link href="{{ cdn('backend/src/plugins/src/tomSelect/tom-select.default.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ cdn('backend/src/plugins/css/light/tomSelect/custom-tomSelect.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ cdn('backend/src/plugins/css/dark/tomSelect/custom-tomSelect.css') }}" rel="stylesheet" type="text/css">

    <style>
        .flatpickr-calendar {
            z-index: 1056 !important;
        }

        .tba {
            width: 35%;
            word-wrap: break-word;
            white-space: normal;
            text-align: left;
        }

        .tbb {
            width: 65%;
            word-wrap: break-word;
            white-space: normal;
            text-align: left;
        }

        .tbb::before {
            content: ": ";
        }
    </style>
@endpush
@section('content')
    <div class="row" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_table">
            <div class="widget-content widget-content-area br-8">
                <form action="" id="formSelected">
                    <table id="tableData" class="table dt-table-hover table-hover" style="width:100%; cursor: pointer;">
                        <thead>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        @include('topup.add')
        @include('topup.edit')
    </div>
@endsection
@push('jslib')
    <script src="{{ cdn('backend/src/plugins/datatable/datatables.min.js') }}"></script>

    <!-- END PAGE LEVEL SCRIPTS -->

    <script src="{{ cdn('backend/src/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ cdn('backend/src/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script src="{{ cdn('backend/src/plugins/src/bootstrap-maxlength/bootstrap-maxlength.js') }}"></script>
    <script src="{{ cdn('backend/src/plugins/src/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ cdn('backend/src/plugins/moment/moment-with-locales.min.js') }}"></script>

    <!-- InputMask -->
    <script src="{{ cdn('backend/src/plugins/src/input-mask/jquery.inputmask.bundle.min.js') }}"></script>

    <script src="{{ cdn('backend/src/plugins/src/tomSelect/tom-select.base.js') }}"></script>
@endpush

@push('js')
    <script src="{{ asset('js/v2/var.js') }}"></script>
    <script src="{{ asset('js/v2/navigation.js') }}"></script>
    <script src="{{ asset('js/v2/func.js') }}"></script>
    <script>
        $('.maxlength').maxlength({
            alwaysShow: true,
            placement: "top",
        });


        // $(document).ready(function() {
        const url_index = "{{ route('topups.index') }}"
        const url_index_api = "{{ route('api.topups.index') }}"
        var id = 0
        var perpage = 50

        $('.mask_angka').inputmask({
            alias: 'numeric',
            groupSeparator: '.',
            autoGroup: true,
            digits: 0,
            rightAlign: false,
            removeMaskOnSubmit: true,
            autoUnmask: true,
            min: 0,
        });

        if ($('.tomse-user').length > 0) {
            document.querySelectorAll('.tomse-user').forEach((el) => {
                var tomse = new TomSelect(el, {
                    valueField: 'id',
                    labelField: 'email',
                    searchField: 'email',
                    preload: 'focus',
                    placeholder: "Please Select User",
                    allowEmptyOption: true,
                    load: function(query, callback) {
                        var url = '{{ route('api.users.paginate') }}?limit=' + perpage + '&email=' +
                            encodeURIComponent(
                                query);
                        fetch(url)
                            .then(response => response.json())
                            .then(json => {
                                callback(json.data);
                            }).catch(() => {
                                callback();
                            });
                    },
                    render: {
                        option: function(item, escape) {
                            return `<div class="py-2 d-flex">
        				<div>
        					<div class="mb-1">
        						<span class="h4">
        							${ escape(item.email) }
        						</span>
        					</div>
        			 		<div class="description">${ escape(item.name) }</div>
        				</div>
        			</div>`;
                        },
                    },
                });
            });
        }

        if ($('.tomse-bank').length > 0) {
            document.querySelectorAll('.tomse-bank').forEach((el) => {
                var tomse = new TomSelect(el, {
                    valueField: 'id',
                    labelField: 'name',
                    searchField: 'name',
                    preload: 'focus',
                    placeholder: "Please Select Bank",
                    allowEmptyOption: true,
                    load: function(query, callback) {
                        var url = '{{ route('api.banks.paginate') }}?is_active=1&limit=' + perpage +
                            '&name=' +
                            encodeURIComponent(
                                query);
                        fetch(url)
                            .then(response => response.json())
                            .then(json => {
                                callback(json.data);
                            }).catch(() => {
                                callback();
                            });
                    },
                    render: {
                        option: function(item, escape) {
                            return `<div class="py-2 d-flex">
        				<div>
        					<div class="mb-1">
        						<span class="h4">
        							${ escape(item.name) } (${item.acc_number})
        						</span>
        					</div>
        			 		<div class="description">${ escape(item.acc_name) }</div>
        				</div>
        			</div>`;
                        },
                    },
                });
            });
        }

        if ($('.tomse-amount').length > 0) {
            document.querySelectorAll('.tomse-amount').forEach((el) => {
                new TomSelect(el, {
                    valueField: 'id',
                    labelField: 'title',
                    searchField: 'title',
                    preload: 'focus',
                    placeholder: "Please Select Amount",
                    options: [{
                            id: 10000,
                            title: 'Rp. 10.000',
                        },
                        {
                            id: 20000,
                            title: 'Rp. 20.000',
                        }, ,
                        {
                            id: 50000,
                            title: 'Rp. 50.000',
                        },
                        {
                            id: 100000,
                            title: 'Rp. 100.000',
                        },
                        {
                            id: 200000,
                            title: 'Rp. 200.000',
                        },
                        {
                            id: 300000,
                            title: 'Rp. 300.000',
                        },
                        {
                            id: 500000,
                            title: 'Rp. 500.000',
                        }
                    ],
                    create: false
                });
            });
        }

        $('#reset').click(function() {
            document.getElementById('user').tomselect.clear()
            document.getElementById('bank').tomselect.clear()
            document.getElementById('amount').tomselect.clear()
        })


        var table = $('#tableData').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: url_index_api,
                error: function(jqXHR, textStatus, errorThrown) {
                    handleResponseCode(jqXHR)
                },
            },
            columnDefs: [{
                defaultContent: '',
                targets: "_all"
            }],
            order: [0, 'desc'],
            lengthChange: false,
            buttons: [{
                extend: "pageLength",
                attr: {
                    'title': 'Change Page Length'
                },
                className: 'btn btn-sm btn-info bs-tooltip'
            }, {
                text: '<i class="fas fa-plus"></i> Add',
                className: 'btn btn-primary bs-tooltip',
                attr: {
                    'title': 'Add New Data'
                },
                action: function(e, dt, node, config) {
                    show_card_add()
                    input_focus('desc')
                },
            }, ],
            dom: dom,
            stripeClasses: [],
            lengthMenu: length_menu,
            pageLength: 10,
            oLanguage: o_lang,
            sPaginationType: 'simple_numbers',
            columns: [{
                title: "Date",
                data: 'date',
                className: "text-start",
            }, {
                title: "User",
                data: 'user.email',
                orderable: false,
                className: "text-start",
            }, {
                title: "Bank",
                data: 'bank.name',
                orderable: false,
                className: "text-start",
            }, {
                title: "Number",
                data: 'number',
                className: "text-start",
            }, {
                title: "Amount",
                data: 'amount',
                className: "text-start",
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return hrg(data)
                    } else {
                        return data
                    }
                }
            }, {
                title: 'Status',
                data: 'status',
                className: "text-center",
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return `<span class="badge badge-${data === 'done' ? 'success' : (data === 'pending'? 'warning':'danger')}">${data}</span>`
                    } else {
                        return data
                    }
                }
            }, {
                title: "Desc",
                data: 'desc',
                className: "text-start",
            }, ],
            headerCallback: function(e, a, t, n, s) {},
            drawCallback: function(settings) {
                feather.replace();
                tooltip()
            },
            initComplete: function() {
                feather.replace();
            }
        });

        $('#btn_delete').remove()
        $('#edit_delete').remove()

        multiCheck(table);

        $('#tableData tbody').on('click', 'tr td:not(:first-child)', function() {
            id = table.row(this).id()
            $('#formEdit').attr('action', url_index_api + "/" + id)
            edit(true)
        });

        function edit(show = false) {
            clear_validate('formEdit')
            $.ajax({
                url: url_index_api + "/" + id,
                method: 'GET',
                success: function(result) {
                    unblock();
                    $('#edit_amount').val(result.data.amount);
                    $('#edit_desc').val(result.data.desc);
                    $('#titleEdit2').html(`<b>${result.data.number}</b> (${result.data.status})`);

                    let tom_bank = document.getElementById('edit_bank').tomselect
                    let tom_user = document.getElementById('edit_user').tomselect
                    let tom_amount = document.getElementById('edit_amount').tomselect
                    tom_amount.setValue(result.data.amount)
                    tom_bank.clear()
                    tom_user.clear()
                    if (result.data.bank != null) {
                        tom_bank.addOption(result.data.bank)
                        tom_bank.setValue(result.data.bank_id)
                    }
                    if (result.data.user != null) {
                        tom_user.addOption(result.data.user)
                        tom_user.setValue(result.data.user_id)
                    }

                    let element = ['edit_delete', 'btn_done', 'btn_cancel'];
                    element.forEach(item => {
                        $(`#${item}`).prop('disabled', result.data.status != 'pending');
                    });
                    if (result.data.status != 'pending') {
                        tom_bank.disable()
                        tom_user.disable()
                        tom_amount.disable()
                    } else {
                        tom_bank.enable()
                        tom_user.enable()
                        tom_amount.enable()
                    }
                    if (result.data.status == 'done') {
                        $('#btn_cancel').prop('disabled', false);
                    }
                    if (show) {
                        show_card_edit()
                        input_focus('desc')
                    }
                },
                beforeSend: function() {
                    block();
                },
                error: function(xhr, status, error) {
                    unblock();
                    handleResponse(xhr)
                }
            });
        }

        function update_status(status) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Status will be update!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes!',
                confirmButtonAriaLabel: 'Thumbs up, Yes!',
                cancelButtonText: '<i class="fa fa-thumbs-down"></i> No',
                cancelButtonAriaLabel: 'Thumbs down',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                padding: '2em',
                customClass: 'animated tada',
                showClass: {
                    popup: `animated tada`
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    ajax_setup();
                    $.ajax({
                        type: 'DELETE',
                        url: url_index_api + "/" + id,
                        data: {
                            status: status
                        },
                        beforeSend: function() {
                            block();
                        },
                        success: function(res) {
                            unblock();
                            table.ajax.reload();
                            Swal.fire(
                                'Success!',
                                res.message,
                                'success'
                            )
                            show_index()
                        },
                        error: function(xhr, status, error) {
                            unblock();
                            handleResponse(xhr)
                            Swal.fire(
                                'Failed!',
                                xhr.responseJSON.message,
                                'error'
                            )
                        }
                    });
                }
            })
        }

        // });
    </script>
    <script src="{{ asset('js/v2/trigger.js') }}"></script>
@endpush
