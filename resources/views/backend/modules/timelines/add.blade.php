
<div class="modal fade" id="add_new_larger_modals" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="add_new_larger_modals_tile"></h4>
            </div>
            <form id="add_new_form" action="{{ route('history.timeline.store') }}" method="POST" enctype="multipart/form-data" >
            @csrf 
            <div class="modal-body">
                <div id="add_new_larger_modals_body">
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-12">   
                                <div class="form-group">
                                    <label class="form-label">Year<small class="text-danger">*</small></label>                                 
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Year" />                                   
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label">Month Name <small class="text-danger">*</small></label>                              
                                    <input type="text" name="month" id="month" class="form-control" placeholder="Month" />                                   
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label">Banner </label>                                
                                    <select class="form-control show-tick ms select2" name="banner" id="banner" onchange="is_edited()">
                                        <option value="">-- Please select --</option>
                                        @foreach(App\Models\Upload::where('user_id', Auth::user()->id)->where('type', 'image')->get() as $key => $value)
                                            <option value="{{ $value->id }}">({{ $value->id }}) - {{ $value->file_title}} </option>
                                        @endforeach
                                    </select>                                    
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label">History <small class="text-danger">*</small></label>                              
                                    <select class="form-control show-tick ms select2" name="cat" id="cat" onchange="is_edited()">
                                        <option value="">-- Please select --</option>
                                        <option value="group">Group History</option>
                                        <option value="indian">India History</option>
                                    </select>                                    
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">Content <small class="text-danger">*</small> </label>                                            
                                    <textarea name="content" id="content" class="form-control" placeholder="Content"></textarea>                                   
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Order </label>                                 
                                    <input type="text" name="order" id="order" class="form-control" placeholder="Order" value="0" />                                   
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
