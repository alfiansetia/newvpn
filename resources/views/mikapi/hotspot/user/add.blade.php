<div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_add" style="display: none;">
    <div class="widget-content widget-content-area br-8">


        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-plus me-1 bs-tooltip" title="Add Data"></i>Add Data</h5>
            </div>
            <div class="card-body">
                <form id="form" class="was-validated"
                    action="{{ route('api.mikapi.hotspot.users.store') }}?router={{ request()->query('router') }}"
                    method="POST">
                    <div class="row">
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="server">Server :</label>
                            <select name="server" id="server" class="form-control-lg tomse-server"
                                style="width: 100%;" required>
                            </select>
                            <span class="error invalid-feedback err_server" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="profile">Profile :</label>
                            <select name="profile" id="profile" class="form-control-lg tomse-profile"
                                style="width: 100%;" required>
                            </select>
                            <span class="error invalid-feedback err_profile" style="display: hide;"></span>
                            <small id="profile_helper" class="form-text text-muted"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="name">Name :</label>
                            <input type="text" name="name" class="form-control maxlength" id="name"
                                placeholder="Please Enter Name" minlength="2" maxlength="50" required>
                            <span class="error invalid-feedback err_name" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="password">Password :</label>
                            <input type="text" name="password" class="form-control maxlength" id="password"
                                placeholder="Please Enter Password" minlength="0" maxlength="50">
                            <span class="error invalid-feedback err_password" style="display: hide;"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="ip_address">IP :</label>
                            <input type="text" name="ip_address" class="form-control maxlength mask_ip"
                                id="ip_address" placeholder="Please Enter IP Address" minlength="0" maxlength="18">
                            <span class="error invalid-feedback err_ip_address" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="mac">MAC :</label>
                            <input type="text" name="mac" class="form-control maxlength mask_mac" id="mac"
                                placeholder="Please Enter MAC" minlength="0" maxlength="18">
                            <span class="error invalid-feedback err_mac" style="display: hide;"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6 mb-2">
                            <label class="control-label" for="data_day">Day Limit :</label>
                            <input type="text" name="data_day" class="form-control mask_angka" id="data_day"
                                placeholder="Please Enter Day Limit" value="0">
                            <span class="error invalid-feedback err_data_day" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-6 mb-2">
                            <label class="control-label" for="time_limit">Time Limit :</label>
                            <input type="text" name="time_limit" class="form-control" id="time_limit"
                                placeholder="Please Enter Time Limit" value="00:00:00" required>
                            <span class="error invalid-feedback err_time_limit" style="display: hide;"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6 mb-2">
                            <label class="control-label" for="data_limit">Data Limit :</label>
                            <input type="text" name="data_limit" class="form-control mask_angka" id="data_limit"
                                placeholder="Please Enter Data Limit" value="0">
                            <span class="error invalid-feedback err_data_limit" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-6 mb-2">
                            <label class="control-label" for="data_type">Type :</label>
                            <select name="data_type" id="data_type" class="form-control select2">
                                <option value="">KB</option>
                                <option value="M">MB</option>
                                <option value="G">GB</option>
                                <option value="B">Bytes</option>
                            </select>
                            <span class="error invalid-feedback err_data_type" style="display: hide;"></span>
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label class="control-label" for="comment">Comment :</label>
                        <textarea name="comment" class="form-control maxlength" id="comment" minlength="0" maxlength="100"
                            placeholder="Please Enter Comment"></textarea>
                        <span class="error invalid-feedback err_comment" style="display: hide;"></span>
                    </div>
                    <div class="form-group mb-2">
                        <div class="col-lg-3 col-6 mb-2 mt-2">
                            <div class="switch form-switch-custom switch-inline form-switch-success">
                                <input class="switch-input" type="checkbox" role="switch" id="is_active"
                                    name="is_active" checked>
                                <label class="switch-label" for="is_active">Active</label>
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
                </form>

            </div>
        </div>
    </div>
</div>
