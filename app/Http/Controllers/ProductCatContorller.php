<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Validator;
use Auth;

class ProductCatContorller extends Controller
{

    public function index(){
        if(dsld_have_user_permission('products') == 0){
            return redirect()->route('backend.admin')->with('error', 'You have no permission');
        }
        $page['title'] = 'Product Category List';
        $page['name'] = 'Product Category';
        return view('backend.modules.products.cat.show', compact('page'));
    }


    public function get_ajax_products_cat(Request $request){
        if($request->page != 1){$start = $request->page * 25;}else{$start = 0;}
        $search = $request->search;
        $sort = $request->sort;

        $data = Page::where('title','!=', '')->where('type', 'product_cat');

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
        return view('backend.modules.products.cat.ajax_items', compact('data'));
    }


    public function edit(Request $request){
        if(dsld_have_user_permission('products_edit') == 0){
            return redirect()->route('backend.admin')->with('error', 'You have no permission');
        }

        $data = Page::where('id', $request->id)->where('type', 'product_cat')->first();
        $product_cat = Page::where('status', 1)->where('type', 'product_cat')->whereNotIn('id', [$request->id])->get();
        return view('backend.modules.products.cat.edit', compact('data', 'product_cat'));
    }



}
