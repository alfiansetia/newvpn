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
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_vpn"><i class="fas fa-network-wired me-1 bs-tooltip"
                                    title="VPN"></i>PORT VPN :</label>
                            <select name="vpn" id="edit_vpn" class="form-control-lg tomse-vpn" style="width: 100%;"
                                required>
                            </select>
                            <span class="error invalid-feedback err_vpn" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_name"><i class="far fas fa-clone me-1 bs-tooltip"
                                    title="Router Name"></i>Router Name :</label>
                            <input type="text" name="name" class="form-control maxlength" id="edit_name"
                                placeholder="Please Enter Router Name" minlength="3" maxlength="50" required>
                            <span class="error invalid-feedback err_name" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_hsname"><i class="fas fas fa-wifi me-1 bs-tooltip"
                                    title="HS Name"></i>HS Name :</label>
                            <input type="text" name="hsname" class="form-control maxlength" id="edit_hsname"
                                placeholder="Please Enter HS Name" minlength="3" maxlength="50" required>
                            <span class="error invalid-feedback err_hsname" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_dnsname"><i
                                    class="fas fas fa-project-diagram me-1 bs-tooltip" title="DNS Name"></i>DNS Name
                                :</label>
                            <input type="text" name="dnsname" class="form-control maxlength" id="edit_dnsname"
                                placeholder="Please Enter DNS Name" minlength="3" maxlength="50" required>
                            <span class="error invalid-feedback err_dnsname" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_username"><i class="fas fa-user me-1 bs-tooltip"
                                    title="Username"></i>Username :</label>
                            <input type="text" name="username" class="form-control maxlength" id="edit_username"
                                placeholder="Please Enter Username" minlength="3" maxlength="50"
                                autocomplete="username">
                            <div class="mt-1">
                                <span class="badge badge-primary w-100 text-start">
                                    <small id="sh-text4" class="form-text mt-0">Kosongkan jika tidak ingin
                                        mengganti username!</small>
                                </span>
                            </div>
                            <span class="error invalid-feedback err_username" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_password"><i class="fas fa-lock me-1 bs-tooltip"
                                    title="Password"></i>Password :</label>
                            <input type="password" name="password" class="form-control maxlength" id="edit_password"
                                placeholder="Please Enter Password" minlength="0" maxlength="100"
                                autocomplete="current-password">
                            <div class="mt-1">
                                <span class="badge badge-primary w-100 text-start">
                                    <small id="sh-text4" class="form-text mt-0 ">Kosongkan jika tidak ingin
                                        mengganti password!</small>
                                </span>
                            </div>
                            <span class="error invalid-feedback err_password" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_contact"><i class="fas fa-phone me-1 bs-tooltip"
                                    title="contact"></i>Contact :</label>
                            <input type="tel" name="contact" class="form-control maxlength" id="edit_contact"
                                placeholder="Please Enter contact" minlength="8" maxlength="15" required>
                            <span class="error invalid-feedback err_contact" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_url_logo"><i class="fas fa-link me-1 bs-tooltip"
                                    title="Url Logo"></i>Url Logo :</label>
                            <input type="url" name="url_logo" class="form-control maxlength" id="edit_url_logo"
                                placeholder="Please Enter Url Logo" minlength="4" maxlength="100" required>
                            <span class="error invalid-feedback err_url_logo" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_currency"><i
                                    class="fas fa-dollar-sign me-1 bs-tooltip" title="Currency"></i>Currency :</label>
                            <input type="text" name="currency" class="form-control maxlength" id="edit_currency"
                                placeholder="Please Enter Currency" minlength="0" maxlength="5">
                            <span class="error invalid-feedback err_currency" style="display: hide;"></span>
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
