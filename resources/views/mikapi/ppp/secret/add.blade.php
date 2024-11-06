<div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_add" style="display: none;">
    <div class="widget-content widget-content-area br-8">

        <form id="form" class="was-validated"
            action="{{ route('api.mikapi.ppp.secrets.store') }}?router={{ request()->query('router') }}" method="POST">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="exampleModalLongTitle"><i class="fas fa-plus me-1 bs-tooltip"
                            title="Add Data"></i>Add Data</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="name">Name :</label>
                            <input type="text" name="name" class="form-control maxlength" id="name"
                                placeholder="Please Enter Name" minlength="1" maxlength="50" required>
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
                            <label class="control-label" for="local_address">Local Address :</label>
                            <input type="text" name="local_address" class="form-control maxlength mask_ip"
                                id="local_address" placeholder="Please Enter Local Address" minlength="0"
                                maxlength="18">
                            <span class="error invalid-feedback err_local_address" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="remote_address">Remote Address :</label>
                            <input type="text" name="remote_address" class="form-control maxlength mask_ip"
                                id="remote_address" placeholder="Please Enter Remote Address" minlength="0"
                                maxlength="18">
                            <span class="error invalid-feedback err_remote_address" style="display: hide;"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6 mb-2">
                            <label class="control-label" for="service">Service :</label>
                            <select name="service" id="service" class="form-control">
                                @php
                                    $services = ['async', 'l2tp', 'ovpn', 'pppoe', 'pptp', 'sstp'];
                                @endphp
                                <option value="">any</option>
                                @foreach ($services as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            <span class="error invalid-feedback err_service" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="profile">Profile :</label>
                            <select name="profile" id="profile" class="form-control-lg tomse-profile"
                                style="width: 100%;" required>
                            </select>
                            <span class="error invalid-feedback err_profile" style="display: hide;"></span>
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
