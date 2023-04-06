@if($data !='')
@php
$details = json_decode($data->meta_fields);
@endphp
<input type="hidden" id="edit_page_id" value="{{ $data->id }}">
<div class="body">
    <div class="row clearfix">
    <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Area Name</label>                                 
                <input type="hidden" name="edit_type[]" value="section_name" />                                   
                <input type="text" name="edit_section_name" id="edit_section_name" class="form-control" placeholder="Area Name" @if($details->section) value="{{ $details->section }}" @endif  />                                   
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Office Name <small class="text-danger">*</small></label>                                 
                <input type="text" name="edit_title" id="edit_title" class="form-control" placeholder="Office Name" @if($data->title) value="{{ $data->title }}" @endif  />                                   
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Address <small class="text-danger">*</small> </label>                               
                <input type="hidden" name="edit_type[]" value="address" />                
                <textarea name="edit_address" id="edit_address" class="form-control" placeholder="Address">@if($data->content) {{ $data->content }} @endif</textarea>                                   
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">Email <small class="text-danger">*</small> </label>                                         
                <input type="hidden" name="edit_type[]" value="email" />                                       
                <input type="text" name="edit_email" id="edit_email" class="form-control" placeholder="Email" @if($details->email) value="{{ $details->email }}" @endif  />                                   
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">Phone <small class="text-danger">*</small> </label>                                             
                <input type="hidden" name="edit_type[]" value="phone" />                                   
                <input type="text" name="edit_phone" id="edit_phone" class="form-control" placeholder="Phone" @if($details->phone) value="{{ $details->phone }}" @endif  />                                   
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">Order </label>                                 
                <input type="text" name="edit_order" id="edit_order" class="form-control" placeholder="Order"  @if($data->title) value="{{ $data->order }}" @endif  />                                   
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">                                 
                <label class="form-label">Status <small class="text-danger">*</small></label>                                 
                <select class="form-control w-100  ms select2 mr-2" name="edit_status" id="edit_status">
                    <option value="">-- Please select --</option>
                    <option value="1"  @if($data->status == 1) selected @endif>Active</option>
                    <option value="0" @if($data->status == 0) selected @endif>Deactive</option>
                </select>                            
            </div>
        </div>
    </div>

</div>
@endif
                