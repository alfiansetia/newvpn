<div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_add" style="display: none;">
    <div class="widget-content widget-content-area br-8">

        <form id="form" class="was-validated" action="{{ route('api.mikapi.packages.store') }}" method="POST">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-plus me-1 bs-tooltip"
                            title="Add Data"></i>Add Data</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <input type="hidden" name="router" value="{{ request()->query('router') }}">
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="name"><i class="fas fa-clone me-1 bs-tooltip"
                                    title="Name"></i>Name :</label>
                            <input type="text" name="name" class="form-control maxlength" id="name"
                                placeholder="Please Enter Name" minlength="3" maxlength="50" required>
                            <span class="error invalid-feedback err_name" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="profile"><i class="fas fa-link me-1 bs-tooltip"
                                    title="Profile"></i>Profile PPP :</label>
                            <div class="input-group mb-3">
                                <input type="text" name="profile" class="form-control maxlength" id="profile"
                                    placeholder="Please Enter Profile PPP" minlength="1" maxlength="50">
                                <button type="button" class="input-group-text" id="select_profile_add">Select</button>
                            </div>
                            <span class="error invalid-feedback err_profile" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="speed_up"><i class="fas fa-upload me-1 bs-tooltip"
                                    title="Speed UP"></i>Speed UP :</label>
                            <div class="input-group mb-3">
                                <input type="text" name="speed_up" class="form-control  mask_angka" id="speed_up"
                                    placeholder="Please Enter Speed UP" min="0" max="1000" value="0"
                                    required>
                                <span class="input-group-text">Mbps</span>
                            </div>
                            <span class="error invalid-feedback err_speed_up" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="speed_down"><i class="fas fa-download me-1 bs-tooltip"
                                    title="Speed Down"></i>Speed Down :</label>
                            <div class="input-group mb-3">
                                <input type="text" name="speed_down" class="form-control  mask_angka" id="speed_down"
                                    placeholder="Please Enter Speed Down" min="0" max="1000" value="0"
                                    required>
                                <span class="input-group-text">Mbps</span>
                            </div>
                            <span class="error invalid-feedback err_speed_down" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="price"><i class="fas fa-dollar-sign me-1 bs-tooltip"
                                    title="Price"></i>Price :</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Rp. </span>
                                <input type="text" name="price" class="form-control  mask_angka" id="price"
                                    placeholder="Please Enter Price" min="0" value="0" required>
                            </div>
                            <span class="error invalid-feedback err_price" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="ppn"><i class="fas fa-percent me-1 bs-tooltip"
                                    title="PPN"></i>PPN :</label>
                            <div class="input-group mb-3">
                                <input type="text" name="ppn" class="form-control mask_angka" id="ppn"
                                    placeholder="Please Enter PPN" min="0" max="100" value="0"
                                    required>
                                <span class="input-group-text">%</span>
                            </div>
                            <span class="error invalid-feedback err_ppn" style="display: hide;"></span>
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
