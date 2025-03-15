<div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_edit" style="display: none;">
    <div class="widget-content widget-content-area br-8">

        <form id="formEdit" class="form-vertical was-validated" action="" method="POST">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title" id="titleEdit"><i class="fas fa-edit me-1 bs-tooltip"
                            title="Edit Data"></i>Edit Data</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <input type="hidden" name="router" value="{{ request()->query('router') }}">
                        <div class="form-group col-md-12 mb-2">
                            <label class="control-label" for="edit_number"><i class="fas fa-id-card-alt me-1 bs-tooltip"
                                    title="Account Number"></i>Account Number :</label>
                            <div class="input-group">
                                <input type="text" name="number" class="form-control maxlength" id="edit_number"
                                    placeholder="Please Enter Account Number" minlength="3" maxlength="30" required>
                                <button type="button" class="btn btn-secondary"
                                    onclick="gen_number_edit()">Generate</button>
                            </div>
                            <span class="error invalid-feedback err_number" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_name"><i class="fas fa-user me-1 bs-tooltip"
                                    title="Name"></i>Name :</label>
                            <input type="text" name="name" class="form-control maxlength" id="edit_name"
                                placeholder="Please Enter Name" minlength="3" maxlength="30" required>
                            <span class="error invalid-feedback err_name" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_status"><i class="fas fa-lock me-1 bs-tooltip"
                                    title="Name"></i>Status :</label>
                            <select name="status" id="edit_status" class="form-select" style="width: 100%;" required>
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
                            <label class="control-label" for="edit_package"><i class="fas fa-cube me-1 bs-tooltip"
                                    title="Package"></i>Package :</label>
                            <select name="package" id="edit_package" class="form-control-lg tomse-package"
                                style="width: 100%;" required>
                            </select>
                            <span class="error invalid-feedback err_package" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_odp"><i
                                    class="fas fa-project-diagram me-1 bs-tooltip" title="ODP"></i>ODP :</label>
                            <select name="odp" id="edit_odp" class="form-control-lg tomse-odp" style="width: 100%;"
                                required>
                            </select>
                            <span class="error invalid-feedback err_odp" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_phone"><i class="fab fa-whatsapp me-1 bs-tooltip"
                                    title="Phone/Whatsapp"></i>Phone/Whatsapp :</label>
                            <input type="tel" name="phone" class="form-control maxlength" id="edit_phone"
                                placeholder="628xxx" minlength="8" maxlength="15" required>
                            <span class="error invalid-feedback err_phone" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_email"><i class="fas fa-at me-1 bs-tooltip"
                                    title="Email"></i>Email :</label>
                            <input type="email" name="email" class="form-control maxlength" id="edit_email"
                                placeholder="Please Enter Email" minlength="1" maxlength="50" required>
                            <span class="error invalid-feedback err_email" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_identity"><i
                                    class="fas fa-id-card me-1 bs-tooltip" title="Identity"></i>Identity :</label>
                            <textarea name="identity" class="form-control maxlength" id="edit_identity" placeholder="Please Enter Identity"
                                minlength="0" maxlength="50"></textarea>
                            <span class="error invalid-feedback err_identity" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_address"><i class="fas fa-home me-1 bs-tooltip"
                                    title="Address"></i>Address :</label>
                            <textarea name="address" class="form-control maxlength" id="edit_address" placeholder="Please Enter Address"
                                minlength="0" maxlength="50"></textarea>
                            <span class="error invalid-feedback err_address" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_regist"><i class="fas fa-calendar me-1 bs-tooltip"
                                    title="Register Date"></i>Register Date :</label>
                            <input type="text" name="regist" class="form-control maxlength" id="edit_regist"
                                placeholder="Please Enter Register Date" minlength="10" maxlength="10" required>
                            <span class="error invalid-feedback err_regist" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_due"><i
                                    class="fas fa-calendar-plus me-1 bs-tooltip" title="Name"></i>Due Date Invoice
                                :</label>
                            <select name="due" id="edit_due" class="form-select" style="width: 100%;" required>
                                @for ($i = 0; $i <= 31; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <span class="error invalid-feedback err_due" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-12 mb-2">
                            <label class="control-label" for="edit_lat"><i
                                    class="fas fa-map-marked-alt me-1 bs-tooltip" title="Map"></i>Map :
                            </label>
                            <div class="input-group">
                                <input type="text" name="lat" id="edit_lat" class="form-control maxlength"
                                    minlength="0" maxlength="50" placeholder="Latitude" required>
                                <input type="text" name="long" id="edit_long" class="form-control maxlength"
                                    minlength="0" maxlength="50" placeholder="Longitude" required>
                                <button type="button" class="input-group-text" id="btn_map_edit">
                                    <i class="fas fa-map-marked-alt me-1 bs-tooltip" title="Show Map"></i>
                                </button>
                            </div>
                            <span class="error invalid-feedback err_lat"></span>
                            <span class="error invalid-feedback err_long"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_ip"><i class="fas fa-ethernet me-1 bs-tooltip"
                                    title="IP Address"></i>IP Address :</label>
                            <input type="text" name="ip" class="form-control maxlength mask_ip"
                                id="edit_ip" placeholder="Please Enter IP Address" minlength="0" maxlength="15">
                            <span class="error invalid-feedback err_ip" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_mac"><i class="fas fa-laptop me-1 bs-tooltip"
                                    title="MAC Address"></i>MAC Address :</label>
                            <input type="text" name="mac" class="form-control maxlength mask_mac"
                                id="edit_mac" placeholder="Please Enter MAC Address" minlength="0" maxlength="20">
                            <span class="error invalid-feedback err_mac" style="display: hide;"></span>
                        </div>

                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_secret_username"><i
                                    class="fas fa-key me-1 bs-tooltip" title="PPP Username"></i>PPP Username :</label>
                            <div class="input-group mb-3">
                                <input type="text" name="secret_username" class="form-control maxlength"
                                    id="edit_secret_username" placeholder="Please Enter PPP Username" minlength="0"
                                    maxlength="50">
                                <button type="button" class="input-group-text" id="select_user_edit">Select</button>
                            </div>
                            <span class="error invalid-feedback err_secret_username" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_secret_password"><i
                                    class="fas fa-lock me-1 bs-tooltip" title="PPP Password"></i>PPP Password
                                :</label>
                            <input type="text" name="secret_password" class="form-control maxlength"
                                id="edit_secret_password" placeholder="Please Enter PPP Password" minlength="0"
                                maxlength="50">
                            <span class="error invalid-feedback err_secret_password" style="display: hide;"></span>
                        </div>

                    </div>
                </div>
                <div class="card-footer text-center">
                    <div class="row">
                        <div class="col-12">

                            @include('components.form.button_edit')

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
