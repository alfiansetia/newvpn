@extends('layouts.backend.template_mikapi', ['title' => 'All Log'])
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
@endpush
@section('content')
    <div class="row" id="cancel-row">
        <div class="row layout-top-spacing layout-spacing pb-0" id="card_filter">
            <div class="col-md-6 mb-2">
                <select class="form-control" name="topics" id="select_topics" multiple>
                </select>
            </div>
            <div class="col-md-2 mb-2">
                <select class="form-control" name="buffer" id="select_buffer">
                </select>
            </div>
            <div class="col-md-4 mb-2">
                <button type="button" class="btn btn-block btn-primary" id="btn_filter">
                    <i class="fas fa-filter me-1"></i>Filter
                </button>
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

        @include('mikapi.log.all.edit')
    </div>
@endsection
@push('jslib')
    <script src="{{ asset('backend/src/plugins/datatable/datatables.min.js') }}"></script>
    <!-- END PAGE LEVEL SCRIPTS -->

    <script src="{{ asset('backend/src/plugins/src/tomSelect/tom-select.base.js') }}"></script>
@endpush


@push('js')
    <script>
        const url_index = "{{ route('mikapi.log.all') }}" + param_router
        const url_index_api = "{{ route('api.mikapi.logs.index') }}"
        const url_index_api_router = "{{ route('api.mikapi.logs.index') }}" + param_router
        var id = 0
        var perpage = 50
    </script>
    <script src="{{ asset('js/v2/var.js') }}"></script>
    <script src="{{ asset('js/v2/navigation.js') }}"></script>
    <script src="{{ asset('js/v2/func.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#refresh').click(function() {
                table.ajax.reload()
            })
        })

        const names = [{
                name: "system"
            },
            {
                name: "error"
            },
            {
                name: "critical"
            },
            {
                name: "account"
            },
            {
                name: "async"
            },
            {
                name: "backup"
            },
            {
                name: "bgp"
            },
            {
                name: "bfd"
            },
            {
                name: "bridge"
            },
            {
                name: "calc"
            },
            {
                name: "caps"
            },
            {
                name: "certificate"
            },
            {
                name: "ddns"
            },
            {
                name: "debug"
            },
            {
                name: "dhcp"
            },
            {
                name: "dns"
            },
            {
                name: "dot1x"
            },
            {
                name: "dude"
            },
            {
                name: "e-mail"
            },
            {
                name: "event"
            },
            {
                name: "firewall"
            },
            {
                name: "gsm"
            },
            {
                name: "gps"
            },
            {
                name: "health"
            },
            {
                name: "hotspot"
            },
            {
                name: "igmp-proxy"
            },
            {
                name: "interface"
            },
            {
                name: "ipsec"
            },
            {
                name: "info"
            },
            {
                name: "isdn"
            },
            {
                name: "iscsi"
            },
            {
                name: "kvm"
            },
            {
                name: "ldp"
            },
            {
                name: "lte"
            },
            {
                name: "lora"
            },
            {
                name: "l2tp"
            },
            {
                name: "mme"
            },
            {
                name: "mqtt"
            },
            {
                name: "mpls"
            },
            {
                name: "ntp"
            },
            {
                name: "raw"
            },
            {
                name: "radius"
            },
            {
                name: "radvd"
            },
            {
                name: "read"
            },
            {
                name: "route"
            },
            {
                name: "rsvp"
            },
            {
                name: "smb"
            },
            {
                name: "script"
            },
            {
                name: "sertcp"
            },
            {
                name: "ssh"
            },
            {
                name: "sstp"
            },
            {
                name: "snmp"
            },
            {
                name: "simulator"
            },
            {
                name: "state"
            },
            {
                name: "stp"
            },
            {
                name: "store"
            },
            {
                name: "tftp"
            },
            {
                name: "telephony"
            },
            {
                name: "timer"
            },
            {
                name: "tr069"
            },
            {
                name: "upnp"
            },
            {
                name: "ups"
            },
            {
                name: "vrrp"
            },
            {
                name: "warning"
            },
            {
                name: "web-proxy"
            },
            {
                name: "wireless"
            },
            {
                name: "write"
            }
        ];

        new TomSelect("#select_topics", {
            valueField: 'name',
            labelField: 'name',
            searchField: 'name',
            preload: 'focus',
            placeholder: "Select Topics",
            allowEmptyOption: true,
            options: names,
            delimiter: ',',
        });

        new TomSelect("#select_buffer", {
            valueField: 'name',
            labelField: 'name',
            searchField: 'name',
            preload: 'focus',
            placeholder: "All Buffer",
            allowEmptyOption: true,
            options: [{
                name: 'disk',
            }, {
                name: 'memory',
            }],
        });

        var filter = document.getElementById('select_buffer').tomselect
        filter.setValue('disk')

        var filter = document.getElementById('select_topics').tomselect
        filter.setValue(['hotspot', 'info', 'debug'])

        var table = $('#tableData').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: url_index_api_router,
                data: function(dt) {
                    let topics = document.getElementById('select_topics').tomselect.getValue() || []
                    let buffer = document.getElementById('select_buffer').tomselect.getValue()
                    let topicsString = ''
                    if (topics.length > 0) {
                        topicsString = topics.join(',');
                    }
                    dt.topics = topicsString
                    dt.buffer = buffer
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    handleResponse(jqXHR)
                },
            },
            columnDefs: [{
                defaultContent: '',
                targets: "_all"
            }],
            order: [
                [1, 'desc']
            ],
            lengthChange: false,
            buttons: [{
                extend: "pageLength",
                attr: {
                    'title': 'Change Page Length'
                },
                className: 'btn btn-sm btn-info bs-tooltip'
            }, {
                text: '<i class="fas fa-trash"></i>',
                className: 'btn btn-danger bs-tooltip',
                attr: {
                    'title': 'Delete Data'
                },
                action: function(e, dt, node, config) {
                    delete_all()
                },
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
                    return `
                    <div class="form-check form-check-primary d-block new-control">
                        <input class="form-check-input child-chk" type="checkbox" name="id[]" value="${data}" >
                    </div>`
                }
            }, {
                title: "Time",
                data: 'time',
                className: 'text-start',
            }, {
                title: "Topics",
                data: 'topics',
                className: 'text-start',
            }, {
                title: "Message",
                data: 'message',
                className: 'text-start',
            }],
            headerCallback: function(e, a, t, n, s) {
                e.getElementsByTagName("th")[0].innerHTML = `
                <div class="form-check form-check-primary d-block new-control">
                    <input class="form-check-input chk-parent" type="checkbox" id="customer-all-info">
                </div>`
            },
            drawCallback: function(settings) {
                feather.replace();
                // tooltip()
            },
            initComplete: function() {
                feather.replace();
            }
        });

        $('#btn_filter').click(function() {
            table.ajax.reload()
        })

        multiCheck(table);

        $('#tableData tbody').on('click', 'tr td:not(:first-child)', function() {
            id = table.row(this).id() + param_router
            $('#formEdit').attr('action', url_index_api + "/" + id)
            edit(true)
        });

        function edit(show = false) {
            clear_validate('formEdit2')
            $.ajax({
                url: url_index_api + "/" + id,
                method: 'GET',
                success: function(result) {
                    unblock();
                    $('#edit_time').val(result.data.time);
                    $('#edit_topics').val(result.data.topics);
                    $('#edit_message').val(result.data.message);
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

        function delete_all() {
            ajax_setup()
            Swal.fire({
                title: 'Are you sure?',
                text: "Data Will be Lost!",
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
                        url: "{{ route('api.mikapi.logs.destroy') }}" + param_router,
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
                        },
                        error: function(xhr, status, error) {
                            unblock();
                            handleResponse(xhr)
                        }
                    });
                }
            })
        }

        // });
    </script>
    <script src="{{ asset('js/v2/trigger.js') }}"></script>
@endpush
