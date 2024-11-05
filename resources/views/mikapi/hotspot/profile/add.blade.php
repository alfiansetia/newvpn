<div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_add" style="display: none;">
    <div class="widget-content widget-content-area br-8">

        <form id="form" class="was-validated"
            action="{{ route('api.mikapi.hotspot.profiles.store') }}?router={{ request()->query('router') }}"
            method="POST">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="exampleModalLongTitle"><i class="fas fa-plus me-1 bs-tooltip"
                            title="Add Data"></i>Add Data</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="name">Profile Name :</label>
                            <input type="text" name="name" class="form-control maxlength" id="name"
                                placeholder="Please Enter Profile Name" minlength="1" maxlength="50" required>
                            <span class="error invalid-feedback err_name" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="shared_users">Shared User :</label>
                            <input type="text" name="shared_users" class="form-control mask_angka" id="shared_users"
                                placeholder="Please Enter Shared User" value="1" required>
                            <span class="error invalid-feedback err_shared_users" style="display: hide;"></span>
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
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="rate_limit">Rate Limit [UP/DOWN] :</label>
                            <input type="text" name="rate_limit" class="form-control" id="rate_limit"
                                placeholder="1M/1M" minlength="5" maxlength="25">
                            <span class="error invalid-feedback err_rate_limit" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="parent">Parent Queue :</label>
                            <select name="parent" id="parent" class="form-control-lg tomse-parent"
                                style="width: 100%;" required>
                                <option value="">Please Select Parent!</option>
                            </select>
                            <span class="error invalid-feedback err_parent" style="display: hide;"></span>
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
