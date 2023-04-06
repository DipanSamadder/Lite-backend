<form id="upload_form"  method="POST"  enctype="multipart/form-data">
@csrf   
<div class="modal fade" id="DSLDImageUpload" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="DSLDLargeModalTitle">Add Files</h4>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="body">
                        <input type="file" name="dsld_files[]" id="upload_images" class="dropify" multiple >
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                <div class="swal-button-container">
                    <button type="submit" class="btn btn-success btn-round waves-effect dsld-btn-loader">UPLOAD</button>
                </div>
            </div>
        </div>
    </div>
</div>
 </form>
