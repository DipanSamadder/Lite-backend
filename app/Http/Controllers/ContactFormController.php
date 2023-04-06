<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportCfLeads;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\PageMeta;
use App\Models\ContactForm;
use Validator;

class ContactFormController extends Controller
{
    public function index(){
        if(dsld_have_user_permission('contact-forms') == 0){
            return redirect()->route('backend.admin')->with('error', 'You have no permission');
        }

        $page['title'] = 'Show all Contact Forms';
        return view('backend.modules.contact_forms.show', compact('page'));
    }

    public function get_ajax_contact_forms(Request $request){
        if($request->page != 1){$start = $request->page * 15;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;

        $data = Page::where('title', '!=', '')->where('type', 'contact_form');
        if($search != ''){
            $data->where('title', 'like', '%'.$search.'%');
        }

        if($sort != ''){
            switch ($request->sort) {
                case 'newest':
                    $data->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $data->orderBy('created_at', 'asc');
                    break;
                case 'active':
                    $data->where('status', 1);
                    break;
                case 'deactive':
                    $data->where('status', 0);
                    break;
                default:
                    $data->orderBy('created_at', 'desc');
                    break;
            }
        }
        $data = $data->skip($start)->paginate(15);
        return view('backend.modules.contact_forms.ajax_forms', compact('data'));
    }

    public function get_ajax_contact_forms_leads(Request $request){
        if($request->page != 1){$start = $request->page * 15;}else{$start = 0;}
        $forms_ids = $request->forms_ids;
        $search = $request->search;
        $sort = $request->sort;

  
        $data = ContactForm::where('meta_key', 'details');
  
        if($search != ''){
            $data->where('meta_value', 'like', '%'.$search.'%');
        }
        if($forms_ids != 'all'){
            $data->where('form_id', $forms_ids);
        }

        if($sort != ''){
            switch ($request->sort) {
                case 'newest':
                    $data->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $data->orderBy('created_at', 'asc');
                    break;
                default:
                    $data->orderBy('created_at', 'desc');
                    break;
            }
        }
        $data = $data->skip($start)->paginate(15);
        return view('backend.modules.contact_forms.ajax_leads', compact('data'));
    }


    public function exportCfLeads($id){

        $data = Page::where('id', $id)->first();
        $form_id =  $data->id;
        $file_name =  $data->title.'.xlsx';
        if($data != ''){
            return Excel::download(new ExportCfLeads($form_id), $file_name);
        }
        
    }

    public function store(Request $request){
        if(dsld_have_user_permission('contact-forms_add') == 0){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:50',
            'status' => 'required|integer'
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }

        $page = new Page;
        $page->title = $request->title;
        $page->type = 'contact_form';
        $page->order = $request->order;
        $page->content = $request->content;
        $page->slug = '-';
        $page->status = $request->status;

        if($page->save()){
            return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);
        }else{
            return response()->json(['status' => 'error', 'message'=> 'Data insert failed.']);
        }

    }

    public function contact_form_leads(){
        if(dsld_have_user_permission('contact-form-leads') == 0){
            return redirect()->route('backend.admin')->with('error', 'You have no permission');
        }
        $page['title'] = 'Show all Leads';
        $page['name'] = 'Lead';
        return view('backend.modules.contact_forms.leads', compact('page'));
    }

    public function ajax_submit_data(Request $request){

        $data = array();
        $i = 0;
        $if_valid = array();
        $email_user = '';

        foreach (dsld_form_field_by_form_id($request->form_id) as $key => $element){
            $is_required = json_decode($element->setting)->is_required;
            $label = dsld_generate_slug_by_text($element->label);
            $is_empty = 0 ;

            if($element->type !='button'){
                $meta_value = $request->form_label[$key];
                if($meta_value != ''){

                    if($element->type =='text' || $element->type =='textarea' || $element->type =='checkbox' || $element->type =='radio' || $element->type =='datepicker' || $element->type =='timepicker' || $element->type =='file'){
                        $is_empty = 1;
                    }elseif($element->type =='email'){
                        if(dsld_is_valid_email($meta_value) == 1){
                            $is_empty = 1;
                            $email_user = $meta_value;
                        }else{
                            return response()->json(['status' => 'error', 'message' => 'Enter your valid email.']);
                        }

                    }elseif($element->type =='phone'){
                        if(dsld_is_valid_phone($meta_value) == 1){
                            $is_empty = 1;
                        }else{
                            return response()->json(['status' => 'error', 'message' => 'Enter your valid phone number.']);
                        }
                    }      

                }
            }

            if($is_required == 'required' && $is_empty == 0){
                $if_valid[$label] = 'required';
                break;
            }
        }

        $validator = Validator::make($request->all(), $if_valid);



        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }


        $form_data = ContactForm::orderBy('id', 'desc')->first();

        $push = array();
        foreach($request->form_type as $key => $type){
            array_push($push, array($type => $request->form_label[$key]));
        }
        array_push($push, array('created' => date('d-m-Y h:i:s A')));

        $form = new ContactForm;
        $form->meta_key = 'details';
        $form->meta_value = json_encode($push);
        $form->form_id =$request->form_id;
        $form->unit_id = (empty($form_data->unit_id)) ? 1 : $form_data->unit_id + 1;

        if($form->save()){

            dsld_mail_send_for_cf($request->form_id, $email_user, json_encode($push));

            return response()->json(['status' => 'success', 'message' => dsld_form_meta_value_get_by_form_id('success_msg', $request->form_id) ]);
        }else{
            return response()->json(['status' => 'error', 'message' => 'Data is not inserted']);
        }

    }
    public function edit(Request $request){
        if(dsld_have_user_permission('contact-forms_edit') == 0){
            return redirect()->route('backend.admin')->with('error', 'You have no permission');
        }
        $data = Page::where('id', $request->page_id)->first();
        $mdetails = PageMeta::where('page_id', $request->page_id)->get();
        return view('backend.modules.contact_forms.edit', compact('data', 'mdetails'));
    }

    public function edit_fields($id){
        if(dsld_have_user_permission('contact-forms_edit') == 0){
            return redirect()->route('backend.admin')->with('error', 'You have no permission');
        }
        $page['title'] = 'Update fields elements';
        $data = Page::where('id', $id)->first();
        return view('backend.modules.contact_forms.edit_forms', compact('data', 'page'));
    }

    public function update(Request $request){
        if(dsld_have_user_permission('contact-forms_edit') == 0){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:50',
            'send_mail' => 'required|email',
            'success_msg' => 'required',
            'admin_template' => 'required',
            'user_template' => 'required',
            'section_name' => 'required',
            'status' => 'required|integer'
        ]);



        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }

        $Page = Page::findOrFail($request->page_id);


        if($Page != ''){
            $Page->title = $request->title;
            $Page->order = $request->order;
            $Page->status = $request->status;
            $Page->save();

            $sectionMeta = PageSection::where('page_id', $Page->id)->where('title', $request->section_name)->first(); 

            if($sectionMeta == ''){
                $sectionMeta = new PageSection;
                $sectionMeta->title = $request->section_name;
                $sectionMeta->page_id = $Page->id;
                $sectionMeta->order = $request->order;
                $sectionMeta->status = $request->status;
                $sectionMeta->save();
            }
            foreach($request->types as $key => $type){
                $PageMeta = PageMeta::where('page_id', $Page->id)->where('meta_key', $type)->first();

                if($PageMeta !=''){
                    $PageMeta->page_id = $Page->id;
                    $PageMeta->section_id = $sectionMeta->id;
                    $PageMeta->meta_value = $request[$type];
                    $PageMeta->save();
                }else{
                    $PageMeta  = new PageMeta;
                    $PageMeta->meta_key = $type;
                    $PageMeta->page_id = $Page->id;
                    $PageMeta->section_id = $sectionMeta->id;
                    $PageMeta->meta_value = $request[$type];
                    $PageMeta->save();
                }
            }
            return response()->json(['status' => 'success', 'message'=> 'Data update success.']);

        }else{
            return response()->json(['status' => 'warning', 'message'=> 'Not Found! please try again.']);
        }

    }

    public function edit_field_update(Request $request){
        if(dsld_have_user_permission('contact-forms_edit') == 0){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }

        $page = Page::findOrFail($request->id);
        $form = array();
        $select_types = ['select', 'multi_select', 'radio', 'checkbox'];
        $j = 0;
        for ($i=0; $i < count($request->type); $i++) {
            $item['type'] = $request->type[$i];
            $item['label'] = $request->label[$i];
            $item['order'] = $request->order[$i];

            if(in_array($request->type[$i], $select_types)){
                $item['options'] = json_encode($request['options_'.$request->option[$j]]);
                $j++;
            }

            $set = array(
                'class_name' => $request->class_name[$i],
                'width' => $request->width[$i],
                'label_setting' => $request->label_setting[$i],
                'is_required' => $request->is_required[$i],
            );

            $item['setting'] =json_encode($set);

            array_push($form, $item);
        }

        $page->meta_fields = json_encode($form);
        if($page->save()){
            return back();
        }
    }

    public function destory(Request $request){
        if(dsld_have_user_permission('contact-forms_delete') == 0){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }
        $Page = Page::findOrFail($request->id);
        if($Page != ''){
            if($Page->delete()){
                return response()->json(['status' => 'success', 'message' => 'Data deleted successully.']);
            }else{
                return response()->json(['status' => 'error', 'message' => 'Data deleted failed.']);
            }
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }

    }
    public function leads_destory(Request $request){
        if(dsld_have_user_permission('contact-form-leads_delete') == 0){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }
        $ContactForm = ContactForm::findOrFail($request->id);
        if($ContactForm != ''){
            if($ContactForm->delete()){
                return response()->json(['status' => 'success', 'message' => 'Data deleted successully.']);
            }else{
                return response()->json(['status' => 'error', 'message' => 'Data deleted failed.']);
            }
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }

    }

    public function status(Request $request){
        if(dsld_have_user_permission('contact-forms_edit') == 0){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }
        
        $Page = Page::findOrFail($request->id);
        if($Page != ''){
            if($Page->status != $request->status){
                $Page->status = $request->status;
                $Page->save();
                return response()->json(['status' => 'success', 'message' => 'Status update successully.']);
            }else{
                return response()->json(['status' => 'error', 'message' => 'Status update failed.']);
            }
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }

    }
}