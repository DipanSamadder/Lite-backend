@if($data !='')
<input type="hidden" id="edit_section_id" value="{{ $data->id }}">
<div class="body">
    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Title <small class="text-danger">*</small></label>                                 
                <input type="text" name="title" id="edit_title" class="form-control" placeholder="Title" @if($data->title) value="{{ $data->title }}" @endif />                                   
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label">Order </label>                                 
                <input type="text" name="order" id="edit_order" class="form-control" placeholder="Order" @if($data->order) value="{{ $data->order }}" @else value="0" @endif />                                   
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label">Page <small class="text-danger">*</small></label>                                 
                <select class="form-control show-tick ms select2" name="page_id" id="edit_page_id" onchange="is_edited()">
                    <option value="">-- Please select --</option>
                    @foreach(App\Models\Page::orderBy('title', 'ASC')->where('type', 'custom_page')->where('status', '1')->get() as $key => $value)
                        <option value="{{ $value->id }}" @if($data->page_id == $value->id) selected @endif>{{ $value->title}} - ({{ $value->id }})</option>
                    @endforeach
                </select>                                                                
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label">Status <small class="text-danger">*</small></label>                                 
                <select class="form-control w-100  ms select2 mr-2" name="status" id="edit_status">
                    <option value="">-- Please select --</option>
                    <option value="1"  @if($data->status == 1) selected @endif>Active</option>
                    <option value="0" @if($data->status == 0) selected @endif>Deactive</option>
                </select>                             
            </div>
        </div>
    </div>
</div>
@endif
                