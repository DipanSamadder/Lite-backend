
<table class="table table-bordered table-striped table-hover dataTable">
    <thead>
            <tr class="text-center">
                <th>Sr</th>
                <th>Name</th>
                <th>Date</th>
                @if(dsld_have_user_permission('roles_edit') == 1 || dsld_have_user_permission('roles_delete') == 1 )
                <th>Action</th>
                @endif
            </tr>
        </thead>
        <tfoot>
            <tr class="text-center">
                <th>Sr</th>
                <th>Name</th>
                <th>Date</th>
                @if(dsld_have_user_permission('roles_edit') == 1 || dsld_have_user_permission('roles_delete') == 1 )
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
                        <a href="{{ route('roles.edit', [$value->id]) }}" target="_blank">{{ $value->name }}</a><br>
                    </td>
                    <td><small>U: {{ date('h:i:s d M, Y', strtotime($value->updated_at)) }}<br>C: {{ date('h:i:s d M, Y', strtotime($value->created_at)) }}</small></td>
                    
                    @if(dsld_have_user_permission('roles_edit') == 1 || dsld_have_user_permission('roles_delete') == 1 )
                    <td>
                        <p class="text-center mb-0 action_items">
                            @if(dsld_have_user_permission('roles_edit') == 1)
                            <a href="{{ route('roles.edit', [$value->id]) }}" target="_blank" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-primary">
                                <i class="zmdi zmdi-edit"></i>
                            </a>
                            @endif

                            @if(dsld_have_user_permission('roles_delete') == 1)
                            <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-danger" onclick="DSLDDeleteAlert('{{ $value->id }}','{{ route('roles.destory') }}','{{ csrf_token() }}')">
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
