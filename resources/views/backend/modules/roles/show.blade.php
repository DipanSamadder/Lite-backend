@extends('backend.layouts.app')

@section('header')
<style>
    .table tbody td, .table tbody th {padding: 0.25rem 0.55rem;}
</style>


@endsection

@section('content')
 <!-- Exportable Table -->
 <div class="row clearfix">
    
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>All</strong> Roles </h2>
                <!-- <ul class="header-dropdown">
                    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-right slideUp">
                            <li><a href="javascript:void(0);">Action</a></li>
                            <li><a href="javascript:void(0);">Another action</a></li>
                            <li><a href="javascript:void(0);">Something else</a></li>
                        </ul>
                    </li>
                    <li class="remove">
                        <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                    </li>
                </ul> -->
            </div>
            <div class="body">
                <div class="row">
                <div class="col-lg-6">
                    
                    @if(dsld_have_user_permission('roles_add') == 1)
                    <button class="btn btn-success btn-round mb-4" title="Add New" onclick="add_new_lg_modal_form()"><i class="zmdi zmdi-hc-fw"></i> Add New</button>
                    @endif
                    <button class="btn btn-info btn-round mb-4" onclick="get_pages();"><i class="zmdi zmdi-hc-fw"></i> Reload</button>
                </div>
                <div class="col-lg-6">
                    <form class="form-inline" id="search_media">
                        <!-- <div class="form-group">                                
                            <input type="date" class="form-control ms  mr-2" name="get_date" onchange="filter()">
                        </div> -->
                        <div class="col-lg-6 form-group">                                
                            <select class="form-control" name="sort" onchange="filter()">
                                <option value="newest">New to Old</option>
                                <option value="oldest">Old to New</option>
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">                                    
                            <input type="text" class="form-control w-100" name="search" onblur="filter()" placeholder="Search..">
                        </div>
                    </form>
                </div>
                </div>
                <div class="table-responsive">
                    <div id="data_table"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
    @include('backend.modules.roles.add')
    <input type="hidden" name="page_no" id="page_no" value="1">
<script>
    function add_new_lg_modal_form(){
        $('#add_new_larger_modals').modal('show');
        $('#add_new_larger_modals_tile').text('Add New Roles');
    }

    $(document).ready(function(){
        $('#add_new_form').on('submit', function(event){
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
                    'name': $('#name').val(),
                },
                success: function(data) {
                    if(data['status'] =='success'){
                        $('#add_new_form')[0].reset();  
                        get_pages();
                        $('#add_new_larger_modals').modal('hide'); 
                    }
                    dsldFlashNotification(data['status'], data['message']);
                    DSLDButtonLoader(Loader, "");
                }
            });
        });
    });
   

    

    function get_pages(){
        var search = $('input[name=search]').val();
        var sort = $('select[name=sort]').val();
        var page = $('#page_no').val();
        $('#data_table').html('<center><img src="{{ dsld_static_asset('backend/assets/images/circle-loading.gif') }}" style="max-width:100px" ></center>');

        $.ajax({
            url: "{{ route('ajax_roles') }}",
            type: "post",
            cache : false,
            data: {
                    '_token':'{{ csrf_token() }}',
                    'user_id':'{{ Auth::user()->id }}',
                    'search': search,
                    'page': page,
                    'sort': sort
                },
            success: function(d) {
                $('#data_table').html(d);
            }
        });
    }

    $(document).ready(function(){
        $('#page_no').val(1);
        get_pages();
    });
    function filter(){
        $('#page_no').val(1);
        get_pages();
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
            get_pages();
        });
    });

</script>
@endsection