<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageSection;
use App\Models\PageMeta;
use Validator;

class PageSectionController extends Controller
{
    public function index(){
        if(dsld_have_user_permission('sections') == 0){
            return redirect()->route('backend.admin')->with('error', 'You have no permission');
        }
        
        $page['title'] = 'Show all sections';
        return view('backend.modules.page_sections.show', compact('page'));
    }

    public function get_ajax_page_sections(Request $request){
        if($request->page != 1){$start = $request->page * 15;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;

        $data = PageSection::where('title','!=','');
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
        return view('backend.modules.page_sections.ajax_sections', compact('data'));
    }

    public function store(Request $request){
        if(dsld_have_user_permission('sections_add') == 0){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:50',
            'page_id' => 'required|integer',
            'status' => 'required|integer'
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }

        $section = new PageSection;
        $section->title = $request->title;
        $section->order = $request->order;
        $section->page_id = $request->page_id;
        $section->status = $request->status;
        
        if($section->save()){
            return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);
        }else{
            return response()->json(['status' => 'error', 'message'=> 'Data insert failed.']);
        }
        
    }

    public function edit(Request $request){
        if(dsld_have_user_permission('sections_edit') == 0){
            return redirect()->route('backend.admin')->with('error', 'You have no permission');
        }
        $data = PageSection::where('id', $request->section_id)->first();
        return view('backend.modules.page_sections.edit', compact('data'));
    }

    public function edit_fields($id){
        $page['title'] = 'Update sections elements';
        $data = PageSection::where('id', $id)->first();
        return view('backend.modules.page_sections.edit_section', compact('data', 'page'));
    }
    
    public function update(Request $request){
        if(dsld_have_user_permission('sections_edit') == 0){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:50',
            'page_id' => 'required|integer',
            'status' => 'required|integer'
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }

        $section = PageSection::findOrFail($request->section_id);

        if($section != ''){
            $section->title = $request->title;
            $section->order = $request->order;
            $section->page_id = $request->page_id;
            $section->status = $request->status;
            
            if($section->save()){
                return response()->json(['status' => 'success', 'message'=> 'Data update success.']);
            }else{
                return response()->json(['status' => 'error', 'message'=> 'Data update failed.']);
            }
        }else{
            return response()->json(['status' => 'warning', 'message'=> 'Not Found! please try again.']);
        }

    }

    public function edit_field_update(Request $request){
        if(dsld_have_user_permission('sections_edit') == 0){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }
      
        $sectionMeta = PageSection::findOrFail($request->id);
        $form = array();
        $select_types = ['select', 'multi_select', 'radio'];
        $j = 0;
        for ($i=0; $i < count($request->type); $i++) {
            $item['type'] = $request->type[$i];
            $item['label'] = $request->label[$i];
            if(in_array($request->type[$i], $select_types)){
                $item['options'] = json_encode($request['options_'.$request->option[$j]]);
                $j++;
            }
            array_push($form, $item);
        }

        $sectionMeta->meta_fields = json_encode($form);
        if($sectionMeta->save()){
            return back();
        }
    }

    public function destory(Request $request){
        if(dsld_have_user_permission('sections_delete') == 0){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }
        $section = PageSection::findOrFail($request->id);
        if($section != ''){
            PageMeta::where('section_id', $request->id)->delete();
            if($section->delete()){
                return response()->json(['status' => 'success', 'message' => 'Data deleted successully.']);
            }else{
                return response()->json(['status' => 'error', 'message' => 'Data deleted failed.']);
            }
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }

    public function status(Request $request){
        if(dsld_have_user_permission('sections_edit') == 0){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }
        $section = PageSection::findOrFail($request->id);
        if($section != ''){
            if($section->status != $request->status){
                $section->status = $request->status;
                $section->save();
                return response()->json(['status' => 'success', 'message' => 'Status update successully.']);
            }else{
                return response()->json(['status' => 'error', 'message' => 'Status update failed.']);
            }
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }
}
