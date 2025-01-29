@extends('layouts.backend.template_mikapi', ['title' => 'Voucher Template'])

@push('csslib')
    <link href="{{ asset('backend/src/assets/css/light/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/assets/css/light/forms/switches.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('backend/src/assets/css/dark/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/assets/css/dark/forms/switches.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('backend/src/assets/css/light/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/src/assets/css/light/components/tabs.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/src/assets/css/dark/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/src/assets/css/dark/components/tabs.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('backend/src/assets/css/light/components/media_object.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/src/assets/css/dark/components/media_object.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="row layout-top-spacing">

        <div class="row">

            @foreach ($data as $item)
                <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-6 mx-auto mb-3">

                    <div class="card bg-{{ getrandomclass() }}">
                        <div class="card-body">
                            <h5 class="card-title text-center">{{ $item->name }}</h5>
                            <p class="mb-0"><a href="{{ route('mikapi.vouchertemplate.show', $item->id) }}"
                                    onclick="window.open(this.href, 'newwindow', 'width=500,height=500'); return false;"
                                    target="_blank">Preview</a></p>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>



    </div>

    {{-- <button class="btn btn-primary" id="tes">TES</button>

    <button class="btn btn-primary" id="stop">STOP</button> --}}

    {{-- <div class="spinner-border" role="status"> --}}
    </div>
@endsection


@push('jslib')
    <script src="{{ asset('backend/src/plugins/src/table/datatable/datatables.js') }}"></script>
    <!-- END PAGE LEVEL SCRIPTS -->

    <script src="{{ asset('backend/src/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script src="{{ asset('backend/src/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/select2/custom-select2.js') }}"></script>

    <script src="{{ asset('backend/src/plugins/src/apex/apexcharts.min.js') }}"></script>

    <script src="{{ asset('backend/src/plugins/src/notification/snackbar/snackbar.min.js') }}"></script>
@endpush
@push('js')
    <script src="{{ asset('js/v2/func.js') }}"></script>

    @if (session()->has('error'))
        <script>
            $(document).ready(function() {
                show_alert("{{ session('error') }}", 'error')
            })
        </script>
    @endif


    <script>
        var count = 0;
        var routerId = "{{ request()->query('router') }}";

        function dashboard() {
            let url = "{{ route('api.mikapi.dashboard.get') }}" + param_router;
            $.get(url).done(function(res) {
                let cpuload = 0
                let ramtot = 0
                let ramfre = 0
                let ramhas = 0

                let disktot = 0
                let diskfre = 0
                let diskhas = 0
                let sys_ros = 'No data!'
                let sys_up = 'No data!'
                let sys_rb = 'No data!'
                if (res.data.resource.length > 0) {
                    cpuload = Math.round(res.data.resource[0]['cpu-load']);
                    ramtot = res.data.resource[0]['total-memory'];
                    ramfre = res.data.resource[0]['free-memory'];
                    ramhas = Math.round((ramtot - ramfre) / ramtot * 100);

                    disktot = res.data.resource[0]['total-hdd-space'];
                    diskfre = res.data.resource[0]['free-hdd-space'];
                    diskhas = Math.round((disktot - diskfre) / disktot * 100);

                    sys_ros = res.data.resource[0].version
                    sys_up = res.data.resource[0].uptime_parse
                }
                if (res.data.routerboard.length > 0) {
                    sys_rb = res.data.resource[0]['board-name'] + ' | ' + (res.data.routerboard[0]
                        .routerboard ? res.data.routerboard[0].model : 'No Routerboard!')
                }
                $('#sys_ros').text(sys_ros);
                $('#sys_up').text(sys_up);
                $('#sys_rb').text(sys_rb);

                $("#cpu_label").text(cpuload + '%');
                $("#cpu").css('width', cpuload + '%')
                $("#ram_label").text("(" + formatBytes(ramtot - ramfre) + '/' + formatBytes(ramtot) + ')')
                $("#ram").css('width', ramhas + '%')
                $("#disk_label").text("(" + formatBytes(disktot - diskfre) + '/' + formatBytes(disktot) + ')')
                $("#disk").css('width', diskhas + '%')

                $('#hs_active').text(res.data.hs_active);
                $('#hs_user').text(res.data.hs_user);
                $('#ppp_active').text(res.data.ppp_active);
                $('#ppp_secret').text(res.data.ppp_secret);
                unblock();
            }).fail(function(xhr) {
                unblock();
                Snackbar.show({
                    text: xhr.responseJSON.message || 'Server Error!',
                    pos: 'bottom-left'
                });
            })
        }

        $(document).ready(function() {
            $('.refresh-data').click(function() {
                block();
                dashboard();
                table.ajax.reload();
            })

            dashboard();

            var i;
            var j;

            $('#tes').click(function() {
                dashboard()
            });

            var table = $('#tableData').DataTable({
                processing: true,
                serverSide: false,
                searching: false,
                order: [
                    [0, 'desc']
                ],
                ajax: {
                    url: "{{ route('api.mikapi.logs.index') }}" + param_router +
                        '&topics=hotspot,info,debug&buffer=disk',
                    error: function(xhr, error, code) {
                        if (xhr.status == 500) {
                            Snackbar.show({
                                text: 'Server Error!',
                                pos: 'bottom-left'
                            });
                        } else {
                            Snackbar.show({
                                text: xhr.responseJSON.message,
                                pos: 'bottom-left'
                            });
                        }
                    }
                },
                dom: "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                oLanguage: {
                    "oPaginate": {
                        "sPrevious": '<i data-feather="arrow-left"></i>',
                        "sNext": '<i data-feather="arrow-right"></i>'
                    },
                    "sInfo": "Showing page _PAGE_ of _PAGES_",
                    "sSearch": '<i data-feather="search"></i>',
                    "sSearchPlaceholder": "Search...",
                    "sLengthMenu": "Results :  _MENU_",
                },
                lengthMenu: [
                    [10, 50, 100, 500, 1000],
                    ['10 rows', '50 rows', '100 rows', '500 rows', '1000 rows']
                ],
                pageLength: 10,
                lengthChange: false,
                columns: [{
                    title: "Time",
                    data: 'time'
                }, {
                    title: "Ip/User",
                    data: 'ip',
                }, {
                    title: "Message",
                    data: 'message_parse',
                }],
                drawCallback: function(settings) {
                    feather.replace();
                    unblock()
                },
                initComplete: function() {
                    feather.replace();
                    unblock()
                }
            });

        });

        function send(formID, message) {
            Swal.fire({
                title: 'Are you sure?',
                text: message,
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
                        type: 'POST',
                        url: $(`#${formID}`).attr('action'),
                        beforeSend: function() {
                            block();
                        },
                        success: function(res) {
                            unblock();
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


        $('#btn_shutdown').click(function() {
            send('form_shutdown', 'Shutdown Router?')

        })

        $('#btn_reboot').click(function() {
            send('form_reboot', 'Reboot Router?')

        })
    </script>
@endpush
