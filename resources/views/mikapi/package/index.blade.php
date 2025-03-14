@extends('layouts.backend.template_mikapi', ['title' => 'Data Package'])

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
        </div>


        @include('mikapi.package.add')
        @include('mikapi.package.edit')
        @include('mikapi.package.modal_profile')
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
        $.fn.dataTable.ext.errMode = 'none';

        $(document).ready(function() {
            $('#refresh').click(function() {
                table.ajax.reload()
            })

        })
        const url_index = "{{ route('mikapi.packages.index') }}"
        const url_index_api = "{{ route('api.mikapi.packages.index') }}"
        const url_index_profile = "{{ route('api.mikapi.ppp.profiles.index') }}" + param_router

        var id = 0
        var perpage = 50
        var state_action = 'add'

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
            }, {
                title: "Profile",
                data: 'profile',
            }, {
                title: "Speed Up",
                data: 'speed_up',
                className: "text-center",
                searchable: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return `${data} Mbps`
                    } else {
                        return data
                    }
                }
            }, {
                title: "Speed Down",
                data: 'speed_down',
                className: "text-center",
                searchable: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return `${data} Mbps`
                    } else {
                        return data
                    }
                }
            }, {
                title: "Price",
                data: 'price',
                className: "text-center",
                searchable: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return `Rp. ${hrg(data)}`
                    } else {
                        return data
                    }
                }
            }, {
                title: "PPN",
                data: 'ppn',
                className: "text-center",
                searchable: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return `${data}%`
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
                tooltip()
            }
        });

        var table_profile = $('#table_profile').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: url_index_profile,
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
                    $('#edit_reset').val(result.data.id);
                    $('#edit_name').val(result.data.name);
                    $('#edit_profile').val(result.data.profile);
                    $('#edit_speed_up').val(result.data.speed_up);
                    $('#edit_speed_down').val(result.data.speed_down);
                    $('#edit_price').val(result.data.price);
                    $('#edit_ppn').val(result.data.ppn);

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

        $('#select_profile_add').click(function() {
            state_action = 'add'
            $('#modalprofile').modal('show')
            table_profile.ajax.reload()
        })

        $('#select_profile_edit').click(function() {
            state_action = 'edit'
            $('#modalprofile').modal('show')
            table_profile.ajax.reload()
        })

        function set_data(data) {
            console.log(state_action);
            if (state_action == 'add') {
                $('#profile').val(data.name)
            } else {
                $('#edit_profile').val(data.name)
            }
        }

        $('#table_profile tbody').on('click', 'tr td', function() {
            data = table_profile.row(this).data()
            set_data(data)
            $('#modalprofile').modal('hide')
        });

        // });
    </script>
    <script src="{{ asset('js/v2/trigger.js') }}"></script>
@endpush
