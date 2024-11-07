@extends('layouts.backend.template_mikapi', ['title' => 'Monitor Interface'])
@push('csslib')
    <link href="{{ asset('backend/src/assets/css/light/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/src/assets/css/dark/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('backend/src/plugins/src/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('backend/src/plugins/src/notification/snackbar/snackbar.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('backend/src/plugins/css/light/notification/snackbar/custom-snackbar.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('backend/src/plugins/css/dark/notification/snackbar/custom-snackbar.css') }}" rel="stylesheet"
        type="text/css" />


    <link href="{{ asset('backend/src/plugins/src/tomSelect/tom-select.default.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('backend/src/plugins/css/light/tomSelect/custom-tomSelect.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('backend/src/plugins/css/dark/tomSelect/custom-tomSelect.css') }}" rel="stylesheet"
        type="text/css">
@endpush
@section('content')
    <div class="row" id="cancel-row">

        <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_detail">
            <div class="widget-content widget-content-area br-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title" id="exampleModalLongTitle">
                            <i class="fas fa-info me-1 bs-tooltip" title="Detail Resource"></i>Monitor Interface
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div id="interface"></div>
                            <div id="xxx"></div>

                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <div class="row">
                            <div class="form-group col-md-8 mb-2">
                                <select name="interface" id="select_interface" class="form-control select2">
                                    <option value="">Select Interface</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4 mb-2 d-grid gap-2">
                                <button type="button" id="btn_stop" class="btn btn-sm btn-primary">Start</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('jslib')
    <script src="{{ asset('backend/src/plugins/src/apex/apexcharts.min.js') }}"></script>

    <script src="{{ asset('backend/src/plugins/src/notification/snackbar/snackbar.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/moment/moment-with-locales.min.js') }}"></script>

    <script src="{{ asset('backend/src/plugins/src/tomSelect/tom-select.base.js') }}"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
@endpush
@push('js')
    <script src="{{ asset('js/navigation.js') }}"></script>
    <script src="{{ asset('js/func.js') }}"></script>
    <script src="{{ asset('js/mikapi.js') }}"></script>
    <script>
        // $(document).ready(function() {

        var sLineArea = {
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: true,
                },
                animations: {
                    enabled: true,
                    easing: 'linear',
                    dynamicAnimation: {
                        speed: 1000
                    }
                },
                fontFamily: 'Quicksand, sans-serif',
                height: 400,
                type: 'area',
                zoom: {
                    enabled: true,
                    type: 'x',
                    autoScaleYaxis: false,
                    zoomedArea: {
                        fill: {
                            color: '#90CAF9',
                            opacity: 0.4
                        },
                        stroke: {
                            color: '#0D47A1',
                            opacity: 0.4,
                            width: 1
                        }
                    }
                },
                dropShadow: {
                    enabled: true,
                    opacity: 0.2,
                    blur: 10,
                    left: -7,
                    top: 22
                },
            },
            colors: ['#1b55e2', '#e7515a'],
            dataLabels: {
                enabled: false
            },
            title: {
                text: 'Traffic Monitor',
                align: 'left',
                margin: 0,
                offsetX: -10,
                offsetY: 0,
                floating: false,
                style: {
                    fontSize: '18px',
                    color: '#0e1726'
                },
            },
            stroke: {
                curve: 'smooth',
            },
            series: [{
                name: 'RX',
                data: []
            }, {
                name: 'TX',
                data: []
            }],
            xaxis: {
                type: 'datetime',
                categories: [],
                labels: {
                    formatter: function(value, timestamp, opts) {
                        return moment(new Date(value)).format("HH:mm:ss");
                    },
                },
            },
            yaxis: {
                tickAmount: 5,
                floating: false,
                labels: {
                    formatter: function(value, index) {
                        return formatBytes(value)
                    },
                    offsetX: -15,
                    offsetY: 0,
                    style: {
                        fontSize: '12px',
                        fontFamily: 'Quicksand, sans-serif',
                        cssClass: 'apexcharts-yaxis-title',
                    },
                },
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false
                },
                grid: {
                    borderColor: '#e0e6ed',
                    strokeDashArray: 5,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    },
                    yaxis: {
                        lines: {
                            show: false,
                        }
                    },
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: -10
                    },
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    offsetY: -50,
                    fontSize: '16px',
                    fontFamily: 'Quicksand, sans-serif',
                    markers: {
                        width: 10,
                        height: 10,
                        strokeWidth: 0,
                        strokeColor: '#fff',
                        fillColors: undefined,
                        radius: 12,
                        onClick: undefined,
                        offsetX: 0,
                        offsetY: 0
                    },
                    itemMargin: {
                        horizontal: 0,
                        vertical: 20
                    }
                },
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                },
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#interface"),
            sLineArea
        );

        chart.render();


        $(document).ready(function() {
            var i;
            var j;

            var tomse = new TomSelect('#select_interface', {
                valueField: '.id',
                labelField: 'name',
                searchField: 'name',
                preload: 'focus',
                placeholder: "Please Select Interface",
                allowEmptyOption: true,
                onChange: function(value) {
                    get_interval()
                },
                load: function(query, callback) {
                    var url = '{{ route('api.mikapi.interfaces.index') }}' + param_router + '&name=' +
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
            });

            $("#btn_stop").click(function() {
                clearInterval(i)
                let id = document.getElementById('select_interface').tomselect.getValue()
                if (id == '') {
                    $(this).text('Start')
                    return
                }
                if ($(this).text() == 'Stop') {
                    $(this).text('Start')
                } else {
                    get_interval()
                    $(this).text('Stop')
                }
            })


            function get_interval() {
                clearInterval(i)
                let id = document.getElementById('select_interface').tomselect.getValue()
                if (id != '') {
                    $('#btn_stop').text('Stop')
                    get_data(id)
                    i = setInterval(function() {
                        get_data(id)
                    }, 2500)
                } else {
                    $('#btn_stop').text('Start')
                }
            }

            function get_data(id) {
                let url = "{{ route('api.mikapi.interfaces.monitor', ':id') }}" + param_router
                url = url.replace(':id', id);
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(result) {
                        var dataPoint = result.data[0];
                        var rxBitsPerSecond = parseInt(dataPoint['rx-bits-per-second']);
                        var txBitsPerSecond = parseInt(dataPoint['tx-bits-per-second']);
                        var timestamp = Date.now();
                        chart.appendData([{
                                name: 'RX',
                                data: [
                                    [timestamp, rxBitsPerSecond]
                                ]
                            },
                            {
                                name: 'TX',
                                data: [
                                    [timestamp, txBitsPerSecond]
                                ]
                            }
                        ]);
                    },
                    beforeSend: function() {},
                    error: function(xhr, status, error) {
                        clearInterval(i)
                        handleResponse(xhr)
                    }
                });
            }
        })


        // });
    </script>
@endpush
