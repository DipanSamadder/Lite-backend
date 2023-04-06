
<table class="table table-bordered table-striped table-hover dataTable">
    <thead>
            <tr class="text-center">
                <th>Sr</th>
                <th>Banner</th>
                <th>Title</th>
                <th>Meta Title</th>
                <th>Date</th>
                @if(dsld_have_user_permission('posts_edit') == 1)
                <th>Status</th>
                @endif
                @if(dsld_have_user_permission('posts_edit') == 1 || dsld_have_user_permission('posts_delete') == 1)
                <th>Action</th>
                @endif
            </tr>
        </thead>
        <tfoot>
            <tr class="text-center">
                <th>Sr</th>
                <th>Banner</th>
                <th>Title</th>
                <th>Meta Title</th>
                <th>Date</th>
                @if(dsld_have_user_permission('posts_edit') == 1)
                <th>Status</th>
                @endif
                @if(dsld_have_user_permission('posts_edit') == 1 || dsld_have_user_permission('posts_delete') == 1)
                <th>Action</th>
                @endif
            </tr>
        </tfoot>
    <tbody>
        @if(is_array($data) || count($data) > 0 )
            @foreach($data as $key => $value)
            @php $key++; @endphp
                <tr>
                    <th scope="row">{{ $key }}</th>
                    <td>
                        @if($value->thumbnail > 0)<img src="{{ dsld_uploaded_asset($value->thumbnail) }}" alt="{{ dsld_upload_file_title($value->thumbnail) }}" class="page_banner_icon">
                        @else
                            <img src="{{ dsld_static_asset('backend/assets/images/xs/avatar1.jpg') }}" alt="Dummy Image" class="page_banner_icon">
                        
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('home') }}/{{ $value->slug }}" target="_blank">{{ $value->title }}</a><br>
                        <small>{{ $value->slug }}</small>
                    </td>
                    <td><small>{{ $value->meta_title }}</small></td>
                    <td><small>U: {{ date('h:i:s d M, Y', strtotime($value->updated_at)) }}<br>C: {{ date('h:i:s d M, Y', strtotime($value->created_at)) }}</small></td>
                    @if(dsld_have_user_permission('posts_edit') == 1)
                    <td>

                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="{{$value->slug }}" onchange="DSLDStatusUpdate('{{ $value->id }}','{{ $value->visibility == 1 ? 0 : 1  }}', '{{ route('posts.status') }}','{{ csrf_token() }}')" @if($value->visibility == 1) checked @endif >
                            <label class="custom-control-label" for="{{$value->slug }}"></label>
                        </div>

                    </td>
                    @endif
                    @if(dsld_have_user_permission('posts_edit') == 1 || dsld_have_user_permission('posts_delete') == 1)
                    <td>
                        <p class="text-center mb-0 action_items">
                            @if(dsld_have_user_permission('posts_edit') == 1)
                            <a href="{{ route('blogs.show_blog', [$value->slug]) }}" target="_blank" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-info">
                                <i class="zmdi zmdi-hc-fw"></i>
                            </a>
                            @endif
                            @if(dsld_have_user_permission('posts_edit') == 1)
                            <a href="{{ route('posts.edit', [$value->id]) }}" target="_blank" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-primary">
                                <i class="zmdi zmdi-edit"></i>
                            </a>
                            @endif
                            @if(dsld_have_user_permission('posts_delete') == 1)
                            <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-danger" onclick="DSLDDeleteAlert('{{ $value->id }}','{{ route('posts.destory') }}','{{ csrf_token() }}')">
                                    <i class="zmdi zmdi-delete"></i>
                            </a>
                            @endif
                        </p>
                    </td>
                    @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="8" class="text-center">Nothing Found</td>
            </tr>
        @endif
    </tbody>
</table>

{{  $data->links('backend.pagination.custom') }}
