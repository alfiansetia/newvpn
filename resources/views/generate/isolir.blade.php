@extends('layouts.backend.template', ['title' => 'Isolir'])

@push('css')
    <link href="{{ asset('backend/src/assets/css/light/components/list-group.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/src/assets/css/light/users/user-profile.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/src/assets/css/dark/components/list-group.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/src/assets/css/dark/users/user-profile.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('backend/src/assets/css/light/elements/alert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/src/assets/css/dark/elements/alert.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('backend/src/assets/css/light/pages/contact_us.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/src/assets/css/dark/pages/contact_us.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="row layout-top-spacing layout-spacing p-2">
        <h2>Coming soon</h2>
    </div>

    {{-- <div class="row layout-top-spacing layout-spacing p-2">
        <form id="form" class="was-validated col-lg-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Generate Speed Test Script</h5>
                </div>
                <div class="card-body">
                    <div class="row" id="div_form">
                        <div class="form-group col-md-12 mb-2">
                            <label class="control-label" for="ros">Ros Version :</label>
                            <select name="ros" id="ros" class="form-select" style="width: 100%;" required>
                                <option value="v6">v6</option>
                                <option value="v7">v7</option>
                            </select>
                            <span class="error invalid-feedback err_ros" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-12 mb-2">
                            <label class="control-label" for="gateway">Gateway IP VPN :</label>
                            <input type="text" name="gateway" class="form-control" id="gateway"
                                placeholder="192.168.168.1" minlength="2" maxlength="50" value="192.168.168.1"
                                autofocus required>
                            <span class="error invalid-feedback err_gateway" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-12 mb-2">
                            <label class="control-label" for="local">IP Local :</label>
                            <div class="input-group">
                                <input type="text" name="local" class="form-control local" id="local"
                                    placeholder="192.168.0.0/24" minlength="3" maxlength="50" value="192.168.0.0/24"
                                    required>
                                <button type="button" class="btn btn-success" id="local_add"
                                    onclick="add_local()">+</button>
                            </div>
                            <span class="error invalid-feedback err_local" style="display: hide;"></span>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <div class="row">
                        <div class="col-12">
                            <a href="" class="btn btn-warning mb-2">
                                <i class="fas fa-undo me-1 bs-tooltip" title="Reset"></i>Reset</a>
                            <button type="submit" class="btn btn-primary mb-2">
                                <i class="fas fa-paper-plane me-1 bs-tooltip" title="Generate"></i>Generate
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form class="was-validated col-lg-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Result</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-12 mb-2">
                            <label class="control-label" for="add_loc">Address List Local :</label>
                            <textarea name="add_loc" id="add_loc" class="form-control"></textarea>
                        </div>
                        <div class="form-group col-md-12 mb-2">
                            <label class="control-label" for="add_sp">Address List Speedtest :</label>
                            <textarea name="add_sp" id="add_sp" class="form-control"></textarea>
                        </div>
                        <div class="form-group col-md-12 mb-2">
                            <label class="control-label" for="nat">NAT :</label>
                            <textarea name="nat" id="nat" class="form-control"></textarea>
                        </div>
                        <div class="form-group col-md-12 mb-2">
                            <label class="control-label" for="mangle">Mangle :</label>
                            <textarea name="mangle" id="mangle" class="form-control"></textarea>
                        </div>
                        <div class="form-group col-md-12 mb-2">
                            <label class="control-label" for="route">Route :</label>
                            <textarea name="route" id="route" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <div class="row">
                        <div class="col-12">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div> --}}
@endsection

@push('jslib')
@endpush

@push('js')
    <script>
        var LOCAL = 1

        function add_local(value = "") {
            let html = `
                    <div class="form-group col-md-12 mb-2" id="local_${LOCAL}">
                        <label class="control-label" for="local_id_${LOCAL}">IP Local :</label>
                        <div class="input-group">
                            <input type="text" name="local" class="form-control local" id="local_id_${LOCAL}"
                                placeholder="192.168.0.0/24" value="${value}" minlength="3" maxlength="50" required>
                            <button type="button" class="btn btn-danger" onclick="delete_local(${LOCAL})">-</button>
                        </div>
                        <span class="error invalid-feedback err_local" style="display: hide;"></span>
                    </div>`
            LOCAL = LOCAL + 1
            $('#div_form').append(html)
        }

        function delete_local(id) {
            $('#local_' + id).remove()
        }

        $(document).ready(function() {
            add_local('192.168.1.0/24')
            add_local('172.16.0.0/24')
            $('#form').submit(function(e) {
                let ver = $('#ros').val()
                e.preventDefault()

                let add_loc = '/ip firewall address-list \n'
                $('.local').each(function() {
                    add_loc += 'add list="private-lokal" address="' + $(this).val() + '" \n'
                });
                let add_sp = '/ip firewall address-list \n'
                const domains = [
                    'yougetsignal.com',
                    'xmyip.com',
                    'www.yougetsignal.com',
                    'expressvpn.com',
                    'www.expressvpn.com',
                    'whatismyip.net',
                    'speedtestcustom.com',
                    'income.speedtestcustom.com',
                    'www.iplocation.net',
                    'www.astrill.com',
                    'www.privateinternetaccess.com',
                    'mxtoolbox.com',
                    'ifconfig.co',
                    'whatismyip.org',
                    'www.goldenfrog.com',
                    'www.mxtoolbox.com',
                    'www.ultratools.com',
                    'www.ip-adress.eu',
                    'iplogger.org',
                    'www.vermiip.es',
                    'www.purevpn.com',
                    'www.whatismybrowser.com',
                    'zenmate.com',
                    'www.ipchicken.com',
                    "bittrex.com",
                    "whatismyip.li",
                    "www.ipburger.com",
                    "cbn.net.id",
                    "whatismyip4.com",
                    "www.inmotionhosting.com",
                    "nordvpn.com",
                    "wolframalpha.com",
                    "cactusvpn.com",
                    "www.cactusvpn.com",
                    "m.wolframalpha.com",
                    "ipcow.com",
                    "whatismycountry.com",
                    "passwordsgenerator.net",
                    "att-services.net",
                    "wtfismyip.com",
                    "whatismyip.network",
                    "ipinfo.info",
                    "encodable.com",
                    "www.overplay.net",
                    "myipaddress.com",
                    "www.myipaddress.com",
                    "whoer.net",
                    "whatismyip.com",
                    "www.speedtest.net",
                    "c.speedtest.net",
                    "www.ipleak.net",
                    "ipleak.net",
                    "whatismyipaddress.com",
                    "whatismyip.host",
                    "bearsmyip.com",
                    "check-host.net",
                    "hide.me",
                    "ipv6test.hide.me",
                    "ipleak.com",
                    "www.perfect-privacy.com",
                    "perfect-privacy.com",
                    "www.whatsmyip.org",
                    "whatsmyip.org"
                ]
                domains.forEach(domain => {
                    add_sp += `add address="${domain}" list="speedtest" \n`;
                });
                let mangle =
                    `/ip firewall mangle add action="mark-routing" chain="prerouting" comment="MANGLE SPEEDTEST VPN" dst-address-list="speedtest" new-routing-mark="speedtest" passthrough="no" src-address-list="private-lokal";`
                let nat =
                    `/ip firewall nat add action="masquerade" chain="srcnat" comment="NAT SPEEDTEST VPN";`
                let gateway = $('#gateway').val()
                let route = ''
                if (ver == 'v7') {
                    route += `/routing table add disabled="no" fib name="speedtest"; \n`
                }
                route += `/ip route add check-gateway="ping" disabled="no" distance="1" `
                route += `dst-address="0.0.0.0/0" gateway="${gateway}" `
                route += `pref-src="" routing-table="speedtest" scope="30" `
                route += `suppress-hw-offload="no" target-scope="10";`

                $('#add_loc').val(add_loc)
                $('#add_sp').val(add_sp)
                $('#mangle').val(mangle)
                $('#nat').val(nat)
                $('#route').val(route)
            })


        });
    </script>
@endpush
