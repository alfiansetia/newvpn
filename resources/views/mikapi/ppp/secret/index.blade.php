@extends('layouts.backend.template_mikapi', ['title' => 'PPP Secret'])
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

        @include('mikapi.ppp.secret.add')
        @include('mikapi.ppp.secret.edit')
        @include('mikapi.ppp.secret.detail')
    </div>
@endsection
@push('jslib')
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
    <script>
        const url_index = "{{ route('mikapi.ppp.secret') }}" + param_router
        const url_index_api = "{{ route('api.mikapi.ppp.secrets.index') }}"
        const url_index_api_router = "{{ route('api.mikapi.ppp.secrets.index') }}" + param_router
        var id = 0
        var perpage = 50
    </script>
    <script src="{{ asset('js/v2/var.js') }}"></script>
    <script src="{{ asset('js/v2/navigation.js') }}"></script>
    <script src="{{ asset('js/v2/func.js') }}"></script>
    <script>
        // $(document).ready(function() {

        Inputmask("ip").mask($(".mask_ip"));

        $('.maxlength').maxlength({
            alwaysShow: true,
            placement: "top",
        });

        var tomse_data = null;
        document.querySelectorAll('.tomse-profile').forEach((el) => {
            var tomse = new TomSelect(el, {
                valueField: 'name',
                labelField: 'name',
                searchField: 'name',
                preload: 'focus',
                placeholder: "Please Select Profile",
                allowEmptyOption: true,
                load: function(query, callback) {
                    if (tomse_data) {
                        callback(tomse_data);
                        return;
                    }
                    var url = '{{ route('api.mikapi.ppp.profiles.index') }}' + param_router +
                        '&limit=' + perpage +
                        '&name=' +
                        encodeURIComponent(
                            query);
                    fetch(url)
                        .then(response => response.json())
                        .then(json => {
                            tomse_data = json.data
                            callback(json.data);
                        }).catch(() => {
                            callback();
                        });
                },
            });
        });

        $('#reset').click(function() {
            document.getElementById('profile').tomselect.clear()
        })

        var table = $('#tableData').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: url_index_api_router,
                error: function(jqXHR, textStatus, errorThrown) {
                    handleResponse(jqXHR)
                },
            },
            columnDefs: [{
                defaultContent: '',
                targets: "_all"
            }],
            createdRow: function(row, data, dataIndex) {
                if (data.disabled == true) {
                    $('td', row).css('background-color', 'rgb(218, 212, 212)');
                }
            },
            lengthChange: false,
            buttons: [{
                extend: "pageLength",
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Page Length'
                },
                className: 'btn btn-sm btn-info'
            }, {
                text: '<i class="fas fa-plus"></i> Add',
                className: 'btn btn-primary',
                action: function(e, dt, node, config) {
                    show_card_add()
                    input_focus('name')
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
                }, {
                    text: 'Refresh Data',
                    action: function(e, dt, node, config) {
                        table.ajax.reload()
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
                data: 'DT_RowId',
                className: "",
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        let text = `<div class="form-check form-check-primary d-block new-control">
                        <input class="form-check-input child-chk" type="checkbox" name="id[]" value="${data}" >`
                        if (row.disabled) {
                            text +=
                                '<span class="badge me-1 badge-danger bs-tooltip" title="Disabled">X</span>'
                        }
                        text += `</div>`
                        return text
                    } else {
                        return data
                    }
                }
            }, {
                title: "Name",
                data: 'name',
                className: 'text-start',
            }, {
                title: "Profile",
                data: 'profile',
                className: 'text-start',
            }, {
                title: "Service",
                data: 'service',
                className: 'text-start',
            }, {
                title: "Remote Address",
                data: 'remote-address',
                className: 'text-start',
            }, {
                title: "Last Logout",
                data: 'last-logged-out',
                className: 'text-start',
            }, {
                title: "Disc Reason",
                data: 'last-disconnect-reason',
                className: 'text-start',
            }, {
                title: "Comment",
                data: 'comment',
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
                tooltip()
            },
            initComplete: function() {
                feather.replace();
            }
        });

        $('#edit_delete').after(btn_detail)

        multiCheck(table);

        $('#tableData tbody').on('click', 'tr td:not(:first-child)', function() {
            id = table.row(this).id() + param_router
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
                    $('#edit_name').val(result.data.name);
                    $('#edit_password').val(result.data.password);
                    $('#edit_comment').val(result.data.comment);
                    $('#edit_service').val(result.data.service).trigger('change');
                    $('#edit_local_address').val(result.data['local-address']);
                    $('#edit_remote_address').val(result.data['remote-address']);
                    let tom_profile = document.getElementById('edit_profile').tomselect
                    if (result.data.profile == null) {
                        tom_profile.clear()
                    } else {
                        tom_profile.addOption({
                            name: result.data.profile
                        })
                        tom_profile.setValue(result.data.profile)
                    }
                    if (result.data.disabled == false) {
                        $('#edit_is_active').prop('checked', true).change();
                    } else {
                        $('#edit_is_active').prop('checked', false).change();
                    }
                    add_detail(result.data, 'tbl_detail')
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
