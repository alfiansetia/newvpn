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
                            <label for="edit_server">Server :</label>
                            <select name="server" id="edit_server" class="form-control-lg tomse-server"
                                style="width: 100%;" required>
                            </select>
                            <span class="error invalid-feedback err_server" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_ip">IP :</label>
                            <input type="text" name="ip" class="form-control mask_ip" id="edit_ip"
                                placeholder="Please Enter ip" minlength="3" maxlength="25" required>
                            <span class="error invalid-feedback err_ip" style="display: hide;"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4 mb-2">
                            <label class="control-label" for="edit_web">Web :</label>
                            <input type="text" name="web" class="form-control mask_angka" id="edit_web"
                                placeholder="Please Enter Web" value="0" min="0" required>
                            <span class="error invalid-feedback err_web" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-4 mb-2">
                            <label class="control-label" for="edit_api">Api :</label>
                            <input type="text" name="api" class="form-control mask_angka" id="edit_api"
                                placeholder="Please Enter Api" value="0" min="0" required>
                            <span class="error invalid-feedback err_api" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-4 mb-2">
                            <label class="control-label" for="edit_win">Win :</label>
                            <input type="text" name="win" class="form-control mask_angka" id="edit_win"
                                placeholder="Please Enter Win" value="0" min="0" required>
                            <span class="error invalid-feedback err_win" style="display: hide;"></span>
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
