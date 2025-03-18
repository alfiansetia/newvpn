@extends('layouts.backend.template_mikapi', ['title' => 'Report'])
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

    <link href="{{ cdn('backend/src/plugins/src/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">


    <link href="{{ cdn('backend/src/assets/css/light/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/dark/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css">

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
                            'aug' => 'August',
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


        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-top-spacing layout-spacing mt-2">
            <div class="row widget-statistic">
                <div class="col-6">
                    <div class="widget widget-one_hybrid widget-engagement">
                        <div class="widget-heading pb-0">
                            <div class="w-title bs-tooltip">
                                <div class="w-icon">
                                    <i data-feather="wifi"></i>
                                </div>
                                <div class="">
                                    <p class="w-value" id="total_vc">Loading...</p>
                                    <h5 class="">Total Vcr</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="widget widget-one_hybrid widget-followers">
                        <div class="widget-heading pb-0">
                            <div class="w-title bs-tooltip">
                                <div class="w-icon">
                                    <i data-feather="dollar-sign"></i>
                                </div>
                                <div class="">
                                    <p class="w-value" id="total_sales">Loading...</p>
                                    <h5 class="">Total Sales</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

        <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_resume">
            <div class="widget-content widget-content-area br-8 p-3">
                <div id="resume"></div>
            </div>
        </div>

        @include('mikapi.report.detail')

    </div>
@endsection
@push('jslib')
    <script src="{{ cdn('backend/src/plugins/datatable/datatables.min.js') }}"></script>
    <script src="{{ cdn('backend/src/plugins/src/tomSelect/tom-select.base.js') }}"></script>

    <script src="{{ cdn('backend/src/plugins/src/apex/apexcharts.min.js') }}"></script>
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

            $('#refresh').click(function() {
                table.ajax.reload()
            })
        })

        let chartInstance = null;

        function createAreaChart(elementId, data) {
            if (chartInstance !== null) {
                chartInstance.destroy();
            }
            let dates = data.map(item => {
                return `${item.date} : [${item.jumlah} vcr]`
            });
            let totals = data.map(item => item.total);

            let options = {
                chart: {
                    type: 'area',
                    height: 350,
                    animations: {
                        enabled: true
                    }
                },
                series: [{
                    name: 'Total Sales',
                    data: totals,
                }],
                xaxis: {
                    categories: dates,
                    title: {
                        text: 'Date',
                    },
                    labels: {
                        show: false,
                    },
                },
                yaxis: {
                    title: {
                        text: 'Total Sales',
                    },
                    labels: {
                        formatter: function(value, timestamp, opts) {
                            return hrg(value);
                        },
                    },
                },
                title: {
                    text: 'Resume Report',
                    align: 'center',
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    curve: 'smooth',
                },
            };
            chartInstance = new ApexCharts(document.querySelector(`#${elementId}`), options);
            chartInstance.render();
        }

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
                    $('td', row).addClass('table-active');
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
                    'title': 'Change Page Length'
                },
                className: 'btn btn-sm btn-info bs-tooltip'
            }, {
                text: '<i class="fas fa-caret-down"></i>',
                extend: 'collection',
                className: 'btn btn-warning bs-tooltip',
                attr: {
                    'title': 'More Action'
                },
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
                    'title': 'Export Options'
                },
                className: 'btn btn-sm btn-success bs-tooltip',
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
                title: "Profile",
                data: 'profile',
                className: "text-start",
            }, {
                title: "Comment",
                data: 'comment',
                className: "text-start",
            }, {
                title: "Price",
                data: 'price',
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
                let json = this.api().ajax.json();
                if (typeof(json) != 'undefined') {
                    let data = json.data;
                    let total_sales = 0;
                    let total_vc = 0;
                    $.each(data, function(i, v) {
                        total_sales += v.price;
                    });

                    $('#total_vc').text(hrg(data.length))
                    $('#total_sales').text(hrg(total_sales))
                    let groupedData = {};
                    data.forEach((item) => {
                        let date = item.date;
                        if (!groupedData[date]) {
                            groupedData[date] = {
                                date: date,
                                total: 0,
                                jumlah: 0,
                            };
                        }
                        groupedData[date].total += item.price;
                        groupedData[date].jumlah += 1;
                    });
                    let result = Object.values(groupedData);
                    createAreaChart('resume', result);
                }
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
