@extends('layouts.backend.template', ['title' => 'Data Vpn'])
@push('csslib')
    <!-- DATATABLE -->
    <link href="{{ asset('backend/src/plugins/datatable/datatables.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/plugins/src/table/datatable/datatables.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('backend/src/plugins/src/table/datatable/datatables.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/plugins/css/light/table/datatable/dt-global_style.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('backend/src/assets/css/light/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('backend/src/plugins/css/dark/table/datatable/dt-global_style.css') }}"
        type="text/css">
    <link href="{{ asset('backend/src/assets/css/dark/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('backend/src/assets/css/light/components/modal.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/src/assets/css/dark/components/modal.css') }}" rel="stylesheet" type="text/css" />

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

        <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_detail"
            style="display: none;">
            <div class="widget-content widget-content-area br-8">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab-icon" data-bs-toggle="tab"
                                    data-bs-target="#home-tab-icon-pane" type="button" role="tab"
                                    aria-controls="home-tab-icon-pane" aria-selected="true">
                                    <i data-feather="info" class="bs-tooltip" title="Detail"></i> Detail
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="simple-pill">

                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home-tab-icon-pane" role="tabpanel"
                                    aria-labelledby="home-tab-icon" tabindex="0">
                                    <div class="media">
                                        <div class="media-body">
                                            <div id="iconsAccordion" class="accordion-icons accordion">
                                                <div class="row">
                                                    <div class="col-xs-12 col-md-6 col-xl-4 mb-2">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <section class="mb-0 mt-0">
                                                                    <div role="menu" class="collapsed"
                                                                        data-bs-toggle="collapse"
                                                                        data-bs-target="#iconAccordionOne"
                                                                        aria-expanded="true"
                                                                        aria-controls="iconAccordionOne">
                                                                        <div class="accordion-icon">
                                                                            <i data-feather="server"></i>
                                                                        </div>
                                                                        Info Server
                                                                        <div class="icons">
                                                                            <i data-feather="chevron-down"></i>
                                                                        </div>
                                                                    </div>
                                                                </section>
                                                            </div>
                                                            <div id="iconAccordionOne"
                                                                class="accordion-collapse collapse show">
                                                                <div class="card-body p-0">
                                                                    <table class="table"
                                                                        style="width: 100%; table-layout: fixed;">
                                                                        <tr>
                                                                            <td class="tba">Name Server</td>
                                                                            <td class="tbb clipboard bs-tooltip"
                                                                                title="Click to copy!"
                                                                                data-container="body"
                                                                                data-clipboard-action="copy"
                                                                                data-clipboard-target="#detail_server_name"
                                                                                id="detail_server_name">Loading..
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>IP Server</td>
                                                                            <td class="tbb clipboard bs-tooltip"
                                                                                title="Click to copy!"
                                                                                data-clipboard-action="copy"
                                                                                data-clipboard-target="#detail_server_ip"
                                                                                id="detail_server_ip">Loading..
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="tba">Domain Server</td>
                                                                            <td class="tbb clipboard bs-tooltip"
                                                                                title="Click to copy!"
                                                                                data-clipboard-action="copy"
                                                                                data-clipboard-target="#detail_server_domain"
                                                                                id="detail_server_domain">Loading..
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="tba">IP Netwatch</td>
                                                                            <td class="tbb clipboard bs-tooltip"
                                                                                title="Click to copy!"
                                                                                data-clipboard-action="copy"
                                                                                data-clipboard-target="#detail_server_netwatch"
                                                                                id="detail_server_netwatch">Loading..
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="tba">Server Status</td>
                                                                            <td class="tbb clipboard bs-tooltip"
                                                                                title="Click to copy!"
                                                                                data-clipboard-action="copy"
                                                                                data-clipboard-target="#detail_server_status"
                                                                                id="detail_server_status"><span
                                                                                    class="badge badge-success">Loading..</span>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-md-6 col-xl-4 mb-2">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <section class="mb-0 mt-0">
                                                                    <div role="menu" class="collapsed"
                                                                        data-bs-toggle="collapse"
                                                                        data-bs-target="#iconAccordionTwo"
                                                                        aria-expanded="false"
                                                                        aria-controls="iconAccordionTwo">
                                                                        <div class="accordion-icon">
                                                                            <i data-feather="share-2"></i>
                                                                        </div>
                                                                        Info Account <span id="account_status"
                                                                            class="font-sm"></span>
                                                                        <div class="icons">
                                                                            <i data-feather="chevron-down"></i>
                                                                        </div>
                                                                    </div>
                                                                </section>
                                                            </div>
                                                            <div id="iconAccordionTwo"
                                                                class="accordion-collapse collapse show">
                                                                <div class="card-body p-0">
                                                                    <table class="table"
                                                                        style="width: 100%; table-layout: fixed;">
                                                                        <tr>
                                                                            <td class="tba">Username</td>
                                                                            <td class="tbb clipboard bs-tooltip"
                                                                                title="Click to copy!"
                                                                                data-clipboard-action="copy"
                                                                                data-clipboard-target="#detail_acc_username"
                                                                                id="detail_acc_username">Loading..</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="tba">Password</td>
                                                                            <td class="tbb clipboard bs-tooltip"
                                                                                title="Click to copy!"
                                                                                data-clipboard-action="copy"
                                                                                data-clipboard-target="#detail_acc_password"
                                                                                id="detail_acc_password">Loading..</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="tba">IP</td>
                                                                            <td class="tbb clipboard bs-tooltip"
                                                                                title="Click to copy!"
                                                                                data-clipboard-action="copy"
                                                                                data-clipboard-target="#detail_acc_ip"
                                                                                id="detail_acc_ip">
                                                                                Loading..</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="tba">Create On</td>
                                                                            <td class="tbb clipboard bs-tooltip"
                                                                                title="Click to copy!"
                                                                                data-clipboard-action="copy"
                                                                                data-clipboard-target="#detail_acc_create"
                                                                                id="detail_acc_create">
                                                                                Loading..</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="tba">Expired On</td>
                                                                            <td class="tbb clipboard bs-tooltip"
                                                                                title="Click to copy!"
                                                                                data-clipboard-action="copy"
                                                                                data-clipboard-target="#detail_acc_expired"
                                                                                id="detail_acc_expired">Loading..</td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-md-6 col-xl-4 mb-2">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <section class="mb-0 mt-0">
                                                                    <div role="menu" class=""
                                                                        data-bs-toggle="collapse"
                                                                        data-bs-target="#iconAccordionThree"
                                                                        aria-expanded="false"
                                                                        aria-controls="iconAccordionThree">
                                                                        <div class="accordion-icon">
                                                                            <i data-feather="link"></i>
                                                                        </div>
                                                                        URl Remote
                                                                        <div class="icons">
                                                                            <i data-feather="chevron-down"></i>
                                                                        </div>
                                                                    </div>
                                                                </section>
                                                            </div>
                                                            <div id="iconAccordionThree"
                                                                class="accordion-collapse collapse show">
                                                                <div class="card-body pt-0 ps-0">
                                                                    <ul class="list-group" id="table_port">
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-md-6 col-xl-6 mb-2">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <section class="mb-0 mt-0">
                                                                    <div role="menu" class=""
                                                                        data-bs-toggle="collapse"
                                                                        data-bs-target="#iconAccordionFour"
                                                                        aria-expanded="false"
                                                                        aria-controls="iconAccordionFour">
                                                                        <div class="accordion-icon">
                                                                            <i data-feather="code"></i>
                                                                        </div>
                                                                        Script Mikrotik
                                                                        <div class="icons">
                                                                            <i data-feather="chevron-down"></i>
                                                                        </div>
                                                                    </div>
                                                                </section>
                                                            </div>
                                                            <div id="iconAccordionFour"
                                                                class="accordion-collapse collapse show">
                                                                <div class="card-body">
                                                                    <div class="form-row">
                                                                        <select class="form-control mb-2"
                                                                            id="select_script"></select>
                                                                        <textarea class="form-control mb-2" id="select_script_value" rows="4"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="card-footer text-center">
                                                <button type="button" class="btn btn-secondary close-detail me-1 mb-2"><i
                                                        class="fas fa-times me-1 bs-tooltip"
                                                        title="Close"></i>Close</button>
                                                <button type="button" id="share" class="btn btn-info me-1 mb-2"><i
                                                        class="fas fa-share-alt me-1 bs-tooltip"
                                                        title="Share"></i>Share</button>
                                                <button type="button" id="wa"
                                                    class="btn btn-success me-1 mb-2"><i
                                                        class="fab fa-whatsapp me-1 bs-tooltip"
                                                        title="Share Whatsapp"></i>WA</button>
                                                <button type="button" id="btn_extend"
                                                    class="btn btn-danger me-1 mb-2"><i
                                                        class="fas fa-external-link-alt me-1 bs-tooltip"
                                                        title="Extend With Balance"></i>Extend / Perpanjang</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="modal animated fade fadeInDown" id="modal_extend" tabindex="-1" role="dialog"
            aria-labelledby="modal_extend" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-lg modal-dialog-centered " role="document">
                <div class="modal-content">
                    <form class="was-validated" action="" id="form_extend">
                        <div class="modal-header">
                            <h5 class="modal-title" id="titleEdit"><i class="fas fa-info me-1 bs-tooltip"
                                    title="Extend With Balance"></i>Extend With Balance</h5>
                            <button type="button" class="btn-close bs-tooltip" data-bs-dismiss="modal"
                                aria-label="Close" title="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group mb-2">
                                <label for="amount">Value Extend :</label>
                                <select name="amount" id="amount" class="form-control-lg" style="width: 100%;"
                                    required>
                                </select>
                                <span id="err_amount" class="error invalid-feedback" style="display: hide;"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                                    class="fas fa-times me-1 bs-tooltip" title="Close"></i>Close</button>
                            <button id="btn_modal_submit" type="submit" class="btn btn-primary"><i
                                    class="fas fa-paper-plane me-1 bs-tooltip" title="Submit"></i>Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


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
        const url_index_api = "{{ route('api.vpns.user.index') }}"
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

        new TomSelect("#amount", {
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            preload: 'focus',
            placeholder: "Please Select Amount",
            allowEmptyOption: true,
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

        $('.close-detail').click(function() {
            hide_card_detail()
        })

        $('.close-add').click(function() {
            hide_card_add()
        })

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
                text: '<i class="fas fa-plus"></i> Order VPN',
                className: 'btn btn-primary',
                action: function(e, dt, node, config) {
                    window.location.href = "{{ route('vpns.create') }}"
                },
            }, ],
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
            $('#form_extend').attr('action', url_index_api + "/" + id)
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
