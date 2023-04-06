<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use Validator;


class TimelineController extends Controller
{
    public function index(){
        if(dsld_have_user_permission('timelines') == 0){
            return redirect()->route('backend.admin')->with('error', 'You have no permission');
        }

        $page['title'] = 'Show all Timeline';
        return view('backend.modules.timelines.show', compact('page'));
    }

    public function get_ajax_history_of_timeline(Request $request){
        if($request->page != 1){$start = $request->page * 15;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;

        $data = Page::where('title','!=','')->where('type', 'history_timeline');
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
        return view('backend.modules.timelines.ajax_timelines', compact('data'));
    }
    
    public function store(Request $request){
        if(dsld_have_user_permission('timelines_add') == 0){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:50',
            'month' => 'required',
            'content' => 'required|max:200',
            'order' => 'required|integer',
            'status' => 'required|integer'
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }

        $data = array(
            'month' => $request->month, 
            'cat' => $request->cat
        );

        $page = new Page;
        $page->title = $request->title;
        $page->type = 'history_timeline';
        $page->order = $request->order;
        $page->content = $request->content;
        $page->banner = $request->banner;
        $page->slug = '-';
        $page->meta_fields = json_encode($data);
        $page->status = $request->status;


        if($page->save()){
            return response()->json(['status' => 'success', 'message'=> 'Data insert success.']);
        }else{
            return response()->json(['status' => 'error', 'message'=> 'Data insert failed.']);
        }
        
    }

    public function edit(Request $request){
        if(dsld_have_user_permission('timelines_edit') == 0){
            return redirect()->route('backend.admin')->with('error', 'You have no permission');
        }
        $data = Page::where('id', $request->page_id)->first();
        return view('backend.modules.timelines.edit', compact('data'));
    }


    public function update(Request $request){
        if(dsld_have_user_permission('timelines_edit') == 0){
            return response()->json(['status' => 'error', 'message'=> "You have no permission."]);
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:50',
            'month' => 'required',
            'content' => 'required|max:200',
            'order' => 'required|integer',
            'status' => 'required|integer'
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }

        $page = Page::findOrFail($request->page_id);

        if($page != ''){

            $data = array(
                'month' => $request->month, 
                'cat' => $request->cat, 
            );

            $page->title = $request->title;
            $page->order = $request->order;
            $page->content = $request->content;
            $page->banner = $request->banner;
            $page->meta_fields = json_encode($data);
            $page->status = $request->status;
            
            if($page->save()){
                return response()->json(['status' => 'success', 'message'=> 'Data update success.']);
            }else{
                return response()->json(['status' => 'error', 'message'=> 'Data update failed.']);
            }

        }else{

            return response()->json(['status' => 'warning', 'message'=> 'Not Found! please try again.']);

        }

    }
}
