<form id="form_sync" class="form-vertical was-validated" action="" method="POST">
    <div class="modal animated fade fadeInDown" id="modal_sync" tabindex="-1" role="dialog"
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
                    <div class="row">
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="sync_from"><i class="fas fa-server me-1 bs-tooltip"
                                    title="Service From"></i>Service From :</label>
                            <select name="from" id="sync_from" class="form-control-lg tomse-from"
                                style="width: 100%;" required>
                            </select>
                            <span class="error invalid-feedback err_from" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="sync_token"><i class="fas fa-key me-1 bs-tooltip"
                                    title="User Token"></i>User Token :</label>
                            <input type="text" name="token" class="form-control maxlength" id="sync_token"
                                placeholder="Please Enter User Token" minlength="3" maxlength="100" required>
                            <span class="error invalid-feedback err_token" style="display: hide;"></span>
                        </div>
                        <div class="col-12 mt-3">
                            <h5>Data Results</h5>
                            <table class="table table-sm" id="sync_table">
                                <thead>
                                    <tr>
                                        <th>Device</th>
                                        <th>Name</th>
                                        <th>Quota</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                <tbody></tbody>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="fas fa-times me-1 bs-tooltip" title="Close"></i>Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-1 bs-tooltip"
                            title="Get Data"></i>Get Data</button>
                </div>
            </div>
        </div>
    </div>
</form>
