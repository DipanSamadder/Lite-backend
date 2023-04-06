@if($data !='')

<input type="hidden" name="id" value="{{ $data->id }}">
<div class="body">
    <div class="row clearfix">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">Category <small class="text-danger">*</small></label>                                 
                <input type="text" name="title" class="form-control" placeholder="Category" @if($data->title) value="{{ $data->title }}" @endif  />                                   
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">Slug <small class="text-danger">*</small></label>                                 
                <input type="text" name="slug" class="form-control" placeholder="Slug" @if($data->slug) value="{{ $data->slug }}" @endif  />                                   
            </div>
        </div>
        
        <div class="col-sm-3">
            <div class="form-group">
                <label class="form-label">Banner</label>                                 
                <select class="form-control show-tick ms select2" name="banner" id="banner" onchange="is_edited()">
                    <option value="">-- Please select --</option>
                    @foreach(App\Models\Upload::where('user_id', Auth::user()->id)->where('type', 'image')->get() as $key => $value)
                        <option value="{{ $value->id }}" @if($data->banner == $value->id) selected @endif>({{ $value->id }}) - {{ $value->file_title}} </option>
                    @endforeach
                </select>                                                                
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="form-label">Icon</label>                                 
                <select class="form-control show-tick ms select2" name="thumbnail" id="thumbnail" onchange="is_edited()">
                    <option value="">-- Please select --</option>
                    @foreach(App\Models\Upload::where('user_id', Auth::user()->id)->where('type', 'image')->get() as $key => $value)
                        <option value="{{ $value->id }}" @if($data->thumbnail == $value->id) selected @endif>({{ $value->id }}) - {{ $value->file_title}} </option>
                    @endforeach
                </select>                                                                
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="form-label">Order </label>                                 
                <input type="text" name="order" class="form-control" placeholder="Order"  @if($data->order) value="{{ $data->order }}" @else value="10"  @endif  />                                   
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="form-label">Category <small class="text-danger">*</small></label>                                 
                <select class="form-control w-100  ms select2 mr-2" name="parent_id">
                    <option value="">-- Please select --</option>
                    @foreach($product_cat as $key => $value)
                        <option value="{{ $value->id }}" @if($value->id == $data->parent_id) selected @endif>{{ $value->title }}
                        </option>
                    @endforeach
                </select>                             
            </div>
        </div>
        
        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label">Meta Title </label>                                 
                <input type="text" name="meta_title" class="form-control" placeholder="Meta Title"  @if($data->meta_title) value="{{ $data->meta_title }}" @endif  />                                   
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label">Meta Description </label>                                 
                <input type="text" name="meta_description" class="form-control" placeholder="Meta Description"  @if($data->meta_description) value="{{ $data->meta_description }}" @endif  />                                   
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">                                 
                <label class="form-label">Status <small class="text-danger">*</small></label>                                 
                <select class="form-control w-100  ms select2 mr-2" name="status">
                    <option value="">-- Please select --</option>
                    <option value="1"  @if($data->status == 1) selected @endif>Active</option>
                    <option value="0" @if($data->status == 0) selected @endif>Deactive</option>
                </select>                            
            </div>
        </div>
    </div>

</div>
@endif
                