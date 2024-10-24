<div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_add" style="display: none;">
    <div class="widget-content widget-content-area br-8">

        <form id="form" class="was-validated" action="{{ route('api.users.store') }}" method="POST">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-plus me-1 bs-tooltip"
                            title="Add Data"></i>Add Data</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="control-label" for="name"><i class="far fa-user me-1 bs-tooltip"
                                        title="Full Name User"></i>Name :</label>
                                <input type="text" name="name" class="form-control maxlength" id="name"
                                    placeholder="Please Enter Name" minlength="3" maxlength="30" required>
                                <span class="error invalid-feedback err_name" style="display: hide;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="control-label" for="email"><i class="far fa-envelope me-1 bs-tooltip"
                                        title="Email User"></i>Email :</label>
                                <input type="text" name="email" class="form-control maxlength email-mask"
                                    id="email" placeholder="Please Enter Email" minlength="3" maxlength="50"
                                    autocomplete="username" required>
                                <span class="error invalid-feedback err_email" style="display: hide;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="control-label" for="gender"><i class="fas fa-venus-mars me-1 bs-tooltip"
                                        title="Gender User"></i>Gender :</label>
                                <select name="gender" id="gender" class="form-control" style="width: 100%;"
                                    required>
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <span class="error invalid-feedback err_gender" style="display: hide;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="control-label" for="phone"><i class="fas fa-phone-alt me-1 bs-tooltip"
                                        title="Phone User"></i>Phone :</label>
                                <input type="text" name="phone" class="form-control maxlength" id="phone"
                                    placeholder="Please Enter Phone" minlength="0" maxlength="15">
                                <span class="error invalid-feedback err_phone" style="display: hide;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="control-label" for="password"><i class="fas fa-lock me-1 bs-tooltip"
                                        title="Password User"></i>Password :</label>
                                <input type="password" name="password" class="form-control maxlength" id="password"
                                    placeholder="Please Enter Password" minlength="5" maxlength="100"
                                    autocomplete="current-password" required>
                                <span class="error invalid-feedback err_password" style="display: hide;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="control-label" for="router_limit"><i
                                        class="fas fa-ethernet me-1 bs-tooltip" title="Router Limit"></i>Router Limit
                                    :</label>
                                <input type="number" name="router_limit" class="form-control" id="router_limit"
                                    placeholder="Please Enter Router Limit" min="0" value="3" required>
                                <span id="err_router_limit" class="error invalid-feedback"
                                    style="display: hide;"></span>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label class="control-label" for="address"><i class="fas fa-map-marker me-1 bs-tooltip"
                                    title="Address User"></i>Address :</label>
                            <textarea name="address" class="form-control maxlength" id="address" placeholder="Please Enter Address"
                                minlength="0" maxlength="100"></textarea>
                            <span id="err_address" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-3 col-6 mb-2 mt-2">
                            <div class="switch form-switch-custom switch-inline form-switch-success">
                                <input class="switch-input" type="checkbox" role="switch" id="role"
                                    name="role"checked>
                                <label class="switch-label" for="role">Admin</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6 mb-2 mt-2">
                            <div class="switch form-switch-custom switch-inline form-switch-success">
                                <input class="switch-input" type="checkbox" role="switch" id="verified"
                                    name="verified"checked>
                                <label class="switch-label" for="verified">Verified</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6 mb-2 mt-2">
                            <div class="switch form-switch-custom switch-inline form-switch-success">
                                <input class="switch-input" type="checkbox" role="switch" id="status"
                                    name="status" checked>
                                <label class="switch-label" for="status">Active</label>
                            </div>
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
