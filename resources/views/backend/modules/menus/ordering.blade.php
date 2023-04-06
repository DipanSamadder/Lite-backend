@extends('backend.layouts.app')

@section('header')
<link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
<style>
    .bootstrap-tagsinput{    border: 1px solid #cbcbcb !important;width: 100%;}
</style>
@endsection

@section('content')
 <!-- Exportable Table -->
 <form id="update_form" action="{{ route('menus.ordering.update') }}" method="POST" enctype="multipart/form-data" >
    <div class="row clearfix">
        <div class="col-lg-12">
            @csrf 
            <input type="hidden" name="type" id="type" value="{{ $type }}" />
            <div class="card mb-0">
                <div class="header">
                    <h2><strong> <i class="zmdi zmdi-hc-fw"></i> {{ $type }}</strong></h2>
                </div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 form-control-label">
                            <div class="dd nestable-dark-theme">
                                <ol class="dd-list">
                                    @if($data != '')
                                        
                                        @foreach($data as $key => $value)
                                            @if($value->level == 1)
                                                <li class="dd-item" data-id="{{ $value->id }}">
                                                    <div class="dd-handle">{{ $value->name }} ({{ $value->id }})</div>
                                                </li>
                                                @php
                                                    $data2 = App\Models\Menu::where('parent', $value->id)->where('status', 0)->get();
                                                @endphp
                                                @if($data2 != null)
                                                    @foreach($data2 as $key2 => $value2)

                                                        <ol class="dd-list">
                                                            <li class="dd-item" data-id="{{ $value2->id }}">
                                                                <div class="dd-handle">{{ $value2->name }} ({{ $value2->id }})</div>
                                                            </li>
                                                            
                                                            @php
                                                                $data3 = App\Models\Menu::where('parent', $value2->id)->where('status', 0)->get();
                                                            @endphp
                                                            @if($data3 != null)
                                                                @foreach($data3 as $key3 => $value3)

                                                                    <ol class="dd-list">
                                                                        <li class="dd-item" data-id="{{ $value3->id }}">
                                                                            <div class="dd-handle">{{ $value3->name }} ({{ $value3->id }})</div>
                                                                        </li>
                                                                        @php
                                                                            $data4 = App\Models\Menu::where('parent', $value3->id)->where('status', 0)->get();
                                                                        @endphp
                                                                        @if($data4 != null)
                                                                            @foreach($data4 as $key4 => $value4)

                                                                                <ol class="dd-list">
                                                                                    <li class="dd-item" data-id="{{ $value4->id }}">
                                                                                        <div class="dd-handle">{{ $value4->name }} ({{ $value4->id }})</div>
                                                                                    </li>
                                                                                    @php
                                                                                        $data5 = App\Models\Menu::where('parent', $value4->id)->where('status', 0)->get();
                                                                                    @endphp
                                                                                    @if($data5 != null)
                                                                                        @foreach($data5 as $key5 => $value5)

                                                                                            <ol class="dd-list">
                                                                                                <li class="dd-item" data-id="{{ $value5->id }}">
                                                                                                    <div class="dd-handle">{{ $value5->name }} ({{ $value5->id }})</div>
                                                                                                </li>
                                                                                                
                                                                                            </ol>

                                                                                        @endforeach
                                                                                    @endif
                                                                                </ol>

                                                                            @endforeach
                                                                        @endif
                                                                    </ol>

                                                                @endforeach
                                                            @endif
                                                        </ol>

                                                    @endforeach
                                                @endif

                                            @endif
                                        @endforeach
                                    @endif

                                </ol>
                            </div>
                            <div class="mt-4">
                                <input type="hidden" class="menu_ordering_value" id="menu_ordering_value" value="">
                            </div>
                            <div class="swal-button-container">
                        <button type="submit" class="btn btn-success btn-round waves-effect dsld-btn-loader" id="submit_btn" disabled="disabled">Update</button>
                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer')



<script src="{{ dsld_static_asset('backend/assets/plugins/nestable/jquery.nestable.js') }}"></script>
<script>
    
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
                data: {
                    '_token':'{{ csrf_token() }}', 
                    'user_id':'{{ Auth::user()->id }}',
                    'type': $('#type').val(),
                    'menu_ordering_value': $('#menu_ordering_value').val(),
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
        window.location.href = "{{ route('menus.index') }}";
    }

</script>
@endsection