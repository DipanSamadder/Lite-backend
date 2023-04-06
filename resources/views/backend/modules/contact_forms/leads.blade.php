@extends('backend.layouts.app')

@section('header')
<style>
    .table tbody td, .table tbody th {padding: 0.25rem 0.55rem;}
    section.content {background: #ffe4e4;}
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
    
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>All</strong> {{ $name }}s </h2>
            </div>
            <div class="body">
                <div class="row">
                <div class="col-lg-2">
                    <button class="btn btn-info btn-round mb-4" onclick="get_pages();"><i class="zmdi zmdi-hc-fw"></i> Reload</button>
                </div>
                <div class="col-lg-10">
                    <form class="form-inline" id="search_media">
                        <!-- <div class="form-group">                                
                            <input type="date" class="form-control ms  mr-2" name="get_date" onchange="filter()">
                        </div> -->
                        <div class="col-lg-3 form-group">                                
                            <select class="form-control" name="export_form_id" onchange="export_data();">
                                <option value="">Export</option>
                                @if(App\Models\Page::where('type', 'contact_form')->get() != '')
                                    @foreach(App\Models\Page::where('type', 'contact_form')->get() as $k => $val)
                                        <option value="{{ route('cf-export-leads', [$val->id]) }}">{{ $val->title }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-lg-3 form-group">                                
                            <select class="form-control" name="forms_ids" onchange="filter()">
                                <option value="all">All</option>
                                @if(App\Models\Page::where('type', 'contact_form')->get() != '')
                                    @foreach(App\Models\Page::where('type', 'contact_form')->get() as $k => $val)
                                        <option value="{{ $val->id }}">{{ $val->title }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-lg-3 form-group">                                
                            <select class="form-control" name="sort" onchange="filter()">
                                <option value="newest">New to Old</option>
                                <option value="oldest">Old to New</option>
                            </select>
                        </div>
                        <div class="col-lg-3 form-group">                                    
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


<input type="hidden" name="page_no" id="page_no" value="1">

<script>
   function export_data(){   
        var url = $('select[name=export_form_id]').val();
        if(url != ''){window.open(url, '_blank'); }
    }
   
    function get_pages(){
        var search = $('input[name=search]').val();
        var forms_ids = $('select[name=forms_ids]').val();
        var sort = $('select[name=sort]').val();
        var page = $('#page_no').val();
        $('#data_table').html('<center><img src="{{ dsld_static_asset('backend/assets/images/circle-loading.gif') }}" style="max-width:100px" ></center>');

        $.ajax({
            url: "{{ route('ajax_contact_forms_leads') }}",
            type: "post",
            cache : false,
            data: {
                    '_token':'{{ csrf_token() }}',
                    'user_id':'{{ Auth::user()->id }}',
                    'search': search,
                    'forms_ids': forms_ids,
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
   

    $(document).ready(function(){
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