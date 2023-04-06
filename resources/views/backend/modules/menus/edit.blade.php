@extends('backend.layouts.app')

@section('header')
<link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
<style>
    .bootstrap-tagsinput{    border: 1px solid #cbcbcb !important;width: 100%;}
</style>
@endsection

@section('content')
 <!-- Exportable Table -->
 <form id="update_form" action="{{ route('menus.update') }}" method="POST" enctype="multipart/form-data" >
    <div class="row clearfix">
        <div class="col-lg-8">
            @csrf 
            <input type="hidden" name="id" id="id" value="{{ $data->id }}" />
            <div class="card mb-0">
                <div class="header">
                    <h2><strong> <i class="zmdi zmdi-hc-fw"></i> {{ $data->name }}</strong></h2>
                </div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                            <label class="form-label">Name <small class="text-danger">*</small></label>  
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8">
                            <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" onchange="is_edited()" value="{{ $data->name }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                            <label class="form-label">Url <small class="text-danger">*</small></label>  
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8">
                            <div class="form-group">
                            <input type="text" name="url" id="url" class="form-control" placeholder="URL" onchange="is_edited()" value="{{ $data->url }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                            <label class="form-label">Parent</label>  
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8">
                         
                            <select class="form-control show-tick ms select2" name="parent" id="parent" onchange="is_edited()">
                                <option value="0">-- Please select --</option>
                                @foreach(App\Models\Menu::where('status', 0)->whereNotIn('id', [$data->id])->get() as $key => $value)
                                    <option value="{{ $value->id }}" @if($value->id == $data->parent) selected @endif>{{ $value->name}}</option>
                                @endforeach
                            </select>  
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-0">
                <div class="header">
                    <h2><strong>Setting</strong></h2>

                </div>
                <div class="form-group">                                
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                            <label class="form-label">Class</label>  
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8">
                            <div class="form-group">
                            <input type="text" name="class_name" id="class_name" class="form-control" placeholder="Class Name" onchange="is_edited()" @if(json_decode($data->setting, true)['class']  != '') value="{{ json_decode($data->setting, true)['class'] }}" @endif/>
                            </div>
                        </div>
                    </div>                      
                </div>
                <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                            <label class="form-label">Target</label>  
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8">
                         
                            <select class="form-control show-tick ms select2" name="target" id="target" onchange="is_edited()">
                                <option value="0">-- Please select --</option>
                                <option value="1" @if(json_decode($data->setting, true)['target'] == 1) selected @endif>New Tab</option>
                            </select>  
                        </div>
                    </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-0">
                <div class="header">
                    <h2><strong>Publish</strong></h2>                        
                </div>
                <div class="body">
            
                    <div class="form-group">
                        <label class="form-label">Status </label>                                 
                        <select class="form-control" name="status" id="status" onchange="is_edited()">
                            <option value="">-- Please select --</option>
                            <option value="0" @if($data->status == 0) selected @endif>Active</option>
                            <option value="1" @if($data->status == 1) selected @endif>Deactive</option>
                        </select>                         
                    </div>
                    <div class="form-group">
                        <label class="form-label">Type </label> 
                        <select class="form-control show-tick ms select2" name="type" id="type" onchange="is_edited()">
                            <option value="">-- Please select --</option>
                            <option value="header_menu" @if($data->type == 'header_menu') selected @endif>Header Menu</option>
                            <option value="footer_menu" @if($data->type == 'footer_menu') selected @endif>Footer Menu</option>
                        </select>                            
                    </div>
                    <div class="form-group">
                        <label class="form-label">Order</label>                                 
                        <input type="text" name="order" id="order" onchange="is_edited()" class="form-control" placeholder="Order" value="{{ $data->order }}" />                                   
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                        </div>
                        <input type="date" name="date" id="date" class="form-control" onchange="is_edited()" value="{{  date('Y-m-d', strtotime($data->created_at)) }}">
                    </div>
                    <div class="swal-button-container">
                        <button type="submit" class="btn btn-success btn-round waves-effect dsld-btn-loader" id="submit_btn" disabled="disabled">Update</button>
                    </div>
                    
                    <button type="button" class="btn btn-danger btn-round waves-effect" onclick="DSLDDeleteAlert('{{ $data->id }}','{{ route('menus.destory') }}','{{ csrf_token() }}')"><i class="zmdi zmdi-delete"></i></button>
                </div>
            </div>
        </div> 
    </div>
</form>
@endsection

@section('footer')



<script src="{{ dsld_static_asset('backend/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
<script>
    
    $(document).ready(function(){
        $('#update_form').on('submit', function(event){
        event.preventDefault();
            $('.dsld-btn-loader').addClass('btnloading');
            var Loader = ".btnloading";
            DSLDButtonLoader(Loader, "start");
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                cache : false,
                data: {
                    '_token':'{{ csrf_token() }}', 
                    'user_id':'{{ Auth::user()->id }}',
                    'id': $('#id').val(),
                    'name': $('#name').val(),
                    'url': $('#url').val(),
                    'class_name': $('#class_name').val(),
                    'parent': $('#parent').val(),
                    'type': $('#type').val(),
                    'status': $('#status').val(),
                    'date': $('#date').val(),
                    'order': $('#order').val(),
                    'target': $('#target').val(),
                },
                success: function(data) {
                    DSLDButtonLoader(Loader, "");
                    dsldFlashNotification(data['status'], data['message']);
                    if(data['status'] =='success'){
                        location.reload();
                    }
                    
                }
            });
        });
    });
    function is_edited(){
        $('#submit_btn').removeAttr('disabled');
    }
    function get_pages(){
        window.location.href = "{{ route('menus.index') }}";
    }

</script>
@endsection