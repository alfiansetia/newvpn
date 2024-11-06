<div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_add" style="display: none;">
    <div class="widget-content widget-content-area br-8">

        <form id="form" class="was-validated"
            action="{{ route('api.mikapi.ppp.l2tp_secrets.store') }}?router={{ request()->query('router') }}"
            method="POST">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="exampleModalLongTitle"><i class="fas fa-plus me-1 bs-tooltip"
                            title="Add Data"></i>Add Data</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-5 mb-2">
                            <label class="control-label" for="secret">Secret :</label>
                            <input type="text" name="secret" class="form-control maxlength" id="secret"
                                placeholder="Please Enter Secret" minlength="1" maxlength="50" required>
                            <span class="error invalid-feedback err_secret" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-5 col-8 mb-2">
                            <label class="control-label" for="address">Address :</label>
                            <input type="text" name="address" class="form-control maxlength mask_ip" id="address"
                                placeholder="Please Enter Address" minlength="0" maxlength="18">
                            <span class="error invalid-feedback err_address" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-2 col-4 mb-2">
                            <label class="control-label" for="subnet">/ :</label>
                            <input type="number" name="subnet" class="form-control" id="subnet"
                                placeholder="Subnet" min="0" max="32">
                            <span class="error invalid-feedback err_subnet" style="display: hide;"></span>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label class="control-label" for="comment">Comment :</label>
                        <textarea name="comment" class="form-control maxlength" id="comment" minlength="0" maxlength="100"
                            placeholder="Please Enter Comment"></textarea>
                        <span class="error invalid-feedback err_comment" style="display: hide;"></span>
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
