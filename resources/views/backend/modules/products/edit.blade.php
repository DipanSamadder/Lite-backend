@extends('backend.layouts.app')

@section('header')
<link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
<style>
    .bootstrap-tagsinput{    border: 1px solid #cbcbcb !important;width: 100%;}
</style>
@endsection

@section('content')
 <!-- Exportable Table -->
 <form id="update_form" action="{{ route('pages.update') }}" method="POST" enctype="multipart/form-data" >
    <div class="row clearfix">
        <div class="col-lg-8">
            <input type="hidden" name="type" id="type" value="products_page">
            <input type="hidden" name="template" id="template" value="product_details">
            @csrf 
            <input type="hidden" name="id" id="id" value="{{ $data->id }}" />
            <div class="card mb-0">
                <div class="header">
                    <a href="{{ route('custom-pages.show_custom_page', [$data->slug]) }}" target="_blank">         
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
                            <label class="form-label">Short Description</label>  
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8">
                            <div class="form-group">
                            <textarea name="short_content" id="short_content" class="form-control" placeholder="Short Description" onchange="is_edited()" >{{ $data->short_content }}</textarea>  
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
                    <div class="summernote" id="content" onchange="is_edited()"> @php $str = $data->content; @endphp
                        <?php echo htmlspecialchars_decode($str); ?>
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
        <div class="col-lg-4">
            <div class="card mb-0">
                <div class="header">
                    <h2><strong>Publish</strong></h2>                        
                </div>
                <div class="body">
            
                    <div class="form-group">
                        <label class="form-label">Status *</label>                                 
                        <select class="form-control" name="status" id="status" onchange="is_edited()">
                            <option value="">-- Please select --</option>
                            <option value="1" @if($data->visibility == 1) selected @endif>Active</option>
                            <option value="0" @if($data->visibility == 0) selected @endif>Deactive</option>
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
                    <a href="{{ route('blogs.show_blog', [$data->slug ]) }}" traget="_blank"  class="btn btn-success btn-round waves-effect">Preview</a>
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
                    <h2><strong>Category</strong></h2>                        
                </div>
                <div class="body">
                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <select class="form-control show-tick ms select2" name="cateogries_id[]" id="cateogries_id" onchange="is_edited()" multiple>
                            <option value="0">-- Please select --</option>
                            @foreach(App\Models\Page::where('status', 1)->where('type', 'product_cat')->get() as $key => $value)
                                <option value="{{ $value->id }}" @if(!empty($data->cateogries_id) && is_array(json_decode($data->cateogries_id, true))) @if(in_array($value->id, json_decode($data->cateogries_id, true))) selected @endif @endif>{{ $value->title }}
                                </option>
                            @endforeach
                        </select>                                                           
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
                    <h2><strong>Gallery</strong></h2>                        
                </div>
                <div class="body">
                    <div class="form-group">
                        <label class="form-label">Gallery</label>
                        <select class="form-control show-tick ms select2" name="gallery[]" id="gallery" onchange="is_edited()" multiple>
                            <option value="0">-- Please select --</option>
                            @foreach(App\Models\Upload::where('user_id', Auth::user()->id)->where('type', 'image')->get() as $key => $value)
                                <option value="{{ $value->id }}"  @if(!empty($data->gallery) && is_array(json_decode($data->gallery, true))) @if(in_array($value->id, json_decode($data->gallery, true))) selected @endif @endif>({{ $value->id }}) - {{ $value->file_title}} </option>
                            @endforeach
                        </select>
                        @if(!empty($data->gallery) && is_array(json_decode($data->gallery, true)))
                            <div class="image mt-2">
                                @foreach(json_decode($data->gallery, true) as $key => $value) 
                                <img src="{{ dsld_uploaded_asset($value) }}"  alt="{{ dsld_upload_file_title($value) }}" style="width:100px;">
                                @endforeach
                            </div> 
                        @endif                                                            
                    </div>
                </div>
            </div>
            
        </div> 
    </div>
</form>

@if(is_array($section) || count($section) > 0)
<h4>Product Details</h4>
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card mb-0">
            <div class="body">
        
                <!-- Nav tabs -->
                <ul class="nav nav-tabs p-0 mb-3 nav-tabs-success" role="tablist">
                    @foreach($section as $key => $sec)
                        <li class="nav-item"><a class="nav-link @if($key == 0 ) active @endif" data-toggle="tab" href="#page_section-{{ $key }}-{{ $sec->id }}"> {{ $sec->title }} </a></li>   
                    @endforeach
                </ul>
                
                <!-- Tab panes -->
                <div class="tab-content">

                    @foreach($section as $key => $sec)
                    @php
                        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '_', $sec->title));
                        $title_page = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '_', $data->title));
                        $name = strtolower($slug);
                        $page_title = strtolower($title_page);
                        
                    @endphp
                    
                    <div role="tabpanel" class="tab-pane  @if($key == 0 ) in active @endif" id="page_section-{{ $key }}-{{ $sec->id }}">
                        
                        <form action="{{ route('pages_extra_content.update') }}" method="POST" enctype="multipart/form-data" >
                            <input type="hidden" name="page_id" value="{{ $data->id }}" />
                            <input type="hidden" name="page_name" value="{{ $page_title }}" />
                            <input type="hidden" name="section_name" value="{{ $name }}" />
                            <input type="hidden" name="section_id" value="{{ $sec->id }}" />

                            @csrf 
                                @if($sec->meta_fields !="")
                                @foreach (json_decode($sec->meta_fields) as $key2 => $element)
                                    @php 
                                        $page_meta_key = $name."_".$element->type."_".$key2;
                                        $page_meta_key_heading = $name."_".$element->type."_".$key2.'_heading';
                                        $page_meta_key_content = $name."_".$element->type."_".$key2.'_content';
                                    @endphp

                                    @if ($element->label == 'Details')
                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                                <label class="form-label">{{ ucfirst($element->label) }}</label>  
                                            </div>
                                            <div class="col-lg-10 col-md-10 col-sm-8">
                                                <div class="text_repeter{{ $sec->id }}_{{ $key2 }}">
                                                    <input type="hidden" name="type[]" value="{{ $page_meta_key }}">
                                                    <input type="hidden" name="{{ $page_meta_key }}[]" value="{{ $page_meta_key_heading }}">
                                                    <input type="hidden" name="{{ $page_meta_key }}[]" value="{{ $page_meta_key_content }}">
                                                    <input type="hidden" name="type[]" value="{{ $page_meta_key_heading }}">
                                                    <input type="hidden" name="type[]" value="{{ $page_meta_key_content }}">
                                                    
                                                    @if(dsld_page_meta_value_by_meta_key($page_meta_key_heading, $data->id) != '')
                                                        @foreach(@json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_heading, $data->id), true) as $key3 => $value) 
                                                            
                                                            <div class="row clearfix">
                                                                <div class="col-sm-10">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control"  name="{{ $page_meta_key_heading }}[]" placeholder="{{ ucfirst($element->label) }}" value="{{ @json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_heading, $data->id), true)[$key3] }}">  
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-auto">
                                                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row">
                                                                        <i class="zmdi zmdi-hc-fw"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="col-sm-10">
                                                                    <div class="form-group">
                                                                        <textarea class="summernote"  name="{{ $page_meta_key_content }}[]" placeholder="{{ ucfirst($element->label) }}">{{ @json_decode(dsld_page_meta_value_by_meta_key($page_meta_key_content, $data->id), true)[$key3] }}</textarea>   
                                                                    </div><hr>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <small>Meta Key: {{ $page_meta_key }} <br>{{ $page_meta_key_heading }}<br>{{ $page_meta_key_content }}</small>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4">
                                            </div>
                                            <div class="col-lg-10 col-md-10 col-sm-10">
                                                <div class="input-group mb-4">
                                                    <button type="button"
                                                        class="btn btn-primary addMoreBtn"
                                                        data-toggle="add-more"
                                                        data-content='<div class="row clearfix">
                                                            <div class="col-sm-10">
                                                                <div class="form-group"><input type="text" class="form-control"  name="{{ $page_meta_key_heading }}[]" placeholder="{{ ucfirst($element->label) }}">  
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row">
                                                                    <i class="zmdi zmdi-hc-fw"></i>
                                                                </button>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <div class="form-group">
                                                                    <textarea class="summernote form-control"  name="{{ $page_meta_key_content }}[]" placeholder="{{ ucfirst($element->label) }}"></textarea>   
                                                                </div><hr>
                                                            </div>
                                                        </div>'
                                                        data-target=".text_repeter{{ $sec->id }}_{{ $key2 }}">
                                                        <i class="zmdi zmdi-hc-fw"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($element->label == 'Select applications')   
                                    <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                                <label class="form-label">{{ ucfirst($element->label) }}</label>  
                                            </div>
                                            <div class="col-lg-10 col-md-10 col-sm-8">
                                                <div class="file_repeter{{ $sec->id }}_{{ $key2 }}">
                                                    <div class="form-group">
                                                        <input type="hidden" name="type[]" value="{{ $page_meta_key }}">
                                                        <select class="form-control show-tick ms select2" name="{{ $page_meta_key }}[]"  multiple>
                                                            <option value="">-- Please select --</option>
                                                            
                                                            @foreach(App\Models\Page::where('status', 1)->where('type', 'product_cat')->get() as $key => $value)
                                                                <option value="{{ $value->id }}" @if(!empty(dsld_page_meta_value_by_meta_key($page_meta_key, $data->id)) && is_array(json_decode(dsld_page_meta_value_by_meta_key($page_meta_key, $data->id), true))) @if(in_array($value->id, json_decode(dsld_page_meta_value_by_meta_key($page_meta_key, $data->id), true))) selected @endif @endif>{{ $value->title }}
                                                                </option>
                                                            @endforeach
                                                            
                                                        </select>
                                                        
                                                    </div>
                                                </div><small>Meta Key: {{ $page_meta_key }}</small>
                                                
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                @endif
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-control-label">
                                        <div class="swal-button-container">
                                            <button type="submit" class="btn btn-success btn-round waves-effect dsld-btn-loader" id="submit_btn">Update</button>
                                        </div>
                                    </div>
                                </div>

                        </form>
                    </div>
                    @endforeach

                </div>

                
            </div>
        </div>
        
    </div>
</div>
@endif
@endsection

@section('footer')



<script src="{{ dsld_static_asset('backend/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
<script>
    
    $(document).ready(function(){
        
        $('.summernote').summernote();

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
                    'type': $('#type').val(),
                    'short_content': $('#short_content').val(),
                    'template': $('#template').val(),
                    'status': $('#status').val(),
                    'slug': $('#slug').val(),
                    'date': $('#date').val(),
                    'gallery': $('#gallery').val(),
                    'thumbnail': $('#thumbnail').val(),
                    'banner': $('#banner').val(),
                    'catalogue': $('#catalogue').val(),
                    'cateogries_id': $('#cateogries_id').val(),
                    'thumbnail': $('#thumbnail').val(),
                    'meta_title': $('#meta_title').val(),
                    'meta_description': $('#meta_description').val(),
                    'order': $('#order').val(),
                    'keywords': $('#keywords').val(),
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