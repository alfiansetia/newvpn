@extends('layouts.backend.template', ['title' => 'Data Vpn'])
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

    <link href="{{ asset('backend/src/plugins/src/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/plugins/src/noUiSlider/nouislider.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/plugins/css/light/flatpickr/custom-flatpickr.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('backend/src/plugins/css/dark/flatpickr/custom-flatpickr.css') }}" rel="stylesheet"
        type="text/css">

    <link href="{{ asset('backend/src/assets/css/light/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/assets/css/light/forms/switches.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('backend/src/assets/css/dark/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/assets/css/dark/forms/switches.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('backend/src/plugins/css/light/clipboard/custom-clipboard.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('backend/src/plugins/css/dark/clipboard/custom-clipboard.css') }}" rel="stylesheet"
        type="text/css">

    <link href="{{ asset('backend/src/assets/css/light/components/tabs.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/assets/css/dark/components/tabs.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/assets/css/light/components/accordions.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/assets/css/dark/components/accordions.css') }}" rel="stylesheet" type="text/css">

    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ asset('backend/src/assets/css/light/components/list-group.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/assets/css/dark/components/list-group.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('backend/src/plugins/src/tomSelect/tom-select.default.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('backend/src/plugins/css/light/tomSelect/custom-tomSelect.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('backend/src/plugins/css/dark/tomSelect/custom-tomSelect.css') }}" rel="stylesheet"
        type="text/css">
    <!-- END THEME GLOBAL STYLES -->
@endpush
@push('css')
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
@endpush
@section('content')
    <div class="row" id="cancel-row">

        <div class="row layout-top-spacing layout-spacing pb-0" id="card_filter">
            <div class="col-md-4 mb-2">
                <select class="form-control" name="status" id="select_status">
                    <option value="">All</option>
                    <option value="1">Active</option>
                    <option value="0">Nonactive</option>
                </select>
            </div>
            <div class="col-md-4 mb-2">
                <select class="form-control" name="trial" id="select_trial">
                    <option value="">All</option>
                    <option value="1">Trial</option>
                    <option value="0">Paid</option>
                </select>
            </div>
            <div class="col-md-2 mb-2">
                <input type="text" class="form-control mask_angka" name="search_port" id="search_port"
                    placeholder="DST Port">
            </div>
            <div class="col-md-2 mb-2">
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

        @include('vpn.detail')

        @include('vpn.create')

        @include('vpn.modal')

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
    <script src="{{ asset('backend/src/plugins/src/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/moment/moment-with-locales.min.js') }}"></script>

    <script src="{{ asset('backend/src/plugins/src/clipboard/clipboard.min.js') }}"></script>

    <script src="{{ asset('backend/src/plugins/src/tomSelect/tom-select.base.js') }}"></script>
@endpush


@push('js')
    <script src="{{ asset('js/v2/var.js') }}"></script>
    <script src="{{ asset('js/v2/navigation.js') }}"></script>
    <script src="{{ asset('js/v2/func.js') }}"></script>
    <script>
        const url_index = "{{ route('vpns.index') }}"
        const url_index_api = "{{ route('api.vpns.index') }}"
        const url_index_api_temp = "{{ route('api.temporaryips.index') }}"
        var id = 0
        var perpage = 50
        var text = ''

        function get_script(param) {
            let vpn = param.data
            let type = param.name || ''
            let sc = '';
            if (type == 'pptp') {
                sc += `/interface pptp-client add `
            } else if (type == 'l2tp') {
                sc += `/interface l2tp-client add `
            } else if (type == 'sstp') {
                sc += `/interface sstp-client add `
            } else if (type == 'ovpn') {
                sc += `/interface ovpn-client add `
                sc += `mode="ethernet" `
            } else {
                return '';
            }
            sc += `disabled="no" `;
            sc += `name="tunnel_${vpn.id}_${vpn.server.name}" `
            sc += `connect-to="${vpn.server.domain}" `
            sc += `user="${vpn.username}" `
            sc += `password="${vpn.password}"; `

            sc += `\n/tool netwatch remove [find where host=${vpn.server.netwatch}]; `
            sc += `\n/tool netwatch add `
            sc += `disabled="no" `;
            sc += `host="${vpn.server.netwatch}" `;
            sc += `comment="netwatch_${vpn.server.name}" `;
            sc += `interval="1m" timeout="1s"; \n`
            return sc
        }

        var script = new TomSelect('#select_script', {
            valueField: 'name',
            labelField: 'name',
            searchField: 'name',
            preload: 'focus',
            placeholder: "Select Type Script",
            allowEmptyOption: true,
            onChange: function(value) {
                if (value != '') {
                    let data = script.options[value];
                    let sc = get_script(data)
                    $('#select_script_value').val(sc)
                } else {
                    $('#select_script_value').val('')
                }
            }
        });

        document.querySelectorAll('.tomse-server').forEach((el) => {
            var tomse = new TomSelect(el, {
                valueField: 'id',
                labelField: 'name',
                searchField: 'name',
                preload: 'focus',
                placeholder: "Please Select Server",
                allowEmptyOption: true,
                load: function(query, callback) {
                    var url = '{{ route('api.servers.paginate') }}?limit=' + perpage + '&name=' +
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
        							${ escape(item.name) }
        						</span>
        						<span class="text-muted">IP ${ escape(item.ip) }</span>
        					</div>
        			 		<div class="description">${ escape(item.domain) }</div>
        				</div>
        			</div>`;
                    },
                },
            });
        });

        document.querySelectorAll('.tomse-user').forEach((el) => {
            var tomse = new TomSelect(el, {
                valueField: 'id',
                labelField: 'email',
                searchField: 'email',
                preload: 'focus',
                placeholder: "Please Select User",
                allowEmptyOption: true,
                load: function(query, callback) {
                    var url = '{{ route('api.users.paginate') }}?limit=' + perpage + '&email=' +
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
        							${ escape(item.email) }
        						</span>
        					</div>
        			 		<div class="description">${ escape(item.name) }</div>
        				</div>
        			</div>`;
                    },
                },
            });
        });

        new TomSelect("#amount", {
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            preload: 'focus',
            placeholder: "Please Select Amount",
            allowEmptyOption: true,
        });

        $('#reset').click(function() {
            document.getElementById('server').tomselect.setValue('all');
            document.getElementById('email').tomselect.clear()
        })

        $('#send_email').after(`<button type="button" id="btn_extend"
                                class="btn btn-danger me-1 mb-2"><i
                                    class="fas fa-external-link-alt me-1 bs-tooltip"
                                    title="Extend With Balance"></i>Extend / Perpanjang</button>`)

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

        $('.close-detail').click(function() {
            hide_card_detail()
        })

        $('.close-add').click(function() {
            hide_card_add()
        })

        $('#send_email').click(function() {
            $('#modalSendEmail').modal('show')
        })

        $('#modalSendEmail').on('shown.bs.modal', function() {
            $('input[name="email"]').focus();
        });

        $('#form_send_email').submit(function(event) {
            event.preventDefault();
        }).validate({
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
                $(element).addClass('is-valid');
            },
            submitHandler: function(form) {
                ajax_setup()
                $.ajax({
                    type: 'POST',
                    url: `${url_index_api}/${id}/send-email`,
                    data: $(form).serialize(),
                    beforeSend: function() {
                        block();
                    },
                    success: function(res) {
                        unblock();
                        show_alert(res.message, 'success')
                    },
                    error: function(xhr, status, error) {
                        unblock();
                        handleResponseForm(xhr, 'form_send_email')
                        Swal.fire(
                            'Failed!',
                            xhr.responseJSON.message,
                            'error'
                        )
                    }
                });
            }
        });

        // $(document).ready(function() {
        var f1 = flatpickr(document.getElementById('expired'), {
            defaultDate: "today",
            disableMobile: true,
        });

        var f2 = flatpickr(document.getElementById('edit_expired'), {
            disableMobile: true,
        });

        var clipboard = new ClipboardJS('.clipboard');

        function share(data) {
            let text;
            text = `============================\n`;
            text += `Detail Of VPN : ${data.username}\n`;
            text += `============================\n`;
            text += `Username : ${data.username}\n`;
            text += `Password : ${data.password}\n`;
            text += `IP       : ${data.ip}\n`;
            text += `------------------------------------------------\n`;
            text += `Server Name     : ${data.server.name}\n`;
            text += `Server Domain   : ${data.server.domain}\n`;
            text += `Server IP       : ${data.server.ip}\n`;
            text += `Server Location : ${data.server.location}\n`;
            text += `------------------------------------------------\n`;
            text += `Created At : ${moment.utc(data.created_at, "YYYY-MM-DD\THH:mm:ss\Z").format('DD MMM YYYY')}\n`;
            text +=
                `Status     : ${data.is_active  ? 'Active': 'Nonactive' + (data.is_trial ? ' Trial' : '')}\n`;
            text += `Expired    : ${moment(data.expired).format('DD MMM YYYY')}\n`;
            text += `------------------------------------------------\n`;
            for (let i = 0; i < data.ports.length; i++) {
                text += `Port ${data.ports[i].to} <=> ${data.server.domain}:${data.ports[i].dst}\n`;
            }
            text += `------------------------------------------------\n`;
            text += `Tgl         : ${moment().format('DD MMM YYYY HH:mm:ss')}\n`;
            text += `Generate By : {{ auth()->user()->name }}\n`;
            text += `------------------------------------------------\n`;
            text += `CS          : 082324129752\n`;
            text += `Web         : https://kacangan.net\n`;
            text += `Member Area : https://member.kacangan.net\n`;
            text += `Tutorial    : https://blog.kacangan.net\n`;
            text += `WA Channel  : {{ config('whatsapp.channel_url') }}\n`;
            text += `------------------------------------------------\n`;
            text += `Terima Kasih Telah Menggunakan Layanan Kami\n`;
            text += `============================\n`;
            return text;
        }

        // $(document).ready(function() {


        $('[data-mask]').inputmask();

        $('#home-tab-icon, #profile-tab-icon').click(function() {
            $('#edit_reset').click()
        })

        $('#btn_filter').click(function() {
            table.ajax.reload()
        })

        $('.maxlength').maxlength({
            alwaysShow: true,
            placement: "top",
        });

        var table = $('#tableData').DataTable({
            processing: true,
            serverSide: true,
            rowId: 'id',
            ajax: {
                url: url_index_api,
                data: function(d) {
                    d.is_active = $('#select_status').val()
                    d.is_trial = $('#select_trial').val()
                    d.dst = $('#search_port').val();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    handleResponseCode(jqXHR)
                },
            },
            columnDefs: [{
                defaultContent: '',
                targets: "_all"
            }, ],
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
                    input_focus('ip')
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
                title: "User",
                orderable: false,
                data: 'user.email',
            }, {
                title: "Username",
                data: 'username',
                render: function(data, type, row, meta) {
                    if (row.is_active && row.is_trial) {
                        text =
                            `<i class="fas fa-circle text-warning bs-tooltip" title="Active Trial"></i> ${data}`;
                    } else if (row.is_active && !row.is_trial) {
                        text =
                            `<i class="fas fa-circle text-success bs-tooltip" title="Active"></i> ${data}`;
                    } else {
                        text =
                            `<i class="fas fa-circle text-danger bs-tooltip" title="Nonactive ${row.is_trial ? 'Trial': ''}"></i> ${data}`;
                    }
                    if (type === 'display') {
                        return text
                    } else {
                        return data
                    }
                }
            }, {
                title: "Server",
                orderable: false,
                data: 'server.name',
            }, {
                title: "IP",
                data: 'ip',
            }, {
                title: "Expired",
                className: 'text-start',
                data: 'expired',
            }, {
                title: "Desc",
                data: 'desc',
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
            }
        });

        multiCheck(table);

        $('#share').click(function() {
            if (navigator.share) {
                navigator.share({
                    title: "Share VPN",
                    text: text,
                }).then(() => {
                    Swal.fire(
                        'Success!',
                        'Thanks For Sharing!',
                        'success'
                    )
                }).catch(err => {
                    Swal.fire(
                        'Failed!',
                        "Error while using Web share API:",
                        'error'
                    )
                    console.log("Error while using Web share API:");
                    console.log(err);
                });
            } else {
                Swal.fire(
                    'Failed!',
                    "Browser doesn't support this API !",
                    'error'
                )
            }
        })

        $('#wa').click(function() {
            var win = window.open('https://api.whatsapp.com/send/?phone=&text=' +
                encodeURIComponent(text), '_blank');
            win.focus();
        })

        $('#tableData tbody').on('click', 'tr td:not(:first-child)', function() {
            id = table.row(this).id()
            $('#formEdit').attr('action', url_index_api + "/" + id)
            $('#form_extend').attr('action', "{{ route('api.vpns.user.index') }}" + "/" + id)
            let data = table.row(this).data()
            if (data.user != null) {
                $('#input_send_email').val(data.user.email)
            }
            edit(true)
        });

        function edit(show = false) {
            clear_validate('formEdit')
            $.ajax({
                url: url_index_api + "/" + id,
                method: 'GET',
                success: function(result) {
                    unblock();
                    text = share(result.data)

                    $('#edit_username').val(result.data.username);
                    $('#edit_password').val(result.data.password);
                    $('#edit_ip').val(result.data.ip);
                    $('#edit_ip').val(result.data.ip);
                    $('#edit_desc').val(result.data.desc);

                    f2.setDate(result.data.expired);
                    let tom_user = document.getElementById('edit_email').tomselect
                    let tom_server = document.getElementById('edit_server').tomselect
                    tom_user.clear()
                    tom_server.clear()
                    if (result.data.user_id != null) {
                        tom_user.addOption(result.data.user)
                        tom_user.setValue(result.data.user_id)
                    }
                    if (result.data.server_id != null) {
                        tom_server.addOption(result.data.server)
                        tom_server.setValue(result.data.server_id)
                    }
                    $('#edit_is_trial').prop('checked', result.data.is_trial).change();
                    $('#edit_is_active').prop('checked', result.data.is_active).change();

                    $('#edit_sync').prop('checked', true).change();

                    $('#detail_server_name').html(result.data.server.name);
                    $('#detail_server_ip').html(result.data.server.ip);
                    $('#detail_server_domain').html(result.data.server.domain);
                    $('#detail_server_netwatch').html(result.data.server.netwatch);
                    if (result.data.server.is_active) {
                        $('#detail_server_status').html(
                            `<span class="badge badge-success">Active</span>`);
                    } else {
                        $('#detail_server_status').html(
                            `<span class="badge badge-danger">Nonactive</span>`);
                    }

                    $('#detail_acc_username').html(result.data.username);
                    $('#detail_acc_password').html(result.data.password);
                    $('#detail_acc_ip').html(result.data.ip);
                    let create = moment.utc(result.data.created_at,
                        "YYYY-MM-DD\THH:mm:ss\Z").format('DD MMM YYYY');
                    let expired = moment(result.data.expired).format('DD MMM YYYY');
                    $('#detail_acc_create').html(create);
                    $('#detail_acc_expired').html(expired);

                    let status = $('#account_status');
                    if (result.data.is_active && !result.data.is_trial) {
                        status.html('<span class="badge badge-success">Active</span>')
                    } else if (result.data.is_active && result.data.is_trial) {
                        status.html('<span class="badge badge-warning">Trial</span>')
                    } else {
                        status.html(
                            `<span class="badge badge-danger">Nonactive ${result.data.is_trial ? 'Trial' : ''}</span>`
                        )
                    }

                    $('#table_port').html('');
                    if (result.data.ports.length > 0) {
                        let a = '';
                        for (let i = 0; i < result.data.ports.length; i++) {
                            a += '<li class="list-group-item border-0 pb-0">'
                            a +=
                                `<span class="badge badge-success clipboard bs-tooltip me-1" id="detail_port_${i}" title="Click to copy!" data-clipboard-action="copy" data-clipboard-target="#detail_port_${i}">${result.data.server.domain}:${result.data.ports[i].dst}</span><i class="fas fa-exchange-alt ms-1 me-1"></i><span class="badge badge-info">${result.data.ports[i].to}</span>`;
                            a += '</li>'
                        }
                        $('#table_port').html(a);
                    }

                    $('#detail_con_serv').html('Vpn Not Connect!')
                    $('#detail_con_call').html('Vpn Not Connect!')
                    $('#detail_con_up').html('Vpn Not Connect!')
                    $('#detail_con_last').html('No Data!')
                    if (result.data.origin != null) {
                        if (result.data.origin.active != null) {
                            $('#detail_con_serv').html(result.data.origin.active.service)
                            $('#detail_con_call').html(result.data.origin.active['caller-id'])
                            $('#detail_con_up').html(result.data.origin.active.uptime)
                        }
                        if (result.data.origin.active != null) {
                            $('#detail_con_last').html(result.data.origin.detail['last-logged-out'])
                        }
                    }

                    tooltip()

                    let amount = document.getElementById('amount').tomselect
                    amount.clear()
                    for (let i = 1; i <= 6; i++) {
                        amount.addOption([{
                            id: i,
                            'name': `${i} Bulan, (Rp. ${hrg(i*result.data.server.price)})`
                        }])
                    }
                    amount.addOption([{
                        id: 12,
                        'name': `1 Tahun Rp. ${hrg(result.data.server.annual_price)}`
                    }])

                    document.querySelectorAll('.accordion .collapse:not(.show)').forEach((item) => {
                        new bootstrap.Collapse(item, {
                            toggle: false
                        }).show();
                    });

                    let script = document.getElementById('select_script').tomselect
                    script.clear()
                    let type = ['pptp', 'l2tp', 'sstp', 'ovpn']
                    type.forEach(item => {
                        script.addOption({
                            name: item,
                            data: result.data
                        })
                    });

                    if (show) {
                        show_card_detail()
                        input_focus('username')
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

        $('#btn_temp').click(function() {
            Swal.fire({
                title: 'Are you sure Delete & Move to Temporary?',
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
                        type: 'POST',
                        url: `${url_index_api}/${id}/temporary`,
                        beforeSend: function() {
                            block();
                        },
                        success: function(res) {
                            refresh = true
                            show_index()
                            table.ajax.reload();
                            show_alert(res.message, 'success')
                            unblock();
                        },
                        error: function(xhr, status, error) {
                            unblock();
                            handleResponse(xhr)
                        }
                    });
                }
            })
        })

        $('#btn_extend').click(function() {
            $('#modal_extend').modal('show')
        })

        $('#form_extend').submit(function(event) {
            event.preventDefault();
        }).validate({
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
                $(element).addClass('is-valid');
            },
            submitHandler: function(form) {
                send_ajax_only('form_extend', 'PUT')
            }
        });

        // });
    </script>
    <script src="{{ asset('js/v2/trigger.js') }}"></script>
@endpush
