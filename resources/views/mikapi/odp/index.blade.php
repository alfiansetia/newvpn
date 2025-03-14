@extends('layouts.backend.template_mikapi', ['title' => 'Data Odp'])

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


    <link href="{{ cdn('backend/src/assets/css/light/components/modal.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ cdn('backend/src/assets/css/dark/components/modal.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ cdn('backend/src/assets/css/light/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/light/forms/switches.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ cdn('backend/src/assets/css/dark/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/dark/forms/switches.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ cdn('backend/src/plugins/src/leaflet/leaflet.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ cdn('backend/src/plugins/leaflet-locatecontrol/dist/L.Control.Locate.min.css') }}" rel="stylesheet"
        type="text/css">

    <style>
        .info {
            padding: 6px 8px;
            font: 14px/16px Arial, Helvetica, sans-serif;
            background: white;
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        .info h4 {
            margin: 0 0 5px;
            color: #777;
        }

        .legend {
            text-align: left;
            line-height: 18px;
            color: #555;
        }

        .legend i {
            width: 18px;
            height: 18px;
            float: left;
            margin-right: 8px;
            opacity: 0.7;
        }

        .leaflet-map {
            border-radius: 8px;
        }
    </style>
@endpush
@section('content')
    <div class="row" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_table">
            <div class="widget-content widget-content-area br-8 mb-3">
                <form action="" id="formSelected">
                    <table id="tableData" class="table dt-table-hover table-hover" style="width:100%; cursor: pointer;">
                        <thead>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </form>
            </div>

            <div class="widget-content widget-content-area br-8">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-map-marked-alt me-1"></i>Map Data Odp</h5>
                    </div>
                    <div class="card-body">
                        <div id="map2" style="width: 100%; height: 300px;"></div>
                    </div>
                </div>
            </div>

        </div>

        @include('mikapi.odp.add')
        @include('mikapi.odp.edit')
        @include('mikapi.odp.modal')
    </div>
@endsection
@push('jslib')
    <script src="{{ cdn('backend/src/plugins/datatable/datatables.min.js') }}"></script>

    <!-- END PAGE LEVEL SCRIPTS -->

    <script src="{{ cdn('backend/src/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ cdn('backend/src/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <!-- InputMask -->
    <script src="{{ cdn('backend/src/plugins/src/input-mask/jquery.inputmask.bundle.min.js') }}"></script>

    <script src="{{ cdn('backend/src/plugins/src/bootstrap-maxlength/bootstrap-maxlength.js') }}"></script>

    <script src="{{ cdn('backend/src/plugins/src/leaflet/us-states.js') }}"></script>
    <script src="{{ cdn('backend/src/plugins/src/leaflet/eu-countries.js') }}"></script>
    <script src="{{ cdn('backend/src/plugins/src/leaflet/leaflet.js') }}"></script>
    <script src="{{ cdn('backend/src/plugins/leaflet-locatecontrol/dist/L.Control.Locate.min.js') }}"></script>
@endpush


@push('js')
    <script src="{{ asset('js/v2/var.js') }}"></script>
    <script src="{{ asset('js/v2/navigation.js') }}"></script>
    <script src="{{ asset('js/v2/func.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#refresh').click(function() {
                table.ajax.reload()
            })

        })
        const url_index = "{{ route('mikapi.odps.index') }}"
        const url_index_api = "{{ route('api.mikapi.odps.index') }}"
        const image_odp = "{{ asset('images/default/odp.png') }}"
        var id = 0
        var perpage = 50
        var state_action = 'add'

        var default_lat = '-6.195168442930952';
        var default_long = '106.81594848632814';
        var map = L.map('map').setView([default_lat, default_long], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        L.control.locate({
            drawCircle: false,
            follow: false,
            position: 'topright',
            icon: 'fa fa-location-arrow',
            iconLoading: 'fa fa-spinner fa-spin',
        }).addTo(map);

        var marker = L.marker([default_lat, default_long], {
            draggable: 'true'
        }).addTo(map);

        map.on('locationfound', function(e) {
            var latitude = e.latlng.lat;
            var longitude = e.latlng.lng;
            marker.setLatLng([latitude, longitude]);
            map.setView([lat, long], 16);
            // console.log(`lat : ${latitude}, Log : ${longitude}`);
            fill_input(latitude, longitude)
        });

        marker.on('dragend', function(event) {
            var marker = event.target;
            var position = marker.getLatLng();
            var latitude = position.lat;
            var longitude = position.lng;
            fill_input(latitude, longitude)
            // console.log(`lat : ${latitude}, Log : ${longitude}`);
        });

        $('#modalmap').on('shown.bs.modal', function() {
            map.invalidateSize(); // Refresh the map to fill the modal
        });

        var markers = [];
        var customIcon = L.icon({
            iconUrl: image_odp,
            iconSize: [42, 42], // [width, height]
            iconAnchor: [16, 32], // [horizontal center, bottom]
        });


        var map2 = L.map('map2').setView([default_lat, default_long], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map2);
        L.control.locate({
            drawCircle: false,
            follow: false,
            position: 'topright',
            icon: 'fa fa-location-arrow',
            iconLoading: 'fa fa-spinner fa-spin',
        }).addTo(map2);

        function draw_marker_map(data) {
            markers.forEach(marker => marker.remove());
            markers = [];
            data.forEach(element => {
                try {
                    if (element.lat != null && element.long != null) {
                        var mark = L.marker([element.lat, element.long], {
                            icon: customIcon
                        }).addTo(map2).bindPopup(
                            `ODP ${element.name}
                            <br>Max Port : ${element.max_port}
                            <br>Use : ${element.customers_count}
                            <br>Remain : ${element.max_port-element.customers_count}
                            <br>Desc : ${element.desc || ''}
                            `
                        );
                        markers.push(mark);
                        map2.setView([element.lat, element.long], 9);
                    }
                } catch (error) {
                    console.log(error);
                }
            });
        }

        function refresh_map() {
            let lat = '-6.195168442930952';
            let long = '106.81594848632814';
            set_map(lat, long)
        }

        function set_map(lat, long) {
            try {
                marker.setLatLng([lat, long]);
                map.setView([lat, long], 15);
            } catch (error) {
                console.log(error);
            }
        }

        function fill_input(lat, long) {
            if (state_action == 'add') {
                $('#lat').val(lat)
                $('#long').val(long)
            } else {
                $('#edit_lat').val(lat)
                $('#edit_long').val(long)
            }
        }

        function drawLine(from, to) {
            L.polyline([from, to], {
                color: 'red',
                weight: 3
            }).addTo(map2);
        }


        $('#btn_map_add').click(function() {
            state_action = 'add'
            $('#modalmap').modal('show')
        })

        $('#btn_map_edit').click(function() {
            state_action = 'edit'
            $('#modalmap').modal('show')
        })


        $('.maxlength').maxlength({
            alwaysShow: true,
            placement: "top",
        });

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

        $('#reset').click(function() {})

        var table = $('#tableData').DataTable({
            processing: true,
            serverSide: false,
            rowId: 'id',
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
                    input_focus('name')
                    refresh_map()
                },
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
                        delete_batch(url_index_api);
                    }
                }]
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
                data: 'id',
                className: "",
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    return `
                    <div class="form-check form-check-primary d-block new-control">
                        <input class="form-check-input child-chk" type="checkbox" name="id[]" value="${data}" >
                    </div>`
                }
            }, {
                title: "Name",
                data: 'name',
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return `<i class="fas fa-circle me-1" style="color:${row.line_color}"></i>${data}`
                    } else {
                        return data
                    }
                }
            }, {
                title: "Max Port",
                data: 'max_port',
                className: "text-center",
            }, {
                title: "Available Port",
                data: 'max_port',
                className: "text-center",
                searchable: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return data - (row.customers_count || 0)
                    } else {
                        return data
                    }
                }
            }, {
                title: "Desc",
                data: 'desc',
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
                try {
                    let data = settings.api.data().toArray()
                    draw_marker_map(data)
                } catch (error) {
                    draw_marker_map([])
                    console.log(error);

                }
            },
            initComplete: function() {
                feather.replace();
                tooltip()
            }
        });

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
                    let lat = result.data.lat
                    let long = result.data.long
                    $('#edit_reset').val(result.data.id);
                    $('#edit_name').val(result.data.name);
                    $('#edit_max_port').val(result.data.max_port);
                    $('#edit_lat').val(lat);
                    $('#edit_long').val(long);
                    $('#edit_desc').val(result.data.desc);
                    $('#edit_line_color').val(result.data.line_color);
                    color_edit(result.data.line_color)
                    if (lat != null && long != null) {
                        set_map(lat, long)
                    } else {
                        refresh_map()
                    }

                    if (show) {
                        show_card_edit()
                        input_focus('name')
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

        function color_add(value) {
            $('#color').text(value)
            $('#color').css('background-color', value)
        }

        function color_edit(value) {
            $('#color_edit').text(value)
            $('#color_edit').css('background-color', value)
        }

        // });
    </script>
    <script src="{{ asset('js/v2/trigger.js') }}"></script>
@endpush
