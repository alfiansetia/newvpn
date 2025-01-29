@extends('layouts.backend.template_mikapi', ['title' => 'User Log'])
@push('csslib')
    <!-- DATATABLE -->
    <link href="{{ asset('backend/src/plugins/datatable/datatables.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/plugins/src/table/datatable/datatables.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('backend/src/plugins/src/table/datatable/datatables.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/plugins/css/light/table/datatable/dt-global_style.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('backend/src/assets/css/light/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/src/plugins/css/dark/table/datatable/dt-global_style.css') }}">
    <link href="{{ asset('backend/src/assets/css/dark/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />


    <link href="{{ asset('backend/src/plugins/src/tomSelect/tom-select.default.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('backend/src/plugins/css/light/tomSelect/custom-tomSelect.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('backend/src/plugins/css/dark/tomSelect/custom-tomSelect.css') }}" rel="stylesheet"
        type="text/css">

    <link href="{{ asset('backend/src/assets/css/light/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/assets/css/dark/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css">

    <style>
        .row-disabled {
            background-color: rgb(218, 212, 212)
        }

        .form-control.flatpickr-input {
            background-image: none !important;
        }
    </style>
@endpush
@section('content')
    <div class="row" id="cancel-row">

        <div class="row layout-top-spacing layout-spacing pb-0" id="card_filter">
            <div class="col-md-4 mb-2">
                <select class="form-control tomse-day" name="day" id="filter_day">
                    <option value="">Select Day</option>
                    @for ($i = 1; $i <= 31; $i++)
                        <option value="{{ $i < 10 ? '0' : '' }}{{ $i }}">
                            {{ $i < 10 ? '0' : '' }}{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4 mb-2">
                <select class="form-control tomse-month" name="month" id="filter_month">
                    @php
                        $months = [
                            'jan' => 'January',
                            'feb' => 'February',
                            'mar' => 'March',
                            'apr' => 'April',
                            'may' => 'May',
                            'jun' => 'June',
                            'jul' => 'July',
                            'agu' => 'August',
                            'sep' => 'September',
                            'oct' => 'October',
                            'nov' => 'November',
                            'dec' => 'December',
                        ];
                        $currentMonth = strtolower(date('M'));
                        $currentYear = date('Y');
                    @endphp

                    @foreach ($months as $key => $name)
                        <option value="{{ $key }}" {{ $currentMonth == $key ? 'selected' : '' }}>
                            {{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-2">
                <select class="form-control tomse-year" name="year" id="filter_year">
                    @for ($i = $currentYear; $i >= 2015; $i--)
                        <option value="{{ $i }}" {{ $i == $currentYear ? 'selected' : '' }}>
                            {{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-sm-12" id="card_table">
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

        @include('mikapi.log.user.detail')

    </div>
@endsection
@push('jslib')
    <script src="{{ asset('backend/src/plugins/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/src/tomSelect/tom-select.base.js') }}"></script>

    <!-- END PAGE LEVEL SCRIPTS -->
@endpush


@push('js')
    <script>
        const url_index = "{{ route('mikapi.report') }}" + param_router
        const url_index_api = "{{ route('api.mikapi.reports.index') }}"
        const url_index_api_router = "{{ route('api.mikapi.reports.index') }}" + param_router
        var id = 0
        var perpage = 50
    </script>
    <script src="{{ asset('js/v2/var.js') }}"></script>
    <script src="{{ asset('js/v2/navigation.js') }}"></script>
    <script src="{{ asset('js/v2/func.js') }}"></script>

    <script>
        $(document).ready(function() {

            document.getElementById('filter_day').tomselect.on('change', function() {
                table.ajax.reload()
            })

            document.getElementById('filter_month').tomselect.on('change', function() {
                table.ajax.reload()
            })

            document.getElementById('filter_year').tomselect.on('change', function() {
                table.ajax.reload()
            })
        })


        document.querySelectorAll('.tomse-day').forEach((el) => {
            var tomse = new TomSelect(el, {
                placeholder: "Please Select Day",
                allowEmptyOption: true,
            });
        });

        document.querySelectorAll('.tomse-month').forEach((el) => {
            var tomse = new TomSelect(el, {
                placeholder: "Please Select Month",
                allowEmptyOption: false,
            });
        });

        document.querySelectorAll('.tomse-year').forEach((el) => {
            var tomse = new TomSelect(el, {
                placeholder: "Please Select Year",
                allowEmptyOption: false,
            });
        });

        $('#edit_save').remove()

        var table = $('#tableData').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: url_index_api_router,
                data: function(param) {
                    let d = document.getElementById('filter_day').tomselect.getValue();
                    let m = document.getElementById('filter_month').tomselect.getValue();
                    let y = document.getElementById('filter_year').tomselect.getValue();
                    if (d != '' || d != null) {
                        param.date = d
                    }
                    if (m != '' || m != null) {
                        param.month = m
                    }
                    if (y != '' || y != null) {
                        param.year = y
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    handleResponse(jqXHR)
                },
            },
            createdRow: function(row, data, dataIndex) {
                if (data.blocked == true) {
                    $('td', row).css('background-color', 'rgb(218, 212, 212)');
                }
            },
            columnDefs: [{
                defaultContent: '',
                targets: "_all"
            }],
            lengthChange: false,
            buttons: [{
                extend: "pageLength",
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Page Length'
                },
                className: 'btn btn-sm btn-info'
            }, {
                text: '<i class="fas fa-sync"></i>',
                className: 'btn btn-primary',
                action: function(e, dt, node, config) {
                    table.ajax.reload()
                },
            }, {
                text: '<i class="fas fa-caret-down"></i>',
                extend: 'collection',
                className: 'btn btn-warning',
                buttons: [{
                    text: 'Delete Selected Data',
                    action: function(e, dt, node, config) {
                        delete_batch(url_index_api_router);
                    }
                }]
            }, {
                extend: 'collection',
                text: '<i class="fas fa-file-download"></i>',
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Export Options'
                },
                className: 'btn btn-sm btn-success',
                buttons: [{
                        extend: 'pdfHtml5',
                        text: 'Export to PDF',
                        className: 'dropdown-item'
                    },
                    {
                        extend: 'copyHtml5',
                        text: 'Copy to Clipboard',
                        className: 'dropdown-item'
                    },
                    {
                        extend: 'csvHtml5',
                        text: 'Export to CSV',
                        className: 'dropdown-item'
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        className: 'dropdown-item'
                    }
                ]
            }],
            dom: dom,
            stripeClasses: [],
            lengthMenu: length_menu,
            pageLength: 10,
            oLanguage: o_lang,
            sPaginationType: 'simple_numbers',
            columns: [{
                width: "30px",
                title: 'Id',
                data: 'DT_RowId',
                className: "",
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        let text = `<div class="form-check form-check-primary d-block new-control">
                        <input class="form-check-input child-chk" type="checkbox" name="id[]" value="${data}" >`
                        if (row.radius) {
                            text +=
                                '<span class="badge me-1 badge-success bs-tooltip" title="Radius">R</span>'
                        }
                        if (row.blocked) {
                            text +=
                                '<span class="badge me-1 badge-danger bs-tooltip" title="Bloked">B</span>'
                        }
                        text += `</div>`
                        return text
                    } else {
                        return data
                    }
                }
            }, {
                title: "Date",
                data: 'date',
                className: "text-start",
            }, {
                title: "Time",
                data: 'time',
                className: "text-start",
            }, {
                title: "User",
                data: 'username',
                className: "text-start",
            }, {
                title: "Address",
                data: 'ip',
                className: "text-start",
            }, {
                title: "MAC",
                data: 'mac',
                className: "text-start",
            }, {
                title: "Validity",
                data: 'validity',
                className: "text-start",
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return hrg(data)
                    } else {
                        return data
                    }
                }
            }, ],
            headerCallback: function(e, a, t, n, s) {
                e.getElementsByTagName("th")[0].innerHTML = `
                <div class="form-check form-check-primary d-block new-control">
                    <input class="form-check-input chk-parent" type="checkbox" id="customer-all-info">
                </div>`
            },
            drawCallback: function(settings) {
                feather.replace();
                tooltip()
            },
            initComplete: function() {
                feather.replace();
            }
        });

        $('#btn_refresh').click(function() {
            table.ajax.reload()
        })

        multiCheck(table);

        $('#tableData tbody').on('click', 'tr td:not(:first-child)', function() {
            id = table.row(this).id() + param_router
            $('#formEdit').attr('action', url_index_api + "/" + id)
            edit(true)
        });

        function edit(show = false) {
            $.ajax({
                url: url_index_api + "/" + id,
                method: 'GET',
                success: function(result) {
                    unblock();
                    add_detail(result.data, 'tbl_detail')
                    if (show) {
                        show_card_detail()
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
