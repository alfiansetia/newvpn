@php
    $param_router = '?router=' . request()->query('router');
@endphp

@extends('layouts.backend.template_mikapi', ['title' => 'All Voucher'])
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

    <link href="{{ cdn('backend/src/assets/css/light/elements/alert.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/dark/elements/alert.css') }}" rel="stylesheet" type="text/css">
@endpush
@section('content')
    <div class="row" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_table">
            <h5>
                <a href="{{ route('mikapi.hotspot.user.generate') }}{{ $param_router }}" class="btn btn-primary"><i
                        class="fas fa-plus"></i>
                    Add Voucher</a>
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

    </div>
@endsection
@push('jslib')
    {{-- <script src="{{ asset('js/pagination.js') }}"></script> --}}
    <script src="{{ cdn('backend/src/plugins/datatable/datatables.min.js') }}"></script>

    <!-- END PAGE LEVEL SCRIPTS -->

    <script src="{{ cdn('backend/src/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ cdn('backend/src/plugins/jquery-validation/additional-methods.min.js') }}"></script>
@endpush


@push('js')
    <script src="{{ asset('js/v2/var.js') }}"></script>
    <script src="{{ asset('js/v2/navigation.js') }}"></script>
    <script src="{{ asset('js/v2/func.js') }}"></script>
    <script>
        // $(document).ready(function() {
        $(document).ready(function() {
            $('#refresh').click(function() {
                table.ajax.reload()
            })

            // setInterval(() => {
            //     table.ajax.reload()
            // }, 10000);
        })

        const url_index = "{{ route('mikapi.voucher.index') }}"
        const url_index_api = "{{ route('api.mikapi.hotspot.users.comment') }}"
        var id = 0
        var perpage = 50

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
                                    <div class="d-flex align-items-center mt-0">
                                        <div>
                                            <i class="fa fa-ticket-alt me-2 text-${item.class}" style="font-size: 40px;"></i>
                                        </div>
                                        <div class="w-100">
                                            <h6 class="mb-0"><strong>${item.comment}</strong></h6>
                                            <p class="mb-0">${item.profile} [${item.count}]</p>
                                            <p>${item.comment}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-0  text-center pb-2">
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i data-feather="printer" class="me-1"></i> Print <i data-feather="chevron-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        <li><a class="dropdown-item" href="#">Small</a></li>
                                        <li><a class="dropdown-item" href="#">Default</a></li>
                                        <li><a class="dropdown-item" href="#">QR</a></li>
                                        </ul>
                                    </div>
                                    <button type="button" onclick="delete_data('${item.comment}')" class="btn btn-sm btn-danger w-33">
                                        <i data-feather="trash-2"></i> <span class="btn-text-inner ">Delete</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        `
                $('#row_content').append(html)
            });
            feather.replace();
        }

        var table = $('#tableData').DataTable({
            processing: true,
            serverSide: true,
            rowId: 'id',
            ajax: {
                url: url_index_api + param_router,
                error: function(jqXHR, textStatus, errorThrown) {
                    handleResponseCode(jqXHR)
                },
            },
            columnDefs: [{
                defaultContent: '',
                targets: "_all"
            }],
            lengthChange: false,
            buttons: [],
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


        function reload_data() {
            table.ajax.reload()
        }

        function open_router(idt) {
            id = idt
            let url = "{{ route('mikapi.dashboard') }}?router=" + id;
            window.open(url, '_blank');
        }

        function delete_data(comment) {
            Swal.fire({
                title: 'Are you sure?',
                text: `Delete All Voucher ${comment} ?`,
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
                    ajax_setup()
                    $.ajax({
                        url: `{{ route('api.mikapi.hotspot.users.comment') }}` + param_router,
                        data: {
                            'comment': comment
                        },
                        type: 'DELETE',
                        beforeSend: function() {
                            block();
                        },
                        success: function(res) {
                            table.ajax.reload()
                            unblock();
                            show_alert(res.message, 'success')
                        },
                        error: function(xhr, status, error) {
                            unblock();
                            handleResponse(xhr)
                        }
                    })
                }
            })

        }

        $(document).ajaxStart(function() {
            block()
        }).ajaxStop(function() {
            unblock()
        });

        // });
    </script>
    <script src="{{ asset('js/v2/trigger.js') }}"></script>
@endpush
