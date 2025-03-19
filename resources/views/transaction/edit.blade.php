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
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="control-label" for="edit_date"><i class="far fa-calendar me-1 bs-tooltip"
                                        title="Date"></i>Date :</label>
                                <input type="text" name="date" class="form-control" id="edit_date"
                                    placeholder="Please Enter Date" required>
                                <span class="error invalid-feedback err_date" style="display: hide;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="control-label" for="edit_type"><i
                                        class="fas fa-exchange-alt me-1 bs-tooltip" title="Type"></i>Type :</label>
                                <select name="type" id="edit_type" class="form-control" style="width: 100%;"
                                    required>
                                    <option value="in">IN</option>
                                    <option value="out">OUT</option>
                                </select>
                                <span class="error invalid-feedback err_type" style="display: hide;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="control-label" for="edit_amount">
                                    <i class="fas fa-dollar-sign me-1 bs-tooltip" title="Amount"></i>Amount :</label>
                                <input type="text" name="amount" class="form-control mask_angka" id="edit_amount"
                                    placeholder="Please Enter Amount" min="0" value="0" required>
                                <span class="error invalid-feedback err_amount" style="display: hide;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="control-label" for="edit_desc"><i class="fas fa-comment me-1 bs-tooltip"
                                        title="Description"></i>Description :</label>
                                <textarea name="desc" class="form-control maxlength" id="edit_desc" placeholder="Please Enter Description"
                                    minlength="0" maxlength="200" required></textarea>
                                <span class="error invalid-feedback err_desc" style="display: hide;"></span>
                            </div>
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
