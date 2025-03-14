@extends('layouts.backend.template_mikapi', ['title' => 'Data Customer'])

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

    <link href="{{ cdn('backend/src/plugins/src/tomSelect/tom-select.default.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ cdn('backend/src/plugins/css/light/tomSelect/custom-tomSelect.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ cdn('backend/src/plugins/css/dark/tomSelect/custom-tomSelect.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ cdn('backend/src/plugins/src/leaflet/leaflet.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ cdn('backend/src/plugins/leaflet-locatecontrol/dist/L.Control.Locate.min.css') }}" rel="stylesheet"
        type="text/css">

    <link href="{{ cdn('backend/src/plugins/src/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/plugins/src/noUiSlider/nouislider.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/plugins/css/light/flatpickr/custom-flatpickr.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ cdn('backend/src/plugins/css/dark/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
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

        .form-control.flatpickr-input {
            background-image: none !important;
        }
    </style>

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
                        <h5><i class="fas fa-map-marked-alt me-1"></i>Map Data Customer</h5>
                    </div>
                    <div class="card-body">
                        <div id="map2" style="width: 100%; height: 400px;"></div>
                    </div>
                </div>
            </div>

        </div>


        @include('mikapi.customer.add')
        @include('mikapi.customer.edit')
        @include('mikapi.customer.modal')
        @include('mikapi.customer.modal_ppp')
    </div>
@endsection
@push('jslib')
    <script src="{{ cdn('backend/src/plugins/datatable/datatables.min.js') }}"></script>

    <!-- END PAGE LEVEL SCRIPTS -->

    <script src="{{ cdn('backend/src/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ cdn('backend/src/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script src="{{ cdn('backend/src/plugins/src/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ cdn('backend/src/plugins/moment/moment-with-locales.min.js') }}"></script>

    <script src="{{ cdn('backend/src/plugins/src/tomSelect/tom-select.base.js') }}"></script>

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
        $.fn.dataTable.ext.errMode = 'none';

        $(document).ready(function() {
            $('#refresh').click(function() {
                table.ajax.reload()
            })

        })
        const url_index = "{{ route('mikapi.customers.index') }}"
        const url_index_api = "{{ route('api.mikapi.customers.index') }}"
        const image_online = "{{ asset('images/default/map_online.png') }}"
        const image_offline = "{{ asset('images/default/map_offline.png') }}"
        const image_odp = "{{ asset('images/default/odp.webp') }}"
        const url_index_odp = "{{ route('api.mikapi.odps.index') }}" + param_router
        const url_index_ppp = "{{ route('api.mikapi.ppp.secrets.index') }}" + param_router

        var id = 0
        var perpage = 50
        var state_action = 'add'

        var default_lat = '-6.195168442930952';
        var default_long = '106.81594848632814';
        var map = L.map('map').setView([default_lat, default_long], 12);
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
            // console.log(`lat : ${latitude}, Log : ${longitude}`);
            fill_input(latitude, longitude)
        });

        map.on('click', function(e) {
            var latitude = e.latlng.lat;
            var longitude = e.latlng.lng;
            marker.setLatLng([latitude, longitude]);
            fill_input(latitude, longitude);
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
        var odp_markers = [];
        var online_icon = L.icon({
            iconUrl: image_online,
            iconSize: [42, 42], // [width, height]
            iconAnchor: [16, 32], // [horizontal center, bottom]
        });

        var offline_icon = L.icon({
            iconUrl: image_offline,
            iconSize: [42, 42], // [width, height]
            iconAnchor: [16, 32], // [horizontal center, bottom]
        });

        var customIcon = L.icon({
            iconUrl: image_odp,
            iconSize: [42, 42], // [width, height]
            iconAnchor: [16, 32], // [horizontal center, bottom]
        });

        var map2 = L.map('map2').setView([default_lat, default_long], 8);
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
            odp_markers.forEach(marker => marker.remove());
            markers = [];
            odp_markers = [];
            data.forEach(element => {
                try {
                    if (element.lat != null && element.long != null) {
                        var mark = L.marker([element.lat, element.long], {
                            icon: element.status == 'active' ? online_icon : offline_icon
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
                map.setView([lat, long], 10);
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

        var f1 = flatpickr(document.getElementById('regist'), {
            defaultDate: "today",
            disableMobile: true,
        });

        var f2 = flatpickr(document.getElementById('edit_regist'), {
            defaultDate: "today",
            disableMobile: true,
        });

        var package_data = null;
        document.querySelectorAll('.tomse-package').forEach((el) => {
            var tomse = new TomSelect(el, {
                valueField: 'id',
                labelField: 'name',
                searchField: 'name',
                preload: 'focus',
                placeholder: "Please Select Package",
                allowEmptyOption: true,
                load: function(query, callback) {
                    if (package_data) {
                        callback(package_data);
                        return;
                    }
                    var url = '{{ route('api.mikapi.packages.index') }}' + param_router +
                        '&limit=' +
                        perpage +
                        '&name=' +
                        encodeURIComponent(
                            query);
                    fetch(url)
                        .then(response => response.json())
                        .then(json => {
                            package_data = json.data
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
        							${escape(item.name)} 
        						</span>
        						<span class="text-muted">(${ escape(hrg(item.price))}) ${item.ppn > 0 ? ('+ '+item.ppn + '%') : ''}</span>
        					</div>
        			 		<div class="description">${escape(item.speed_up)}Mbps /${escape(item.speed_down)}Mbps</div>
        				</div>
        			</div>`;
                    },
                    item: function(item, escape) {
                        return `<span class="h5">
        							${escape(item.name)} (Rp${hrg(item.price)} ${item.ppn > 0 ? ('+ '+item.ppn + '%') : ''})
        						</span>`;
                    }
                },
            });
        });

        document.querySelectorAll('.tomse-odp').forEach((el) => {
            var tomse = new TomSelect(el, {
                valueField: 'id',
                labelField: 'name',
                searchField: 'name',
                preload: 'focus',
                placeholder: "Please Select Package",
                allowEmptyOption: true,
                load: function(query, callback) {
                    var url = '{{ route('api.mikapi.odps.index') }}' + param_router +
                        '&limit=' +
                        perpage +
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
                                        ${escape(item.name)} 
                                    </span>
                                    <span class="text-muted">(Max Port : ${ escape(item.max_port)})</span>
                                </div>
                                <div class="description">Available : ${escape(item.max_port-item.customers_count)}</div>
                            </div>
                        </div>`;
                    },
                },
            });
        });


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

        Inputmask("ip").mask($(".mask_ip"));
        Inputmask("mac").mask($(".mask_mac"));

        $('#reset').click(function() {
            document.getElementById('package').tomselect.clear();
            document.getElementById('odp').tomselect.clear()
            f1.setDate("{{ date('Y-m-d') }}")
        })

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
                title: "ID",
                data: 'number_id',
                className: "text-start",
            }, {
                title: "Name",
                data: 'name',
                className: "text-start",
            }, {
                title: "Package",
                data: 'package.name',
                orderable: false,
                className: "text-start",
            }, {
                title: "ODP",
                data: 'odp.name',
                orderable: false,
                className: "text-start",
            }, {
                title: "Phone",
                data: 'phone',
                className: "text-start",
            }, {
                title: "Email",
                data: 'email',
                className: "text-start",
            }, {
                title: "Status",
                data: 'status',
                className: "text-center",
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

        var table_ppp = $('#table_ppp').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: url_index_ppp,
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
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
            }, ],
            dom: dom,
            stripeClasses: [],
            lengthMenu: length_menu,
            pageLength: 10,
            oLanguage: o_lang,
            sPaginationType: 'simple_numbers',
            columns: [{
                title: "Name",
                data: 'name',
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        let text =
                            `<i class="fas fa-circle bs-tooltip text-${row.online ? 'success' : 'danger'} " title="${row.online ? 'Online' : 'Offline'}"></i> ${data}`
                        return text
                    } else {
                        return data
                    }
                }
            }, {
                title: "Password",
                data: 'password',
            }, {
                title: "Profile",
                data: 'profile',
            }, {
                title: "Remote Address",
                data: 'remote-address',
            }, ],
            drawCallback: function(settings) {
                feather.replace();
                tooltip()
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
                    $('#edit_status').val(result.data.status).change();
                    $('#edit_phone').val(result.data.phone);
                    $('#edit_email').val(result.data.email);
                    $('#edit_identity').val(result.data.identity);
                    $('#edit_address').val(result.data.address);
                    $('#edit_due').val(result.data.due);
                    $('#edit_lat').val(lat);
                    $('#edit_long').val(long);
                    $('#edit_ip').val(result.data.ip);
                    $('#edit_mac').val(result.data.mac);
                    $('#edit_secret_username').val(result.data.secret_username);
                    $('#edit_secret_password').val(result.data.secret_password);

                    f2.setDate(result.data.regist);

                    let tom_package = document.getElementById('edit_package').tomselect
                    let tom_odp = document.getElementById('edit_odp').tomselect
                    tom_package.clear()
                    tom_odp.clear()
                    if (result.data.package_id != null) {
                        tom_package.addOption(result.data.package)
                        tom_package.setValue(result.data.package_id)
                    }
                    if (result.data.odp_id != null) {
                        tom_odp.addOption(result.data.odp)
                        tom_odp.setValue(result.data.odp_id)
                    }
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

        $('#select_user_add').click(function() {
            state_action = 'add'
            $('#modalppp').modal('show')
            table_ppp.ajax.reload()
        })

        $('#select_user_edit').click(function() {
            state_action = 'edit'
            $('#modalppp').modal('show')
            table_ppp.ajax.reload()
        })

        function set_data(data) {
            console.log(state_action);
            if (state_action == 'add') {
                $('#secret_username').val(data.name)
                $('#secret_password').val(data.password)
                $('#ip').val(data['remote-address'])
            } else {
                $('#edit_secret_username').val(data.name)
                $('#edit_secret_password').val(data.password)
                $('#edit_ip').val(data['remote-address'])
            }
        }

        $('#table_ppp tbody').on('click', 'tr td', function() {
            data = table_ppp.row(this).data()
            set_data(data)
            $('#modalppp').modal('hide')
        });

        // });
    </script>
    <script src="{{ asset('js/v2/trigger.js') }}"></script>
@endpush
