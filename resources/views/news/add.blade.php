<div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_add" style="display: none;">
    <div class="widget-content widget-content-area br-8">

        <form id="form" class="was-validated" action="{{ route('api.news.store') }}" method="POST">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-plus me-1 bs-tooltip"
                            title="Add Data"></i>Add Data</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group mb-2">
                            <label class="control-label" for="title"><i class="fas fa-clone me-1 bs-tooltip"
                                    title="Title"></i>Title :</label>
                            <input type="text" name="title" class="form-control maxlength" id="title"
                                placeholder="Please Enter Title" minlength="3" maxlength="150" required>
                            <span class="error invalid-feedback err_title" style="display: hide;"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label" for="add_content"><i class="fas fa-newspaper me-1 bs-tooltip"
                                    title="Content"></i>Content :</label>
                            <div id="add_content"></div>
                            <textarea name="content" id="hidden_content" style="display: none"></textarea>
                            <span class="error invalid-feedback err_content" style="display: hide;"></span>
                        </div>

                        <div class="form-group  mb-2">
                            <div class="form-check form-check-primary form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status_add1"
                                    value="draft" checked>
                                <label class="form-check-label" for="status_add1">Draft </label>
                            </div>
                            <div class="form-check form-check-primary form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status_add2"
                                    value="published">
                                <label class="form-check-label" for="status_add2"> Publish </label>
                            </div>
                            <div class="form-check form-check-primary form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status_add3"
                                    value="archived">
                                <label class="form-check-label" for="status_add3"> Archived </label>
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
