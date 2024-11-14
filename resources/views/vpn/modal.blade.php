<form id="form_send_email" class="form-vertical was-validated" action="" method="POST">
    <div class="modal animated fade fadeInDown" id="modalSendEmail" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-envelope me-1 bs-tooltip"
                            title="Add Data"></i> Send Email</h5>
                    <button type="button" class="btn-close bs-tooltip" data-bs-dismiss="modal" aria-label="Close"
                        title="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label class="control-label" for="input_send_email"><i class="fas fa-clone me-1 bs-tooltip"
                                title="Email To"></i>Email To :</label>
                        <input type="email" name="email" class="form-control maxlength" id="input_send_email"
                            placeholder="Please Enter Email To" minlength="3" maxlength="50" required>
                        <span id="err_email" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="fas fa-times me-1 bs-tooltip" title="Close"></i>Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-1 bs-tooltip"
                            title="Save"></i>Send</button>
                </div>
            </div>
        </div>
    </div>
</form>


<div class="modal animated fade fadeInDown" id="modal_extend" tabindex="-1" role="dialog"
    aria-labelledby="modal_extend" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered " role="document">
        <div class="modal-content">
            <form class="was-validated" action="" id="form_extend">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleEdit"><i class="fas fa-info me-1 bs-tooltip"
                            title="Extend With Balance"></i>Extend With Balance</h5>
                    <button type="button" class="btn-close bs-tooltip" data-bs-dismiss="modal" aria-label="Close"
                        title="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label for="amount">Value Extend :</label>
                        <select name="amount" id="amount" class="form-control-lg" style="width: 100%;" required>
                        </select>
                        <span id="err_amount" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="fas fa-times me-1 bs-tooltip" title="Close"></i>Close</button>
                    <button id="btn_modal_submit" type="submit" class="btn btn-primary"><i
                            class="fas fa-paper-plane me-1 bs-tooltip" title="Submit"></i>Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
