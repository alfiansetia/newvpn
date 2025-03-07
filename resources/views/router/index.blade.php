@extends('layouts.backend.template', ['title' => 'Data Router'])
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


    <link href="{{ asset('backend/src/assets/css/light/components/modal.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/src/assets/css/dark/components/modal.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('backend/src/assets/css/light/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/assets/css/light/forms/switches.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('backend/src/assets/css/dark/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/assets/css/dark/forms/switches.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('backend/src/plugins/src/tomSelect/tom-select.default.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('backend/src/plugins/css/light/tomSelect/custom-tomSelect.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('backend/src/plugins/css/dark/tomSelect/custom-tomSelect.css') }}" rel="stylesheet"
        type="text/css">

    <link href="{{ asset('backend/src/assets/css/light/elements/alert.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/assets/css/dark/elements/alert.css') }}" rel="stylesheet" type="text/css">
@endpush
@section('content')
    <div class="row" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_table">
            <h5>
                <button type="button" class="btn btn-primary" onclick="add_data()"><i class="fas fa-plus"></i> Add
                    Router</button>
                <button type="button" class="btn btn-seconday" onclick="reload_data()"><i class="fas fa-sync"></i>
                    Reload</button>
            </h5>
            <div class="row" id="row_content"></div>

            <div class="widget-content widget-content-area br-8" style="display: none">
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

        @include('router.add')
        @include('router.edit')
    </div>
@endsection
@push('jslib')
    {{-- <script src="{{ asset('js/pagination.js') }}"></script> --}}
    <script src="{{ asset('backend/src/plugins/datatable/datatables.min.js') }}"></script>

    <!-- END PAGE LEVEL SCRIPTS -->

    <script src="{{ asset('backend/src/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <!-- InputMask -->
    <script src="{{ asset('backend/src/plugins/src/input-mask/jquery.inputmask.bundle.min.js') }}"></script>

    <script src="{{ asset('backend/src/plugins/src/bootstrap-maxlength/bootstrap-maxlength.js') }}"></script>

    <script src="{{ asset('backend/src/plugins/src/tomSelect/tom-select.base.js') }}"></script>
@endpush


@push('js')
    <script src="{{ asset('js/v2/var.js') }}"></script>
    <script src="{{ asset('js/v2/navigation.js') }}"></script>
    <script src="{{ asset('js/v2/func.js') }}"></script>
    <script>
        // $(document).ready(function() {
        const url_index = "{{ route('routers.index') }}"
        const url_index_api = "{{ route('api.routers.index') }}"
        var id = 0
        var perpage = 50

        // get_data()

        function add_data() {
            show_card_add()
            input_focus('name')
        }

        function reload_data() {
            table.ajax.reload()
        }

        function img_valid(image_url = "") {
            let default_image = "{{ asset('images/default/logo.svg') }}"
            try {
                const response = fetch(image_url, {
                    method: 'HEAD',
                    cache: "no-store"
                });
                if (!response.ok) {
                    return default_image;
                }
                return image_url;
            } catch (error) {
                return default_image;
            }
        }

        function parse_div(data) {
            $('#row_content').html('')
            if (data.length < 1) {
                $('#row_content').html(`<div class="p-3"><div class="alert alert-light-primary alert-dismissible fade show border-0 mb-4 ms-2 p-3" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="close" data-feather="x"></i></button>
                    <strong>No data!</strong></button>
                </div></div> `)
            }
            data.forEach(item => {
                let html = `<div class="col-md-6 col-lg-4 mb-2">
                            <div class="card style-4">
                                <div class="card-body pt-3 pb-1">
                                    <div class="media mt-0">
                                        <div class="">
                                            <div class="avatar avatar-md avatar-indicators avatar-online me-3">
                                                <img alt="avatar" src="${img_valid(item.url_logo)}"
                                                    class="rounded-circle">
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="media-heading mb-0"><strong>${item.name}</strong></h4>
                                            <p class="media-text mb-0">${item.hsname}</p>
                                            <p class="media-text">${item.dnsname}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-0  text-center pb-2">
                                    <button type="button" onclick="ping(${item.id})" class="btn btn-sm btn-info">
                                        <i data-feather="alert-octagon"></i> <span class="btn-text-inner ">Ping</span>
                                    </button>
                                    <button type="button" onclick="open_router(${item.id})" class="btn btn-sm btn-secondary">
                                        <i data-feather="send"></i> <span class="btn-text-inner ">Open</span>
                                    </button>
                                    <button type="button" onclick="edit_data(${item.id})" class="btn btn-sm btn-warning w-33">
                                        <i data-feather="edit"></i> <span class="btn-text-inner ">Edit</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        `
                $('#row_content').append(html)
            });
            feather.replace();
        }

        function get_data() {
            $.get(url_index_api).done(function(res) {
                console.log(res);
                parse_div(res.data)
            })
        }

        function edit_data(idt) {
            id = idt
            $('#formEdit').attr('action', url_index_api + "/" + id)
            edit(true)
        }

        $('.maxlength').maxlength({
            alwaysShow: true,
            placement: "top",
        });

        document.querySelectorAll('.tomse-vpn').forEach((el) => {
            var tomse = new TomSelect(el, {
                valueField: 'id',
                labelField: 'id',
                searchField: ['vpn_username'],
                preload: 'focus',
                placeholder: "Please Select PORT VPN",
                allowEmptyOption: true,
                closeAfterSelect: true,
                load: function(query, callback) {
                    var url = '{{ route('api.ports.paginate.user') }}?limit=' + perpage +
                        '&username=' + encodeURIComponent(query);
                    fetch(url)
                        .then(response => response.json())
                        .then(json => {
                            var modifiedData = json.data.map(item => {
                                return {
                                    ...item,
                                    vpn_username: item.vpn.username,
                                    vpn_is_active: !item.vpn.is_active,
                                };
                            });
                            callback(modifiedData);
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
        							${escape(item.vpn.username)} 
        						</span>
        						<span class="text-muted">(${ escape(item.vpn.server.name)})</span>
        					</div>
        			 		<div class="description">IP : ${escape(item.vpn.ip)}</div>
        			 		<div class="description">${escape(item.dst)} <=> ${escape(item.to)} <span class="badge badge-${item.vpn.is_active ? 'success' : 'danger'}">${item.vpn.is_active ? 'active' : 'nonactive'}</span></div>
        				</div>
        			</div>`;
                    },
                    item: function(item, escape) {
                        return `<span class="h4">
        							${escape(item.vpn.username)}:${escape(item.dst)} <=> ${escape(item.to)} (${escape(item.vpn.server.name)})
        						</span>`;
                    }
                },
            });
        });

        $('#reset').click(function() {
            document.getElementById('vpn').tomselect.clear()
        })

        var table = $('#tableData').DataTable({
            processing: true,
            serverSide: true,
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
            paging: false,
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
                title: "VPN",
                data: 'port.vpn.username',
                className: 'text-start',
                orderable: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        if (data != null) {
                            return `${row.port.vpn.username}: ${row.port.dst} <=> ${row.port.to} (${row.port.vpn.server.name})`;
                        } else {
                            return null;
                        }
                    } else {
                        return data
                    }
                }
            }, {
                title: "Name",
                data: 'name',
            }, {
                title: "Hs Name",
                data: 'hsname',
            }, {
                title: "DNS Name",
                data: 'dnsname',
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
                    let data = this.api().ajax.json().data
                    parse_div(data)
                } catch (error) {
                    parse_div([])
                }
            },
            initComplete: function() {
                feather.replace();
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
                    $('#edit_reset').val(result.data.id);
                    $('#edit_name').val(result.data.name);
                    $('#edit_hsname').val(result.data.hsname);
                    $('#edit_dnsname').val(result.data.dnsname);
                    $('#edit_username').val(result.data.username);
                    $('#edit_password').val('');
                    $('#edit_contact').val(result.data.contact);
                    $('#edit_url_logo').val(result.data.url_logo);
                    $('#edit_currency').val(result.data.currency);
                    let tom = document.getElementById('edit_vpn').tomselect
                    tom.clear()
                    if (result.data.port_id != null) {
                        tom.addOption(result.data.port)
                        tom.setValue(result.data.port_id)
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

        // $('#edit_delete').after(
        //     `<button type="button" class="btn btn-info ms-2 mb-2" id="edit_ping">
    //         <i class="fas fa-plug me-1 bs-tooltip" title="Ping"></i>Ping
    //     </button>
    //     <button type="button" class="btn btn-secondary mb-2" id="btn_open">
    //         <i class="fas fa-rocket me-1 bs-tooltip" title="Open"></i>Open
    //     </button>`
        // )




        $('#btn_open').on('click', function() {
            open_router(id)
        });

        $('#edit_ping').click(function() {
            ping(id)
        })

        function open_router(idt) {
            id = idt
            let url = "{{ route('mikapi.dashboard') }}?router=" + id;
            window.open(url, '_blank');
        }

        function ping(idt) {
            id = idt
            ajax_setup()
            $.ajax({
                url: `${url_index_api}/${id}/ping`,
                method: 'GET',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    block();
                },
                success: function(res) {
                    unblock();
                    show_alert(res.message, 'success')
                },
                error: function(xhr, status, error) {
                    unblock();
                    handleResponse(xhr)
                }
            })
        }

        // });
    </script>
    <script src="{{ asset('js/v2/trigger.js') }}"></script>
@endpush
