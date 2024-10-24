<div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_add" style="display: none;">
    <div class="widget-content widget-content-area br-8">

        <form id="form" class="was-validated" action="{{ route('api.temporaryips.store') }}" method="POST">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-plus me-1 bs-tooltip"
                            title="Add Data"></i>Add Data</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6 mb-2">
                            <label for="server">Server :</label>
                            <select name="server" id="server" class="form-control-lg tomse-server"
                                style="width: 100%;" required>
                            </select>
                            <span class="error invalid-feedback err_server" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="ip">IP :</label>
                            <input type="text" name="ip" class="form-control mask_ip" id="ip"
                                placeholder="Please Enter ip" minlength="3" maxlength="25" required>
                            <span class="error invalid-feedback err_ip" style="display: hide;"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4 mb-2">
                            <label class="control-label" for="web">Web :</label>
                            <input type="text" name="web" class="form-control mask_angka" id="web"
                                placeholder="Please Enter Web" value="0" min="0" required>
                            <span class="error invalid-feedback err_web" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-4 mb-2">
                            <label class="control-label" for="api">Api :</label>
                            <input type="text" name="api" class="form-control mask_angka" id="api"
                                placeholder="Please Enter Api" value="0" min="0" required>
                            <span class="error invalid-feedback err_api" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-4 mb-2">
                            <label class="control-label" for="win">Win :</label>
                            <input type="text" name="win" class="form-control mask_angka" id="win"
                                placeholder="Please Enter Win" value="0" min="0" required>
                            <span class="error invalid-feedback err_win" style="display: hide;"></span>
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
