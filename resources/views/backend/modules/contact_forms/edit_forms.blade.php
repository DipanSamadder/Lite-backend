@extends('backend.layouts.app')

@section('header')
<link rel="stylesheet" href="{{ dsld_static_asset('backend/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
<style>
    .bootstrap-tagsinput{    border: 1px solid #cbcbcb !important;width: 100%;}
    section.content {background: #ffe4e4;}
</style>
@endsection

@section('content')
 <!-- Exportable Table -->
 <form id="update_form" action="{{ route('contact_form_fields.update') }}" method="POST" enctype="multipart/form-data" >
    <div class="row clearfix">
        <div class="col-lg-8">
            @csrf 
            <input type="hidden" name="id" id="id" value="{{ $data->id }}" />
            <div class="card mb-0">
                <div class="header">
                    <h2><strong> <i class="zmdi zmdi-hc-fw"></i> {{ $data->title }}</strong></h2>
                </div>
                <div class="body">
                    <div id="form_elements">
                        @if($data->meta_fields != '')
                        @php
                            $meta_fields = json_decode($data->meta_fields);
                            usort($meta_fields, function($a, $b) { //Sort the array using a user defined function
                                return $a->order > $b->order ? 1 : -1; //Compare the scores
                            }); 
                        @endphp
                        @foreach ($meta_fields as $key => $element)

								@if ($element->type == 'text' || $element->type == 'editor' || $element->type == 'button' || $element->type == 'file' || $element->type == 'text_repeter' || $element->type == 'file_repeter' || $element->type == 'textarea' || $element->type == 'email' || $element->type == 'phone' || $element->type == 'datepicker' || $element->type == 'timepicker' || $element->type == 'country' || $element->type == 'city' || $element->type == 'state')
								
									<div class="row clearfix  mb-2">
									    <input type="hidden" name="type[]" value="{{ $element->type }}">
									    <div class="col-lg-2">
									        <label class="col-from-label">{{ ucfirst(str_replace('_', ' ', $element->type)) }}</label>
									    </div>
									    <div class="col-lg-10">
									        <input class="form-control" type="text" name="label[]" value="{{ $element->label }}" placeholder="Label" onchange="is_edited()">
									    </div>
                                        <div class="col-sm-4 offset-sm-2 mt-2">
                                            <input class="form-control" type="text" name="class_name[]" placeholder="Class_name" onchange="is_edited()" @if(json_decode($element->setting)->class_name != '') value="{{ json_decode($element->setting)->class_name }}" @endif>
                                        </div>
                                        <div class="col-sm-3 mt-2">
                                            <select class="form-control" type="text" name="width[]" onchange="is_edited()">
                                                <option value="25" @if(json_decode($element->setting)->width == '25') selected @endif>Width 25%</option>
                                                <option value="33" @if(json_decode($element->setting)->width == '33') selected @endif>Width 33%</option>
                                                <option value="50" @if(json_decode($element->setting)->width == '50') selected @endif>Width 50%</option>
                                                <option value="75" @if(json_decode($element->setting)->width == '75') selected @endif>Width 75%</option>
                                                <option value="100" @if(json_decode($element->setting)->width == '100') selected @endif>Width 100%</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3 mt-2">
                                            <input type="hidden" name="setting[]" value="label_setting">
                                            <select class="form-control" type="text" name="label_setting[]" onchange="is_edited()">
                                            <option value="show" @if(json_decode($element->setting)->label_setting == 'show') selected @endif>Show</option>
                                            <option value="hide" @if(json_decode($element->setting)->label_setting == 'hide') selected @endif>Hide</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3 offset-sm-2 mt-2">
                                            <input class="form-control" type="text" name="order[]" placeholder="order" onchange="is_edited()" @if(@json_decode($element->order) != '') value="{{ @json_decode($element->order) }}" @endif>
                                        </div>
                                        <div class="col-sm-3 mt-2">
                                            <input type="hidden" name="setting[]" value="is_required">
                                            <select class="form-control" type="text" name="is_required[]" onchange="is_edited()">
                                            <option value="required" @if(@json_decode($element->setting)->is_required == 'required') selected @endif>Required</option>
                                            <option value="no" @if(@json_decode($element->setting)->is_required == 'no') selected @endif>No</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2"><button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button></div>
									</div>
								@elseif ($element->type == 'select' || $element->type == 'multi_select' || $element->type == 'radio' || $element->type == 'checkbox')


									<div class="row clearfix mb-2">
									    <input type="hidden" name="type[]" value="{{ $element->type }}">
									    <input type="hidden" name="option[]" class="option" value="{{ $key }}">
									    <div class="col-lg-2">
									        <label class="col-from-label">{{ ucfirst(str_replace('_', ' ', $element->type)) }}</label>
									    </div>
									    <div class="col-lg-10">
									        <input class="form-control" type="text" name="label[]" value="{{ $element->label }}" placeholder="Select Label" style="margin-bottom:10px" onchange="is_edited()">
									        <div class="customer_choice_options_types_wrap_child">

												@if (is_array(json_decode($element->options)))
													@foreach (json_decode($element->options) as $value)
														<div class="row clearfix mb-2">
														    <div class="col-sm-6 col-sm-offset-4">
														        <input class="form-control" type="text" name="options_{{ $key }}[]" value="{{ $value }}" required="" onchange="is_edited()">
														    </div>
														    <div class="col-sm-2"> <button type="button" class="btn btn-sm btn-info" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button></div>
														</div>
													@endforeach
												@endif

											</div>
									        <button class="btn btn-info pull-right" type="button" onclick="add_customer_choice_options(this)"><i class="glyphicon glyphicon-plus"></i> Add option</button>
									    </div>
                                        <div class="col-sm-4 offset-sm-2 mt-2">
                                            <input class="form-control" type="text" name="class_name[]" placeholder="Class_name" onchange="is_edited()" @if(json_decode($element->setting)->class_name != '') value="{{ json_decode($element->setting)->class_name }}" @endif>
                                        </div>
                                        <div class="col-sm-3 mt-2">
                                            <select class="form-control" type="text" name="width[]" onchange="is_edited()">
                                                <option value="25" @if(json_decode($element->setting)->width == '25') selected @endif>Width 25%</option>
                                                <option value="33" @if(json_decode($element->setting)->width == '33') selected @endif>Width 33%</option>
                                                <option value="50" @if(json_decode($element->setting)->width == '50') selected @endif>Width 50%</option>
                                                <option value="75" @if(json_decode($element->setting)->width == '75') selected @endif>Width 75%</option>
                                                <option value="100" @if(json_decode($element->setting)->width == '100') selected @endif>Width 100%</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3 mt-2">
                                            <input type="hidden" name="setting[]" value="label_setting">
                                            <select class="form-control" type="text" name="label_setting[]" onchange="is_edited()">
                                            <option value="show" @if(json_decode($element->setting)->label_setting == 'show') selected @endif>Show</option>
                                            <option value="hide" @if(json_decode($element->setting)->label_setting == 'hide') selected @endif>Hide</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3 offset-sm-2 mt-2">
                                            <input class="form-control" type="text" name="order[]" placeholder="order" onchange="is_edited()" @if(json_decode($element->order) != '') value="{{ json_decode($element->order) }}" @endif>
                                        </div>
                                        <div class="col-sm-3 mt-2">
                                            <input type="hidden" name="setting[]" value="is_required">
                                            <select class="form-control" type="text" name="is_required[]" onchange="is_edited()">
                                            <option value="required" @if(@json_decode($element->setting)->is_required == 'required') selected @endif>Required</option>
                                            <option value="no" @if(@json_decode($element->setting)->is_required == 'no') selected @endif>No</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2"><button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button></div>
									</div>

								@endif
							@endforeach
                        @endif
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 form-control-label">
                            <div class="swal-button-container">
                                <button type="submit" class="btn btn-success btn-round waves-effect dsld-btn-loader" id="submit_btn" >Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-0">
                <div class="header">
                    <h2><strong>All Fields</strong></h2>                        
                </div>
                <div class="body">
                    <ul class="list-group">
                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('text')">Text Input</li>
                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('textarea')">Textarea</li>
                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('email')">Email</li>
                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('phone')">Phone</li>
                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('checkbox')">Checkbox</li>
                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('datepicker')">Date Picker</li>
                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('timepicker')">Time Picker</li>
                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('country')">Country</li>
                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('city')">City</li>
                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('state')">State</li>
                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('select')">Select</li>
                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('radio')">Radio</li>
                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('file')">File</li>
                        <li class="list-group-item btn" style="text-align: left;" onclick="appendToForm('button')">Button</li>
                    </ul>
                </div>
            </div>
        </div> 
    </div>
</form>
@endsection

@section('footer')

<script src="{{ dsld_static_asset('backend/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>

<script type="text/javascript">
    var i = 0;
    function  appendToForm(type){
        is_edited();
        if(type == 'text'){
            var str = '<div class="row clearfix mb-2">'
                            +'<div class="col-sm-2">'
                                +'<input type="hidden" name="type[]" value="text">'
                                +'<label class="col-from-label">Text</label>'
                            +'</div>'
                            +'<div class="col-sm-10">'
                                +'<input class="form-control" type="text" name="label[]" placeholder="Label" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="class_name[]" placeholder="Class_name" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="width">'
                                +'<select class="form-control" type="text" name="width[]" onchange="is_edited()">'
                                +'<option value="25">Width 25%</option>'
                                +'<option value="33">Width 33%</option>'
                                +'<option value="50">Width 50%</option>'
                                +'<option value="75">Width 75%</option>'
                                +'<option value="100" selected>Width 100%</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="label_setting">'
                                +'<select class="form-control" type="text" name="label_setting[]" onchange="is_edited()">'
                                +'<option value="show">Show</option>'
                                +'<option value="hide">Hide</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="order[]" placeholder="Order" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="is_required">'
                                +'<select class="form-control" type="text" name="is_required[]" onchange="is_edited()">'
                                +'<option value="required">Required</option>'
                                +'<option value="no">No</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-4 mt-2">'
                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'
                            +'</div>'
                        +'</div>';
            $('#form_elements').append(str);
        } else if(type == 'textarea'){
            var str = '<div class="row clearfix mb-2">'
                            +'<div class="col-sm-2">'
                                +'<input type="hidden" name="type[]" value="textarea">'
                                +'<label class="col-from-label">Text Area</label>'
                            +'</div>'
                            +'<div class="col-sm-10">'
                                +'<input class="form-control" type="text" name="label[]" placeholder="Label" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="class_name[]" placeholder="Class_name" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="width">'
                                +'<select class="form-control" type="text" name="width[]" onchange="is_edited()">'
                                +'<option value="25">Width 25%</option>'
                                +'<option value="33">Width 33%</option>'
                                +'<option value="50">Width 50%</option>'
                                +'<option value="75">Width 75%</option>'
                                +'<option value="100" selected>Width 100%</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="label_setting">'
                                +'<select class="form-control" type="text" name="label_setting[]" onchange="is_edited()">'
                                +'<option value="show">Show</option>'
                                +'<option value="hide">Hide</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="order[]" placeholder="Order" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="is_required">'
                                +'<select class="form-control" type="text" name="is_required[]" onchange="is_edited()">'
                                +'<option value="required">Required</option>'
                                +'<option value="no">No</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-2 mt-2">'
                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'
                            +'</div>'
                        +'</div>';
            $('#form_elements').append(str);
        }  else if(type == 'email'){
            var str = '<div class="row clearfix mb-2">'
                            +'<div class="col-sm-2">'
                                +'<input type="hidden" name="type[]" value="email">'
                                +'<label class="col-from-label">Email</label>'
                            +'</div>'
                            +'<div class="col-sm-10">'
                                +'<input class="form-control" type="text" name="label[]" placeholder="Label" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="class_name[]" placeholder="Class_name" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="width">'
                                +'<select class="form-control" type="text" name="width[]" onchange="is_edited()">'
                                +'<option value="25">Width 25%</option>'
                                +'<option value="33">Width 33%</option>'
                                +'<option value="50">Width 50%</option>'
                                +'<option value="75">Width 75%</option>'
                                +'<option value="100" selected>Width 100%</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="label_setting">'
                                +'<select class="form-control" type="text" name="label_setting[]" onchange="is_edited()">'
                                +'<option value="show">Show</option>'
                                +'<option value="hide">Hide</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="order[]" placeholder="Order" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="is_required">'
                                +'<select class="form-control" type="text" name="is_required[]" onchange="is_edited()">'
                                +'<option value="required">Required</option>'
                                +'<option value="no">No</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-2 mt-2">'
                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'
                            +'</div>'
                        +'</div>';
            $('#form_elements').append(str);
        } else if(type == 'phone'){
            var str = '<div class="row clearfix mb-2">'
                            +'<div class="col-sm-2">'
                                +'<input type="hidden" name="type[]" value="phone">'
                                +'<label class="col-from-label">Phone</label>'
                            +'</div>'
                            +'<div class="col-sm-10">'
                                +'<input class="form-control" type="text" name="label[]" placeholder="Label" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="class_name[]" placeholder="Class_name" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="width">'
                                +'<select class="form-control" type="text" name="width[]" onchange="is_edited()">'
                                +'<option value="25">Width 25%</option>'
                                +'<option value="33">Width 33%</option>'
                                +'<option value="50">Width 50%</option>'
                                +'<option value="75">Width 75%</option>'
                                +'<option value="100" selected>Width 100%</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="label_setting">'
                                +'<select class="form-control" type="text" name="label_setting[]" onchange="is_edited()">'
                                +'<option value="show">Show</option>'
                                +'<option value="hide">Hide</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="order[]" placeholder="Order" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="is_required">'
                                +'<select class="form-control" type="text" name="is_required[]" onchange="is_edited()">'
                                +'<option value="required">Required</option>'
                                +'<option value="no">No</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-2 mt-2">'
                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'
                            +'</div>'
                        +'</div>';
            $('#form_elements').append(str);
        }else if(type == 'datepicker'){
            var str = '<div class="row clearfix mb-2">'
                            +'<div class="col-sm-2">'
                                +'<input type="hidden" name="type[]" value="datepicker">'
                                +'<label class="col-from-label">Date Picker</label>'
                            +'</div>'
                            +'<div class="col-sm-10">'
                                +'<input class="form-control" type="text" name="label[]" placeholder="Label" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="class_name[]" placeholder="Class_name" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="width">'
                                +'<select class="form-control" type="text" name="width[]" onchange="is_edited()">'
                                +'<option value="25">Width 25%</option>'
                                +'<option value="33">Width 33%</option>'
                                +'<option value="50">Width 50%</option>'
                                +'<option value="75">Width 75%</option>'
                                +'<option value="100" selected>Width 100%</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="label_setting">'
                                +'<select class="form-control" type="text" name="label_setting[]" onchange="is_edited()">'
                                +'<option value="show">Show</option>'
                                +'<option value="hide">Hide</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="order[]" placeholder="Order" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="is_required">'
                                +'<select class="form-control" type="text" name="is_required[]" onchange="is_edited()">'
                                +'<option value="required">Required</option>'
                                +'<option value="no">No</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-2 mt-2">'
                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'
                            +'</div>'
                        +'</div>';
            $('#form_elements').append(str);
        }else if(type == 'timepicker'){
            var str = '<div class="row clearfix mb-2">'
                            +'<div class="col-sm-2">'
                                +'<input type="hidden" name="type[]" value="timepicker">'
                                +'<label class="col-from-label">Time Picker</label>'
                            +'</div>'
                            +'<div class="col-sm-10">'
                                +'<input class="form-control" type="text" name="label[]" placeholder="Label" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="class_name[]" placeholder="Class_name" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="width">'
                                +'<select class="form-control" type="text" name="width[]" onchange="is_edited()">'
                                +'<option value="25">Width 25%</option>'
                                +'<option value="33">Width 33%</option>'
                                +'<option value="50">Width 50%</option>'
                                +'<option value="75">Width 75%</option>'
                                +'<option value="100" selected>Width 100%</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="label_setting">'
                                +'<select class="form-control" type="text" name="label_setting[]" onchange="is_edited()">'
                                +'<option value="show">Show</option>'
                                +'<option value="hide">Hide</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="order[]" placeholder="Order" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="is_required">'
                                +'<select class="form-control" type="text" name="is_required[]" onchange="is_edited()">'
                                +'<option value="required">Required</option>'
                                +'<option value="no">No</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-2 mt-2">'
                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'
                            +'</div>'
                        +'</div>';
            $('#form_elements').append(str);
        }else if(type == 'country'){
            var str = '<div class="row clearfix mb-2">'
                            +'<div class="col-sm-2">'
                                +'<input type="hidden" name="type[]" value="country">'
                                +'<label class="col-from-label">Country</label>'
                            +'</div>'
                            +'<div class="col-sm-10">'
                                +'<input class="form-control" type="text" name="label[]" placeholder="Label" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="class_name[]" placeholder="Class_name" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="width">'
                                +'<select class="form-control" type="text" name="width[]" onchange="is_edited()">'
                                +'<option value="25">Width 25%</option>'
                                +'<option value="33">Width 33%</option>'
                                +'<option value="50">Width 50%</option>'
                                +'<option value="75">Width 75%</option>'
                                +'<option value="100" selected>Width 100%</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="label_setting">'
                                +'<select class="form-control" type="text" name="label_setting[]" onchange="is_edited()">'
                                +'<option value="show">Show</option>'
                                +'<option value="hide">Hide</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="order[]" placeholder="Order" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="is_required">'
                                +'<select class="form-control" type="text" name="is_required[]" onchange="is_edited()">'
                                +'<option value="required">Required</option>'
                                +'<option value="no">No</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-2 mt-2">'
                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'
                            +'</div>'
                        +'</div>';
            $('#form_elements').append(str);
        }else if(type == 'city'){
            var str = '<div class="row clearfix mb-2">'
                            +'<div class="col-sm-2">'
                                +'<input type="hidden" name="type[]" value="city">'
                                +'<label class="col-from-label">City</label>'
                            +'</div>'
                            +'<div class="col-sm-10">'
                                +'<input class="form-control" type="text" name="label[]" placeholder="Label" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="class_name[]" placeholder="Class_name" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="width">'
                                +'<select class="form-control" type="text" name="width[]" onchange="is_edited()">'
                                +'<option value="25">Width 25%</option>'
                                +'<option value="33">Width 33%</option>'
                                +'<option value="50">Width 50%</option>'
                                +'<option value="75">Width 75%</option>'
                                +'<option value="100" selected>Width 100%</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="label_setting">'
                                +'<select class="form-control" type="text" name="label_setting[]" onchange="is_edited()">'
                                +'<option value="show">Show</option>'
                                +'<option value="hide">Hide</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="order[]" placeholder="Order" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="is_required">'
                                +'<select class="form-control" type="text" name="is_required[]" onchange="is_edited()">'
                                +'<option value="required">Required</option>'
                                +'<option value="no">No</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-2 mt-2">'
                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'
                            +'</div>'
                        +'</div>';
            $('#form_elements').append(str);
        }else if(type == 'state'){
            var str = '<div class="row clearfix mb-2">'
                            +'<div class="col-sm-2">'
                                +'<input type="hidden" name="type[]" value="state">'
                                +'<label class="col-from-label">State</label>'
                            +'</div>'
                            +'<div class="col-sm-10">'
                                +'<input class="form-control" type="text" name="label[]" placeholder="Label" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="class_name[]" placeholder="Class_name" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="width">'
                                +'<select class="form-control" type="text" name="width[]" onchange="is_edited()">'
                                +'<option value="25">Width 25%</option>'
                                +'<option value="33">Width 33%</option>'
                                +'<option value="50">Width 50%</option>'
                                +'<option value="75">Width 75%</option>'
                                +'<option value="100" selected>Width 100%</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="label_setting">'
                                +'<select class="form-control" type="text" name="label_setting[]" onchange="is_edited()">'
                                +'<option value="show">Show</option>'
                                +'<option value="hide">Hide</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="order[]" placeholder="Order" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="is_required">'
                                +'<select class="form-control" type="text" name="is_required[]" onchange="is_edited()">'
                                +'<option value="required">Required</option>'
                                +'<option value="no">No</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-2 mt-2">'
                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'
                            +'</div>'
                        +'</div>';
            $('#form_elements').append(str);
        }
        else if (type == 'select') {
            i++;
            var str = '<div class="row clearfix mb-2">'
                            +'<div class="col-sm-2">'
                                +'<input type="hidden" name="type[]" value="select"><input type="hidden" name="option[]" class="option" value="'+i+'">'
                                +'<label class="col-from-label">Select</label>'
                            +'</div>'
                            +'<div class="col-lg-10">'
                                +'<input class="form-control" type="text" name="label[]" placeholder="Select Label" style="margin-bottom:10px" onchange="is_edited()">'
                                +'<div class="customer_choice_options_types_wrap_child">'

                                +'</div>'
                                +'<button class="btn btn-sm btn-info" type="button" onclick="add_customer_choice_options(this)"><i class="glyphicon glyphicon-plus"></i> Add option</button>'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="class_name[]" placeholder="Class_name" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="width">'
                                +'<select class="form-control" type="text" name="width[]" onchange="is_edited()">'
                                +'<option value="25">Width 25%</option>'
                                +'<option value="33">Width 33%</option>'
                                +'<option value="50">Width 50%</option>'
                                +'<option value="75">Width 75%</option>'
                                +'<option value="100" selected>Width 100%</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="label_setting">'
                                +'<select class="form-control" type="text" name="label_setting[]" onchange="is_edited()">'
                                +'<option value="show">Show</option>'
                                +'<option value="hide">Hide</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="order[]" placeholder="Order" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="is_required">'
                                +'<select class="form-control" type="text" name="is_required[]" onchange="is_edited()">'
                                +'<option value="required">Required</option>'
                                +'<option value="no">No</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-2 mt-2">'
                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'
                            +'</div>'
                        +'</div>';
            $('#form_elements').append(str);
        }
        
        else if (type == 'radio') {
            i++;
            var str = '<div class="row clearfix mb-2">'
                            +'<div class="col-sm-2">'
                                +'<input type="hidden" name="type[]" value="radio"><input type="hidden" name="option[]" class="option" value="'+i+'">'
                                +'<label class="col-from-label">Radio</label>'
                            +'</div>'
                            +'<div class="col-lg-10">'
                                +'<div class="customer_choice_options_types_wrap_child">'
                                +'<input class="form-control" type="text" name="label[]" onchange="is_edited()" placeholder="Radio Label" style="margin-bottom:10px">'

                                +'</div>'
                                +'<button class="btn btn-sm btn-info" type="button" onclick="add_customer_choice_options(this)"><i class="glyphicon glyphicon-plus"></i> Add option</button>'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="class_name[]" placeholder="Class_name" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="width">'
                                +'<select class="form-control" type="text" name="width[]" onchange="is_edited()">'
                                +'<option value="25">Width 25%</option>'
                                +'<option value="33">Width 33%</option>'
                                +'<option value="50">Width 50%</option>'
                                +'<option value="75">Width 75%</option>'
                                +'<option value="100" selected>Width 100%</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="label_setting">'
                                +'<select class="form-control" type="text" name="label_setting[]" onchange="is_edited()">'
                                +'<option value="show">Show</option>'
                                +'<option value="hide">Hide</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="order[]" placeholder="Order" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="is_required">'
                                +'<select class="form-control" type="text" name="is_required[]" onchange="is_edited()">'
                                +'<option value="required">Required</option>'
                                +'<option value="no">No</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-2 mt-2">'
                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'
                            +'</div>'
                        +'</div>';
            $('#form_elements').append(str);
        }
        else if (type == 'checkbox') {
            i++;
            var str = '<div class="row clearfix mb-2">'
                            +'<div class="col-sm-2">'
                                +'<input type="hidden" name="type[]" value="checkbox"><input type="hidden" name="option[]" class="option" value="'+i+'">'
                                +'<label class="col-from-label">Checkbox</label>'
                            +'</div>'
                            +'<div class="col-lg-10">'
                                +'<div class="customer_choice_options_types_wrap_child">'
                                +'<input class="form-control" type="text" name="label[]" onchange="is_edited()" placeholder="Checkbox Label" style="margin-bottom:10px">'

                                +'</div>'
                                +'<button class="btn btn-sm btn-info" type="button" onclick="add_customer_choice_options(this)"><i class="glyphicon glyphicon-plus"></i> Add option</button>'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="class_name[]" placeholder="Class_name" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="width">'
                                +'<select class="form-control" type="text" name="width[]" onchange="is_edited()">'
                                +'<option value="25">Width 25%</option>'
                                +'<option value="33">Width 33%</option>'
                                +'<option value="50">Width 50%</option>'
                                +'<option value="75">Width 75%</option>'
                                +'<option value="100" selected>Width 100%</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="label_setting">'
                                +'<select class="form-control" type="text" name="label_setting[]" onchange="is_edited()">'
                                +'<option value="show">Show</option>'
                                +'<option value="hide">Hide</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="order[]" placeholder="Order" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="is_required">'
                                +'<select class="form-control" type="text" name="is_required[]" onchange="is_edited()">'
                                +'<option value="required">Required</option>'
                                +'<option value="no">No</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-2 mt-2">'
                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'
                            +'</div>'
                        +'</div>';
            $('#form_elements').append(str);
        }
        else if (type == 'file') {
            var str = '<div class="row clearfix mb-2">'
                            +'<div class="col-sm-2">'
                                +'<input type="hidden" name="type[]" value="file">'
                                +'<label class="col-from-label">File</label>'
                            +'</div>'
                            +'<div class="col-lg-10">'
                                +'<input class="form-control" type="text" name="label[]" onchange="is_edited()" placeholder="Label">'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="class_name[]" placeholder="Class_name" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="width">'
                                +'<select class="form-control" type="text" name="width[]" onchange="is_edited()">'
                                +'<option value="25">Width 25%</option>'
                                +'<option value="33">Width 33%</option>'
                                +'<option value="50">Width 50%</option>'
                                +'<option value="75">Width 75%</option>'
                                +'<option value="100" selected>Width 100%</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="label_setting">'
                                +'<select class="form-control" type="text" name="label_setting[]" onchange="is_edited()">'
                                +'<option value="show">Show</option>'
                                +'<option value="hide">Hide</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="order[]" placeholder="Order" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="is_required">'
                                +'<select class="form-control" type="text" name="is_required[]" onchange="is_edited()">'
                                +'<option value="required">Required</option>'
                                +'<option value="no">No</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-2 mt-2">'
                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'
                            +'</div>'
                        +'</div>';
            $('#form_elements').append(str);
        }
        
        else if (type == 'button') {
            var str = '<div class="row clearfix mb-2">'
                            +'<div class="col-sm-2">'
                                +'<input type="hidden" name="type[]" value="button">'
                                +'<label class="col-from-label">Button</label>'
                            +'</div>'
                            +'<div class="col-lg-10">'
                                +'<input class="form-control" type="text" name="label[]" onchange="is_edited()" placeholder="Label">'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="class_name[]" placeholder="Class_name" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="width">'
                                +'<select class="form-control" type="text" name="width[]" onchange="is_edited()">'
                                +'<option value="25">Width 25%</option>'
                                +'<option value="33">Width 33%</option>'
                                +'<option value="50">Width 50%</option>'
                                +'<option value="75">Width 75%</option>'
                                +'<option value="100" selected>Width 100%</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="label_setting">'
                                +'<select class="form-control" type="text" name="label_setting[]" onchange="is_edited()">'
                                +'<option value="show">Show</option>'
                                +'<option value="hide">Hide</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-3  offset-sm-2 mt-2">'
                                +'<input class="form-control" type="text" name="order[]" placeholder="Order" onchange="is_edited()">'
                            +'</div>'
                            +'<div class="col-sm-3 mt-2">'
                                +'<input type="hidden" name="setting[]" value="is_required">'
                                +'<select class="form-control" type="text" name="is_required[]" onchange="is_edited()">'
                                +'<option value="required">Required</option>'
                                +'<option value="no">No</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="col-sm-2 mt-2">'
                                +'<button type="button" class="btn btn-sm btn-danger" data-toggle="remove-parent" data-parent=".row"><i class="zmdi zmdi-hc-fw"></i> </button>'
                            +'</div>'
                        +'</div>';
            $('#form_elements').append(str);
        }
    }

    function add_customer_choice_options(em){
        var j = $(em).closest('.clearfix.row').find('.option').val();
        var str = '<div class="row clearfix mb-2 ">'
                        +'<div class="col-sm-6 col-sm-offset-4">'
                            +'<input class="form-control" type="text" name="options_'+j+'[]" value="" required>'
                        +'</div>'
                        +'<div class="col-sm-2"> <span class="btn btn-sm btn-primary" onchange="is_edited()" onclick="delete_choice_clearfix(this)"><i class="zmdi zmdi-hc-fw"></i></span>'
                        +'</div>'
                    +'</div>'
        $(em).parent().find('.customer_choice_options_types_wrap_child').append(str);
    }
    function delete_choice_clearfix(em){
        $(em).parent().parent().remove();
    }


   
    function is_edited(){
        $('#submit_btn').removeAttr('disabled');
    }
    function get_pages(){
        window.location.href = "{{ route('pages_section.index') }}";
    }


</script>
@endsection