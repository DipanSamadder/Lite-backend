
<table class="table table-bordered table-striped table-hover dataTable">
    <thead>
            <tr>
                <th>Sr</th>
                <th>Title</th>
                <th>Template</th>
                <th>Meta Title</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Sr</th>
                <th>Title</th>
                <th>Template</th>
                <th>Meta Title</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </tfoot>
    <tbody>
        @if(is_array($data) || count($data) > 0 )
            @foreach($data as $key => $value)
            @php $key++; @endphp
                <tr>
                    <th scope="row">{{ $key }}</th>
                    <td>{{ $value->title }}</td>
                    <td>{{ $value->template }}</td>
                    <td>{{ $value->meta_title }}</td>
                    <td>{{ $value->status }}</td>
                    <td><p class="text-right"><span class="text-primary"><i class="zmdi zmdi-hc-fw"></i> <span>edit</span></span> <span class="text-danger"><i class="zmdi zmdi-hc-fw"></i> <span>delete</span></span></p></td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6" class="text-center">Nothing Found</td>
            </tr>
        @endif
    </tbody>
</table>