 
<div class="modal fade" id="add_new_larger_modals" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="add_new_larger_modals_tile"></h4>
            </div>
            <form id="add_new_form" action="{{ route('pages.store') }}" method="POST" enctype="multipart/form-data" >
                <input type="hidden" name="type" id="type" value="custom_page">
            @csrf 
            <div class="modal-body">
                <div id="add_new_larger_modals_body">
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">Title <small class="text-danger">*</small></label>                                 
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Title" />                                   
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Banner</label>                                 
                                    <select class="form-control show-tick ms select2" name="banner" id="banner" onchange="is_edited()">
                                        <option value="">-- Please select --</option>
                                        @foreach(App\Models\Upload::where('user_id', Auth::user()->id)->where('type', 'image')->get() as $key => $value)
                                            <option value="{{ $value->id }}">({{ $value->id }}) - {{ $value->file_title}} </option>
                                        @endforeach
                                    </select>                                                                
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Status <small class="text-danger">*</small></label>                                 
                                    <select class="form-control w-100  ms select2 mr-2" name="status" id="status">
                                        <option value="">-- Please select --</option>
                                        <option value="1" selected>Active</option>
                                        <option value="0">Deactive</option>
                                    </select>                             
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">Description</label>                                 
                                    <div class="summernote" id="content">
                                    </div>                                   
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                <div class="swal-button-container">
                    <button type="submit" class="btn btn-success btn-round waves-effect dsld-btn-loader">SUBMIT</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
