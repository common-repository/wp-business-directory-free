<?php
/**
* Plugin Name: WP Business Directory FREE
* Plugin URI: http://www.wpbusinessdirectorypro.com/free
* Description: A free version of the comprehensive business directory plug-in for Wordpress. Get the full version for additional features such as multiple tiered subscription types, user ownership/claiming, user dashboard, automated subscription reminders, bulk importing, ratings and reviews and much more. For a full list of options visit www.wpbusinessdirectorypro.com
* Version: 1.0.8.2
* Author: James Tibbles
* Author URI: http://www.jamestibbles.co.uk
* Author Email: jamestibbles.jt@gmail.com
**/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
global $wpbdf_version;

$wpbdf_version = "1.0.8.2";

include(plugin_dir_path( __FILE__ ) . '/functions/email.php');

include(plugin_dir_path( __FILE__ ) . '/functions/setup.php');

include(plugin_dir_path( __FILE__ ) . '/functions/settings.php');

include(plugin_dir_path( __FILE__ ) . '/functions/admin.php');

include(plugin_dir_path( __FILE__ ) . '/functions/google-map.php');

include(plugin_dir_path( __FILE__ ) . '/functions/search.php');


register_activation_hook(__FILE__,'wpbdf_install'); //hook must be here in the main function
register_activation_hook(__FILE__,'wpbdf_activate');
register_activation_hook( __FILE__, 'wpbdf_admin_notice_example_activation_hook' );
add_action( 'admin_notices', 'wpbdf_admin_notice_example_notice' );


//handle requests - set up actions

add_action( 'plugins_loaded', 'wpbdf_translation_init');




//Allow translation
function wpbdf_translation_init() {
    load_plugin_textdomain( 'wpbdf', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}


//preload all files atleast once. This will speed up future requests
function wpdbf_cacheFiles(){
  wp_enqueue_style('font-awesome-min', plugin_dir_url((__FILE__))."css/font-awesome.min.css",array());  
  wp_enqueue_script('wpbdf-slideshow', plugin_dir_url((__FILE__)).'js/slideshow.js', array( 'jquery' ));
  wp_enqueue_script('fe-business-details', plugin_dir_url((__FILE__)).'js/fe-business-details.js', array( 'jquery' ));
  wp_enqueue_style('wpbdf-slideshow-css',plugin_dir_url((__FILE__))."css/slideshow.css"); 
  wp_enqueue_style('business-page-css',plugin_dir_url((__FILE__))."template/css/wpbdf-business-details-page.css");
  $api = wpbdf_get_google_api_key();
  $extra = "";
  wp_enqueue_script('google-maps', '//maps.googleapis.com/maps/api/js?key='.$api.$extra, array(), '3');
}
add_action( 'wp_enqueue_scripts', 'wpdbf_cacheFiles');





function wpbdf_pagination($pageurl,$count,$resultsperpage,$pagenum){

   $num_surrounding_pages = 5;
  
  if($pagenum>1){$pagenum_prev = $pagenum-1;}else{$pagenum_prev=1;}

  if(($pagenum*$resultsperpage)<$count){$pagenum_next = $pagenum+1;}else{$pagenum_next=$pagenum;}

  $filtername = sanitize_text_field($_GET['filter-name']);
  $filteremail = sanitize_email($_GET['filter-email']);
  $filtersort = sanitize_text_field($_GET['filter-sort']);
  $filterascdesc = sanitize_text_field($_GET['filter-ascdesc']);
  $filterstatus = sanitize_text_field($_GET['filter-status']);

  $params="filter-name=".$filtername."&filter-email=".$filteremail."&filter-sort=".$filtersort."&filter-ascdesc=".$filterascdesc."&filter-status=".$filterstatus;


  if($pagenum==1){$poff = " off";}else{$poff="";}

  if($pagenum!=1){
        $prevpage = "<a href='".$pageurl."&pg=".$pagenum_prev."&".$params."' class='wpbdf-pagination".$poff."'>‹ Previous</a>";
  }else{
        $prevpage = "<a class='wpbdf-pagination off' style='color:#ccc;'>‹ Previous</a>";
  }

  $pagination = "<a href ='".$pageurl."&pg=1&".$params."' class='wpbdf-pagination".$poff."'>«</a>".$prevpage;

  $starti = $pagenum - $num_surrounding_pages;
  if($starti<1){$starti=1;}
  $endi = $pagenum + $num_surrounding_pages;

  for($i=$starti; $i<=$endi; $i++){

    if( ($i*$resultsperpage) <= ceil($count / $resultsperpage) * $resultsperpage ) {

        if($pagenum == $i){

            $pagination .= "<span class='wpbdf-pagination'> ".$i."</span>";

        }else{

            $pagination .= "<a href='".$pageurl."&pg=".$i.$alb."&".$params."' class='wpbdf-pagination'>".$i."</a>";

        }

    }

  }

  if(($pagenum*$resultsperpage)==$count){$poff = " off";}else{$poff="";}

  if($pagenum_next!=$pagenum){

        $nxtpage = "<a href ='".$pageurl."&pg=".$pagenum_next."&".$params."' class='wpbdf-pagination".$poff."'>Next ›</a>";

  }else{

        $nxtpage = "<a class='wpbdf-pagination off' style='color:#ccc;'>Next ›</a>";

  }

  $pagination .= $nxtpage."<a href ='".$pageurl."&pg=".ceil($count/$resultsperpage)."&".$params."' class='wpbdf-pagination".$poff."'>»</a>";

  return $pagination;

}

//Delete business
function wpbdf_remove_business_page(){
    if( current_user_can('editor') || current_user_can('administrator') ){
        
        //global $wpdb;
        $filtername = sanitize_text_field($_GET['filter-name']);
        $filteremail = sanitize_email($_GET['filter-email']);
        $filtersort = sanitize_text_field($_GET['filter-sort']);
        $filterascdesc = sanitize_text_field($_GET['filter-ascdesc']);
        $filterstatus = sanitize_text_field($_GET['filter-status']);


        $params="filter-name=".$filtername."&filter-email=".$filteremail."&filter-sort=".$filtersort."&filter-ascdesc=".$filterascdesc."&filter-status=".$filterstatus;

        if(isset($_GET['delid'])){
            if(wpbdf_remove_business($_GET['delid'])){
                echo '<script>window.location = "admin.php?page=wpbdf_view_entries&del=1&'.$params.'";</script>'; exit; 
            }else{
                echo '<script>window.location = "admin.php?page=wpbdf_view_entries&del=-1&'.$params.'";</script>'; exit;
            }
        }else if(isset($_GET['theids'])){
            $theids = sanitize_text_field($_GET['theids']);
            $id_array = explode("|",$theids);
            $ok = true;
            foreach($id_array as $id){
                if($id>0){
                    if(!wpbdf_remove_business($id)){
                        $ok = false;
                    }
                }
            }
            if($ok){
                 echo '<script>window.location = "admin.php?page=wpbdf_view_entries&dels=1&'.$params.'";</script>'; exit;
            }else{
                echo '<script>window.location = "admin.php?page=wpbdf_view_entries&dels=-1&'.$params.'";</script>'; exit;
            }
        }
    }
}

function wpbdf_remove_business($id){

    if (current_user_can( 'edit_posts' ) ) {
        global $wpdb;
        global $wpbdf_listings_db;

        //get user id of this item
        $vals = $wpdb->get_row($wpdb->prepare("SELECT _email,_name,_active FROM {$wpbdf_listings_db} WHERE id=%d",$id));

        $user_email = $vals->_email;
        $bus_name = $vals->_name;
        $status = $vals->_active;

        wpbdf_removal_response($bus_name,$user_email,$status);

        //Now delete business
        $wpdb->delete( $wpbdf_listings_db, array( 'id' => $id ), array( '%d' ) );

        return true;

    }else{

        return false;

    }
}



//Activate a business
function wpbdf_act_business(){

    if( current_user_can('editor') || current_user_can('administrator') ){

        global $wpdb;

      $filtername = sanitize_text_field($_GET['filter-name']);
      $filteremail = sanitize_email($_GET['filter-email']);
      $filtersort = sanitize_text_field($_GET['filter-sort']);
      $filterascdesc = sanitize_text_field($_GET['filter-ascdesc']);
      $filterstatus = sanitize_text_field($_GET['filter-status']);

        $params="filter-name=".$filtername."&filter-email=".$filteremail."&filter-sort=".$filtersort."&filter-ascdesc=".$filterascdesc."&filter-status=".$filterstatus;

        if(isset($_GET['id'])){

            if(wpbdf_status_business($_GET['id'],1)){

                echo '<script>window.location = "admin.php?page=wpbdf_view_entries&act=1&'.$params.'";</script>'; 

            }else{

                echo '<script>window.location = "admin.php?page=wpbdf_view_entries&act=-1&'.$params.'";</script>'; 

            }

        }else if(isset($_GET['theids'])){

            $theids = sanitize_text_field($_GET['theids']);

            $id_array = explode("|",$theids);

            $ok = true;

            foreach($id_array as $id){

                if($id>0 && wpbdf_get_status($id)!=2){
                 

                    if(!wpbdf_status_business($id,1)){

                        $ok = false;

                    }

                }

            }

            if($ok){

                 echo '<script>window.location = "admin.php?page=wpbdf_view_entries&acts=1&'.$params.'";</script>'; exit;

            }else{

                echo '<script>window.location = "admin.php?page=wpbdf_view_entries&acts=-1&'.$params.'";</script>'; exit;

            }
        }
    }
}



//Deactivate a business
function wpbdf_deact_business(){

    if( current_user_can('editor') || current_user_can('administrator') ){

        global $wpdb;

      $filtername = sanitize_text_field($_GET['filter-name']);
      $filteremail = sanitize_email($_GET['filter-email']);
      $filtersort = sanitize_text_field($_GET['filter-sort']);
      $filterascdesc = sanitize_text_field($_GET['filter-ascdesc']);
      $filterstatus = sanitize_text_field($_GET['filter-status']);

        $params="filter-name=".$filtername."&filter-email=".$filteremail."&filter-sort=".$filtersort."&filter-ascdesc=".$filterascdesc."&filter-status=".$filterstatus;

        if(isset($_GET['id'])){

            if(wpbdf_status_business($_GET['id'],0)){

                echo '<script>window.location = "admin.php?page=wpbdf_view_entries&deact=1&'.$params.'";</script>'; 

            }else{

                echo '<script>window.location = "admin.php?page=wpbdf_view_entries&deact=-1&'.$params.'";</script>'; 

            }

        }else if(isset($_GET['theids'])){

            $theids = sanitize_text_field($_GET['theids']);

            $id_array = explode("|",$theids);

            $ok = true;

            foreach($id_array as $id){

                if($id>0){

                    if(!wpbdf_status_business($id,0)){

                        $ok = false;

                    }
                }
            }

            if($ok){
                 echo '<script>window.location = "admin.php?page=wpbdf_view_entries&deacts=1&'.$params.'";</script>'; exit;
            }else{
                echo '<script>window.location = "admin.php?page=wpbdf_view_entries&deacts=-1&'.$params.'";</script>'; exit;
            }

        }
    }
}


//count number of businesses
function wpbdf_count_businesses(){
    global $wpdb;
    global $wpbdf_listings_db;
    $count = $wpdb->get_var("SELECT COUNT(id) as cnt from {$wpbdf_listings_db}"); 
    return $count;
}


//Change status of business
function wpbdf_status_business($id,$act){

    if (current_user_can( 'edit_posts' ) ) {

        global $wpdb;
        global $wpbdf_listings_db;

        //If it is not already in this state then set it
        if( wpbdf_get_status($id)!=$act){

            $data = array(
                    '_active'    => $act,
                    '_update' => current_time( 'mysql' )
            );
            
            $format = array(
                    '%s',
                    '%s'
            );

            
            $success = $wpdb->update( 
                    $wpbdf_listings_db, 
                    $data, 
                    array( 'id' => $id ), 
                    $format, 
                    array( '%d' ) 
            );

            if($success){
                $email = wpbdf_get_email($id);
                wpbdf_sendUserNotification($email,$act,$id);
                return true;
            }else{
                return true;
            }

        }else{
            return true;
        }
    }else{
        return false;
    }
}


/**************************Useful Global functions *******************************/

function wpbdf_add_ajax(){
    echo "<script>var ajaxurl = '".admin_url('admin-ajax.php')."';</script>";
}

function wpbdf_add_font_awesome(){
    wp_enqueue_style('font-awesome-min', plugins_url('css/font-awesome.min.css' , __FILE__ ) );
}
function wpbdf_add_global_style(){

    if('' != locate_template( 'wpbdf/css/wpbdf-global-style.css' ) ){
        wp_enqueue_style('global-style-css', get_theme_root_uri().'/'.get_template() . '/wpbdf/css/wpbdf-global-style.css');
    }else{
        wp_enqueue_style('global-style-css',  plugins_url( 'template/css/wpbdf-global-style.css' , __FILE__ ) );
    }
}
function wpbdf_add_notice_style(){

    if('' != locate_template( 'wpbdf/css/wpbdf-notice-page.css' ) ){
        wp_enqueue_style('notice-page-css', get_theme_root_uri().'/'.get_template() . '/wpbdf/user-businesses/css/wpbdf-notice-page.css');
    }else{
        wp_enqueue_style('notice-style-css',  plugins_url( 'template/user-businesses/css/wpbdf-notice-page.css' , __FILE__ ) );
    }
}



function wpbdf_get_status($id){

    global $wpdb;
    global $wpbdf_listings_db;
    $curr_state = $wpdb->get_var($wpdb->prepare("SELECT _active from {$wpbdf_listings_db} where id=%d;",array($id))); 
    return $curr_state;
}


function wpbdf_get_email($id){

    global $wpdb;
    global $wpbdf_listings_db;
    $email = $wpdb->get_var($wpdb->prepare("SELECT _email from {$wpbdf_listings_db} where id=%d;",array($id))); 
    return $email;
}
function wpbdf_get_businessname($id){

    global $wpdb;
    global $wpbdf_listings_db;
    $name = $wpdb->get_var($wpdb->prepare("SELECT _name from {$wpbdf_listings_db} where id=%d;",array($id))); 
    return $name;
}





function wpbdf_createSlideshow($imgs){

    $html = "";
        
    $originalsize = 1;

    $transition_speed=250;

    $wait=8000;

    $maxh = '100%';

    $maxw = '100%';

    $minh = 'auto';

    $minw = '100%';

    $h = 'auto';

    $nav_arrows = 1;

    $nav_bullets = 1;

    $slidecount=0;

    $bullets="";

    foreach($imgs as $array_key=>$array_item)
    {
      if($imgs[$array_key] < 1)
      {
        unset($imgs[$array_key]);
      }
    }

    if(count($imgs)>0){


        $rndname= rand(0,99999).rand(0,99999);

        $html .= "<div class='wpbdf-slideshow slideshow_".$rndname."' data-name='".$rndname."'>";

        foreach ( $imgs as $imgid )
        {

                if($originalsize=="1" || $originalsize==true) {
                    $img_code = wp_get_attachment_image( $imgid, 'original' );
                }else{
                    $img_code = wp_get_attachment_image( $imgid, 'bd-thumbnail' );
                }
                $img_code = str_replace("img ", "img style='max-width:".$maxw.";max-height:".$maxh.";min-width:".$minw.";min-height:".$minh.";height:".$h.";'", $img_code);
                
                $itm = "<div class='slideshow-item' >".$img_code."</div>";

                $slidecount++;
                
                $html.="<div class='slide' data-transpeed='".$transition_speed."' data-wait='".$wait."'  id='".$rndname."_slide_".$slidecount."' data-slide='".$slidecount."'";

                if(count($imgs)==1){
                    $html.=" style='display:block;position:static;'";
                }

                $html.=">".$itm.$text_code."</div>";
                
                $bullets.="<li class='bullet bullet-".$slidecount."' data-slide-num='".$slidecount."'></li>";

        }

        $html.="</div>";

        if(count($imgs)>1){

            if($nav_arrows==1){
                $html.="<div class='previous-arrow' data-slideshow='".$rndname."' ready='1'><div class='arrow' style='background-image: url(".plugins_url( '/img/arrows.png' , __FILE__ ).");'></div></div>";
                $html.="<div class='next-arrow' data-slideshow='".$rndname."' ready='1'><div class='arrow' style='background-image: url(".plugins_url( '/img/arrows.png' , __FILE__ ).");'></div></div>";
            }
            if($nav_bullets==1){
                $html.="<ul class='bullets' data-slideshow='".$rndname."' ready='1'>";
                $html.=$bullets;
                $html.="</ul>";
            }
            $html.="<script>document.autoplay=false;</script>";

        }else{
            $html.="<script>document.noanim=1;document.autoplay=false;</script>";
        }

    }else{
            $html.="<script>document.noanim=1;document.autoplay=false;</script>";
    }

    return $html;

}



//Ajax query to return image object for business
function wpbdf_get_business_image() {

   $id = intval($_POST['id']);

   $img = wp_get_attachment_image( $id, 'bd-thumbnail' );

   echo $img;

   exit;
}
add_action( 'wp_ajax_get_business_image', 'wpbdf_get_business_image' );



//return business name
function wpbdf_getbusinessName($id){

    if($id>0){

        global $wpdb;
        global $wpbdf_listings_db;

        $nm = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT _name FROM {$wpbdf_listings_db} WHERE id=%d;",$id
            )
        );
        return $nm;
    }else{
        return null;
    }
}

//return business details
function wpbdf_getbusinessDetails($id){

    if($id>0){

        global $wpdb;
        global $wpbdf_listings_db;

        $row = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT _name,_address,_postcode,_country,_lat,_lng,_imgid,_images,_active,_cat,_tel,_fax,_desc,_typ,_website,_email,_social FROM {$wpbdf_listings_db} WHERE id=%d;",$id
            )
        );
        return array($row->_name,$row->_address,$row->_postcode,$row->_country,$row->_lng,$row->_lat,$row->_imgid,$row->_images,$row->_active,$row->_cat,$row->_tel,$row->_fax,$row->_desc,$row->_typ,$row->_website,$row->_email,$row->_social);
    }else{
        return null;
    }
}

//return business details
function wpbdf_getActiveBusinessDetails($id){

    if($id>0){

        global $wpdb;
        global $wpbdf_listings_db;

        $row = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT _name,_address,_postcode,_country,_cat,_lat,_lng,_imgid,_images,_active,_tel,_fax,_desc,_typ,_website,_email,_social  FROM {$wpbdf_listings_db} WHERE id=%d and _active=1;",$id
            )
        );
        return array(
            '_name' => $row->_name,
            '_address' => $row->_address,
            '_postcode' => $row->_postcode,
            '_country' => $row->_country,
            '_lng' => $row->_lng,
            '_lat' => $row->_lat,
            '_imgid' => $row->_imgid,
            '_images' => $row->_images,
            '_active' => $row->_active,
            '_cat' => $row->_cat,
            '_tel' => $row->_tel,
            '_fax' => $row->_fax,
            '_desc' => $row->_desc,
            '_typ' => $row->_typ,
            '_website' => $row->_website,
            '_email' => $row->_email,
            '_social' => $row->_social);
    }else{
        return null;
    }
}




/************************************************************FRONT END*************************************************/
//convert uploaded image to media library
function wp_handle_image_upload($img)
{
    
    $uploadOk = 0;

    if(!empty($img) && isset($img["tmp_name"]) && $img["tmp_name"]!="")
    {
        
        // Check if image file is a actual image or fake image
        $check = getimagesize($img["tmp_name"]);

        if($check !== false) {
           
           $uploadOk = wpbdf_fetch_media($img["tmp_name"],$img["name"]);

        }
    }

    return $uploadOk;
      
}

//convert temp image file to media library
function wpbdf_fetch_media($file_url,$orgname) {
    require_once(ABSPATH . 'wp-load.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    global $wpdb;

    //directory to import to    
    $artDir = 'wp-content/uploads/wpbdfmedia/';

    //if the directory doesn't exist, create it 
    if(!file_exists(ABSPATH.$artDir)) {
        mkdir(ABSPATH.$artDir);
    }

    //rename the file... alternatively, you could explode on "/" and keep the original file name
    $ext = array_pop(explode(".", $orgname));
    $new_filename = 'bd-img-'.time()."-".rand(0,9999).rand(0,9999).".".$ext; //if your post has multiple files, you may need to add a random number to the file name to prevent overwrites

    if (@fclose(@fopen($file_url, "r"))) { //make sure the file actually exists
        copy($file_url, ABSPATH.$artDir.$new_filename);

        $siteurl = get_option('siteurl');
        $file_info = getimagesize(ABSPATH.$artDir.$new_filename);

        //create an array of attachment data to insert into wp_posts table
        $artdata = [];
        $artdata = array(
            'post_author' => 1, 
            'post_date' => current_time('mysql'),
            'post_date_gmt' => current_time('mysql'),
            'post_title' => $new_filename, 
            'post_status' => 'inherit',
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_name' => sanitize_title_with_dashes(str_replace("_", "-", $new_filename)),                                            
            'post_modified' => current_time('mysql'),
            'post_modified_gmt' => current_time('mysql'),
            'post_parent' => 0,
            'post_type' => 'attachment',
            'guid' => $siteurl.'/'.$artDir.$new_filename,
            'post_mime_type' => $file_info['mime'],
            'post_excerpt' => '',
            'post_content' => ''
        );

        $uploads = wp_upload_dir();
        $save_path = $uploads['basedir'].'/wpbdfmedia/'.$new_filename;

        //insert the database record
        $attach_id = wp_insert_attachment( $artdata, $save_path, 0 );

        //generate metadata and thumbnails
        if ($attach_data = wp_generate_attachment_metadata( $attach_id, $save_path)) {
            wp_update_attachment_metadata($attach_id, $attach_data);
        }

    }
    else {
        return 0;
    }

    return $attach_id;
}



//Validate upload details on new business from front end
function wpbdf_new_business_fe_sanitation() {

    global $wpdb;

    $goodhtml = array(
        'a' => array(
            'href' => array(),
            'title' => array(),
            'alt' => array(),
            'title' => array(),
            'target' => array(),
        ),
        'img' => array(
            'href' => array(),
            'title' => array(),
            'alt' => array(),
            'title' => array(),
        ),
        'br' => array(),
        'em' => array(),
        'p' => array(),
        'span' => array(),
        'div' => array(),
        'ul' => array(),
        'li' => array(),
        'ol' => array(),
        'em' => array(),
        'b' => array(),
        'hr' => array(),
        'strong' => array(),
    );

    $ok = true;
    $id=0;

    // if the submit button is clicked, send the email
    if ( wp_verify_nonce($_POST['custom_meta_box_nonce'], 'wpbdf-new-business-safe-check')  ) {

        // sanitize form values
        $name = sanitize_text_field($_POST["business_name"]); 

        $address = sanitize_textarea_field($_POST["address"]);
        
        $postcode = sanitize_text_field($_POST["postcode"]);
        
        $country = sanitize_text_field($_POST["country"]);
        
        $cat = sanitize_text_field($_POST["cat"]);
        
        $long = floatval( sanitize_text_field($_POST["long"]) );
        
        $lat = floatval (sanitize_text_field($_POST["lat"]) );
        
        $typ = sanitize_text_field($_POST["typ"]);
        
        $email = sanitize_email($_POST["email"]);
        
        $tel = sanitize_text_field($_POST["tel"]);       
        
        $fax = sanitize_text_field($_POST["fax"]);   
        
        $website = sanitize_text_field($_POST["website"]); 
        
        $social = sanitize_text_field($_POST["social"]); 


        $desc = wp_kses($_POST["desc"],$goodhtml);
  
         
        //logo
        $imgid = 0;
        if($_FILES["img_file"]["error"] != 4 ){
            $imgid = wp_handle_image_upload($_FILES["img_file"]);
        }else if (isset($_POST['logoid']) && intval($_POST['logoid']>0) ){
            $imgid = intval($_POST['logoid']);
        }

        //each image
        $imgsid = "";
        for($i=1;$i<=5;$i++){
            if($_FILES["img_file_".$i]["error"] != 4){
                $imgsid .= wp_handle_image_upload($_FILES['img_file_'.$i]).":";
            }else if (isset($_POST['img_'.$i]) && intval($_POST['img_'.$i]>0)){
                $imgsid .=(intval($_POST['img_'.$i])).":";
            }else{
                //don't let it exist
            } 
        }   
               
        $data = array(
                '_name' => $name,
                '_address' => $address,
                '_postcode' => $postcode,
                '_country' => $country,
                '_cat' => $cat,
                '_imgid' => $imgid,
                '_images' => $imgsid,
                '_desc' => $desc,
                '_website' => $website,
                '_email' => $email,
                '_tel' => $tel,
                '_fax' => $fax,
                '_typ' => $typ,
                '_active'    => 3,
                '_social' => $social,
                '_update' => current_time( 'mysql' )
        );

        global $wpbdf_listings_db;
        
        $format = array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%s'
        );
        
        $success=$wpdb->insert( $wpbdf_listings_db, $data, $format );

        if(!$success){
            $ok = false;
        }else{
            $id = $wpdb->get_var("SELECT id FROM {$wpbdf_listings_db} ORDER BY id DESC limit 0,1");       
        }

    }

    return array($ok,$id);
}




//Prevent pages with user-logged-in-required shortcodes should be redirected if they are no logged in
function wpdbf_got_shortcode($shortcode) {

    global $post;

    if (!$shortcode || $post == null) {  
        return false;  
    }

    if ( stripos($post->post_content,'['.$shortcode) !== false ) {     
        return true;
    }

    return false;
}



//add business details in the front-end
 add_shortcode( 'wpbdf-signup-page', 'wpbdf_addBusinessDetails_fe');

 function wpbdf_addBusinessDetails_fe(){

    wpbdf_add_font_awesome();
    wpbdf_add_global_style();

    global $goodhtml;

    if('' != locate_template( 'wpbdf/user-businesses/css/wpbdf-signup-page.css' ) ){
        wp_enqueue_style('signup-css', get_theme_root_uri().'/'.get_template() . '/wpbdf/user-businesses/css/wpbdf-signup-page.css');
    }else{
        wp_enqueue_style('signup-css', plugins_url( 'template/user-businesses/css/wpbdf-signup-page.css' , __FILE__ ));
    }

    wp_enqueue_script( 'new-edit-business-min', plugins_url( '/js/wpbdf-create-edit-business-frontend-script.js' , __FILE__ ), array('jquery'), '1.0.0', true );

    wpbdf_add_ajax();

    //Store new updated file
    if ( wp_verify_nonce($_POST['custom_meta_box_nonce'], 'wpbdf-new-business-safe-check')  ) {

        global $main_page,$view_business,$signup_success;

        list($ok,$newid) = wpbdf_new_business_fe_sanitation();

        if($ok){
            $signup_success = 1;
            wpbdf_EmailAdmin($newid,wpbdf_getAdminEmail());
        }else{
            $signup_success = 0;
        }

        list($main_page,$view_business,$add_business) = wpbdf_get_urls(false);

        if('' != locate_template( 'wpbdf/user-businesses/wpbdf-notice-page.php' ) ){
            include(get_template_directory() . '/wpbdf/user-businesses/wpbdf-notice-page.php');
        }else{
            include( plugin_dir_path( __FILE__ ) . 'template/user-businesses/wpbdf-notice-page.php');
        }

    }else{

        global $business_cats,$business_types,$terms,$main_page,$view_business;

        //get types
            
        $taxonomy = 'business-type-free';
            
        $term_args=array(
              'hide_empty' => false,
              'orderby' => 'name',
              'order' => 'ASC'
        );
            
        $business_types=get_terms($taxonomy,$term_args); 
            
        //get cats
            
        $taxonomy = 'business-cat-free';
            
        $business_cats=get_terms($taxonomy,$term_args); 

        $terms = wpbdf_GetTerms();

        list($main_page,$view_business,$add_business) = wpbdf_get_urls(false);

        $goodhtml = array(
            'a' => array(
                'href' => array(),
                'title' => array(),
                'alt' => array(),
                'title' => array(),
                'target' => array(),
            ),
            'img' => array(
                'href' => array(),
                'title' => array(),
                'alt' => array(),
                'title' => array(),
            ),
            'br' => array(),
            'em' => array(),
            'p' => array(),
            'span' => array(),
            'div' => array(),
            'ul' => array(),
            'li' => array(),
            'ol' => array(),
            'em' => array(),
            'i' => array(),
            'ul' => array(),
            'b' => array(),
            'hr' => array(),
            'strong' => array(),
        );


        if('' != locate_template( 'wpbdf/user-businesses/wpbdf-signup-page.php' ) ){
            include(get_template_directory() . '/wpbdf/user-businesses/wpbdf-signup-page.php');
        }else{
            include( plugin_dir_path( __FILE__ ) . 'template/user-businesses/wpbdf-signup-page.php');
        }

    }
}
