<div class="modal animated fade fadeInDown" id="modalmap" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleEdit"><i class="fas fa-info me-1 bs-tooltip"
                        title="Select Map"></i>Please Select Map! </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body pb-0 pt-0">
                <div id="map" style="width: 100%; height: 400px;"></div>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                        class="fas fa-times me-1 bs-tooltip" title="Close"></i>Close</button> --}}
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><i
                        class="fas fa-paper-plane me-1 bs-tooltip" title="Select"></i>Select</button>
            </div>
        </div>
    </div>
</div>
