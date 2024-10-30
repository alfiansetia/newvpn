@extends('layouts.backend.template', ['title' => 'Order Vpn'])
@push('csslib')
    <link href="{{ asset('backend/src/assets/css/light/forms/switches.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/plugins/css/light/pricing-table/css/component.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/assets/css/dark/forms/switches.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/plugins/css/dark/pricing-table/css/component.css') }}" rel="stylesheet"
        type="text/css">

    <link href="{{ asset('backend/src/plugins/src/tomSelect/tom-select.default.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('backend/src/plugins/css/light/tomSelect/custom-tomSelect.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('backend/src/plugins/css/dark/tomSelect/custom-tomSelect.css') }}" rel="stylesheet"
        type="text/css">
@endpush
@section('content')
    <div class="middle-content container-xxl p-0">

        <div class="row" id="cancel-row">
            <div class="col-lg-6 layout-top-spacing">
                <blockquote class="blockquote">
                    <div class="widget-heading">
                        <h5 class="">Informasi VPN</h5>
                    </div>
                    <ul class="list-icon">
                        <li>
                            <i data-feather="arrow-right"></i>
                            <span class="d-inline">VPN Remote berfungsi untuk remote perangkat anda dari luar
                                jaringan.</span>
                        </li>
                        <li>
                            <i data-feather="arrow-right"></i>
                            <span class="d-inline">Ini dapat digunakan sebagai alternative dari tidak tersedianya ip
                                public pada
                                isp anda.</span>
                        </li>
                        <li>
                            <i data-feather="arrow-right"></i>
                            <span class="d-inline">1 Akun VPN bisa digunakan untuk 3 remote port </span>
                        </li>
                        <li>
                            <i data-feather="arrow-right"></i>
                            <span class="d-inline">Koneksi VPN ini bisa menggunakan protokol PPTP, L2TP, SSTP &
                                OpenVPN.</span>
                        </li>
                        <li>
                            <i data-feather="arrow-right"></i>
                            <span class="d-inline">Masa trial berlaku selama 1 Hari</span>
                        </li>
                        <li>
                            <i data-feather="arrow-right"></i>
                            <span class="d-inline">1 User Hanya Bisa create 1 akun VPN Trial. Untuk Menambah akun
                                VPN maka silahkan lakukan pembayaran akun trial tsb.</span>
                        </li>
                        {{-- <li>
                                    <i data-feather="arrow-right"></i>
                                    <span class="d-inline">1 User Hanya Mendapat 1 Free Akun. Untuk Menambah akun VPN silahkan Pilih
                                        Server berbayar.</span>
                                </li> --}}
                    </ul>
                </blockquote>
            </div>

            <div class="col-lg-6 layout-top-spacing">
                <blockquote class="blockquote">
                    <div class="widget-heading">
                        <h5 class="">Informasi Pengisian</h5>
                    </div>
                    <ul class="list-icon">
                        <li>
                            <i data-feather="arrow-right"></i>
                            <span class="d-inline"><b>VPN Server</b> : Silahkan pilih sesuai lokasi server & harga yang ada
                                inginkan.</span>
                        </li>
                        <li>
                            <i data-feather="arrow-right"></i>
                            <span class="d-inline"><b>Username</b> : Silahkan isi username untuk akun vpn anda.</span>
                        </li>
                        <li>
                            <i data-feather="arrow-right"></i>
                            <span class="d-inline"><b>Password</b> : Silahkan isi password untuk akun vpn anda.</span>
                        </li>
                        <li>
                            <i data-feather="arrow-right"></i>
                            <span class="d-inline">Harap diperhatikan kembali data yang anda isi sebelum order vpn
                                !!!</span>
                        </li>
                    </ul>
                </blockquote>
            </div>

            <form id="form" class="was-validated" action="{{ route('api.vpns.user.store') }}" method="POST">
                <div class="card">
                    <div class="card-header">
                        <h5 class="modal-title"><i class="fas fa-plus me-1 bs-tooltip" title="Order VPN"></i>Order VPN
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="form-group col-md-12">
                                <label for="server"><i class="fas fa-server me-1 bs-tooltip" title="Server"></i>Server
                                    :</label>
                                <select class="form-control-lg tomse-server" name="server" id="server"
                                    style="width: 100%" required>
                                </select>
                                <span class="error invalid-feedback err_server" style="display: hide;"></span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="form-group col-md-12">
                                <label for="qty"><i class="fas fa-dollar-sign me-1 bs-tooltip"
                                        title="Qty Order"></i>Qty Order :</label>
                                <select class="form-control" name="qty" id="qty" style="width: 100%" required>
                                    <option value="0">1 Hari Trial (Rp. 0)</option>
                                </select>
                                <span class="error invalid-feedback err_qty" style="display: hide;"></span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="form-group col-md-12">
                                <label for="username"><i class="far fa-user me-1 bs-tooltip"
                                        title="Username Vpn"></i>Username Vpn :</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="username" class="form-control maxlength" id="username"
                                        placeholder="Please Enter Username" minlength="4" maxlength="50"
                                        aria-describedby="sufiks" oninput="setLowercase()" required>
                                    <span class="input-group-text" id="sufiks">@kacangan.net</span>
                                </div>
                                <span class="error invalid-feedback err_username" style="display: hide;"></span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="form-group col-md-12">
                                <label for="password"><i class="fas fa-fingerprint me-1 bs-tooltip"
                                        title="Password Vpn"></i>Password Vpn :</label>
                                <input type="text" name="password" class="form-control maxlength" id="password"
                                    placeholder="Please Enter Password" minlength="4" maxlength="50" required>
                                <span class="error invalid-feedback err_password" style="display: hide;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <div class="row">
                            <div class="col-12">
                                {{-- <button type="button" class="btn btn-secondary show-index"><i
                                        class="fas fa-times me-1 bs-tooltip" title="Close"></i>Close</button> --}}
                                <button type="reset" id="reset" class="btn btn-warning"><i
                                        class="fas fa-undo me-1 bs-tooltip" title="Reset"></i>Reset</button>
                                <button type="submit" class="btn btn-primary"><i
                                        class="fas fa-paper-plane me-1 bs-tooltip" title="Save"></i>Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            {{-- </div> --}}
            {{-- </div> --}}


        </div>
    </div>
@endsection
@push('jslib')
    <script src="{{ asset('backend/src/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script src="{{ asset('backend/src/plugins/src/bootstrap-maxlength/bootstrap-maxlength.js') }}"></script>

    <script src="{{ asset('backend/src/plugins/src/tomSelect/tom-select.base.js') }}"></script>
@endpush


@push('js')
    <script src="{{ asset('js/v2/var.js') }}"></script>
    <script src="{{ asset('js/v2/navigation.js') }}"></script>
    <script src="{{ asset('js/v2/func.js') }}"></script>
    <script>
        function setLowercase() {
            var inputElement = document.getElementById('username');
            inputElement.value = inputElement.value.toLowerCase();
        }

        $('.maxlength').maxlength({
            placement: "top",
            alwaysShow: true
        });

        const perpage = 50;

        var tomse = new TomSelect('#server', {
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            preload: 'focus',
            placeholder: "Please Select Server",
            allowEmptyOption: true,
            onChange: function(value) {
                $('#qty').empty()
                $("#qty").append(new Option(`1 Hari Trial (Rp. 0)`, 0));
                if (value != '') {
                    let server = tomse.options[value];
                    $('#sufiks').text(server.sufiks)
                    for (let i = 1; i <= 6; i++) {
                        $("#qty").append(new Option(`${i} Bulan, (Rp. ${hrg(i*server.price)})`, i));
                    }
                    $("#qty").append(new Option(`1 Tahun Rp. ${hrg(server.annual_price)}`, 12));

                } else {
                    $('#sufiks').text('@kacangan.net')
                }

            },
            load: function(query, callback) {
                var url = '{{ route('api.servers.paginate') }}?is_available=1&limit=' + perpage +
                    '&name=' +
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
        						<span class="text-muted"> (${ escape(item.location) })</span>
        					</div>
        			 		<div class="description">${ escape(item.domain) } <span class="badge badge-${item.is_available ? 'success': 'danger'}">${item.is_available ? 'available': 'unavailable'}</span></div>
        			 		<div class="description">
                                Rp. ${hrg(item.price)} / Months
                            </div>
                            <div class="description">
                                Rp. ${hrg(item.annual_price)} / Years
                            </div>
        				</div>
        			</div>`;
                },
                item: function(item, escape) {
                    return `<span>${item.name} (${item.location})</span>`
                }
            },
        });


        var getSwithchInput = document.querySelector('#toggle-1');
        var pricingContainer = document.querySelector('.pricing-plans-container')

        // getSwithchInput.addEventListener('change', function() {
        //     var isChecked = getSwithchInput.checked;
        //     if (isChecked) {
        //         pricingContainer.classList.add('billed-yearly');

        //         pricingContainer.querySelectorAll('.badge').forEach(element => {
        //             element.classList.add('show')
        //         });

        //     } else {
        //         pricingContainer.classList.remove('billed-yearly')
        //         pricingContainer.querySelectorAll('.badge').forEach(element => {
        //             element.classList.remove('show')
        //         });
        //     }
        // })


        $('#reset').click(function btn_reset() {
            $("#qty").val(0).change()
            document.getElementById('server').tomselect.clear()
        })
    </script>
    <script src="{{ asset('js/v2/trigger.js') }}"></script>
@endpush
