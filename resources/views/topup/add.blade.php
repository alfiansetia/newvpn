<div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_add" style="display: none;">
    <div class="widget-content widget-content-area br-8">

        <form id="form" action="{{ route('api.topups.store') }}" method="POST">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-plus me-1 bs-tooltip"
                            title="Add Data"></i>Add Data</h5>
                </div>
                <div class="card-body">
                    @if (auth()->user()->is_admin())
                        <div class="form-group mb-2">
                            <label for="user"><i class="far fa-envelope me-1 bs-tooltip"
                                    title="Option User"></i>User
                                :</label>
                            <select name="user" id="user" class="form-control-lg tomse-user"
                                style="width: 100%;" required>
                            </select>
                            <span class="error invalid-feedback err_user" style="display: hide;"></span>
                        </div>
                    @endif
                    <div class="form-group mb-2">
                        <label for="bank"><i class="fas fa-university me-1 bs-tooltip" title="Option Bank"></i>Bank
                            :</label>
                        <select name="bank" id="bank" class="form-control-lg tomse-bank" style="width: 100%;"
                            required>
                        </select>
                        <span class="error invalid-feedback err_bank" style="display: hide;"></span>
                    </div>
                    <div class="form-group mb-2">
                        <label for="amount"><i class="fas fa-dollar-sign me-1 bs-tooltip" title="amount"></i>Amount
                            :</label>
                        <select name="amount" id="amount" class="form-control-lg tomse-amount" style="width: 100%;"
                            required>
                        </select>
                        <span class="error invalid-feedback err_amount" style="display: hide;"></span>
                    </div>
                    <div class="form-group mb-2">
                        <label class="control-label" for="desc"><i class="fas fa-map-marker me-1 bs-tooltip"
                                title="desc User"></i>Description :</label>
                        <textarea name="desc" class="form-control maxlength" id="desc" placeholder="Please Enter Description"
                            minlength="0" maxlength="100"></textarea>
                        <span class="error invalid-feedback err_desc" style="display: hide;"></span>
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
