<div class="modal animated fade fadeInDown" id="modalppp" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleEdit"><i class="fas fa-info me-1 bs-tooltip"
                        title="Select Map"></i>Select User! </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body pb-0 pt-0">
                <div class="form-group mt-3 text-center">
                    <div class="form-check form-check-inline">
                        <input type="radio" name="filter_ppp" id="f1" value="all" class="form-check-input">
                        <label class="form-check-label" for="f1">All</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="filter_ppp" id="f2" value="online" class="form-check-input">
                        <label class="form-check-label" for="f2">Online</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="filter_ppp"id="f3" value="offline" class="form-check-input">
                        <label class="form-check-label" for="f3">Offline</label>
                    </div>
                </div>
                <table id="table_ppp" class="table table-hover" style="width: 100%; cursor: pointer;"></table>
            </div>
            <div class="modal-footer">
                <button class="btn btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>
                    Close</button>
            </div>
        </div>
    </div>
</div>
