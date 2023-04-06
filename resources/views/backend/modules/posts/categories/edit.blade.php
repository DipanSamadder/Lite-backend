@extends('backend.layouts.app')

@section('header')
<link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
<style>
    .bootstrap-tagsinput{    border: 1px solid #cbcbcb !important;width: 100%;}
    section.content{background: #f8fbc6;}
</style>
@endsection

@section('content')
 <!-- Exportable Table -->
 <form id="update_form" action="{{ route('posts_cat.update') }}" method="POST" enctype="multipart/form-data" >
    <div class="row clearfix">
        <div class="col-lg-8">
            @csrf 
            <input type="hidden" name="id" id="id" value="{{ $data->id }}" />
            <div class="card mb-0">
                <div class="header">
                    <a href="{{ route('custom-pages.show_custom_page', [$data->slug ]) }}" target="_blank">         
                        <h2><strong> <i class="zmdi zmdi-hc-fw"></i> {{ $data->title }}</strong></h2>
                    </a>
                </div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                            <label class="form-label">Title <small class="text-danger">*</small></label>  
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8">
                            <div class="form-group">
                            <input type="text" name="title" id="title" class="form-control" placeholder="Title" onchange="is_edited()" value="{{ $data->title }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                            <label class="form-label">Slug <small class="text-danger">*</small><span class="ml-2 pointer-cursor" onclick="$('input[name=slug]').removeAttr('disabled');"><i class="zmdi zmdi-edit"></i></a></label>  
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8">
                            <div class="form-group">
                            <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" value="{{ $data->slug }}" onchange="is_edited()" disabled/>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                            <label class="form-label">Excerpt</label>  
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8">
                            <div class="form-group">
                            <input type="text" name="excerpt" id="excerpt" class="form-control" placeholder="Excerpt" value="{{ $data->excerpt }}" onchange="is_edited()" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-0">
                <div class="header">
                    <h2><strong>Description</strong></h2>
                </div>
                <div class="form-group">                                
                    <div class="summernote" id="content" onchange="is_edited()">    @php $str = $data->content; @endphp
                        <?php echo htmlspecialchars_decode($str); ?>
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
                    <a href="{{ route('custom-pages.show_custom_page', [$data->slug ]) }}" traget="_blank"  class="btn btn-success btn-round waves-effect">Preview</a>
                    <button type="button" class="btn btn-danger btn-round waves-effect" onclick="DSLDDeleteAlert('{{ $data->id }}','{{ route('pages.destory') }}','{{ csrf_token() }}')"><i class="zmdi zmdi-delete"></i></button>
                </div>
            </div>
            <div class="card mb-0">
                <div class="header">
                    <h2><strong>Banner</strong></h2>                        
                </div>
                <div class="body">
                    <div class="form-group">
                        <label class="form-label">Banner</label>
                        <select class="form-control show-tick ms select2" name="banner" id="banner" onchange="is_edited()">
                            <option value="0">-- Please select --</option>
                            @foreach(App\Models\Upload::where('user_id', Auth::user()->id)->where('type', 'image')->get() as $key => $value)
                                <option value="{{ $value->id }}" @if($data->banner == $value->id) selected @endif>({{ $value->id }}) - {{ $value->file_title}} </option>
                            @endforeach
                        </select>
                        @if($data->banner > 0)
                        <div class="image mt-2">
                            <img src="{{ dsld_uploaded_asset($data->banner) }}"  alt="{{ dsld_upload_file_title($data->banner) }}" class="img-fluid">
                        </div> 
                        @endif                                                            
                    </div>
                </div>
            </div>
            <div class="card mb-0">
                <div class="header">
                    <h2><strong>Thumbnail</strong></h2>                        
                </div>
                <div class="body">
                    <div class="form-group">
                        <label class="form-label">Thumbnail</label>
                        <select class="form-control show-tick ms select2" name="thumbnail" id="thumbnail" onchange="is_edited()">
                            <option value="0">-- Please select --</option>
                            @foreach(App\Models\Upload::where('user_id', Auth::user()->id)->where('type', 'image')->get() as $key => $value)
                                <option value="{{ $value->id }}" @if($data->thumbnail == $value->id) selected @endif>({{ $value->id }}) - {{ $value->file_title}} </option>
                            @endforeach
                        </select>
                        @if($data->thumbnail > 0)
                        <div class="image mt-2">
                            <img src="{{ dsld_uploaded_asset($data->thumbnail) }}"  alt="{{ dsld_upload_file_title($data->banner) }}" class="img-fluid">
                        </div> 
                        @endif                                                            
                    </div>
                </div>
            </div>
            <div class="card mb-0">
                <div class="header">
                    <h2><strong>SEO</strong></h2>                        
                </div>
                <div class="body">
                    <div class="form-group">
                        <label class="form-label">Meta Title</label>                                 
                        <input type="text" name="meta_title" id="meta_title" onchange="is_edited()" class="form-control" placeholder="Meta Title" value="{{ $data->meta_title }}" />                                   
                    </div>
                    <div class="form-group">
                        <label class="form-label">Meta Description</label>                                 
                        <input type="text" name="meta_description" onchange="is_edited()" id="meta_description" class="form-control" placeholder="Meta Drscription" value="{{ $data->meta_description }}" />                                   
                    </div>
                    <div class="form-group">
                        <label class="form-label">Keyword</label>   <br>                                       
                        <input type="text" class="form-control" onchange="is_edited()" name="keywords" id="keywords" data-role="tagsinput" value="{{ $data->keywords }}">                          
                    </div>
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
            var content =  $("#content").summernote('code');
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                cache : false,
                data: {
                    '_token':'{{ csrf_token() }}', 
                    'user_id':'{{ Auth::user()->id }}',
                    'id': $('#id').val(),
                    'title': $('#title').val(),
                    'slug': $('#slug').val(),
                    'date': $('#date').val(),
                    'banner': $('#banner').val(),
                    'thumbnail': $('#thumbnail').val(),
                    'meta_title': $('#meta_title').val(),
                    'meta_description': $('#meta_description').val(),
                    'order': $('#order').val(),
                    'keywords': $('#keywords').val(),
                    'excerpt': $('#excerpt').val(),
                    'content': content,
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
        window.location.href = "{{ route('pages.index') }}";
    }

</script>
@endsection