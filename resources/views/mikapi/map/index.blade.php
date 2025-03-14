@extends('layouts.backend.template_mikapi', ['title' => 'Maps'])

@push('csslib')
    <!-- DATATABLE -->
    <link href="{{ cdn('backend/src/assets/css/light/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ cdn('backend/src/assets/css/dark/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />

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
            <div class="widget-content widget-content-area br-8">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-map-marked-alt me-1"></i>Map <button type="button"
                                class="btn btn-sm btn-secondary" id="refresh_map">Refresh</button></h5>
                    </div>
                    <div class="card-body">
                        <div id="map2" style="width: 100%; height: 500px;"></div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
@push('jslib')
    <!-- END PAGE LEVEL SCRIPTS -->
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
                get_data()
            })

            $('#refresh_map').click(function() {
                get_data()
            })

        })
        const url_index = "{{ route('mikapi.maps.index') }}"
        const url_index_api = "{{ route('api.mikapi.maps.index') }}" + param_router
        const url_index_api_odp = "{{ route('api.mikapi.odps.index') }}" + param_router
        const image_online = "{{ asset('images/default/map_online.png') }}?"
        const image_offline = "{{ asset('images/default/map_offline.png') }}?"
        const image_detail = "{{ asset('images/default/map_detail.png') }}?"
        const image_odp = "{{ asset('images/default/odp.png') }}?"

        var id = 0
        var perpage = 50
        var state_action = 'add'

        var default_lat = '-6.195168442930952';
        var default_long = '106.81594848632814';

        var markers = [];
        var odp_markers = [];
        var online_icon = L.icon({
            iconUrl: image_online,
            iconSize: [32, 32], // [width, height]
            iconAnchor: [16, 32], // [horizontal center, bottom]
        });

        var offline_icon = L.icon({
            iconUrl: image_offline,
            iconSize: [32, 32], // [width, height]
            iconAnchor: [16, 32], // [horizontal center, bottom]
        });

        var detail_icon = L.icon({
            iconUrl: image_detail,
            iconSize: [46, 46], // [width, height]
            iconAnchor: [16, 32], // [horizontal center, bottom]
        });

        var customIcon = L.icon({
            iconUrl: image_odp,
            iconSize: [42, 42], // [width, height]
            iconAnchor: [16, 32], // [horizontal center, bottom]
        });

        var map2 = L.map('map2').setView([default_lat, default_long], 11);
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
                    if (element.valid_location) {
                        let mark_icon = element.router_active ? online_icon : offline_icon
                        var mark = L.marker([element.lat, element.long], {
                            icon: mark_icon
                        }).addTo(map2).bindPopup(
                            `Name : ${element.name}
                            <br>ID : ${element.number_id}
                            <br>ODP : ${element.odp.name || '-'}
                            <br>Package : ${element.package.name || '-'}
                            <br>Phone : ${element.phone || '-'}
                            <br>Email : ${element.email || '-'}
                            <br>Status Member : ${element.status}
                            <br>IP : ${element.ip || '-'}
                            <br>MAC Router : ${element.mac || '-'}
                            <br>Secret Username : ${element.secret_username || '-'}
                            <br>Secret Password : ${element.secret_password || '-'}
                            <br>Router Status : <span class="badge badge-${element.router_active ? 'success' : 'danger'}">${element.router_active ? 'Online' : 'Offline'}</span>
                            <br>Router Uptime : ${element.router_uptime}
                        `
                        );
                        mark.on('click', function() {
                            this.setIcon(detail_icon);
                        });
                        mark.on('popupclose', function() {
                            this.setIcon(mark_icon);
                        });
                        markers.push(mark);
                        map2.setView([element.lat, element.long], 13);
                        drawLine([element.odp.lat, element.odp.long], [element.lat, element.long], element.odp
                            .line_color)
                    }
                } catch (error) {
                    console.log(error);
                }

            });
        }

        function draw_odp(data) {
            try {
                odp_markers.forEach(marker => marker.remove());
                odp_markers = [];
                data.forEach(element => {
                    if (element.valid_location) {
                        var mark = L.marker([element.lat, element.long], {
                            icon: customIcon
                        }).addTo(map2).bindPopup(
                            `ODP ${element.name}
                            <br>Max Port : ${element.max_port}
                            <br>Use : ${element.customers_count}
                            <br>Remain : ${element.max_port-element.customers_count}
                            <br>Desc : ${element.desc || ''}
                            <br>Line Color : <span class="" style="background-color:${element.line_color}">${element.line_color}</span>
                        `
                        );
                        odp_markers.push(mark);
                    }
                })
            } catch (error) {
                console.log(error);
            }
        }

        function refresh_map() {
            let lat = '-6.195168442930952';
            let long = '106.81594848632814';
            set_map(lat, long)
        }

        function set_map(lat, long) {
            try {
                marker.setLatLng([lat, long]);
                map.setView([lat, long], 10);
            } catch (error) {
                console.log(error);
            }
        }

        function drawLine(from, to, color = "red") {
            L.polyline([from, to], {
                color: color,
                weight: 2
            }).addTo(map2);
        }

        function get_data() {
            $.get(url_index_api).done(function(result) {
                draw_marker_map(result.data || [])
            }).fail(function(xhr) {
                console.log(xhr);
            })

            $.get(url_index_api_odp).done(function(result) {
                draw_odp(result.data || [])
            }).fail(function(xhr) {
                console.log(xhr);
            })
        }

        get_data()

        // });
    </script>
    <script src="{{ asset('js/v2/trigger.js') }}"></script>
@endpush
