@extends('backend.layouts.app')

@section('header')
<link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/plugins/footable-bootstrap/css/footable.bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/plugins/footable-bootstrap/css/footable.standalone.min.css') }}">
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-lg-4">

        @if(dsld_have_user_permission('media_add') == 1)  
        <button class="btn btn-success btn-round mb-4" data-toggle="modal" data-target="#DSLDImageUpload" title="Add Media"><i class="zmdi zmdi-hc-fw"></i> Add New</button>
        @endif

        <button class="btn btn-info btn-round mb-4" onclick="get_files();"><i class="zmdi zmdi-hc-fw"></i> Reload</button>
    </div>
    <div class="col-lg-8">
    <form class="form-inline" id="search_media">
        <!-- <div class="form-group">                                
            <input type="date" class="form-control ms  mr-2" name="get_date" onchange="filter()">
        </div> -->
        <div class="col-lg-4">
            <div class="form-group">                                
                <select class="form-control" name="sort" onchange="filter()">
                    <option value="newest">New to Old</option>
                    <option value="oldest">Old to New</option>
                    <option value="smallest">Samllest</option>
                    <option value="largest">Largest</option>
                </select>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">                                
                <select class="form-control" name="media_type" onchange="filter()">
                    <option value="all">All</option>
                    <option value="image">Image</option>
                    <option value="document">Documents</option>
                    <option value="video">Video</option>
                    <option value="audio">Audio</option>
                    <option value="archive">Archive</option>
                </select>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">                                    
                <input type="text" class="form-control" name="search" onblur="filter()" placeholder="Search File name">
            </div>
        </div>
    </form>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="tab-content">
                
                <div class="tab-pane file_manager active" id="grid_view">
                    <div id="load_files">
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('footer')
<input type="hidden" name="page_no" id="page_no" value="1">
<!--Edit Section-->
<div class="modal fade" id="edit_larger_modals" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="edit_larger_modals_title"></h4>
            </div>
            <form id="update_form" action="{{ route('media.update') }}" method="POST" enctype="multipart/form-data" >
            @csrf 
            <div class="modal-body">
                <div id="edit_larger_modals_body">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                <div class="swal-button-container">
                    <button type="submit" class="btn btn-success btn-round waves-effect dsld-btn-loader">UPDATE</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<!--Edit Section-->


<script src="{{ dsld_static_asset('backend/assets/bundles/footable.bundle.js') }}"></script>
<script src="{{ dsld_static_asset('backend/assets/js/pages/tables/footable.js') }}"></script>

<script>
    function popup_media(id){

        $('#edit_larger_modals_body').html('');
        $('#edit_larger_modals').modal('show');
        $('#edit_larger_modals_title').text('Edit Alt Tag');
        $.ajax({
            url: "{{ route('media.edit') }}",
            type: "post",
            cache : false,
            data: {
                    '_token':'{{ csrf_token() }}',
                    'user_id':'{{ Auth::user()->id }}',
                    'id': id,
                },
            success: function(d) {
                $('#edit_larger_modals_body').html(d);
            }
        });
    }

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
                    'title': $('#edit_file_title').val(),
                    'id': $('#edit_id').val(),
                },
                success: function(data) {
                    DSLDButtonLoader(Loader, "");
                    dsldFlashNotification(data['status'], data['message']);
                    if(data['status'] =='success'){
                        get_files();
                    }
                    
                }
            });
        });
    });

    function file_delete(id){
        $.ajax({
            url: "{{ route('media.destroy.admin') }}",
            type: "post",
            data: {'_token':'{{ csrf_token() }}', 'id':id},
            success: function(d) {
               
                get_files();
            }
        });
    }

    function get_files(){
        var search = $('input[name=search]').val();
        var sort = $('select[name=sort]').val();
        var media_type = $('select[name=media_type]').val();
        var page = $('#page_no').val();

        $('#load_files').html('<center><img src="{{ dsld_static_asset('backend/assets/images/circle-loading.gif') }}" style="max-width:100px" ></center>');

        $.ajax({
            url: "{{ route('media.gets.admin') }}",
            type: "post",
            cache : false,
            data: {'_token':'{{ csrf_token() }}', 'user_id':'{{ Auth::user()->id }}', 'search':search, 'sort':sort, 'media_type':media_type, 'page':page},
            success: function(d) {
                $('#load_files').html(d);
            }
        });
    }

    $(document).ready(function(){
        $('#page_no').val(1);
        get_files();
    });
    function filter(){
        $('#page_no').val(1);
        get_files();
    }
    $(document).ready(function()
{
        $(document).on('click', '.pagination a',function(event)
        {
            $('li').removeClass('active');
            $(this).parent('li').addClass('active');
            event.preventDefault();
            var myurl = $(this).attr('href');
            var page=$(this).attr('href').split('page=')[1];
            $('#page_no').val(page);
            get_files();
        });
    });
</script>
@endsection