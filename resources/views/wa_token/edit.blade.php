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
                            <label class="control-label" for="edit_from"><i class="fas fa-server me-1 bs-tooltip"
                                    title="Service From"></i>Service From :</label>
                            <select name="from" id="edit_from" class="form-control-lg tomse-from"
                                style="width: 100%;" required>
                            </select>
                            <span class="error invalid-feedback err_from" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_value"><i class="fas fa-key me-1 bs-tooltip"
                                    title="Token Value"></i>Token Value :</label>
                            <input type="text" name="value" class="form-control maxlength" id="edit_value"
                                placeholder="Please Enter Token Value" minlength="3" maxlength="100" required>
                            <span class="error invalid-feedback err_value" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_desc"><i class="fas fa-comment-alt me-1 bs-tooltip"
                                    title="Desc"></i>Desc :</label>
                            <textarea name="desc" class="form-control maxlength" id="edit_desc" placeholder="Please Enter Description"
                                minlength="0" maxlength="100"></textarea>
                            <span id="err_desc" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_status"><i class="fas fa-link me-1 bs-tooltip"
                                    title="Device Status"></i>Device Status :</label>
                            <input type="text" name="status" class="form-control maxlength" id="edit_status"
                                placeholder="Please Enter Device Status" minlength="3" maxlength="100"
                                value="Disconnect">
                            <span class="error invalid-feedback err_status" style="display: hide;"></span>
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
