@extends('backend.layouts.app')

@section('header')
<link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
<style>
    .bootstrap-tagsinput{    border: 1px solid #cbcbcb !important;width: 100%;}
</style>
@endsection

@section('content')
 <!-- Exportable Table -->
 <form id="update_form" action="{{ route('roles.update') }}" method="POST" enctype="multipart/form-data" >
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
                </div>
            </div>
            <div class="card mb-0">
                <div class="header">
                    <h2><strong> <i class="zmdi zmdi-hc-fw"></i> Permissions</strong></h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Menu</th>
                                <th>Add</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php 
                                $permission = json_decode($data->permissions);
                                @endphp
                                @foreach(App\Models\RolePermission::where('parent_id', 0)->get() as $key => $value)
                                <tr>
                                    <td>
                                        
                                        <div class="checkbox">
                                            <input id="dashboard_{{ $value->keys }}" name="permissions[]" type="checkbox" onchange="is_edited()" value="{{ $value->id }}"
                                            @if(in_array($value->id, $permission)) checked @endif >
                                            <label for="dashboard_{{ $value->keys }}">{{ $value->name }}</label>
                                        </div>
                                    </td>
                                    @php 
                                     $arr = array('add', 'edit','delete');
                                    @endphp

                                    @foreach($arr as $ckey => $child)
                                        @php 
                                        $ch = App\Models\RolePermission::where('parent_id', $value->id)->where('keys', $value->keys.'_'.$child)->first();
                                        @endphp
                                        @if($ch != '')
                                        <td>
                                            <div class="checkbox">
                                            <input id="dashboard_{{ $ch->keys }}" name="permissions[]" onchange="is_edited()" type="checkbox" value="{{ $ch->id }}"
                                            @if(in_array($ch->id, $permission)) checked @endif >
                                            <label for="dashboard_{{ $ch->keys }}"></label>
                                            </div>
                                        </td>
                                        @else
                                            <td>
                                                <div class="checkbox disable_checkbox">
                                                <input id="{{ $value->keys }}_{{ $ckey }}" type="checkbox" value="{{ $value->keys }}{{ $ckey }}" disabled>
                                                <label for="{{ $value->keys }}_{{ $ckey }}"></label>
                                                </div>
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                        <label class="form-label">Publish <small class="text-danger">*</small></label>                             
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
                    <button type="button" class="btn btn-danger btn-round waves-effect" onclick="DSLDDeleteAlert('{{ $data->id }}','{{ route('users.destory') }}','{{ csrf_token() }}')"><i class="zmdi zmdi-delete"></i></button>
                </div>
            </div>
        </div> 
    </div>
</form>
@endsection

@section('footer')



<script src="{{ dsld_static_asset('backend/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
<script>
    
    // $(document).ready(function(){
    //     $('#update_form').on('submit', function(event){
    //     event.preventDefault();
    //         $('.dsld-btn-loader').addClass('btnloading');
    //         var Loader = ".btnloading";
    //         DSLDButtonLoader(Loader, "start");
    //         $.ajax({
    //             url: $(this).attr('action'),
    //             type: $(this).attr('method'),
    //             cache : false,
    //             data: {
    //                 '_token':'{{ csrf_token() }}', 
    //                 'user_id':'{{ Auth::user()->id }}',
    //                 'id': $('#id').val(),
    //                 'name': $('#name').val(),
    //                 'permissions': $('#permissions').val(),
    //             },
    //             success: function(data) {
    //                 DSLDButtonLoader(Loader, "");
    //                 dsldFlashNotification(data['status'], data['message']);
    //                 if(data['status'] =='success'){
    //                     location.reload();
    //                 }
                    
    //             }
    //         });
    //     });
    // });
    function is_edited(){
        $('#submit_btn').removeAttr('disabled');
    }
    function get_pages(){
        window.location.href = "{{ route('users.index') }}";
    }

</script>
@endsection