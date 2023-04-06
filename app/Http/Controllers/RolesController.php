<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Validator;

class RolesController extends Controller
{
    public function index(){
        if(dsld_have_user_permission('roles') == 0){
            return redirect()->route('backend.admin')->with('error', 'You have no permission');
        }
        $page['title'] = 'Show all role';
        return view('backend.modules.roles.show', compact('page'));
    }

    public function get_ajax_roles(Request $request){
        if($request->page != 1){$start = $request->page * 25;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;

        $data = Role::where('name','!=','');
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
                default:
                    $data->orderBy('created_at', 'desc');
                    break;
            }
        }
        $data = $data->skip($start)->paginate(25);
        return view('backend.modules.roles.ajax_roles', compact('data'));
    }

    public function store(Request $request){
        if(dsld_have_user_permission('roles_add') == 0){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }

     
        if(Role::where('name', $request->name)->first() == null){
            $role =  new Role;
            $role->name = $request->name;
            
            if($role->save()){
                return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);
            }else{
                return response()->json(['status' => 'error', 'message'=> 'Data insert failed.']);
            }
        }else{
            return response()->json(['status' => 'warning', 'message'=> 'Details already exist! please try agin.']);
        }
    }

    public function edit($id){
        if(dsld_have_user_permission('roles_edit') == 0){
            return redirect()->route('backend.admin')->with('error', 'You have no permission');
        }
        
        $data = Role::where('id', $id)->first();
        $page['title'] = 'Edit Data';
        return view('backend.modules.roles.edit', compact('data', 'page'));
    }
    
    public function update(Request $request){
        if(dsld_have_user_permission('roles_edit') == 0){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
        ]);


        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
     
        if(Role::whereNotIn('id', [$request->id])->where('name', $request->name)->first() == null){
            $role =  Role::findOrFail($request->id);
            $role->name = $request->name;
            $role->permissions = json_encode($request->permissions);
            $role->created_at = $request->date;
            
            if($role->save()){
                return back()->with('success', 'Data update success.');
            }else{
                return back()->with('error', 'Data update failed.');
            }
        }else{
            return back()->with('warning', 'Details already exist! please try agin.');
        }

    }
    
    public function destory(Request $request){
        if(dsld_have_user_permission('roles_delete') == 0){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }
        $user = Role::findOrFail($request->id);
        if($user != ''){
            if($user->delete()){
                return response()->json(['status' => 'success', 'message' => 'Data deleted successully.']);
            }else{
                return response()->json(['status' => 'error', 'message' => 'Data deleted failed.']);
            }
        }else{
            return response()->json(['status' => 'warning', 'message' => 'Data Not found.']);
        }
       
    }

}
