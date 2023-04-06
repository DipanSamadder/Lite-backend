<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Models\Menu;
use App\Models\Page;
use App\Models\User;
use Auth;

class HomeController extends Controller
{
    function admin_dashboard(){
        $page['title'] = 'Dashboard';
        return view('backend.index', compact('page'));
        
    }
    function clear_cache(){
        Artisan::call('cache:clear');
        Artisan::call('config:cache');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        return response()->json(['status' => 'success', 'message' => 'Cache cleared successfully.']);
    }
    function index(){
        $header_menu = Menu::where('type', 'header_menu')->where('status', 0)->orderBy('order', 'asc')->get();
        $page = Page::where('id', 3)->first();
        return view('frontend.index', compact('page', 'header_menu'));
    }

}
