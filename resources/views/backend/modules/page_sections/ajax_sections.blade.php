
<table class="table table-bordered table-striped table-hover dataTable">
    <thead>
            <tr class="text-center">
                <th>Sr</th>
                <th>Title</th>
                <th>Page Name</th>
                <th>Date</th>
                
                @if(dsld_have_user_permission('sections_edit') == 1)
                <th>Status</th>
                @endif
                @if(dsld_have_user_permission('sections_edit') == 1 || dsld_have_user_permission('sections_delete') == 1)
                <th>Action</th>
                @endif
            </tr>
        </thead>
        <tfoot>
            <tr class="text-center">
                <th>Sr</th>
                <th>Title</th>
                <th>Page Name</th>
                <th>Date</th>
                
                @if(dsld_have_user_permission('sections_edit') == 1)
                <th>Status</th>
                @endif
                @if(dsld_have_user_permission('sections_edit') == 1 || dsld_have_user_permission('sections_delete') == 1)
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
                        {{ $value->title }}
                    </td>
                    <td>
                       <small><a href="#">{{ $value->page->title }}</a></small>
                    </td>
                    <td><small>U: {{ date('h:i:s d M, Y', strtotime($value->updated_at)) }}<br>C: {{ date('h:i:s d M, Y', strtotime($value->created_at)) }}</small></td>
                    @if(dsld_have_user_permission('sections_edit') == 1)
                    <td>

                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="status_{{$value->id }}" onchange="DSLDStatusUpdate('{{ $value->id }}','{{ $value->status == 1 ? 0 : 1  }}', '{{ route('pages_section.status') }}','{{ csrf_token() }}')" @if($value->status == 1) checked @endif >
                            <label class="custom-control-label" for="status_{{$value->id }}"></label>
                        </div>

                    </td>
                @endif      
                @if(dsld_have_user_permission('sections_edit') == 1 || dsld_have_user_permission('sections_delete') == 1)
                    <td>
                        <p class="text-center mb-0 action_items">
                            @if(dsld_have_user_permission('sections_edit') == 1)
                            <a href="{{ route('pages_section_fields.edit', [$value->id]) }}"  class="btn btn-default waves-effect waves-float btn-sm waves-red bg-primary">
                                <i class="zmdi zmdi-hc-fw"></i>
                            </a>
                            @endif
                            @if(dsld_have_user_permission('sections_edit') == 1)
                            <a href="javascript:void(0)"  onclick="edit_lg_modal_form({{ $value->id }});" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-primary">
                                <i class="zmdi zmdi-edit"></i>
                            </a>
                            @endif
                            @if(dsld_have_user_permission('sections_delete') == 1)
                            <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-danger" onclick="DSLDDeleteAlert('{{ $value->id }}','{{ route('pages_section.destory') }}','{{ csrf_token() }}')">
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
