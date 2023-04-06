
<table class="table table-bordered table-striped table-hover dataTable">
    <thead>
            <tr class="text-center">
                <th>Sr</th>
                <th>Banner</th>
                <th>Title</th>
                <th>Meta Title</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
            <tr class="text-center">
                <th>Sr</th>
                <th>Banner</th>
                <th>Title</th>
                <th>Meta Title</th>
                <th>Date</th>
                <th>Action</th>
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
                    
                    <td>
                        <p class="text-center mb-0 action_items">
                           
                            <a href="{{ route('posts_cat.edit', [$value->id]) }}" target="_blank" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-primary">
                                <i class="zmdi zmdi-edit"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-danger" onclick="DSLDDeleteAlert('{{ $value->id }}','{{ route('posts_cat.destory') }}','{{ csrf_token() }}')">
                                    <i class="zmdi zmdi-delete"></i>
                            </a>
                        </p>
                    </td>
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
