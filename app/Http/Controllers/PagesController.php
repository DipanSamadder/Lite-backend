<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\PageMeta;
use App\Models\Menu;
use App\Models\Post;

use Validator;


class PagesController extends Controller
{
    public function index(){
        if(dsld_have_user_permission('pages') == 0){
            return redirect()->route('backend.admin')->with('error', 'You have no permission');
        }

        $page['title'] = 'Show all pages';
        return view('backend.modules.pages.show', compact('page'));
    }
    public function get_ajax_pages(Request $request){
        if(dsld_have_user_permission('media') == 0){
            return "You have no permission.";
        }

        if($request->page != 1){$start = $request->page * 15;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;

        $data = Page::where('type','custom_page');
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
        return view('backend.modules.pages.ajax_pages', compact('data'));
    }
    public function store(Request $request){
        if(dsld_have_user_permission('pages_add') == 0){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }
        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->title));


        $validator = Validator::make($request->all(), [
            'title' => 'required|max:50',
            'status' => 'required|integer'
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }

     
        if(Page::where('slug', strtolower($slug))->first() == null){
            
            $page = new Page;
            $page->title = $request->title;
            $page->meta_title = $request->title;
            $page->meta_description =  $request->title;
            $page->keywords =  $request->title;
            $page->type =  $request->type;
            if(isset($request->template)){
                $page->template =  $request->template;
            }else{
                $page->template = 'default_template';
            }
            $page->is_meta = 0;
            if(isset($request->parent_id)){
                $page->parent_id =  $request->parent_id;
                $page->level =  $this->parent_level($request->parent_id);
            }else{
                $page->parent_id =  0;
                $page->level =  1;
            }
            if(isset($request->short_content)){
                $page->short_content =  $request->short_content;
            }else{
                $page->short_content = 'default_template';
            }

            $page->banner = $request->banner;
            $page->status = $request->status;
            $page->content = $request->content;
            $page->slug = strtolower($slug);
            
            if($page->save()){
                return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);
            }else{
                return response()->json(['status' => 'error', 'message'=> 'Data insert failed.']);
            }
        }else{
            return response()->json(['status' => 'warning', 'message'=> 'Page & slug already exist! please try agin.']);
        }
    }
    public function edit($id){
        if(dsld_have_user_permission('pages_edit') == 0){
            return redirect()->route('backend.admin')->with('error', 'You have no permission');
        }
        $data = Page::where('id', $id)->first();
        $section = PageSection::where('page_id', $id)->orderBy('order', 'asc')->where('status', 1)->get();
        $page['title'] = 'Edit Data';
        return view('backend.modules.pages.edit', compact('data', 'page', 'section'));
    }
    public function parent_level($parent_id){
        if($parent_id > 0){
            return Page::where('id', $parent_id)->first()->level + 1;
        }else{
            return 1;
        } 
    }

    public function show_custom_page($slug){
        $page = Page::where('slug', $slug)->first();
        $header_menu = Menu::where('type', 'header_menu')->where('status', 0)->orderBy('order', 'asc')->get();
        if($page != null){
             if($page->template == 'blogs_template'){
                $posts = Post::where('type', 'posts')->paginate(6);
                return view('frontend.pages.'.$page->template, compact('page', 'header_menu', 'posts'));

            }else if($page->template != null){
                return view('frontend.pages.'.$page->template, compact('page', 'header_menu'));
            } else{
                 return view('frontend.pages.default_template', compact('page', 'header_menu'));
            }
        }
    }
    public function update(Request $request){
        if(dsld_have_user_permission('pages_edit') == 0){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }
        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));


        $validator = Validator::make($request->all(), [
            'title' => 'required|max:50',
            'status' => 'required|integer'
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }

      
        if(is_array($request->setting) && count($request->setting) > 0){
            foreach($request->setting as $key => $value){
                $setting = PageMeta::where('meta_key', $value)->where('page_id', $request->id)->first();
                if($setting != ''){
                    if($request[$value] !='' || $request[$value] !='null'){
                        $setting->meta_value = $request[$value];
                        $setting->save();
                    }
                }else{
                    if($request[$value] !='' || $request[$value] !='null'){
                        $setting = new PageMeta;
                        $setting->meta_key = $value;
                        $setting->meta_value = $request[$value];
                        $setting->page_id = $request->id;
                        $setting->save();
                    }
                } 
            }
        }
        
        if(is_array($request->setting_slider) && count($request->setting_slider) > 0){

            foreach($request->setting_slider as $key => $value){
                if($value !=''){
                    $setting2 = PageMeta::where('meta_key', $value)->where('page_id', $request->id)->first();
                    if($setting2 != ''){
                        if($request[$value] !='' || $request[$value] !='null'){
                            $setting2->meta_value = json_encode($request[$value]);
                            $setting2->save();
                        }                        
                    }else{
                        if($request[$value] !='' || $request[$value] !='null'){
                            $setting2 = new PageMeta;
                            $setting2->meta_key = $value;
                            $setting2->meta_value = json_encode($request[$value]);
                            $setting2->page_id = $request->id;
                            $setting2->save();
                        } 
                    }
                }
            }
        }
        

        if(Page::whereNotIn('id', [$request->id])->where('slug', strtolower($slug))->first() == null){
            $page =  Page::findOrFail($request->id);
            $page->title = $request->title;
            $page->meta_title = $request->meta_title;
            $page->meta_description =  $request->meta_description;
            $page->keywords =  $request->keywords;
            $page->type =  $request->type;
            if(isset($request->template)){
                $page->template =  $request->template;
            }else{
                $page->template = 'default_template';
            }
            $page->type =  $request->type;
            if(isset($request->short_content)){
                $page->short_content =  $request->short_content;
            }else{
                $page->short_content = 'default_template';
            }
            $page->is_meta = 0;
            
            if(isset($request->parent_id)){
                $page->parent_id =  $request->parent_id;
                $page->level =  $this->parent_level($request->parent_id);
            }else{
                $page->parent_id =  0;
                $page->level =  1;
            }

            $page->order = $request->order;
            if(isset($request->cateogries_id)){
                $page->cateogries_id = json_encode($request->cateogries_id);
            }else{
                $page->cateogries_id = json_encode(array());
            }
            if(isset($request->gallery)){
                $page->gallery = json_encode($request->gallery);
            }else{
                $page->gallery = json_encode(array());
            }
            if(isset($request->thumbnail)){
                $page->thumbnail = $request->thumbnail;
            }else{
                $page->thumbnail = 0;
            }
           
            $page->banner = $request->banner;
            $page->status = $request->status;
            $page->created_at = $request->date;
            $page->content = $request->content;
            $page->slug = strtolower($slug);
            
            if($page->save()){
                return response()->json(['status' => 'success', 'message'=> 'Data update success.']);
            }else{
                return response()->json(['status' => 'error', 'message'=> 'Data update failed.']);
            }
        }else{
            return response()->json(['status' => 'warning', 'message'=> 'Page & slug already exist! please try agin.']);
        }

    }
    public function update_extra_content(Request $request){
        if(dsld_have_user_permission('pages_edit') == 0){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }
        // echo '<pre>';
        // print_r($request->all());
         foreach($request->type as $key => $type){
             $meta_data = PageMeta::where('meta_key', $type)->where('page_id', $request->page_id)->first();
             if($meta_data == ''){
                 if(gettype($request[$type]) == 'array'){
                     $new_data = new PageMeta;
                     $new_data->meta_key = $type;
                     $new_data->meta_value = json_encode($request[$type]);
                     $new_data->page_id = $request->page_id;
                     $new_data->section_id = $request->section_id;
                     $new_data->save();
                 }else{
                     $new_data = new PageMeta;
                     $new_data->meta_key = $type;
                     $new_data->meta_value = $request[$type];
                     $new_data->page_id = $request->page_id;
                     $new_data->section_id = $request->section_id;
                     $new_data->save();
                 }
             }else{
                 
                 if(gettype($request[$type]) == 'array'){
                     $meta_data->meta_value =  json_encode($request[$type]);
                     $meta_data->save();
                 }else{
                     $meta_data->meta_value =  $request[$type];
                     $meta_data->save();
                 }
                 
             }
         }
 
         return back();
 
         /**$page =  Page::findOrFail($request->id);
         $page->title = $request->title;
         $page->order = $request->order;
         $page->created_at = $request->date;
         $page->content = $request->content;
         $page->slug = strtolower($slug);**/
 
     }
    public function destory(Request $request){
        if(dsld_have_user_permission('pages_delete') == 0 || dsld_have_user_permission('office_delete') == 0 ||dsld_have_user_permission('timelines_delete') == 0 ){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }
        $page = Page::findOrFail($request->id);
        if($page != ''){
            if($page->delete()){
                return response()->json(['status' => 'success', 'message' => 'Data deleted successully.']);
            }else{
                return response()->json(['status' => 'error', 'message' => 'Data deleted failed.']);
            }
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }
    public function status(Request $request){
        if(dsld_have_user_permission('pages_edit') == 0){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }
        
        $page = Page::findOrFail($request->id);
        if($page != ''){
            if($page->status != $request->status){
                $page->status = $request->status;
                $page->save();
                return response()->json(['status' => 'success', 'message' => 'Status update successully.']);
            }else{
                return response()->json(['status' => 'error', 'message' => 'Status update failed.']);
            }
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }
}
