@extends('backend.layouts.app')

@section('header')
<style>
    .table tbody td, .table tbody th {padding: 0.25rem 0.55rem;}

</style>


@endsection

@section('content')
@php
$name = 'page';
if(isset($page) && !empty($page['name'])){
    $name = $page['name'];
}
@endphp
 <!-- Exportable Table -->
 <div class="row clearfix">
    
    <div class="col-lg-7">
        <div class="card">
            <div class="header">
                <h2><strong>All</strong> {{ $name }}s </h2>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-lg-4">
                        <button class="btn btn-info btn-round mb-4" onclick="get_pages();"><i class="zmdi zmdi-hc-fw"></i> Reload</button>
                    </div>
                    <div class="col-lg-8">
                        <form class="form-inline" id="search_media">
                            <div class="col-lg-6 form-group">                                
                                <select class="form-control" name="sort" onchange="filter()">
                                    <option value="newest">New to Old</option>
                                    <option value="oldest">Old to New</option>
                                    <option value="active">Active</option>
                                    <option value="deactive">Deactive</option>
                                </select>
                            </div>
                            <div class="col-lg-6 form-group">                                    
                                <input type="text" class="form-control w-100" name="search" onblur="filter()" placeholder="Search..">
                            </div>
                        </form><br>  
                    </div>
                </div>
                <div class="table-responsive">
                    <div id="data_table"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="header">
                <h2><strong>Add New</strong> {{ $name }}s </h2>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-lg-12">
                        <form id="add_new_form" action="{{ route('pages.store') }}" method="POST" enctype="multipart/form-data" >
                            <input type="hidden" name="type" value="product_cat">
                            <input type="hidden" name="template" value="product_list">
                            @csrf 
                            <div class="modal-body">
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">{{ $name }}<small class="text-danger">*</small></label>                                 
                                            <input type="text" name="title" class="form-control" placeholder="{{ $name }}" />                                   
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Parent </label>   
                                            @php 
                                                $parent = \App\Models\Page::where('status', 1)->where('type', 'product_cat')->get();
                                            @endphp
                              
                                            <select class="form-control w-100  ms select2 mr-2" name="parent_id">
                                                <option value="">Select Parent</option>
                                                
                                                    @foreach($parent as $key => $value)
                                                        <option value="{{ $value->id }}">{{ $value->title }}</option>
                                                    @endforeach
                                               
 
                                            </select>                             
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Order </label>                                 
                                            <input type="text" name="order" class="form-control" placeholder="Order" value="10" />                                   
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Status <small class="text-danger">*</small></label>                                 
                                            <select class="form-control w-100  ms select2 mr-2" name="status" id="status">
                                                <option value="">Please select --</option>
                                                <option value="1" selected>Active</option>
                                                <option value="0">Deactive</option>
                                            </select>                             
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="swal-button-container">
                                            <button type="submit" class="btn btn-success btn-round waves-effect dsld-btn-loader">SUBMIT</button>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
    <!--Edit Section-->
    <div class="modal fade" id="edit_larger_modals" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="edit_larger_modals_title"></h4>
                </div>
                <form id="update_form" action="{{ route('pages.update') }}" method="POST" enctype="multipart/form-data" >
                    
                <input type="hidden" name="type" value="product_cat">
                <input type="hidden" name="template" value="product_list">
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


    <input type="hidden" name="page_no" id="page_no" value="1">
<script>


    function edit_lg_modal_form(id){
        $('#edit_larger_modals_body').html('');
        $('#edit_larger_modals').modal('show');
        $('#edit_larger_modals_title').text('Edit {{ $name }}');
        $.ajax({
            url: "{{ route('products_cat.edit') }}",
            type: "post",
            cache : false,
            data: {
                '_token':'{{ csrf_token() }}',
                'created_by':'{{ Auth::user()->id }}',
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
                data: $(this).serialize(),
                success: function(data) {
                    DSLDButtonLoader(Loader, "");
                    dsldFlashNotification(data['status'], data['message']);
                    if(data['status'] =='success'){
                        get_pages();
                        $('#edit_larger_modals').modal('hide');
                    }
                }
            });
        });
    });

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
                data: $(this).serialize(),
                success: function(data) {
                    if(data['status'] =='success'){
                        $('#add_new_form')[0].reset();   
                        get_pages();
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
            url: "{{ route('ajax_products_cat') }}",
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