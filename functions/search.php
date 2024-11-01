<?php
/*-----------------------Business Directory - Front End-------------------------------*/

add_shortcode( 'wpbdf-directory', 'wpbdf_show_directory' ); 
add_shortcode( 'wpbdf-directory-details', 'wpbdf_show_details' );
add_action( 'wp_ajax_get_locals', 'wpbdf_getNearby' ); 
add_action('wp_ajax_nopriv_get_locals', 'wpbdf_getNearby');

function wpbdf_show_directory(){

    $script_frontend_js = plugin_dir_url(dirname(__FILE__))."js/script-frontend.js";
    $bdstyle_css = plugin_dir_url(dirname(__FILE__))."template/css/wpbdf-business-directory-page.css";
    $gstyle_css = plugin_dir_url(dirname(__FILE__))."template/css/wpbdf-global-style.css";
    $wpbdf_business_details_page = plugin_dir_path(dirname(__FILE__))."template/wpbdf-directory-page.php"; 
    
    if('' != locate_template( 'wpbdf/css/wpbdf-global-style.css' ) ){
        wp_enqueue_style('global-style-css', get_theme_root_uri().'/'.get_template() . '/wpbdf/css/wpbdf-global-style.css');    
    }else{
        wp_enqueue_style('wpbdf-global-style-css', $gstyle_css);
    }
    if('' != locate_template( 'wpbdf/css/wpbdf-business-directory-page.css' ) ){
        wp_enqueue_style('wpbdf-bd-style-css', get_theme_root_uri().'/'.get_template() . '/wpbdf/css/wpbdf-business-directory-page.css');    
    }else{
        wp_enqueue_style('wpbdf-bd-style-css', $bdstyle_css);
    }

    wp_enqueue_style('font-awesome-min', plugin_dir_url(dirname(__FILE__))."css/font-awesome.min.css");  

    wp_enqueue_script( 'wpbdf-script-frontend', $script_frontend_js, array('jquery'), '1.0.0', true );

    global $gmap,$api,$canmap,$business_types,$business_types_options,$business_cats,$business_cats_options,$url,$_page,$_radius,$_amt,$_lat,$_lng,$_ascdesc,$_order;

    $canmap = wpbdf_get_google_option();

    //get types

    $taxonomy = 'business-type-free';

    $term_args=array(
      'hide_empty' => false,
      'orderby' => 'name',
      'order' => 'ASC'
    );

    $business_types = get_terms($taxonomy,$term_args); 

    $business_types_options = "";

    foreach ($business_types as $tax ) {
        
        $business_types_options.= '<option value="'.$tax->slug.'" class="business_types_option"';
        

        if((sanitize_text_field($_REQUEST['_typ'])) == $tax->slug){
        
            $business_types_options.= " selected";
        
        }
        
        $business_types_options.= '>'.$tax->name.'</option>';                   
    }

    //get cats

    $taxonomy = 'business-cat-free';

    $business_cats = get_terms($taxonomy,$term_args); 

    $business_cats_options = "";
        
    $c = (sanitize_text_field($_REQUEST['_cat']));

    $N = count($c);

    foreach ($business_cats as $cat ) {

                $business_cats_options.= '<input type="checkbox" name="_cat[]" value="'.$cat->slug.'" class="business_cat_option"';

                $checked=0;

                for($i=0; $i < $N; $i++){

                    if($c[$i] == $cat->slug){

                        $checked=1;

                    }

                }

                if($checked==1){$business_cats_options.=  " checked";}

                $business_cats_options.= '><span class="checkbox-label">'.$cat->name.'</span><br>'; 

    }

    //GMap

    $api = wpbdf_get_google_api_key();

    if($api!="" && $canmap==1 ){
        $gmap  = "<div id='map-parent'>";
        $gmap .= "<div id='wait' style='display:block;'><div class='waitcontent'>Please wait...<div class='loader'><img src='/wp-content/plugins/wp-business-directory-free/img/loader.gif' alt='please wait, loading...'/></div></div></div>";
        $gmap .= "<div id='map-container'><div class='message'><p class='msg'></p><a id='exit-btn' class=''>Close</a></div><div id='map_wpbdf'></div></div>";
        $gmap .= "<script>var map_wpbdf;var markers = [];var infoWindow;var locationSelect;var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';var labelIndex = 0;";
        $gmap .= "wpbdf_initMap();function wpbdf_initMap() {map_wpbdf = new google.maps.Map(document.getElementById('map_wpbdf'), {center: {lat: 50.24, lng: -2.5},zoom: 2});infoWindow = new google.maps.InfoWindow();locationSelect = document.getElementById('locationSelect');}";
        $gmap .= "document.canMap = true;</script>";
        $gmap .= "</div><div id='loc_err'></div>";
    }else{
        $gmap = "<div id='loc_err'></div>";
        $gmap .= "<script>document.canMap = false;function wpbdf_initMap(){}</script>";
    }

    //We need google api for finding the distance field (via long and lat). Without it you won't be able to perform this check
    if($api!=""){
        $gmap .= "<script>document.canDistance=true;</script>";
    }else{
        $gmap .= "<script>document.canDistance=false;</script>";
    }
    $gmap .= '<script>var ajaxurl = "'.admin_url('admin-ajax.php').'";</script>';

    $_page = 1;
    if($_REQUEST['_page']!=""){
      $_page = intval( $_REQUEST['_page']);
    }
    if($_page<1){$page=1;}

    $_radius = 25;
    if($_REQUEST['_radius']!=""){
      $_radius = intval($_REQUEST['_radius']);
    }

    $_amt = 25;
    if($_REQUEST['_amt']!="" && $amt<=200){
      $_amt = intval($_REQUEST['_amt']);
    }

    $_lat = "";
    if($_REQUEST['_lat']!=""){
      $_lat = floatval(stripslashes(sanitize_text_field($_REQUEST['_lat'])));
    }

    $_lng = "";
    if($_REQUEST['_lng']!=""){
      $_lng = floatval(stripslashes(sanitize_text_field($_REQUEST['_lng'])));
    }

    $_ascdesc = "";
    if($_REQUEST['_ascdesc']!=""){
      $_ascdesc = stripslashes(sanitize_text_field($_REQUEST['_ascdesc']));
    }

    $_order = "";
    if($_REQUEST['_order']!=""){
      $_order =  stripslashes(sanitize_text_field($_REQUEST['_order']));
    }


    //longlat is flagged to be saved to our recycle, do this now:
    if($_REQUEST['_save_longlat']==1 && $_lng!="" && $_lat!=""){
        wpbdf_storeLongLat($_lng,$_lat, stripslashes(sanitize_text_field($_REQUEST['_tcp'])), stripslashes(sanitize_text_field($_REQUEST['_country'])));
    }

    //Are we on the initial search page?
    if(!isset($_GET['_page']) && !isset($_GET['_search'])) { $startsearch = true; }else{ $startsearch = false; }

    

    if('' != locate_template( 'wpbdf/wpbdf-directory-page.php' ) ){
        include(get_template_directory() . '/wpbdf/wpbdf-directory-page.php');
    }else{
       include($wpbdf_business_details_page);
    }


}


function wpbdf_fe_pagination($pageurl,$count,$resultsperpage,$pagenum){

   $num_surrounding_pages = 5;

   $pagination = "<div class='wpbdf-pagination'>";
  
  if($pagenum>1){$pagenum_prev = $pagenum-1;}else{$pagenum_prev=1;}

  if(($pagenum*$resultsperpage)<$count){$pagenum_next = $pagenum+1;}else{$pagenum_next=$pagenum;}

  if($_REQUEST['_ascdesc']=="asc"){
    $ascdesc = "asc";
  }else if($_REQUEST['_ascdesc']=="desc"){
    $ascdesc = "desc";
  }else{
    $ascdesc = "";
  }

  $params="_typ=".sanitize_text_field($_REQUEST['_typ'])."&_tcp=". sanitize_text_field($_REQUEST['_tcp'])."&_country=". sanitize_text_field($_REQUEST['_country'])."&_radius=". (intval(sanitize_text_field($_REQUEST['_radius']))  )."&_lng=".(floatval(sanitize_text_field($_REQUEST['_lng'])))."&_lat=".(floatval(sanitize_text_field($_REQUEST['_lat']) ))."&_amt=".(intval( sanitize_text_field($_REQUEST['_amt'])))."&_order=".sanitize_text_field($_REQUEST['_order'])."&_ascdesc=".$ascdesc."&_search=1";

  if($pagenum==1){$poff = " off";}else{$poff="";}

  if($pagenum!=1){
        $prevpage = "<a href='".$pageurl."&_page=".$pagenum_prev."&".$params."' class='wpbdf-pbtn".$poff."'>‹ Previous</a>";
  }else{
        $prevpage = "<a class='wpbdf-pbtn off'>‹ Previous</a>";
  }

  $pagination .= "<a href ='".$pageurl."&_page=1&".$params."' class='wpbdf-pbtn".$poff."'>«</a>".$prevpage;

  $starti = $pagenum - $num_surrounding_pages;
  if($starti<1){$starti=1;}
  $endi = $pagenum + $num_surrounding_pages;

  for($i=$starti; $i<=$endi; $i++){

    if( ($i*$resultsperpage) <= ceil($count / $resultsperpage) * $resultsperpage ) {

        if($pagenum == $i){

            $pagination .= "<span class='current-page'>".$i."</span>";

        }else{

            $pagination .= "<a href='".$pageurl."&_page=".$i.$alb."&".$params."' class='wpbdf-pbtn'>".$i."</a>";

        }

    }

  }

  if(($pagenum*$resultsperpage)==$count){$poff = " off";}else{$poff="";}

  if($pagenum_next!=$pagenum){

        $nxtpage = "<a href ='".$pageurl."&_page=".$pagenum_next."&".$params."' class='wpbdf-pbtn".$poff."'>Next ›</a>";
        $finalpage = "<a href ='".$pageurl."&_page=".ceil($count/$resultsperpage)."&".$params."' class='wpbdf-pbtn".$poff."'>»</a>";

  }else{

        $nxtpage = "<a class='wpbdf-pbtn off'>Next ›</a>";
        $finalpage = "<a class='wpbdf-pbtn off'>»</a>";

  }

  $pagination .= $nxtpage.$finalpage;

  $pagination.="</div>";

  return $pagination;

}



function wpbdf_show_details(){


    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    global $canmap;
    global $api;
    global $arrs;
    global $name;
    global $email;
    global $website;
    global $website_no_http;
    global $tel;
    global $fax;
    global $desc;
    global $cat;
    global $business_typ;
    global $address;
    global $postcode;
    global $country;
    global $main_img_src;
    global $the_slideshow_widget;
    global $the_social_widget;
    global $the_gmap_widget;
    global $cats;
    global $types;
    global $backbutton; 
    global $shortcodes;
    global $main_page;
    

    $wpbdf_fe_business_details_js = plugin_dir_url(dirname(__FILE__))."js/fe-business-details.js";
    $wpbdf_slideshow_css = plugin_dir_url(dirname(__FILE__))."css/slideshow.css";
    $wpbdf_slideshow_js =  plugin_dir_url(dirname(__FILE__)).'js/slideshow.js';
    $business_page_css = plugin_dir_url(dirname(__FILE__))."template/css/wpbdf-business-details-page.css";
    $wpbdf_business_details_page = plugin_dir_path(dirname(__FILE__))."template/wpbdf-business-details-page.php"; 
    $gstyle_css = plugin_dir_url(dirname(__FILE__))."template/css/wpbdf-global-style.css";
    wp_enqueue_style('font-awesome-min', plugin_dir_url(dirname(__FILE__))."css/font-awesome.min.css");    

    wp_enqueue_script(
            'fe-business-details',
            $wpbdf_fe_business_details_js,
            array( 'jquery' )
    ); 

    if('' != locate_template( 'wpbdf/css/wpbdf-global-style.css' ) ){
        wp_enqueue_style('global-style-css', get_theme_root_uri().'/'.get_template() . '/wpbdf/css/wpbdf-global-style.css');    
    }else{
        wp_enqueue_style('wpbdf-global-style-css', $gstyle_css);
    }

    if('' != locate_template( 'wpbdf/css/wpbdf-business-details-page.css' ) ){
        wp_enqueue_style('business-page-css', get_theme_root_uri().'/'.get_template() . '/wpbdf/css/wpbdf-business-details-page.css');    
    }else{
        wp_enqueue_style('business-page-css',$business_page_css);
    }

    $canmap = wpbdf_get_google_option();
    

    list($main_page,$view_business,$add_business) = wpbdf_get_urls(false);
   
    $arrs = $_SESSION['searcharrs'];

    if($arrs == ""){
        $backbutton = "<a href='".$main_page."' class='btn back'>‹ ".__("Search Again","wpbdf")."</a>";
    }else{
        $backbutton = "<a href='".$main_page."?".$arrs."' class='btn back'>‹ ".__("Back To Search","wpbdf")."</a>";
    }

    $business_details = wpbdf_getActiveBusinessDetails(intval( $_GET['bid']));

    echo '<script>var ajaxurl = "'.admin_url('admin-ajax.php').'";</script>';

    $http = array("http://","https://");

    $name = stripslashes(sanitize_text_field($business_details['_name']));
    $lng = floatval(stripslashes(sanitize_text_field($business_details['_lng'])));
    $lat = floatval(stripslashes(sanitize_text_field($business_details['_lat'])));
    
    $the_gmap_widget = "";

    if($canmap==1){

        $api = wpbdf_get_google_api_key();

        if($api!=""){

            $the_gmap_widget = wpbdf_createGmapWidget($lng,$lat,$api);

        }
    }
    
    $website = stripslashes(sanitize_text_field($business_details['_website']));
    if($website=="" || $website==" " || $website=="http://"){ $website = "";}
    $website_no_http = str_replace($http,"",$website);
    $email = stripslashes(sanitize_email($business_details['_email']));
    if($email=="" || $email==" "){ $email = "";}
    $tel = stripslashes(sanitize_text_field($business_details['_tel']));
    $fax = stripslashes(sanitize_text_field($business_details['_fax']));
    
    
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

    $desc = wp_kses($business_details['_desc'],$goodhtml); //modified sanitation, as *some* html is allowed. Any dangerous code will be removed. only *$good_html* will remain
    
    $desc = nl2br($desc);
    
    if($desc == ""){
        $desc = "<div><em>".__("No description has been provided for this business.","wpbdf")."</em></div>";
    }

    //A description *may* have shortcodes within it. We want these to work, so let's strip them out, replace them with placeholders, and process them individually at the end. Then swap the content back in to place
    preg_match_all("/\[[^\]]*\]/", $desc, $matches);
    $shortcodes = $matches[0];
    if(count($shortcodes)>0){
        $counter = 0;
        foreach($shortcodes as $shortcode){
            $desc = str_replace($shortcode,"<wpbdf-shortcode-marker-".$counter.">",$desc);
            $sc = "<div id='wpbdf-shortcode-container-".$counter."' class='shortcode-container'>".do_shortcode($shortcode)."</div>";
            $desc = str_replace("<wpbdf-shortcode-marker-".$counter.">",$sc,$desc);
            $counter++;
        }
    }

    $cat = $business_details['_cat'];

    $business_typ = $business_details['_typ'];

    $address = nl2br($business_details['_address'],false);

    $postcode = $business_details['_postcode'];

    $country = $business_details['_country']; 

    $logo_img_id = $business_details['_imgid'];

    $imgs = $business_details['_images'];

    $social = $business_details['_social'];

    $cat = ltrim($cat,"|");

    $cat = str_replace("_"," and ",$cat);

    $cat = explode("|",$cat);

    $business_typ = ltrim($business_typ,"|");

    $business_typ = str_replace("_"," and ",$business_typ);

    $business_typ = explode("|",$business_typ);

    if($logo_img_id!="" && $logo_img_id>0){

        $img = wp_get_attachment_image_src( $logo_img_id, 'full'  );

        $main_img_src = $img[0];
    }

    $name = stripslashes($name);  

    $the_social_widget = "";

    $social_array = explode("|",$social);

    if(count($social)>0){

        list($n,$tw) = explode("^",$social_array[1]);
        list($n,$fb) = explode("^",$social_array[2]);
        list($n,$gp) = explode("^",$social_array[3]);
        list($n,$li) = explode("^",$social_array[4]);
        list($n,$in) = explode("^",$social_array[5]);
        list($n,$yt) = explode("^",$social_array[6]);

        if($tw!="" ||$fb!="" ||$gp!="" ||$li!="" ||$in!="" ||$yt!=""){

            $the_social_widget = "<ul class='social-list'>";

            $tw = str_replace("@","",$tw);

            if($tw!=""){
                $the_social_widget .="<li class='fa tw'><a href='https://twitter.com/".$tw."' alt='Twitter @".$tw."' target='_blank'></a></li>";
            }
            if($fb!=""){
                $the_social_widget .="<li class='fa fb'><a href='".$fb."' alt='Facebook' target='_blank'></a></li>";
            }
            if($gp!=""){
                $the_social_widget .="<li class='fa gp'><a href='".$gp."' alt='Google+' target='_blank'></a></li>";
            }
            if($li!=""){
                $the_social_widget .="<li class='fa li'><a href='".$li."' alt='LinkedIn' target='_blank'></a></li>";
            }
            if($in!=""){
                $the_social_widget .="<li class='fa in'><a href='".$in."' alt='Instagram' target='_blank'></a></li>";
            }
            if($yt!=""){
                $the_social_widget .="<li class='fa yt'><a href='".$yt."' alt='YouTube' target='_blank'></a></li>";
            }

            $the_social_widget .= "<ul>";

        }

    }

    $the_slideshow_widget = "";

    $imgs_array = explode(":",$imgs);

    if($imgs!="" && count($imgs_array)>0){
        wp_enqueue_script(
            'wpbdf-slideshow',
           $wpbdf_slideshow_js,
            array( 'jquery' )
        );
        wp_enqueue_style('wpbdf-slideshow-css',$wpbdf_slideshow_css); 
        $the_slideshow_widget = wpbdf_createSlideshow($imgs_array);
    }

    $types = wpdbf_stringify_typs(implode("|",$business_typ),true,"../");
    $cats = wpdbf_stringify_cats(implode("|",$cat),true,"../");

    if('' != locate_template( 'wpbdf/wpbdf-business-details-page.php' ) ){
        include(get_template_directory() . '/wpbdf/wpbdf-business-details-page.php');
    }else{
        include($wpbdf_business_details_page);
    }
    
}



//Get results of search
function wpbdf_getResults($page,$amt){

        global $wpdb;
        global $wpbdf_listings_db;
        $lat = floatval(stripslashes(sanitize_text_field($_REQUEST['_lat'])));
        $lng = floatval(stripslashes(sanitize_text_field($_REQUEST['_lng'])));
        $rad = intval(stripslashes(sanitize_text_field($_REQUEST['_radius'])));
        $tcp = stripslashes(sanitize_text_field($_REQUEST['_tcp']));
        $typ = stripslashes(sanitize_text_field($_REQUEST['_typ']));
        $country = stripslashes(sanitize_text_field($_REQUEST['_country']));
        $order = stripslashes(sanitize_text_field($_REQUEST['_order']));
        if(stripslashes(sanitize_text_field($_REQUEST['_ascdesc']))=="asc"){
            $ascdesc = "asc";
        }else if(stripslashes(sanitize_text_field($_REQUEST['_ascdesc']))=="desc"){
            $ascdesc = "desc";
        }else{
            $ascdesc = "";
        }

    
        //categories            
        $_cat = "";
        $_catbits = "";
        $_cat_arr = array();
        if(@$_REQUEST['_cat']!=""){
            $_cat = " AND (";
            //Note below we are using "OR". We can swap this to "AND" to ensure that only those with EVERY category the user has requested is returned.
            $_Cat = stripslashes(sanitize_text_field($_REQUEST['_cat']));
            foreach($_Cat as $c){
                $_catbits .= "a._cat LIKE %s OR ";
                $_cat_arr[] = '%|'.$c.'|%';
            }
            $_catbits = rtrim($_catbits," OR ");
            $_cat .= $_catbits." ) ";
        }

        //order
        if($order != "name" && $order != "distance" && $order != "latest"){
            $order = "id";
        }else if($order == "distance" && ($tcp=="" || $lat=="" || $lng == "") ){
            $order = "id";
        }else if($order == "name"){
            $order = "_name";
        }else if($order == "latest"){
            $order = "id";
        }

        if($ascdesc!="asc"){
            $ascdesc = "desc";
        }else{
            $ascdesc = "asc";
        }



        $start=(($page-1)*$amt);

        $arr = array();
        // Search the rows in the listings table

        if($tcp=="" || $lat=="" || $lng == ""){

            if($typ != ""){
                
                $arrs = array('%|'.$typ.'|%');

                if($arrs)
                
                foreach($_cat_arr as $ca){
                    $arrs[] = $ca;
                }

                
                $totalsql = "SELECT COUNT(a.id) as cnt FROM {$wpbdf_listings_db} a WHERE a._active = 1 AND a._typ LIKE %s ".$_cat;
                
                $sql = "SELECT a.id,a._address,a._postcode,a._country,a._name,a._lat,a._lng,a._typ,a._cat,a._imgid FROM {$wpbdf_listings_db} a WHERE a._active = 1 AND a._typ LIKE %s ".$_cat;
                
                if($country!=""){
                    $totalsql .= " AND a._country = %s";
                    $sql .= " AND a._country = %s";
                    $arrs[] = $country;
                } 

                $sql .= " ORDER BY $order $ascdesc LIMIT $start,$amt;";
                
                $totalarrs = $arrs;
                
            }else{

                $arrs = array();

                foreach($_cat_arr as $ca){
                    $arrs[] = $ca;
                }

                $totalsql = "SELECT COUNT(a.id) as cnt FROM {$wpbdf_listings_db} a WHERE a._active = 1 ".$_cat; 
                
                $sql = "SELECT a.id, a._address, a._postcode, a._country, a._name, a._lat, a._lng, a._typ, a._cat,a._imgid FROM {$wpbdf_listings_db} a WHERE a._active = 1 ".$_cat;

                if($country!=""){

                    $totalsql .= " AND a._country = %s";

                    $sql .= " AND a._country = %s ";

                    $arrs[] = $country;
                }

                $totalarrs = $arrs;

                $sql .= " ORDER BY $order $ascdesc LIMIT $start,$amt;";
            }

        }else{


            if($typ != ""){

                $totalarrs = array('%|'.$typ.'|%',$lat,$lng,$lat,$rad);//,$country

                $arrs = array($lat,$lng,$lat,'%|'.$typ.'|%');//,$rad,$country

                foreach($_cat_arr as $ca){
                    $arrs[] = $ca;
                    $totalarrs[] = $ca;
                }

                $totalsql = "SELECT COUNT(a.id) AS cnt,a._lng,a._lat FROM {$wpbdf_listings_db} a WHERE a._active = 1 AND a._typ LIKE %s AND ( 3959 * acos( cos( radians(%f ) ) * cos( radians( a._lat ) ) * cos( radians( a._lng ) - radians(%f ) ) + sin( radians(%f) ) * sin( radians( a._lat ) ) ) )< %d  ".$_cat;
               
                $sql = "SELECT a.id, a._address, a._postcode, a._country, a._name, a._lat, a._lng, a._typ, a._cat,a._imgid, ( 3959 * acos( cos( radians(%f ) ) * cos( radians( a._lat ) ) * cos( radians( a._lng ) - radians(%f ) ) + sin( radians(%f) ) * sin( radians( a._lat ) ) ) ) AS _distance FROM {$wpbdf_listings_db} a WHERE a._active = 1 AND a._typ LIKE %s";

                if($country!=""){

                    $totalsql .= " AND a._country = %s";

                    $sql .= " AND a._country = %s";

                    $arrs[] = $country;

                    $totalarrs[] = $country;

                }

                $arrs[] = $rad;

                $sql .= " HAVING _distance < %d ".$_cat." ORDER BY $order $ascdesc LIMIT $start,$amt;";

            }else{
                $arrs = array($lat,$lng,$lat);//,$rad),$country
                $totalarrs = array($lat,$lng,$lat,$rad);//,$country
                foreach($_cat_arr as $ca){
                    $arrs[] = $ca;
                    $totalarrs[] = $ca;
                }
                
                
                $totalsql = "SELECT COUNT(a.id) AS cnt, a._lng,a._lat FROM {$wpbdf_listings_db} a WHERE a._active = 1 AND ( 3959 * acos( cos( radians(%f ) ) * cos( radians( a._lat ) ) * cos( radians( a._lng ) - radians(%f ) ) + sin( radians(%f) ) * sin( radians( a._lat ) ) ) ) < %d ".$_cat;
                
                $sql = "SELECT a.id, a._address, a._postcode, a._country, a._name, a._lat, a._lng, a._typ, a._cat,a._imgid,  ( 3959 * acos( cos( radians(%f ) ) * cos( radians( a._lat ) ) * cos( radians( a._lng ) - radians(%f ) ) + sin( radians(%f) ) * sin( radians( a._lat ) ) ) ) AS _distance FROM {$wpbdf_listings_db} a WHERE a._active = 1";

                if($country!=""){

                    $totalsql .= " AND a._country = %s";

                    $sql .= " AND a._country = %s";

                    $arrs[] = $country;
                    
                    $totalarrs[] = $country;

                }

                $arrs[] = $rad;

                $sql .= " HAVING _distance < %d ".$_cat." ORDER BY $order $ascdesc LIMIT $start,$amt";

            }
        }

        $restot = $wpdb->get_row($wpdb->prepare($totalsql, $totalarrs));
        $t = $restot->cnt;


        $res = $wpdb->get_results($wpdb->prepare($sql, $arrs));

        foreach ( $res as $row ){

            $typ = ltrim($row->_typ,"|");

            $typ = str_replace("_"," and ",$typ);

            $cat = ltrim($row->_cat,"|");

            $cat = str_replace("_"," and ",$cat);

            array_push($arr, array(
                    "name" => stripslashes($row->_name),
                    "address" => stripslashes($row->_address),
                    "postcode" => $row->_postcode,
                    "country" => $row->_country,
                    "lat" => $row->_lat,
                    "lng" => $row->_lng,
                    "distance" => $row->_distance,
                    "typ" => $typ,
                    "cat" => $cat,
                    "id" => $row->id,
                    "t" => $t,
                    "_imgid" => $row->_imgid
            ));
        }
        if(count($arr) > 0){
            return($arr);
        }else{
            return null;
        }

}

//Get localised results based on inputted data


function wpbdf_getNearby(){

    //must come via ajax, otherwise ignore
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

        global $wpdb;
        global $wpbdf_listings_db;

        $lat = floatval(stripslashes(sanitize_text_field($_POST['lat'])));
        $lng = floatval(stripslashes(sanitize_text_field($_POST['lng'])));
        $rad = intval(stripslashes(sanitize_text_field($_POST['rad'])));
        $tcp = (sanitize_text_field($_POST['tcp']));
        $typ = (sanitize_text_field($_POST['typ']));
        $country = (sanitize_text_field($_POST['country']));

        $page = intval(sanitize_text_field($_POST['page']));
        $amt = intval(sanitize_text_field($_POST['amt']));

  

        $start=($page*$amt);

        if($tcp==""){
            $rad = 2500;
        }

        $arr = array();

        // Search the rows in the listings table

        $typtxt ="";

        $arrs = array($lat,$lng,$lat,$country,$rad);

        if($typ != ""){

            $typtxt =" and _typ = %s";

            $arrs = array($lat,$lng,$lat,$typ,$country,$rad);

        }

        $sql = "SELECT id, _address, _postcode, _country, _name, _lat, _lng, _typ, _cat, ( 3959 * acos( cos( radians(%f       ) ) * cos( radians( _lat ) ) * cos( radians( _lng ) - radians(%f       ) ) + sin( radians(%f       ) ) * sin( radians( _lat ) ) ) ) AS _distance FROM {$wpbdf_listings_db} WHERE _active = 1 ".$typtxt." AND _country = %s HAVING _distance < %d ORDER BY _distance ASC LIMIT $start,$amt";

        $res = $wpdb->get_results($wpdb->prepare($sql, $arrs));

       foreach ( $res as $row ){

            $typ = ltrim($row->_typ,"|");

            $typ = str_replace("_"," and ",$typ);

            $cat = ltrim($row->_cat,"|");

            $cat = str_replace("_"," and ",$cat);

            array_push($arr, array(
                    "name" => stripslashes($row->_name),
                    "address" => stripslashes($row->_address),
                    "postcode" => $row->_postcode,
                    "country" => $row->_country,
                    "lat" => $row->_lat,
                    "lng" => $row->_lng,
                    "distance" => $row->_distance,
                    "typ" => $typ,
                    "cat" => $cat,
                    "id" => $row->id
            ));
        }

        if(count($arr) > 0){
            echo json_encode($arr);
        }else{
            echo "[]";
        }

    }else{
        echo "0";
    }

    exit();

}


//Convert list of business categories to string
//NOTE we remove type from the list here, as the user may get confused when we refine the search based on categories and type still remain from the previous search
//We can put this back in by cuncommenting the lines below
function wpdbf_stringify_cats($cats,$clickable,$url){

    $html = "";
    $comma="";
    $_amt=intval(sanitize_text_field($_GET['_amt']));

    $_tcp = sanitize_text_field($_GET['_tcp']);
    $_country = sanitize_text_field($_GET['_country']);
    $_search = sanitize_text_field($_GET['_search']);

    $cats = explode("|",$cats);

   //get ALL cats
   $taxonomy = 'business-cat-free';
   $term_args=array(
   'hide_empty' => false,
   'order' => 'ASC'
   );
   $business_cats=get_terms($taxonomy,$term_args); 

    if(count($cats)>0 && $cats[0]!=""){
        foreach($cats as $cat){
            if($cat!=""){

                if(!$clickable){
                    $html.=$comma.$cat;
                }else{
                    foreach ($business_cats as $tax ) {
                       if($tax->slug == $cat){
                          $cat_name = $tax->name;
                        }
                    }
                    $html.=$comma."<a href='".$url."?_tcp=".$_tcp."&_country=".$_country."&amt=".$_amt."&_cat[]=".$cat."&_search=1'>".$cat_name."</a>";
                }
                $comma=', ';

            }
        }
    }
    return $html;

}


//Convert list of business types to string
//NOTE we remove categories from the list here, as the user may get confused when we refine the search based on type and categories still remain from the previous search
//We can put this back in by cuncommenting the lines below
function wpdbf_stringify_typs($typs,$clickable,$url){

    $html = "";
    $comma="";
    $_tcp=esc_html(stripslashes($_GET['_tcp']));
    $_country=esc_html(stripslashes($_GET['_country']));
    $_amt=intval($_GET['_amt']);
    $_search=esc_html(stripslashes($_GET['_search']));

    $typs = explode("|",$typs);


    //get ALL types
    $taxonomy = 'business-type-free';
    $term_args=array(
     'hide_empty' => false,
     'order' => 'ASC'
    );
    $business_types=get_terms($taxonomy,$term_args); 

    foreach($typs as $typ){
            if($typ!=""){
                if(!$clickable){
                    $html.=$comma.$typ;
                }else{
                                      foreach ($business_types as $tax ) {
                       if($tax->slug == $typ){
                          $type_name.= $tax->name;
                        }
                    }
                    $html.=$comma."<a href='".$url."?_typ=".$typ."&_tcp=".$_tcp."&_country=".$_country."&amt=".$_amt."&_search=1'>".$type_name."</a>";
                }
                $comma=', ';
            }
    }
    return $html;

}

//Render logo
function wpbdf_createLogo($imgid){

    $img = wp_get_attachment_image_src( $imgid, 'original');

    return $img[0];

}



?>