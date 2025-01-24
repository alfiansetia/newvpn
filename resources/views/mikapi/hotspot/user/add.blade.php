<div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_add" style="display: none;">
    <div class="widget-content widget-content-area br-8">


        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab-icon" data-bs-toggle="tab"
                            data-bs-target="#home-tab-icon-pane" type="button" role="tab"
                            aria-controls="home-tab-icon-pane" aria-selected="true">
                            <h5><i class="fas fa-plus me-1 bs-tooltip" title="Add Data"></i>Add Data</h5>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab-icon" data-bs-toggle="tab"
                            data-bs-target="#profile-tab-icon-pane" type="button" role="tab"
                            aria-controls="profile-tab-icon-pane" aria-selected="false">
                            <h5><i class="fas fa-plus me-1 bs-tooltip" title="Add Data"></i>Generate</h5>
                        </button>
                    </li>
                </ul>
                {{-- </h5> --}}
            </div>
            <div class="card-body">
                <div class="simple-tab">

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home-tab-icon-pane" role="tabpanel"
                            aria-labelledby="home-tab-icon" tabindex="0">
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
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2">
                                        <label class="control-label" for="name">Name :</label>
                                        <input type="text" name="name" class="form-control maxlength"
                                            id="name" placeholder="Please Enter Name" minlength="2" maxlength="50"
                                            required>
                                        <span class="error invalid-feedback err_name" style="display: hide;"></span>
                                    </div>
                                    <div class="form-group col-md-6 mb-2">
                                        <label class="control-label" for="password">Password :</label>
                                        <input type="text" name="password" class="form-control maxlength"
                                            id="password" placeholder="Please Enter Password" minlength="0"
                                            maxlength="50">
                                        <span class="error invalid-feedback err_password" style="display: hide;"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2">
                                        <label class="control-label" for="ip_address">IP :</label>
                                        <input type="text" name="ip_address" class="form-control maxlength mask_ip"
                                            id="ip_address" placeholder="Please Enter IP Address" minlength="0"
                                            maxlength="18">
                                        <span class="error invalid-feedback err_ip_address"
                                            style="display: hide;"></span>
                                    </div>
                                    <div class="form-group col-md-6 mb-2">
                                        <label class="control-label" for="mac">MAC :</label>
                                        <input type="text" name="mac" class="form-control maxlength mask_mac"
                                            id="mac" placeholder="Please Enter MAC" minlength="0"
                                            maxlength="18">
                                        <span class="error invalid-feedback err_mac" style="display: hide;"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6 mb-2">
                                        <label class="control-label" for="data_day">Day Limit :</label>
                                        <input type="text" name="data_day" class="form-control mask_angka"
                                            id="data_day" placeholder="Please Enter Day Limit" value="0">
                                        <span class="error invalid-feedback err_data_day"
                                            style="display: hide;"></span>
                                    </div>
                                    <div class="form-group col-6 mb-2">
                                        <label class="control-label" for="time_limit">Time Limit :</label>
                                        <input type="text" name="time_limit" class="form-control" id="time_limit"
                                            placeholder="Please Enter Time Limit" value="00:00:00" required>
                                        <span class="error invalid-feedback err_time_limit"
                                            style="display: hide;"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6 mb-2">
                                        <label class="control-label" for="data_limit">Data Limit :</label>
                                        <input type="text" name="data_limit" class="form-control mask_angka"
                                            id="data_limit" placeholder="Please Enter Data Limit" value="0">
                                        <span class="error invalid-feedback err_data_limit"
                                            style="display: hide;"></span>
                                    </div>
                                    <div class="form-group col-6 mb-2">
                                        <label class="control-label" for="data_type">Type :</label>
                                        <select name="data_type" id="data_type" class="form-control select2">
                                            <option value="">KB</option>
                                            <option value="M">MB</option>
                                            <option value="G">GB</option>
                                        </select>
                                        <span class="error invalid-feedback err_data_type"
                                            style="display: hide;"></span>
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
                                            <input class="switch-input" type="checkbox" role="switch"
                                                id="is_active" name="is_active" checked>
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
                        <div class="tab-pane fade" id="profile-tab-icon-pane" role="tabpanel"
                            aria-labelledby="profile-tab-icon" tabindex="0">
                            <form id="form_gen" class="was-validated"
                                action="{{ route('api.mikapi.hotspot.users.generate') }}?router={{ request()->query('router') }}"
                                method="POST">
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2">
                                        <label class="control-label" for="gen_qty">Qty :</label>
                                        <input type="text" name="qty" class="form-control mask_angka"
                                            id="gen_qty" placeholder="Please Enter Price" min="1"
                                            max="1000" value="1" required>
                                        <span class="error invalid-feedback err_qty" style="display: hide;"></span>
                                    </div>
                                    <div class="form-group col-md-6 mb-2">
                                        <label class="control-label" for="gen_server">Server :</label>
                                        <select name="server" id="gen_server" class="form-control-lg tomse-server"
                                            style="width: 100%;" required>
                                        </select>
                                        <span class="error invalid-feedback err_server" style="display: hide;"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2">
                                        <label class="control-label" for="gen_user_mode">User Mode :</label>
                                        <select name="user_mode" id="gen_user_mode"
                                            class="form-select form-control-lg" style="width: 100%;" required>
                                            <option value="up">Username & Password (Member)</option>
                                            <option value="vc">Username = Password (Voucher)</option>
                                        </select>
                                        <span class="error invalid-feedback err_user_mode"
                                            style="display: hide;"></span>
                                    </div>

                                    <div class="form-group col-md-6 mb-2">
                                        <label class="control-label" for="gen_length">Name Length :</label>
                                        <select name="length" id="gen_length" class="form-select form-control-lg"
                                            style="width: 100%;" required>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5" selected>5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                        </select>
                                        <span class="error invalid-feedback err_length" style="display: hide;"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2">
                                        <label class="control-label" for="gen_prefix">Prefix :</label>
                                        <input type="text" name="prefix" class="form-control maxlength"
                                            id="gen_prefix" placeholder="Please Enter Prefix" maxlength="6"
                                            pattern="[a-zA-Z0-9]*">
                                        <span class="error invalid-feedback err_prefix" style="display: hide;"></span>
                                    </div>
                                    <div class="form-group col-md-6 mb-2">
                                        <label class="control-label" for="gen_character">Character :</label>
                                        <select name="character" id="gen_character"
                                            class="form-select form-control-lg" style="width: 100%;" required>
                                            <option value="num">Random 23456</option>
                                            <option value="low">Random abcd</option>
                                            <option value="up">Random ABCD</option>
                                            <option value="uplow">Random aBcD</option>
                                            <option value="numlow" selected>Random 5ab2c34d</option>
                                            <option value="numup">Random 5AB2C34D</option>
                                            <option value="numlowup">Random 5aB2c34D</option>
                                        </select>
                                        <span class="error invalid-feedback err_character"
                                            style="display: hide;"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2">
                                        <label class="control-label" for="gen_profile">Profile :</label>
                                        <select name="profile" id="gen_profile" class="form-control-lg tomse-profile"
                                            style="width: 100%;" required>
                                        </select>
                                        <span class="error invalid-feedback err_profile"
                                            style="display: hide;"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6 mb-2">
                                        <label class="control-label" for="gen_data_day">Day Limit :</label>
                                        <input type="text" name="data_day" class="form-control mask_angka"
                                            id="gen_data_day" placeholder="Please Enter Day Limit" value="0">
                                        <span class="error invalid-feedback err_data_day"
                                            style="display: hide;"></span>
                                    </div>
                                    <div class="form-group col-6 mb-2">
                                        <label class="control-label" for="gen_time_limit">Time Limit :</label>
                                        <input type="text" name="time_limit" class="form-control"
                                            id="gen_time_limit" placeholder="Please Enter Time Limit"
                                            value="00:00:00" required>
                                        <span class="error invalid-feedback err_time_limit"
                                            style="display: hide;"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6 mb-2">
                                        <label class="control-label" for="gen_data_limit">Data Limit :</label>
                                        <input type="text" name="data_limit" class="form-control mask_angka"
                                            id="gen_data_limit" placeholder="Please Enter Data Limit" value="0">
                                        <span class="error invalid-feedback err_data_limit"
                                            style="display: hide;"></span>
                                    </div>
                                    <div class="form-group col-6 mb-2">
                                        <label class="control-label" for="gen_data_type">Type :</label>
                                        <select name="data_type" id="gen_data_type" class="form-control select2">
                                            <option value="">KB</option>
                                            <option value="M">MB</option>
                                            <option value="G">GB</option>
                                        </select>
                                        <span class="error invalid-feedback err_data_type"
                                            style="display: hide;"></span>
                                    </div>
                                </div>

                                <div class="form-group mb-2">
                                    <label class="control-label" for="gen_comment">Comment :</label>
                                    <textarea name="comment" class="form-control maxlength" id="gen_comment" minlength="0" maxlength="100"
                                        placeholder="Please Enter Comment"></textarea>
                                    <span class="error invalid-feedback err_comment" style="display: hide;"></span>
                                </div>
                                <div class="card-footer text-center">
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-secondary show-index mb-2">
                                                <i class="fas fa-times me-1 bs-tooltip"
                                                    title="Close"></i>Close</button>
                                            <button type="reset" id="gen_reset" class="btn btn-warning mb-2">
                                                <i class="fas fa-undo me-1 bs-tooltip"
                                                    title="Reset"></i>Reset</button>
                                            <button type="submit" class="btn btn-primary mb-2">
                                                <i class="fas fa-paper-plane me-1 bs-tooltip"
                                                    title="Save"></i>Save</button>

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
