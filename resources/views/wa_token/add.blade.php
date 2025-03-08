<div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_add" style="display: none;">
    <div class="widget-content widget-content-area br-8">

        <form id="form" class="was-validated" action="{{ route('api.wa_tokens.store') }}" method="POST">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-plus me-1 bs-tooltip"
                            title="Add Data"></i>Add Data</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="from"><i class="fas fa-server me-1 bs-tooltip"
                                    title="Service From"></i>Service From :</label>
                            <select name="from" id="from" class="form-control-lg tomse-from"
                                style="width: 100%;" required>
                            </select>
                            <span class="error invalid-feedback err_from" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="value"><i class="fas fa-key me-1 bs-tooltip"
                                    title="Token Value"></i>Token Value :</label>
                            <input type="text" name="value" class="form-control maxlength" id="value"
                                placeholder="Please Enter Token Value" minlength="3" maxlength="100" required>
                            <span class="error invalid-feedback err_value" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="desc"><i class="fas fa-comment-alt me-1 bs-tooltip"
                                    title="Desc"></i>Desc :</label>
                            <textarea name="desc" class="form-control maxlength" id="desc" placeholder="Please Enter Description"
                                minlength="0" maxlength="100"></textarea>
                            <span id="err_desc" class="error invalid-feedback" style="display: hide;"></span>
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
