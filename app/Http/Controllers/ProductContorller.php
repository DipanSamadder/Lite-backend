<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\Menu;
use Validator;

class ProductContorller extends Controller
{
    public function index(){
        if(dsld_have_user_permission('program_pages') == 0){
            return redirect()->route('backend.admin')->with('error', 'You have no permission');
        }

        $page['name'] = 'Program page';
        $page['title'] = 'Show all '.$page['name'].'s';
        return view('backend.modules.products.show', compact('page'));
    }

    public function get_ajax_products (Request $request){
        if(dsld_have_user_permission('media') == 0){
            return "You have no permission.";
        }

        if($request->page != 1){$start = $request->page * 25;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;

        $data = Page::where('type','products_page');
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
       
   
        $data = $data->skip($start)->paginate(25);
        return view('backend.modules.products.ajax_files', compact('data'));
    }

   
    public function edit($id){
        if(dsld_have_user_permission('pages_edit') == 0){
            return redirect()->route('backend.admin')->with('error', 'You have no permission');
        }
        $section = PageSection::where('page_id', 56)->orderBy('order', 'asc')->where('status', 1)->get();
        $data = Page::where('id', $id)->first();
        $page['title'] = 'Edit Data';
        return view('backend.modules.products.edit', compact('data', 'page', 'section'));
    }
}
