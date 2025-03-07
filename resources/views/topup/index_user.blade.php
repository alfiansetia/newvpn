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

    <link href="{{ cdn('backend/src/plugins/src/tomSelect/tom-select.default.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/plugins/css/light/tomSelect/custom-tomSelect.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/plugins/css/dark/tomSelect/custom-tomSelect.css') }}" rel="stylesheet" type="text/css">

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="{{ cdn('backend/src/assets/css/light/elements/alert.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/dark/elements/alert.css') }}" rel="stylesheet" type="text/css">
@endpush
@section('content')
    <div class="row" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_add" style="display: none">
            <div class="widget-content widget-content-area br-8">
                <form id="form" action="{{ route('api.topups.user.store') }}" method="POST">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-plus me-1 bs-tooltip"
                                    title="Add Data"></i>Add Data</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-2">
                                <label for="bank"><i class="fas fa-university me-1 bs-tooltip"
                                        title="Option Bank"></i>Bank
                                    :</label>
                                <select name="bank" id="bank" class="form-control-lg tomse-bank"
                                    style="width: 100%;" required>
                                </select>
                                <span class="error invalid-feedback err_bank" style="display: hide;"></span>
                            </div>
                            <div class="form-group mb-2">
                                <label for="amount"><i class="fas fa-dollar-sign me-1 bs-tooltip"
                                        title="amount"></i>Amount
                                    :</label>
                                <select name="amount" id="amount" class="form-control-lg tomse-amount"
                                    style="width: 100%;" required>
                                </select>
                                <span class="error invalid-feedback err_amount" style="display: hide;"></span>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <div class="row">
                                <div class="col-12">
                                    @include('components.form.button_add')
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

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

        <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_edit" style="display: none;">
            <div class="widget-content widget-content-area br-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title" id="titleEdit"><i class="fas fa-info me-1 bs-tooltip"
                                title="Detail Data"></i>Detail Data <span id="titleEdit2"></span></h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-arrow-left alert-icon-left alert-light-warning alert-dismissible fade show mb-4"
                            role="alert" id="edit_alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i data-feather="x"></i></button>
                            <i data-feather="bell"></i>
                            <strong>Warning!</strong> <span id="edit_warning"></span>
                        </div>
                        <div class="form-group mb-2">
                            <label class="control-label" for="edit_number">Number TRX :</label>
                            <input type="text" id="edit_number" class="form-control" placeholder="No Number"
                                disabled>
                        </div>
                        <div class="form-group mb-2">
                            <label class="control-label" for="edit_date">Date Topup :</label>
                            <input type="text" id="edit_date" class="form-control" placeholder="No Date" disabled>
                        </div>
                        <div class="form-group mb-2">
                            <label class="control-label" for="edit_bank">Bank :</label>
                            <textarea class="form-control" rows="3" id="edit_bank" placeholder="No Bank" disabled></textarea>
                        </div>
                        <div class="form-group mb-2">
                            <label class="control-label" for="edit_amount">Amount :</label>
                            <input type="text" id="edit_amount" class="form-control" placeholder="No Amount"
                                disabled>
                        </div>
                        <div class="form-group mb-2">
                            <label class="control-label" for="edit_status">Status :</label>
                            <input type="text" id="edit_status" class="form-control" placeholder="No Status"
                                disabled>
                        </div>
                        <div class="form-group mb-2">
                            <label class="control-label" for="edit_desc">Description :</label>
                            <textarea class="form-control" id="edit_desc" placeholder="No Description" disabled></textarea>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-secondary show-index mb-2">
                                    <i class="fas fa-times me-1 bs-tooltip" title="Close"></i>Close</button>
                                <button type="button" id="edit_reset" class="btn btn-warning mb-2">
                                    <i class="fas fa-undo me-1 bs-tooltip" title="Refresh Data"></i>Refresh
                                </button>
                                <button type="button" id="edit_delete" class="btn btn-danger mb-2">
                                    <i class="fas fa-trash me-1 bs-tooltip" title="Cancel"></i>Cancel
                                </button>
                                <a href="#" class="btn btn-info ms-1 me-1 mb-2" id="btn_pay" target="_blank"><i
                                        class="fab fa-whatsapp"></i> Confirm Payment</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('jslib')
    <script src="{{ cdn('backend/src/plugins/datatable/datatables.min.js') }}"></script>

    <!-- END PAGE LEVEL SCRIPTS -->

    <script src="{{ cdn('backend/src/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ cdn('backend/src/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script src="{{ cdn('backend/src/plugins/src/bootstrap-maxlength/bootstrap-maxlength.js') }}"></script>

    <!-- InputMask -->
    {{-- <script src="{{ cdn('backend/src/plugins/src/input-mask/jquery.inputmask.bundle.min.js') }}"></script> --}}

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
        const url_index_api = "{{ route('api.topups.user.index') }}"
        var id = 0
        var perpage = 50

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
                        item: function(item, escape) {
                            return `<div>${item.name} (${item.acc_number})</div>`
                        }
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
                text: '<i class="fas fa-dollar-sign"></i> Topup Account',
                className: 'btn btn-primary',
                action: function(e, dt, node, config) {
                    $('#card_add').show()
                    document.getElementById('bank').tomselect.focus()
                    document.getElementById('bank').tomselect.open()
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

        $('#tableData tbody').on('click', 'tr td', function() {
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

                    $('#edit_number').val(result.data.number)
                    $('#edit_date').val(result.data.date)
                    if (result.data.bank != null) {
                        $('#edit_bank').val(
                            `${result.data.bank.name} \n${result.data.bank.acc_number} \n(${result.data.bank.acc_name})`
                        )
                    } else {
                        $('#edit_bank').val('')
                    }
                    $('#edit_amount').val(hrg(result.data.amount))
                    $('#edit_status').val(result.data.status)
                    $('#edit_desc').val(result.data.desc)
                    $('#edit_warning').html(result.data.message)
                    if (result.data.status == 'pending') {
                        $('#edit_alert').show();
                    } else {
                        $('#edit_alert').hide();
                    }

                    $('#btn_pay').attr('href', result.data.confirm_url)
                    let element = ['edit_delete', 'btn_pay'];
                    element.forEach(item => {
                        $(`#${item}`).prop('disabled', result.data.status != 'pending');
                    });

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


        // });
    </script>
    <script src="{{ asset('js/v2/trigger.js') }}"></script>
@endpush
