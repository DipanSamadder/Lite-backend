@if($data !='')
@php
$details = json_decode($data->meta_fields);
@endphp
<input type="hidden" id="edit_page_id" value="{{ $data->id }}">
<div class="body">
    <div class="row clearfix">

        <div class="col-sm-12">   
            <div class="form-group">
                <label class="form-label">Year <small class="text-danger">*</small></label>                                 
                <input type="text" name="edit_title" id="edit_title" class="form-control" placeholder="Year" @if($data->title) value="{{ $data->title }}" @endif />                                   
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label">Month Name<small class="text-danger">*</small></label>                                                               
                <input type="text" name="edit_month" id="edit_month" class="form-control" placeholder="Month" @if($details->month) value="{{ $details->month }}" @endif />                                   
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label">Banner </label>                                
                <select class="form-control show-tick ms select2" name="edit_banner" id="edit_banner" onchange="is_edited()">
                    <option value="">-- Please select --</option>

                    @foreach(App\Models\Upload::where('user_id', Auth::user()->id)->where('type', 'image')->get() as $key => $value)
                        <option value="{{ $value->id }}" @if($data->banner == $value->id) selected @endif>({{ $value->id }}) - {{ $value->file_title}} </option>
                    @endforeach

                </select>                                    
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label">History <small class="text-danger">*</small></label>                            
                <select class="form-control show-tick ms select2" name="edit_cat" id="edit_cat" onchange="is_edited()">
                    <option value="">-- Please select --</option>
                    <option value="group" @if($details->cat == 'group') selected @endif>Group History</option>
                    <option value="indian" @if($details->cat == 'indian') selected @endif>India History</option>
                </select>                                    
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Content <small class="text-danger">*</small> </label>                                            
                <textarea name="edit_content" id="edit_content" class="form-control" placeholder="Content">@if($data->content) {{ $data->content }} @endif</textarea>                                   
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">Order </label>                                 
                <input type="text" name="edit_order" id="edit_order" class="form-control" placeholder="Order" @if($data->order) value="{{ $data->order }}" @endif />                                   
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
                