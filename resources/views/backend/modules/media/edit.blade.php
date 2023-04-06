@if($data !='')
<input type="hidden" id="edit_id" value="{{ $data->id }}">
<div class="body">
    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Alt Tag <small class="text-danger">*</small></label>                                 
                <input type="text" name="file_title" id="edit_file_title" class="form-control" placeholder="Title" @if($data->file_title) value="{{ $data->file_title }}" @endif />                                   
            </div>
        </div>
    </div>
</div>
@endif
                