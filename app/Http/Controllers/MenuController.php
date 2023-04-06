<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Validator;
class MenuController extends Controller
{
    public function index(){
        if(dsld_have_user_permission('menus') == 0){
            return redirect()->route('backend.admin')->with('error', 'You have no permission');
        }

        $page['title'] = 'Show all menus';
        return view('backend.modules.menus.show', compact('page'));
    }
    public function get_ajax_menus(Request $request){
        if($request->page != 1){$start = $request->page * 15;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;

        $data = Menu::where('name','!=','');
        if($search != ''){
            $data->where('name', 'like', '%'.$search.'%');
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
                    $data->where('status', 0);
                    break;
                case 'deactive':
                    $data->where('status', 1);
                    break;
                default:
                    $data->orderBy('created_at', 'desc');
                    break;
            }
        }
        $data = $data->skip($start)->paginate(15);
        return view('backend.modules.menus.ajax_menus', compact('data'));
    }
    public function store(Request $request){
        if(dsld_have_user_permission('menus_add') == 0){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }

     
        if(Menu::where('name', $request->name)->first() == null){
            $menu =  new Menu;
            $menu->name = $request->name;
            $menu->url = $request->url;
            $menu->parent = $request->parent;
            $menu->user_id = $request->user_id;
            $menu->setting = json_encode(array('target' => "0", 'class' => ""));
            
            if($menu->save()){
                return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);
            }else{
                return response()->json(['status' => 'error', 'message'=> 'Data insert failed.']);
            }
        }else{
            return response()->json(['status' => 'warning', 'message'=> 'Details already exist! please try agin.']);
        }
    }
    public function edit($id){
        if(dsld_have_user_permission('menus_edit') == 0){
            return redirect()->route('backend.admin')->with('error', 'You have no permission');
        }
        $data = Menu::where('id', $id)->first();
        $page['title'] = 'Edit Data';
        return view('backend.modules.menus.edit', compact('data', 'page'));
    }
    public function menus_ordering($type){
        if(dsld_have_user_permission('menus_edit') == 0){
            return redirect()->route('backend.admin')->with('error', 'You have no permission');
        }
        $data = Menu::where('type', $type)->where('status', 0)->orderBy('order', 'desc')->get();
        $page['title'] = 'Edit Type';
        return view('backend.modules.menus.ordering', compact('data', 'page', 'type'));
    }
    public function menus_ordering_update(Request $request){
        if(dsld_have_user_permission('menus_edit') == 0){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }
        
        $get_menu = array();
        foreach(json_decode($request->menu_ordering_value, true) as $key => $level1){

            $level1_data = array('id'=> $level1['id'], 'level'=> 1, 'parent' => 0, 'order' => ($key+1)*10);
            array_push($get_menu, $level1_data);

            if(isset($level1['children']) && is_array($level1['children'])){

                foreach($level1['children'] as $key2 => $level2){

                    $level2_data = array('id'=> $level2['id'], 'level'=> 2, 'parent' => $level1['id'], 'order' => ($key2+1)*10);
                    array_push($get_menu, $level2_data);
                 
                    if(isset($level2['children']) && is_array($level2['children'])){

                        foreach($level2['children'] as $key3 => $level3){
                          
                            $level3_data = array('id'=> $level3['id'], 'level'=> 3, 'parent' => $level2['id'], 'order' => ($key3+1)*10);
                            array_push($get_menu, $level3_data);

                            if(isset($level3['children']) && is_array($level3['children'])){
                                
                                foreach($level3['children'] as $key4 => $level4){

                                    $level4_data = array('id'=> $level4['id'], 'level'=> 4, 'parent' => $level3['id'], 'order' => ($key4+1)*10);
                                    array_push($get_menu, $level4_data);

                                    if(isset($level4['children']) && is_array($level4['children'])){
                                        foreach($level4['children'] as $key5 => $level5){

                                            $level5_data = array('id'=> $level5['id'], 'level'=> 5, 'parent' => $level4['id'], 'order' => ($key5+1)*10);
                                            array_push($get_menu, $level5_data);

                                        }
                                    }

                                }
                            }

                        }

                       
                    }
                    
                }

            }
           
        }
        foreach($get_menu as $key => $value){
            $menu =  Menu::where('type', $request->type)->where('id', $value['id'])->first();
            $menu->level = $value['level'];
            $menu->parent = $value['parent'];
            $menu->order = $value['order'];
            $menu->save();
        }
        return response()->json(['status' => 'success', 'message' => 'Data update success.']);

    }
    public function update(Request $request){
        if(dsld_have_user_permission('menus_edit') == 0){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'url' => 'required|string|max:50',
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
     
        if(Menu::whereNotIn('id', [$request->id])->where('name', $request->name)->first() == null){
            $menu =  Menu::findOrFail($request->id);
            $menu->name = $request->name;
            $menu->url = $request->url;
            $menu->parent = $request->parent;
            $menu->level = $this->menu_parent_level($request->parent);
            $menu->type = $request->type;
            $menu->order = $request->order;
            $menu->setting = json_encode(array('target' => $request->target, 'class' => $request->class_name));
            $menu->status = $request->status;
            $menu->created_at = $request->date;
            
            if($menu->save()){
                return response()->json(['status' => 'success', 'message' => 'Data update success.']);
            }else{
                return response()->json(['status' => 'error', 'message' => 'Data update failed.']);
            }
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Details already exist! please try agin.']);
        }

    }

    public function menu_parent_level($parent_id){
        if($parent_id > 0){
            return Menu::where('id', $parent_id)->first()->level + 1;
        }else{
            return 1;
        } 
    }
    public function destory(Request $request){
        if(dsld_have_user_permission('menus_delete') == 0){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }
        $menu = Menu::findOrFail($request->id);
        if($menu != ''){
            if($menu->delete()){
                return response()->json(['status' => 'success', 'message' => 'Data deleted successully.']);
            }else{
                return response()->json(['status' => 'error', 'message' => 'Data deleted failed.']);
            }
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }

    public function status(Request $request){
        if(dsld_have_user_permission('menus_edit') == 0){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }
        
        $menu = Menu::findOrFail($request->id);
        if($menu != ''){
            if($menu->status != $request->status){
                $menu->status = $request->status;
                $menu->save();
                return response()->json(['status' => 'success', 'message' => 'Status update successully.']);
            }else{
                return response()->json(['status' => 'error', 'message' => 'Status update failed.']);
            }
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }
}
