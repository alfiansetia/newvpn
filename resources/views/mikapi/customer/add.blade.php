<div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_add" style="display: none;">
    <div class="widget-content widget-content-area br-8">

        <form id="form" class="was-validated" action="{{ route('api.mikapi.customers.store') }}" method="POST">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-plus me-1 bs-tooltip"
                            title="Add Data"></i>Add Data</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <input type="hidden" name="router" value="{{ request()->query('router') }}">
                        <div class="form-group col-md-12 mb-2">
                            <label class="control-label" for="number"><i class="fas fa-id-card-alt me-1 bs-tooltip"
                                    title="Account Number"></i>Account Number :</label>
                            <div class="input-group">
                                <input type="text" name="number" class="form-control maxlength" id="number"
                                    placeholder="Please Enter Account Number" minlength="3" maxlength="30" required>
                                <button type="button" class="btn btn-secondary"
                                    onclick="gen_number_add()">Generate</button>
                            </div>
                            <span class="error invalid-feedback err_number" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="name"><i class="fas fa-user me-1 bs-tooltip"
                                    title="Name"></i>Name :</label>
                            <input type="text" name="name" class="form-control maxlength" id="name"
                                placeholder="Please Enter Name" minlength="3" maxlength="30" required>
                            <span class="error invalid-feedback err_name" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="status"><i class="fas fa-lock me-1 bs-tooltip"
                                    title="Name"></i>Status :</label>
                            <select name="status" id="status" class="form-select" style="width: 100%;" required>
                                @php
                                    $status = ['active', 'nonactive', 'suspended', 'blacklisted', 'pending'];
                                @endphp
                                @foreach ($status as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            <span class="error invalid-feedback err_status" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="package"><i class="fas fa-cube me-1 bs-tooltip"
                                    title="Package"></i>Package :</label>
                            <select name="package" id="package" class="form-control-lg tomse-package"
                                style="width: 100%;" required>
                            </select>
                            <span class="error invalid-feedback err_package" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="odp"><i
                                    class="fas fa-project-diagram me-1 bs-tooltip" title="ODP"></i>ODP :</label>
                            <select name="odp" id="odp" class="form-control-lg tomse-odp" style="width: 100%;"
                                required>
                            </select>
                            <span class="error invalid-feedback err_odp" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="phone"><i class="fab fa-whatsapp me-1 bs-tooltip"
                                    title="Phone/Whatsapp"></i>Phone/Whatsapp :</label>
                            <input type="tel" name="phone" class="form-control maxlength" id="phone"
                                placeholder="628xxx" minlength="8" maxlength="15" required>
                            <span class="error invalid-feedback err_phone" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="email"><i class="fas fa-at me-1 bs-tooltip"
                                    title="Email"></i>Email :</label>
                            <input type="email" name="email" class="form-control maxlength" id="email"
                                placeholder="Please Enter Email" minlength="1" maxlength="50" required>
                            <span class="error invalid-feedback err_email" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="identity"><i class="fas fa-id-card me-1 bs-tooltip"
                                    title="Identity"></i>Identity :</label>
                            <textarea name="identity" class="form-control maxlength" id="identity" placeholder="Please Enter Identity"
                                minlength="0" maxlength="50"></textarea>
                            <span class="error invalid-feedback err_identity" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="address"><i class="fas fa-home me-1 bs-tooltip"
                                    title="Address"></i>Address :</label>
                            <textarea name="address" class="form-control maxlength" id="address" placeholder="Please Enter Address"
                                minlength="0" maxlength="50"></textarea>
                            <span class="error invalid-feedback err_address" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="regist"><i class="fas fa-calendar me-1 bs-tooltip"
                                    title="Register Date"></i>Register Date :</label>
                            <input type="text" name="regist" class="form-control maxlength" id="regist"
                                placeholder="Please Enter Register Date" minlength="10" maxlength="10" required>
                            <span class="error invalid-feedback err_regist" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="due"><i
                                    class="fas fa-calendar-plus me-1 bs-tooltip" title="Name"></i>Due Date Invoice
                                :</label>
                            <select name="due" id="due" class="form-select" style="width: 100%;" required>
                                @for ($i = 0; $i <= 31; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <span class="error invalid-feedback err_due" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-12 mb-2">
                            <label class="control-label" for="lat"><i
                                    class="fas fa-map-marked-alt me-1 bs-tooltip" title="Map"></i>Map :
                            </label>
                            <div class="input-group">
                                <input type="text" name="lat" id="lat" class="form-control maxlength"
                                    minlength="0" maxlength="50" placeholder="Latitude" required>
                                <input type="text" name="long" id="long" class="form-control maxlength"
                                    minlength="0" maxlength="50" placeholder="Longitude" required>
                                <button type="button" class="input-group-text" id="btn_map_add">
                                    <i class="fas fa-map-marked-alt me-1 bs-tooltip" title="Show Map"></i>
                                </button>
                            </div>
                            <span class="error invalid-feedback err_lat"></span>
                            <span class="error invalid-feedback err_long"></span>
                        </div>

                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="ip"><i class="fas fa-ethernet me-1 bs-tooltip"
                                    title="IP Address"></i>IP Address :</label>
                            <input type="text" name="ip" class="form-control maxlength mask_ip"
                                id="ip" placeholder="Please Enter IP Address" minlength="0" maxlength="15">
                            <span class="error invalid-feedback err_ip" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="mac"><i class="fas fa-laptop me-1 bs-tooltip"
                                    title="MAC Address"></i>MAC Address :</label>
                            <input type="text" name="mac" class="form-control maxlength mask_mac"
                                id="mac" placeholder="Please Enter MAC Address" minlength="0" maxlength="20">
                            <span class="error invalid-feedback err_mac" style="display: hide;"></span>
                        </div>

                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="secret_username"><i class="fas fa-key me-1 bs-tooltip"
                                    title="PPP Username"></i>PPP Username :</label>
                            <div class="input-group mb-3">
                                <input type="text" name="secret_username" class="form-control maxlength"
                                    id="secret_username" placeholder="Please Enter PPP Username" minlength="0"
                                    maxlength="50">
                                <button type="button" class="input-group-text" id="select_user_add">Select</button>
                            </div>
                            <span class="error invalid-feedback err_secret_username" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="secret_password"><i class="fas fa-lock me-1 bs-tooltip"
                                    title="PPP Password"></i>PPP Password :</label>
                            <input type="text" name="secret_password" class="form-control maxlength"
                                id="secret_password" placeholder="Please Enter PPP Password" minlength="0"
                                maxlength="50">
                            <span class="error invalid-feedback err_secret_password" style="display: hide;"></span>
                        </div>

                    </div>
                </div>
                <div class="card-footer text-center">
                    <div class="row">
                        <div class="col-12">
                            @include('components.form.button_add')
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
