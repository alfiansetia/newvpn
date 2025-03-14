@extends('layouts.backend.template_mikapi', ['title' => 'Dashboard'])

@push('csslib')
    <link href="{{ cdn('backend/src/plugins/src/table/datatable/datatables.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/plugins/css/light/table/datatable/dt-global_style.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ cdn('backend/src/assets/css/light/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css"
        href="{{ cdn('backend/src/plugins/css/dark/table/datatable/dt-global_style.css') }}">
    <link href="{{ cdn('backend/src/assets/css/dark/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ cdn('backend/src/assets/css/light/components/modal.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ cdn('backend/src/assets/css/dark/components/modal.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ cdn('backend/src/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ cdn('backend/src/assets/css/light/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/light/forms/switches.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ cdn('backend/src/assets/css/dark/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/dark/forms/switches.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ cdn('backend/src/plugins/src/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ cdn('backend/src/assets/css/light/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/dark/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ cdn('backend/src/assets/css/light/components/list-group.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/light/dashboard/dash_2.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ cdn('backend/src/assets/css/dark/components/list-group.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cdn('backend/src/assets/css/dark/dashboard/dash_2.css') }}" rel="stylesheet" type="text/css" />


    <link href="{{ cdn('backend/src/plugins/src/notification/snackbar/snackbar.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ cdn('backend/src/plugins/css/light/notification/snackbar/custom-snackbar.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ cdn('backend/src/plugins/css/dark/notification/snackbar/custom-snackbar.css') }}" rel="stylesheet"
        type="text/css" />

    <link href="{{ cdn('backend/src/assets/css/light/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ cdn('backend/src/assets/css/light/components/tabs.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ cdn('backend/src/assets/css/dark/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ cdn('backend/src/assets/css/dark/components/tabs.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="row layout-top-spacing">

        @include('mikapi.dashboard.summary')
        @include('mikapi.dashboard.resource')
        @include('mikapi.dashboard.card_count')
        @include('mikapi.dashboard.log')
        @include('mikapi.dashboard.panel')

    </div>

    {{-- <button class="btn btn-primary" id="tes">TES</button>

    <button class="btn btn-primary" id="stop">STOP</button> --}}

    {{-- <div class="spinner-border" role="status"> --}}
    </div>
@endsection


@push('jslib')
    <script src="{{ cdn('backend/src/plugins/src/table/datatable/datatables.js') }}"></script>
    <!-- END PAGE LEVEL SCRIPTS -->

    <script src="{{ cdn('backend/src/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ cdn('backend/src/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script src="{{ cdn('backend/src/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ cdn('backend/src/plugins/select2/custom-select2.js') }}"></script>

    <script src="{{ cdn('backend/src/plugins/src/apex/apexcharts.min.js') }}"></script>

    <script src="{{ cdn('backend/src/plugins/src/notification/snackbar/snackbar.min.js') }}"></script>
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
        $.fn.DataTable.ext.pager.numbers_length = 5;

        var count = 0;
        var routerId = "{{ request()->query('router') }}";
        var interval;

        function dashboard() {
            clearInterval(interval);

            let url = "{{ route('api.mikapi.dashboard.get') }}" + param_router;
            let url_report = "{{ route('api.mikapi.report.summary') }}" + param_router;
            // $('#sys_ros').text('Loading...');
            // $('#sys_up').text('Loading...');
            // $('#sys_rb').text('Loading...');

            // $("#cpu_label").text('Loading...');
            // $("#cpu").css('width', '100%')
            // $("#ram_label").text('Loading...')
            // $("#ram").css('width', '100%')
            // $("#disk_label").text('Loading...')
            // $("#disk").css('width', '100%')

            // $('#hs_active').text('Loading...');
            // $('#hs_user').text('Loading...');
            // $('#ppp_active').text('Loading...');
            // $('#ppp_secret').text('Loading...');
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
                let sys_up_all = {
                    'd': 0,
                    'h': 0,
                    'm': 0,
                    's': 0
                }
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
                    sys_up_all = res.data.resource[0].uptime_parse_all
                }
                if (res.data.routerboard.length > 0) {
                    sys_rb = res.data.resource[0]['board-name'] + ' | ' + (res.data.routerboard[0]
                        .routerboard ? res.data.routerboard[0].model : 'No Routerboard!')
                }
                $('#sys_ros').text(sys_ros);
                $('#sys_up').text(sys_up);
                $('#sys_rb').text(sys_rb);
                let uptime = sys_up_all.s + (sys_up_all.m * 60) + (sys_up_all.h * 3600) + (sys_up_all.d * 86400);
                interval = setInterval(() => {
                    uptime++;

                    let uptimeDays = Math.floor(uptime / 86400);
                    let uptimeHours = Math.floor((uptime % 86400) / 3600);
                    let uptimeMinutes = Math.floor((uptime % 3600) / 60);
                    let uptimeSeconds = uptime % 60;

                    // Format angka agar selalu dua digit
                    let formattedUptime =
                        `${uptimeDays > 0 ? uptimeDays + 'd ' : ''}${String(uptimeHours).padStart(2, '0')}:${String(uptimeMinutes).padStart(2, '0')}:${String(uptimeSeconds).padStart(2, '0')}`;
                    $('#sys_up').text(formattedUptime);
                }, 1000);

                $("#cpu_label").text(cpuload + '%');
                $("#cpu").css('width', cpuload + '%')
                $("#ram_label").text("(" + formatBytes(ramtot - ramfre) + '/' + formatBytes(ramtot) + ')')
                $("#ram").css('width', ramhas + '%')
                $("#disk_label").text("(" + formatBytes(disktot - diskfre) + '/' + formatBytes(disktot) + ')')
                $("#disk").css('width', diskhas + '%')

                $('#hs_active').text(hrg(res.data.hs_active));
                $('#hs_user').text(hrg(res.data.hs_user));
                $('#ppp_active').text(hrg(res.data.ppp_active));
                $('#ppp_secret').text(hrg(res.data.ppp_secret));
                unblock();
            }).fail(function(xhr) {
                unblock();
                Snackbar.show({
                    text: xhr.responseJSON.message || 'Server Error!',
                    pos: 'bottom-left'
                });
            })

            // $('#report_today').text('Loading...')
            // $('#report_month').text('Loading...')
            $.get(url_report).done(function(res) {
                $('#report_today').text(`Today ${res.data.today.vc} vcr : ${hrg(res.data.today.total)}`);
                $('#report_month').text(`This Month ${res.data.month.vc} vcr : ${hrg(res.data.month.total)}`);
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

            $('#refresh').click(function() {
                // block();
                dashboard();
                table.ajax.reload();
            })

            dashboard();
            setInterval(() => {
                dashboard();
            }, 10000);


            var i;
            var j;

            $('#tes').click(function() {
                dashboard()
            });

            var table = $('#tableData').DataTable({
                processing: false,
                serverSide: false,
                searching: false,
                order: [
                    [0, 'desc']
                ],
                ajax: {
                    url: "{{ route('api.mikapi.logs.index') }}" + param_router +
                        '&topics=hotspot,info,debug&buffer=disk',
                    error: function(xhr, error, code) {
                        Snackbar.show({
                            text: xhr.responseJSON.message || 'Server Error!',
                            pos: 'bottom-left'
                        });
                    }
                },
                dom: "<'table-responsive'tr>" +
                    "<'dt--bottom-section  text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
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
                info: false,
                sPaginationType: 'simple_numbers',
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
