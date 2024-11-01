<?php

//get the urls of the front end business directory pages
function wpbdf_get_urls($idsonly){
    global $wpdb;
    global $wpbdf_settings;
    $urls = [];
    $var = $wpdb->get_var("SELECT _page_ids FROM {$wpbdf_settings} limit 0,1");
    $url_ids = explode(":",$var);
     foreach($url_ids as $u){
        if($idsonly){
            $urls[] = $u;
        }else{
            $urls[] = get_permalink($u);
        }
    }
    return $urls;
}

//get timezone
function wpbdf_getTimezone(){

    global $wpdb;
    global $wpbdf_settings;

    return stripslashes(sanitize_text_field($wpdb->get_var("SELECT _timezone FROM {$wpbdf_settings}")));
}


//Get terms and dconditions
function wpbdf_GetTerms(){
    global $wpdb;
    global $wpbdf_settings;
    $_tcs = $wpdb->get_var("SELECT _tcs FROM {$wpbdf_settings}");
    return stripslashes(sanitize_textarea_field($_tcs));       
}

//get admin email
function wpbdf_getAdminEmail(){
    global $wpdb;
    global $wpbdf_settings;
    
    $email = "";
    $email = $wpdb->get_var($wpdb->prepare("SELECT _admin_email from {$wpbdf_settings};",array())); 
    return stripslashes(sanitize_email($email));      
}


//get general settings
function wpbdf_getBusinessSettings(){
        global $wpdb;
        global $wpbdf_settings;
    if (current_user_can( 'edit_pages' ) ) {
        $row = $wpdb->get_row("SELECT * FROM {$wpbdf_settings}");
        return array(stripslashes(sanitize_text_field($row->_google_api,"text")),stripslashes(sanitize_text_field($row->_google_map)),stripslashes(sanitize_text_field($row->_google_dir)),stripslashes(sanitize_text_field($row->_admin_email)),stripslashes(sanitize_textarea_field($row->_tcs)),stripslashes(sanitize_text_field($row->_timezone,"text")),stripslashes(sanitize_text_field($row->_dateformat)));
    }else{

        return null;

    }
}


//save general settings
function wpbdf_setBusinessSettings(){


    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if ( current_user_can( 'edit_posts' )  && is_admin() && isset($_POST) && wp_verify_nonce($_POST['custom_meta_box_nonce'], 'wpbdf-safe-check-nonce')  ) {

        global $wpdb;
        global $wpbdf_settings;        

        $api = sanitize_text_field($_POST["google_api"]);
        if($_POST["map"]==1){
            $map = 1;
        }else{
            $map = 0;
        }

        //directions currently unused
        if($_POST["dir"]==1){
            $dir = 1;
        }else{
            $dir = 0;
        }

        if($_POST["admin_email"]){
             $admin_email = stripslashes(sanitize_email($_POST["admin_email"]));
        }else{
            $admin_email = "";
        }

        //terms and conditions

        $tcs = stripslashes(sanitize_textarea_field($_POST['_tcs']));

        //timezone

        $_SESSION['wpbdf_timezone'] = $tz;

        $urls = sanitize_text_field($_POST['main_directory']).":".sanitize_text_field($_POST['view_business']).":".sanitize_text_field($_POST['directory_add_business']);  

        $dateformat = sanitize_text_field($_POST['admin_dateformat']);

        $data = array(
                    'id' => 1,
                    '_google_api'    => $api,
                    '_google_map'    => $map,
                    '_google_dir'    => $dir,
                    '_admin_email'   => $admin_email,
                   '_tcs' =>  $tcs,
                   '_page_ids' => $urls,
                   '_dateformat' => $dateformat,
                    '_update'        => current_time( 'mysql' )
        );
            
        $format = array(
                    '%d',
                    '%s',
                    '%d',
                    '%d',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s'
         );

        $delete = $wpdb->query("TRUNCATE TABLE `{$wpbdf_settings}`");

        $success = $wpdb->insert( 
                    $wpbdf_settings, 
                    $data, 
                    $format 
        );
        return $success;
    }else{
        return 0;
    }

}


/*--------------------------Google Map Functions -----------------------------------*/

function wpbdf_get_google_api_key(){
    global $wpdb;
    global $wpbdf_settings;
    $sql = "SELECT _google_api FROM {$wpbdf_settings};";
    $api = $wpdb->get_var($sql);
    return stripslashes(sanitize_text_field($api));
}
function wpbdf_get_google_link_options(){
    global $wpdb;
    global $wpbdf_settings;
    $sql = "SELECT _google_map FROM {$wpbdf_settings};";
    $googlelink = $wpdb->get_var($sql);
    return stripslashes(sanitize_text_field($googlelink));
}

function wpbdf_get_google_option(){
    global $wpdb;
    global $wpbdf_settings;
    $sql = "SELECT _google_map,_google_api FROM {$wpbdf_settings};";
    $gl = $wpdb->get_row($sql);
    if($gl->_google_api==''){
        $map = 0;
    }else if($gl->_google_map==0){
        $map = 0;
    }else{
        $map = 1;
    }
    return $map;
}

function get_admin_requests(){
    global $wpdb;
    global $wpbdf_settings;
    $sql = "SELECT * FROM {$wpbdf_settings};";
    $gl = $wpdb->get_row($sql);
    return array(stripslashes(sanitize_text_field($gl->_dateformat)), stripslashes(sanitize_text_field($gl->_google_api)), stripslashes(sanitize_text_field($gl->_google_map)));
}

?>