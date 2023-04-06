<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessSetting;
class BusinessSettingsController extends Controller
{
    function backend_setting(){
        if(dsld_have_user_permission('backend-setting') == 0){
            return redirect()->route('backend.admin')->with('error', 'You have no permission');
        }

        $page['title'] = 'Backend Setting';
        return view('backend.modules.settings.backend', compact('page'));
    }
    function frontend_setting(){
        if(dsld_have_user_permission('frontend-setting') == 0){
            return redirect()->route('backend.admin')->with('error', 'You have no permission');
        }

        $page['title'] = 'Frontend Setting';
        return view('backend.modules.settings.frontend', compact('page'));
    }
    function backend_header(){
        $page['title'] = 'Header Setting';
        return view('backend.modules.settings.header', compact('page'));
    }
    function backend_footer(){
        $page['title'] = 'Footer Setting';
        return view('backend.modules.settings.footer', compact('page'));
    }
    
    function edit(Request $request){
        $result['status'] = 'test';
        return response()->json(['name' => 'test', 'status' => 'success']);
    }

    function update(Request $request){
        foreach($request->types as $key => $type){
            if($type == 'dashboard_title'){
                $this->overWriteEnvFile('APP_NAME', $request[$type]);
            }
            $data = BusinessSetting::where('type', $type)->first();
            if($data != ''){
                if(gettype($request[$type]) == 'array'){
                    $data->value = json_encode($request[$type]);
                }else{
                    $data->value = $request[$type];
                }
                $data->save();
            }else{
                $new_data = new BusinessSetting;
                $new_data->type = $type;
                if(gettype($request[$type] == 'array')){
                    $new_data->value = json_encode($request[$type]);
                }else{
                    $new_data->value = $request[$type];
                }
                $new_data->save();
            }
        }

        return response()->json(['status' => 'success', 'content' => 'Thank you for update data.']);
    }


    public function overWriteEnvFile($type, $val)
    {
        if(env('DEMO_MODE') != 'On'){
            $path = base_path('.env');
            if (file_exists($path)) {
                $val = '"'.trim($val).'"';
                if(is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0){
                    file_put_contents($path, str_replace(
                        $type.'="'.env($type).'"', $type.'='.$val, file_get_contents($path)
                    ));
                }
                else{
                    file_put_contents($path, file_get_contents($path)."\r\n".$type.'='.$val);
                }
            }
        }
    }
}
