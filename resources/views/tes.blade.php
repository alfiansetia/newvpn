@extends('layouts.app', ['title' => 'Data User'])
@push('css')
    <link href="{{ cdn('backend/assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ cdn('backend/assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css">
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom card-tabs d-flex flex-wrap align-items-center gap-2">
                    <div class="flex-grow-1">
                        <h4 class="header-title">Invoices</h4>
                    </div>

                    <div class="d-flex flex-wrap flex-lg-nowrap gap-2">
                        <div class="flex-shrink-0 d-flex align-items-center gap-2">
                            <div class="position-relative">
                                <input type="text" class="form-control ps-4" placeholder="Search Here...">
                                <i class="ti ti-search position-absolute top-50 translate-middle-y start-0 ms-2"></i>
                            </div>
                        </div>
                        <a href="apps-invoice-create.html" class="btn btn-primary"><i class="ti ti-plus me-1"></i>Add
                            Invoice</a>
                    </div><!-- end d-flex -->
                </div>

                <div class="table-responsive">
                    <table class="table table-hover text-nowrap mb-0" id="tableData" style="width: 100%;cursor: pointer;">
                        <thead class="bg-light-subtle">
                            {{-- <tr>
                                <th class="ps-3" style="width: 50px;">
                                    <input type="checkbox" class="form-check-input" id="customCheck1">
                                </th>
                                <th>Product ID</th>
                                <th>Name</th>
                                <th>Description </th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th class="text-center" style="width: 120px;">Action</th>
                            </tr> --}}
                        </thead>
                        <tbody>
                            {{-- <tr>
                                <td class="ps-3">
                                    <input type="checkbox" class="form-check-input" id="customCheck2">
                                </td>
                                <td>PRD001</td>
                                <td>
                                    <div class="d-flex justify-content-start align-items-center gap-3">
                                        <div class="avatar-md">
                                            <img src="{{ cdn('backend/assets/images/products/p-1.png') }}" alt="Product-1"
                                                class="img-fluid rounded-2">
                                        </div>
                                        Men White Slim Fit T-shirt
                                    </div>
                                </td>
                                <td>100% cotton t-shirt in white</td>
                                <td>$70.90</td>
                                <td>890</td>
                                <td>Fashion</td>
                                <td>
                                    <span class="badge bg-success-subtle text-success fs-12 p-1">Active</span>
                                </td>
                                <td class="pe-3">
                                    <div class="hstack gap-1 justify-content-end">
                                        <a href="javascript:void(0);"
                                            class="btn btn-soft-primary btn-icon btn-sm rounded-circle">
                                            <i class="ti ti-eye"></i></a>
                                        <a href="javascript:void(0);"
                                            class="btn btn-soft-success btn-icon btn-sm rounded-circle">
                                            <i class="ti ti-edit fs-16"></i></a>
                                        <a href="javascript:void(0);"
                                            class="btn btn-soft-danger btn-icon btn-sm rounded-circle"> <i
                                                class="ti ti-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-3">
                                    <input type="checkbox" class="form-check-input" id="customCheck3">
                                </td>
                                <td>PRD002</td>
                                <td>
                                    <div class="d-flex justify-content-start align-items-center gap-3">
                                        <div class="avatar-md">
                                            <img src="{{ cdn('backend/assets/images/products/p-2.png') }}" alt="Product-1"
                                                class="img-fluid rounded-2">
                                        </div>
                                        55 L Laptop Backpack fits upto 16 In..
                                    </div>
                                </td>
                                <td>Durable hiking backpack</td>
                                <td>$100.90 </td>
                                <td>923</td>
                                <td>Bags</td>
                                <td>
                                    <span class="badge bg-success-subtle text-success fs-12 p-1">Active</span>
                                </td>
                                <td class="pe-3">
                                    <div class="hstack gap-1 justify-content-end">
                                        <a href="javascript:void(0);"
                                            class="btn btn-soft-primary btn-icon btn-sm rounded-circle">
                                            <i class="ti ti-eye"></i></a>
                                        <a href="javascript:void(0);"
                                            class="btn btn-soft-success btn-icon btn-sm rounded-circle">
                                            <i class="ti ti-edit fs-16"></i></a>
                                        <a href="javascript:void(0);"
                                            class="btn btn-soft-danger btn-icon btn-sm rounded-circle"> <i
                                                class="ti ti-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <ul class="pagination justify-content-center mb-0">
                            <li class="page-item disabled">
                                <a href="#" class="page-link"><i class="ti ti-chevrons-left"></i></a>
                            </li>
                            <li class="page-item">
                                <a href="#" class="page-link">1</a>
                            </li>
                            <li class="page-item active">
                                <a href="#" class="page-link">2</a>
                            </li>
                            <li class="page-item">
                                <a href="#" class="page-link">3</a>
                            </li>
                            <li class="page-item">
                                <a href="#" class="page-link"><i class="ti ti-chevrons-right"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> <!-- end card-->
        </div><!-- end col -->
    </div>
@endsection
@push('js')
    <script src="{{ cdn('backend/assets/js/function.js') }}"></script>
    <script src="{{ cdn('backend/assets/vendor/datatables.net/js/dataTables.min.js') }}"></script>
    <script src="{{ cdn('backend/assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    {{-- <script src="{{ cdn('backend/assets/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script> --}}
    <script>
        var url_index = "{{ route('users.index') }}"
        var url_index_api = "{{ route('api.users.index') }}"
        // $.fn.DataTable.ext.pager.numbers_length = 5;
        // $.fn.DataTable.ext.pager.firstLast = false;

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
            oLanguage: {
                oPaginate: {
                    sPrevious: '<i class="ti ti-chevron-left"></i>',
                    sNext: '<i class="ti ti-chevron-right"></i>'
                },
                // "sInfo": "Showing page _PAGE_ of _PAGES_",
                sSearch: 'Search',
                sSearchPlaceholder: "Search...",
                sLengthMenu: "Results :  _MENU_",
            },
            // buttons: [],
            stripeClasses: [],
            pageLength: 10,
            columns: [{
                width: "30px",
                title: 'Id',
                data: 'id',
                className: "",
                orderable: !1,
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
                    if (row.is_verified) {
                        text =
                            `<i class="fas fa-circle text-success bs-tooltip" title="Verified"></i> ${data}`;
                    } else {
                        text =
                            `<i class="fas fa-circle text-danger bs-tooltip" title="Unverified"></i> ${data}`;
                    }
                    if (type == 'display') {
                        return text
                    } else {
                        return data
                    }
                }
            }, {
                title: "Email",
                data: 'email',
            }, {
                title: "Gender",
                data: 'gender',
            }, {
                title: "Balance",
                data: 'balance',
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return hrg(data)
                    } else {
                        return data
                    }
                }
            }, {
                title: "Phone",
                data: 'phone',
            }, {
                title: 'Role',
                data: 'role',
                className: "text-center",
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return `<span class="badge badge-${row.is_admin ? 'success' : 'warning'}">${data}</span>`
                    } else {
                        return data
                    }
                }
            }, {
                title: 'Status',
                data: 'status',
                className: "text-center",
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return `<span class="badge badge-${row.is_active ? 'success' : 'danger'}">${data}</span>`
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
                // feather.replace();
                // tooltip()
            },
            initComplete: function() {
                // feather.replace();
            }
        });
    </script>
@endpush
