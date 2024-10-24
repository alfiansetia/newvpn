<div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_add" style="display: none;">
    <div class="widget-content widget-content-area br-8">

        <form id="form" class="was-validated" action="{{ route('api.ports.store') }}" method="POST">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-plus me-1 bs-tooltip"
                            title="Add Data"></i>Add Data</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="form-group col-md-12">
                            <label for="vpn"><i class="fas fa-network-wired me-1 bs-tooltip"
                                    title="Option Vpn"></i>Vpn :</label>
                            <select name="vpn" id="vpn" class="form-control-lg tomse-vpn" style="width: 100%;"
                                required>
                            </select>
                            <span class="error invalid-feedback err_vpn" style="display: hide;"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="form-group col-md-4">
                            <label for="dst"><i class="fas fa-random me-1 bs-tooltip" title="Dst Port"></i>Dst Port
                                :</label>
                            <input type="text" name="dst" class="form-control mask_angka" id="dst"
                                placeholder="Please Enter Dst" value="0" required>
                            <span class="error invalid-feedback err_dst" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="to"><i class="fas fa-arrows-alt me-1 bs-tooltip" title="To Port"></i>To
                                Port
                                :</label>
                            <input type="text" name="to" class="form-control mask_angka" id="to"
                                placeholder="Please Enter To" value="0" required>
                            <span class="error invalid-feedback err_to" style="display: hide;"></span>
                        </div>
                        <div class="col-md-4">
                            <label class="bs-tooltip" for="sync" title="Option Sync Data"></label>
                            <div class="form-check ps-0">
                                <div class="switch form-switch-custom switch-inline form-switch-primary mt-4">
                                    <input class="switch-input" type="checkbox" role="switch" id="sync"
                                        name="sync" checked>
                                    <label class="switch-label" for="sync">Sync</label>
                                </div>
                            </div>
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
