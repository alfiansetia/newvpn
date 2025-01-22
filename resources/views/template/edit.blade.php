<div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_edit" style="display: none;">
    <div class="widget-content widget-content-area br-8">

        <form id="formEdit" class="form-vertical was-validated" action="" method="POST">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title" id="titleEdit"><i class="fas fa-edit me-1 bs-tooltip"
                            title="Edit Data"></i>Edit Data</h5>
                </div>
                <div class="card-body">
                    <div class="form-group mb-2">
                        <label class="control-label" for="edit_name">Name :</label>
                        <input type="text" name="name" class="form-control maxlength" id="edit_name"
                            placeholder="Please Enter Name" minlength="3" maxlength="30" required>
                        <span class="error invalid-feedback err_name" style="display: hide;"></span>
                    </div>
                    <div class="form-group mb-2">
                        <label class="control-label" for="edit_header">Header :</label>
                        <textarea name="header" class="form-control" id="edit_header" placeholder="Please Enter Header" rows="10"
                            required></textarea>
                        <span class="error invalid-feedback err_header" style="display: hide;"></span>
                    </div>
                    <div class="form-group mb-2">
                        <label class="control-label" for="edit_html_up">HTML UP :</label>
                        <textarea name="html_up" class="form-control" id="edit_html_up" placeholder="Please Enter HTML UP" rows="10"
                            required></textarea>
                        <span class="error invalid-feedback err_html_up" style="display: hide;"></span>
                    </div>
                    <div class="form-group mb-2">
                        <label class="control-label" for="edit_html_vc">HTML VC :</label>
                        <textarea name="html_vc" class="form-control" id="edit_html_vc" placeholder="Please Enter HTML VC" rows="10"
                            required></textarea>
                        <span class="error invalid-feedback err_html_vc" style="display: hide;"></span>
                    </div>
                    <div class="form-group mb-2">
                        <label class="control-label" for="edit_footer">Footer :</label>
                        <textarea name="footer" class="form-control" id="edit_footer" placeholder="Please Enter Footer" rows="10"
                            required></textarea>
                        <span class="error invalid-feedback err_footer" style="display: hide;"></span>
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
