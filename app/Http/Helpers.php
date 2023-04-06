<?php
use  App\Models\Translation;
use  App\Models\BusinessSetting;
use  App\Models\Upload;
use  App\Models\PostCategory;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\Page;
use App\Models\PageMeta;
use App\Models\PageSection;
use  App\Http\Controllers\MailController;


//Get Post Parent Category Nmae
if(!function_exists('dsld_have_user_permission')){
    function dsld_have_user_permission($key){
        if(Auth::user()->user_type != 'admin'){
            $data = RolePermission::where('keys', $key)->where('status', 1)->first();
            if( $data != ''){

                if(in_array($data->id, json_decode(@Auth::user()->roles->permissions, true))){
                    return 1;
                }else{
                    return 0;
                }
               
            }else{
                return 0;
            }
        }else{
            return 1;
        }
 
    }
}


//Get Post Parent Category Nmae
if(!function_exists('dsld_post_parent_name_by_id')){
    function dsld_post_parent_name_by_id($id){
        $data = PostCategory::where('id', $id)->first();

        if( $data != ''){
            return $data->title;
        }else{
            return 'Null';
        }
        
    }
}

//Get Post Parent Category Nmae
if(!function_exists('dsld_generate_slug_by_text')){
    function dsld_generate_slug_by_text($text){
        return str_replace(' ', '_', $text);

    }
}

if(!function_exists('dsld_is_valid_email')){
    function dsld_is_valid_email($email){ 
        return (!preg_match(
            "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email))
                    ? 0 : 1;   
    } 
}

if(!function_exists('dsld_is_valid_phone')){
    function dsld_is_valid_phone($phone){ 
        return (!preg_match('/^[0-9]{10}+$/', $phone))
                    ? 0 : 1;   
    } 
}


//Get Post Parent Category Nmae
if(!function_exists('dsld_form_field_by_form_id')){
    function dsld_form_field_by_form_id($id = ''){
        $data = Page::where('id', $id)->where('type', 'contact_form')->first();
        if( $data != ''){
            $meta_fields = json_decode($data->meta_fields);     

            usort($meta_fields, function($a, $b) { //Sort the array using a user defined function
                return $a->order > $b->order ? 1 : -1; //Compare the scores
            }); 
            return $meta_fields;
        }else{
            return array();
        }

    }
}

//Get Post Parent Category Nmae
if(!function_exists('dsld_form_meta_value_get_by_form_id')){
    function dsld_form_meta_value_get_by_form_id($meta_key = '', $form_id){
        $data = PageMeta::where('meta_key', $meta_key)->where('page_id', $form_id)->first();
        if( $data != ''){
                return $data->meta_value;
        }else{
            return '';
        }

    }
}


//Get Post Parent Category Nmae
if(!function_exists('dsld_mail_send_for_cf')){
    function dsld_mail_send_for_cf($form_id, $email_user, $push){

        $to = dsld_form_meta_value_get_by_form_id('send_mail', $form_id);
            
        $subject = dsld_form_meta_value_get_by_form_id('user_mail_subject', $form_id);
        $user_template = dsld_form_meta_value_get_by_form_id('user_template', $form_id);
        $admin_template = dsld_form_meta_value_get_by_form_id('admin_template', $form_id);
        $from = dsld_form_meta_value_get_by_form_id('from_mail_id', $form_id);
        $success_msg = dsld_form_meta_value_get_by_form_id('success_msg', $form_id);
        $mail_body = dsld_form_meta_value_get_by_form_id('mail_body', $form_id);

        if($from != 0 || $from != ""){
            $from = env('MAIL_FROM_ADDRESS');
        }
        
        if($user_template != '' && !empty($email_user)){
            $content['title'] = $success_msg;
            $content['body'] = $mail_body;
            $cdata = new MailController;
            $cdata->cf_submite_mail($email_user, $from, $subject, $content, $user_template);
        }

        if($admin_template != ''){
            $cdata = new MailController;
            $content['title'] = $success_msg." | Admin Mail";
            $content['body'] = $push;
            $cdata->cf_submite_mail($to, $from, $subject, $content, $admin_template);
        }

    }
}


//Get Post Parent Category Nmae
if(!function_exists('dsld_page_meta_value_by_meta_key')){
    function dsld_page_meta_value_by_meta_key($meta_key = '', $page_id){
        $data = PageMeta::where('meta_key', $meta_key)->where('page_id', $page_id)->first();

        if( $data != ''){
            return $data->meta_value;
        }else{
            return '';
        }
        
    }
}



if(!function_exists('dsld_is_route_active')){
    function dsld_is_route_active(Array $routes, $output = 'active'){
        foreach($routes as $route){
            if(Route::currentRouteName() == $route) return $output;
        }
    }
}

if(!function_exists('include_form_by_id')){
    function include_form_by_id($form_id){

        if(dsld_page_meta_value_by_meta_key('layout', $form_id) !=''){
            
            echo view('frontend.forms.'.dsld_page_meta_value_by_meta_key('layout', $form_id), compact('form_id'));
        }else{
            echo '';
        } 
    }
}


//return file uploaded via uploader
if (!function_exists('dsld_uploaded_asset')) {
    function dsld_uploaded_asset($id)
    {
        if (($asset = Upload::find($id)) != null) {
            return my_asset($asset->file_path);
        }
        return null;
    }
}
//return file uploaded via uploader
if (!function_exists('dsld_upload_file_title')) {
    function dsld_upload_file_title($id)
    {
        if (($asset = Upload::find($id)) != null) {
            return $asset->file_title;
        }
        return null;
    }
}

if (! function_exists('my_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function my_asset($path, $secure = null)
    {
        if(env('FILESYSTEM_DRIVER') == 's3'){
            return Storage::disk('s3')->url($path);
        }
        else {
            return app('url')->asset($path, $secure);
        }
    }
}

if(!function_exists('dsld_get_setting')){
    function dsld_get_setting($key, $default = null){
        $data = BusinessSetting::where('type', $key)->first();
        return $data == null ? $default : $data->value; 
    }
}

if(!function_exists('dsld_translation')){
    function dsld_translation($key, $lang = null){
        if($lang == null){
            $lang = App::getLocale();
        }
        $check_data = Translation::where('lang', env("DEFAULT_LANGUAGE", "en"))->where('lang_key', $key)->first();
        if($check_data == null){
            $data = new Translation;
            $data->lang = env("DEFAULT_LANGUAGE", "en");
            $data->lang_key = $key;
            $data->lang_value = $key;
            $data->save();
        }

        $get_value = Translation::where('lang_key', $key)->where('lang', $lang)->first();
        if($get_value != null){
            return $get_value->lang_value;
        }else{
            return $check_data->lang_value;
        }
    }
}

if(! function_exists('dsld_default_language')){
    function dsld_default_language(){
        return env("DEFAULT_LANGUAGE");
    }
}


if(!function_exists('dsld_static_asset')){
        /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @return string
     */
    function dsld_static_asset($path = null){
        return app('url')->asset($path, '');
    }
}


?>