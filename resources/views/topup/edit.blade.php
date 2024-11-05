<div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_edit" style="display: none;">
    <div class="widget-content widget-content-area br-8">

        <form id="formEdit" class="form-vertical was-validated" action="" method="POST">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="titleEdit"><i class="fas fa-edit me-1 bs-tooltip"
                            title="Edit Data"></i>Edit Data <span id="titleEdit2"></span></h5>
                </div>
                <div class="card-body">
                    <div class="form-group mb-2">
                        <label for="edit_user"><i class="far fa-envelope me-1 bs-tooltip" title="Option User"></i>User
                            :</label>
                        <select name="user" id="edit_user" class="form-control-lg tomse-user" style="width: 100%;"
                            required>
                        </select>
                        <span class="error invalid-feedback err_user" style="display: hide;"></span>
                    </div>
                    <div class="form-group mb-2">
                        <label for="edit_bank"><i class="fas fa-university me-1 bs-tooltip" title="Option Bank"></i>Bank
                            :</label>
                        <select name="bank" id="edit_bank" class="form-control-lg tomse-bank" style="width: 100%;"
                            required>
                        </select>
                        <span class="error invalid-feedback err_bank" style="display: hide;"></span>
                    </div>
                    <div class="form-group mb-2">
                        <label for="edit_amount"><i class="fas fa-dollar-sign me-1 bs-tooltip" title="amount"></i>Amount
                            :</label>
                        <select name="amount" id="edit_amount" class="form-control-lg tomse-amount"
                            style="width: 100%;" required>
                        </select>
                        <span class="error invalid-feedback err_amount" style="display: hide;"></span>
                    </div>
                    <div class="form-group mb-2">
                        <label class="control-label" for="edit_desc"><i class="fas fa-map-marker me-1 bs-tooltip"
                                title="desc User"></i>Description :</label>
                        <textarea name="desc" class="form-control maxlength" id="edit_desc" placeholder="Please Enter Description"
                            minlength="0" maxlength="100"></textarea>
                        <span class="error invalid-feedback err_desc" style="display: hide;"></span>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <div class="row">
                        <div class="col-12">

                            @include('components.form.button_edit')
                            @if (auth()->user()->is_admin())
                                <div class="btn-group me-4 mb-2" role="group">
                                    <button id="btn_action" type="button"
                                        class="btn btn-outline-danger dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">Status
                                        <i data-feather="chevron-down"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btn_action">
                                        <button id="btn_done" type="button" class="dropdown-item"
                                            onclick="update_status('done')"><i
                                                class="fas fa-check-double me-1"></i>Done</button>
                                        <button id="btn_cancel" type="button" class="dropdown-item"
                                            onclick="update_status('cancel')"><i
                                                class="fas fa-times me-1"></i>Cancel</button>
                                    </div>
                                </div>
                            @endif
                            <button type="button" class="btn btn-info ms-1 me-1 mb-2" id="btn_pay"><i
                                    class="fas fa-paper-plane"></i> Bayar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
