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
                        <input type="hidden" name="router" value="{{ request()->query('router') }}">
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_name"><i class="fas fa-clone me-1 bs-tooltip"
                                    title="Name"></i>Name :</label>
                            <input type="text" name="name" class="form-control maxlength" id="edit_name"
                                placeholder="Please Enter Name" minlength="3" maxlength="50" required>
                            <span class="error invalid-feedback err_name" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="control-label" for="edit_max_port"><i class="fas fa-link me-1 bs-tooltip"
                                    title="Max Port"></i>Max Port :</label>
                            <input type="text" name="max_port" class="form-control maxlength mask_angka"
                                id="edit_max_port" placeholder="Please Enter Max Port" minlength="1" maxlength="50"
                                value="1" required>
                            <span class="error invalid-feedback err_max_port" style="display: hide;"></span>
                        </div>
                        <div class="form-group col-12 mb-2">
                            <label class="control-label" for="edit_lat"><i class="fas fa-map-marked-alt me-1 bs-tooltip"
                                    title="Map"></i>Map :
                            </label>
                            <div class="input-group">
                                <input type="text" name="lat" id="edit_lat" class="form-control maxlength"
                                    minlength="0" maxlength="50" placeholder="Latitude">
                                <input type="text" name="long" id="edit_long" class="form-control maxlength"
                                    minlength="0" maxlength="50" placeholder="Longitude">
                                <button type="button" class="input-group-text" id="btn_map_edit">
                                    <i class="fas fa-map-marked-alt me-1 bs-tooltip" title="Show Map"></i>
                                </button>
                            </div>
                            <span class="error invalid-feedback err_lat"></span>
                            <span class="error invalid-feedback err_long"></span>
                        </div>
                        <div class="form-group mb-2">
                            <label class="control-label" for="edit_line_color"><i class="fas fa-palette me-1 bs-tooltip"
                                    title="Line Color"></i>Line Color :</label>
                            <div class="input-group">
                                <input type="color" name="line_color" class="form-control maxlength"
                                    id="edit_line_color" placeholder="Please Enter Line Color" minlength="5"
                                    maxlength="50" onchange="color_edit(this.value)" required>
                                <span id="color_edit" class="badge" style="background-color: #ff0000">#ff0000</span>
                            </div>
                            <span class="error invalid-feedback err_line_color" style="display: hide;"></span>
                        </div>
                        <div class="form-group mb-2">
                            <label class="control-label" for="edit_desc"><i class="fas fa-comment me-1 bs-tooltip"
                                    title="Description"></i>Description :</label>
                            <textarea name="desc" class="form-control maxlength" id="edit_desc" placeholder="Please Enter Description"
                                minlength="0" maxlength="50"></textarea>
                            <span class="error invalid-feedback err_desc" style="display: hide;"></span>
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
