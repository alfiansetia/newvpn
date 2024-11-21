 <!-- Modal -->
 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                     <i data-feather="x"></i>
                 </button>
             </div>
             <div class="modal-body">
                 <div class="row">
                     <div class="form-group col-md-6 col-12  mb-2">
                         <label class="control-label" for="template">Template :</label>
                         <select name="" id="template" class="form-control-lg" style="width: 100%"></select>
                         <span id="err_template" class="error invalid-feedback " style="display: hide;">Please Select
                             Template!</span>
                     </div>
                     <div class="form-group col-md-6 col-12 mb-2">
                         <label class="control-label" for="mode">Mode :</label>
                         <select name="" id="mode" class="form-control-lg" style="width: 100%">
                             <option value="vc">Voucher</option>
                             <option value="up">User & Password</option>
                         </select>
                     </div>
                 </div>
                 <div class="row mt-3">
                     <div class="d-flex justify-content-center" id="preview"></div>
                 </div>
             </div>
             <div class="modal-footer">
                 <button class="btn btn btn-light-dark" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i>
                     Discard</button>
                 <button id="btn_print_submit" type="button" class="btn btn-primary">Print</button>
             </div>
         </div>
     </div>
 </div>
