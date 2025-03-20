@extends('layouts.backend.template', ['title' => 'Data Server'])
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


    <link href="{{ cdn('backend/src/assets/css/light/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/light/forms/switches.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ cdn('backend/src/assets/css/dark/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/dark/forms/switches.css') }}" rel="stylesheet" type="text/css">
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
        @include('server.add')
        @include('server.edit')
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
@endpush


@push('js')
    <script src="{{ asset('js/v2/var.js') }}"></script>
    <script src="{{ asset('js/v2/navigation.js') }}"></script>
    <script src="{{ asset('js/v2/func.js') }}"></script>
    <script>
        // $(document).ready(function() {

        const url_index = "{{ route('servers.index') }}"
        const url_index_api = "{{ route('api.servers.index') }}"
        var id = 0
        var perpage = 50

        $('#edit_delete').after(
            `<button type="button" class="btn btn-info ms-2 mb-2" id="edit_ping"><i class="fas fa-plug me-1 bs-tooltip" title="Ping"></i>Ping</button>`
        )

        $('#edit_ping').click(function() {
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

        Inputmask("ip").mask($(".mask_ip"));
        Inputmask("mac").mask($(".mask_mac"));

        var table = $('#tableData').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: url_index_api,
                error: function(jqXHR, textStatus, errorThrown) {
                    handleResponseCode(jqXHR)
                    $('#tableData_processing').hide();
                    $('.dt-empty').text('Empty Data!');
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
                        return `<i class="fas fa-circle bs-tooltip text-${row.is_active ? 'success' : 'danger'}" title="${row.is_active ? 'Active' : 'Nonactive'}"></i> ${data}`;
                    } else {
                        return data
                    }
                }
            }, {
                title: "IP",
                data: 'ip',
            }, {
                title: "Domain",
                data: 'domain',
            }, {
                title: "Netwatch",
                data: 'netwatch',
            }, {
                title: "Price",
                data: 'price',
                className: 'text-center',
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return hrg(data)
                    } else {
                        return data
                    }
                }
            }, {
                title: "Location",
                data: 'location',
            }, {
                title: "Available",
                data: 'is_available',
                className: 'text-center',
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return `<span class="badge badge-${data ? 'success' : 'danger'}">${data ? 'Available' : 'Unvailable'}</span>`;
                    } else {
                        return data
                    }
                }
            }],
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
                    $('#formEdit')[0].reset();
                    $('#edit_name').val(result.data.name);
                    $('#edit_username').val(result.data.username);
                    $('#edit_password').val('');
                    $('#edit_ip').val(result.data.ip);
                    $('#edit_domain').val(result.data.domain);
                    $('#edit_netwatch').val(result.data.netwatch);
                    $('#edit_location').val(result.data.location);
                    $('#edit_sufiks').val(result.data.sufiks);
                    $('#edit_port').val(result.data.port);
                    $('#edit_price').val(result.data.price);
                    $('#edit_annual_price').val(result.data.annual_price);
                    $('#edit_last_ip').val(result.data.last_ip);
                    $('#edit_active').prop('checked', result.data.is_active).change();
                    $('#edit_available').prop('checked', result.data.is_available).change();

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

        // });
    </script>
    <script src="{{ asset('js/v2/trigger.js') }}"></script>
@endpush
