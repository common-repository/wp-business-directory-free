<?php 
/*-------------------------------Admin functions------------------------------*/


//hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'wpbdf_create_businessdirectory_hierarchical_taxonomy', 0 );

//create a custom taxonomy name it topics for your posts
function wpbdf_create_businessdirectory_hierarchical_taxonomy() {

// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI

  $labels = array(
    'name' => _x( 'Business Types', 'taxonomy general name' ),
    'singular_name' => _x( 'Business Type', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Business Types' ),
    'all_items' => __( 'All Business Types' ),
    'parent_item' => __( 'Parent Business Type' ),
    'parent_item_colon' => __( 'Parent Business Type:' ),
    'edit_item' => __( 'Edit Business Type' ), 
    'update_item' => __( 'Update Business Type' ),
    'add_new_item' => __( 'Add New Business Type' ),
    'new_item_name' => __( 'New Business Type Name' ),
    'menu_name' => __( 'Business Types' ),
  );    

 // Now register the taxonomy

  register_taxonomy('business-type-free','wpbdf', array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_in_menu'  => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'business-type-free' ),
  ));

  //repeat for business categories
  $labels = array(
    'name' => _x( 'Business Categories', 'taxonomy general name' ),
    'singular_name' => _x( 'Business Category', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Business Categories' ),
    'all_items' => __( 'All Business Categories' ),
    'parent_item' => __( 'Parent Business Category' ),
    'parent_item_colon' => __( 'Parent Business Category:' ),
    'edit_item' => __( 'Edit Business Category' ), 
    'update_item' => __( 'Update Business Category' ),
    'add_new_item' => __( 'Add New Business Category' ),
    'new_item_name' => __( 'New Business Category Name' ),
    'menu_name' => __( 'Business Categories' ),
  );    

 // Now register the taxonomy

  register_taxonomy('business-cat-free','wpbdf', array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_in_menu'  => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'business-cat-free' ),
  ));

}



add_action( 'admin_menu', 'wpbdf_admin_menu' );
function wpbdf_admin_menu() {
	add_menu_page('WPBD Pro', 'WPBD Free',  'edit_pages', 'wpbdf', 'wpbdf_view_entries', 'dashicons-location-alt', 11  );
	add_submenu_page( 'wpbdf', 'Businesses', 'Businesses', 'edit_pages', 'wpbdf_view_entries', 'wpbdf_view_entries');
    add_submenu_page( 'wpbdf', 'Add New Business', 'Add New Business', 'edit_pages', 'wpbdf_add_business', 'wpbdf_add_business');
    add_submenu_page( 'wpbdf', 'Business Types', 'Business Types', 'edit_pages', 'edit-tags.php?taxonomy=business-type-free',false );
    add_submenu_page( 'wpbdf', 'Business Categories', 'Business Categories', 'edit_pages', 'edit-tags.php?taxonomy=business-cat-free',false );
    add_submenu_page( 'wpbdf', 'Email Options', 'Email Options', 'edit_posts', 'wpbdf_email_options', 'wpbdf_email_options'  );
    add_submenu_page( 'wpbdf', 'Settings', 'Settings', 'edit_posts', 'wpbdf_settings', 'wpbdf_settings'  );
    add_submenu_page( 'wpbdf', 'Custom Theme Files', 'Custom Theme Files', 'edit_posts', 'wpbdf_custom_theme', 'wpbdf_custom_theme'  );
    add_submenu_page( 'wpbdf', 'Tutorials', 'Tutorials', 'edit_posts', 'wpbdf_tutorials', 'wpbdf_tutorials'  );
    add_submenu_page( 'wpbdf', 'Support', 'Support', 'edit_posts', 'wpbdf_support', 'wpbdf_support'  );

    add_submenu_page( 'null', 'Remove Business', 'Remove Business', 'edit_pages', 'wpbdf_remove_business_page', 'wpbdf_remove_business_page');
    add_submenu_page( 'null', 'Edit Business', 'Edit Business', 'edit_pages', 'wpbdf_edit_business', 'wpbdf_edit_business');
    add_submenu_page( 'null', 'Activate Business', 'Activate Business', 'edit_pages', 'wpbdf_act_business', 'wpbdf_act_business');
    add_submenu_page( 'null', 'Deactivate Business', 'Deactivate Business', 'edit_pages', 'wpbdf_deact_business', 'wpbdf_deact_business');
    
}


function wpbdf_tutorials(){
    global $wpbdf_version; 
    wp_enqueue_style('font-awesome-min', plugins_url('../css/font-awesome.min.css',__FILE__));  
    wp_enqueue_style('admin-min-css', plugins_url( '../css/admin.css' , __FILE__ ));
    $html = "<div class='admin-padd'><div class='admin-header'><div class='admin-header-left'><img src='".plugin_dir_url(dirname(__FILE__))."/img/logo_small.png' alt='WP Business Directory FREE Admin'/></div><div class='admin-header-right'><div class='title'>Tutorials</div></div><div class='admin-header-right-ad'><div style='width:50%;vertical-align:top;-webkit-box-sizing: border-box;moz-box-sizing: border-box;box-sizing: border-box;display:inline-block;margin:auto;'><strong>READY TO GO PRO?</strong><br>- Tiered Subscription System<br>- Google friendly Ratings<br>- User Reviews<br>- Bulk Importing<br>- User Ownership / Claiming<br>- More Business Options</div><div style='width:50%;vertical-align:top;text-align:center;-webkit-box-sizing: border-box;moz-box-sizing: border-box;box-sizing: border-box;display:inline-block;margin:auto;'><strong>LOWEST EVER PRICE!</strong><br><br><a href='http://www.wpbusinessdirectorypro.com' class='button button-orange' style='height:auto;' target='_blank'><span class='fa' style='font-size:2em;padding-top:10px;'></span><br>GET WPBD PRO</a></div></div><div class='clear'></div></div><div class='wrap'><p>All tutorials and guidelines can be found on our main website at www.wpbusinessdirectorypro.com. Tutorials for the FREE and PRO version of the plug-in can be found on our main website at www.wpbusinessdirectorypro.com.<Br>Click the button below to open the tutorials section in a new page.</p><p><a href='http://www.wpbusinessdirectorypro.com/tutorial/' target='_blank' class='button button-primary'>View Tutorial Page</a></p></div><div class='admin-footer'><div class='admin-footer-left'>WP Business Directory FREE <strong>v1.0</strong></div><div class='admin-footer-right'>For more information, or to visit our support forum visit <a href='http://www.wpbusinessdirectorypro.com' target='_blank' style='color:#6ca23a;'>www.wpbusinessdirectorypro.com</a></div></div></div>";
    echo $html;
}

function wpbdf_support(){
    global $wpbdf_version;
    wp_enqueue_style('font-awesome-min', plugins_url('../css/font-awesome.min.css',__FILE__));  
    wp_enqueue_style('admin-min-css', plugins_url( '../css/admin.css' , __FILE__ ));
    $html = "<div class='admin-padd'><div class='admin-header'><div class='admin-header-left'><img src='".plugin_dir_url(dirname(__FILE__))."/img/logo_small.png' alt='WP Business Directory FREE Admin'/></div><div class='admin-header-right'><div class='title'>Settings</div></div><div class='admin-header-right-ad'><div style='width:50%;vertical-align:top;-webkit-box-sizing: border-box;moz-box-sizing: border-box;box-sizing: border-box;display:inline-block;margin:auto;'><strong>READY TO GO PRO?</strong><br>- Tiered Subscription System<br>- Google friendly Ratings<br>- User Reviews<br>- Bulk Importing<br>- User Ownership / Claiming<br>- More Business Options</div><div style='width:50%;vertical-align:top;text-align:center;-webkit-box-sizing: border-box;moz-box-sizing: border-box;box-sizing: border-box;display:inline-block;margin:auto;'><strong>LOWEST EVER PRICE!</strong><br><br><a href='http://www.wpbusinessdirectorypro.com' class='button button-orange' style='height:auto;' target='_blank'><span class='fa' style='font-size:2em;padding-top:10px;'></span><br>GET WPBD PRO</a></div></div><div class='clear'></div></div><div class='wrap'><p>Support for both the FREE and PRO versions can be found on our main website at www.wpbusinessdirectorypro.com.<br>Click the button below to open the support section in a new page.</p><p><a href='http://www.wpbusinessdirectorypro.com/support/' target='_blank' class='button button-primary'>View Support Page</a></p></div><div class='admin-footer'><div class='admin-footer-left'>WP Business Directory FREE <strong>v{$wpbdf_version}</strong></div><div class='admin-footer-right'>For support, or to review benefits of the PRO version visit <a href='http://www.wpbusinessdirectorypro.com' target='_blank' style='color:#6ca23a;'>www.wpbusinessdirectorypro.com</a></div></div></div>";
    echo $html;
}

function wpbdf_custom_theme(){
    global $wpbdf_version; 
    wp_enqueue_style('font-awesome-min', plugins_url('../css/font-awesome.min.css',__FILE__));  
    wp_enqueue_style('admin-min-css', plugins_url( '../css/admin.css' , __FILE__ ));
    global $pluginpath;
    $pluginpath = rtrim(plugin_dir_path(__FILE__ ),"functions/")."//template/";
    include( plugin_dir_path( __FILE__ ) . '../admin/wpbdf-view-custom-theme-files.php');
}


//Admin - Show all businesses in a list
function wpbdf_view_entries(){ 
    global $wpdb;
    global $wpbdf_listings_db;
    global $wpbdf_version;
    wp_enqueue_style('font-awesome-min', plugins_url('../css/font-awesome.min.css',__FILE__));  
    wp_enqueue_script( 'all-businesses-min', plugins_url( '../js/view-all-script.js' , __FILE__ ), array('jquery'), '1.0.0', true );
    wp_enqueue_style('admin-min-css', plugins_url( '../css/admin.css' , __FILE__ ));
    include( plugin_dir_path( __FILE__ ) . '../admin/wpbdf-view-all-businesses.php');
}


//Admin - create new business
function wpbdf_add_business(){ 
    global $wpdb;
    global $wpbdf_bands;
    global $wpbdf_version;
    wp_enqueue_media();
    echo "<script>var ajaxurl = '".admin_url('admin-ajax.php')."';</script>";
    wp_enqueue_style('font-awesome-min', plugins_url('../css/font-awesome.min.css',__FILE__));  
    wp_enqueue_script( 'new-edit-business-min', plugins_url( '../js/create-edit-business-script.js' , __FILE__ ), array('jquery'), '1.0.0', true );
    wp_enqueue_script( 'media-library-popup-min', plugins_url( '../js/media-library-popup.js' , __FILE__ ), array('jquery'), '1.0.0', true );
    echo "<script>document.set_to_post_id = ".get_option( 'media_selector_attachment_id', 0 )."</script>";
    wp_enqueue_style('admin-min-css', plugins_url( '../css/admin.css' , __FILE__ ));
    include( plugin_dir_path( __FILE__ ) . '../admin/wpbdf-create-business-admin.php');
}


//Admin - edit business
function wpbdf_edit_business(){      
    global $wpdb;
    global $wpbdf_bands;
    global $wpbdf_version;
    wp_enqueue_media();
    echo "<script>var ajaxurl = '".admin_url('admin-ajax.php')."';</script>";
    wp_enqueue_style('font-awesome-min', plugins_url('../css/font-awesome.min.css',__FILE__));  
    wp_enqueue_script( 'new-edit-business-min', plugins_url( '../js/create-edit-business-script.js' , __FILE__ ), array('jquery'), '1.0.0', true );
    wp_enqueue_script( 'media-library-popup-min', plugins_url( '../js/media-library-popup.js' , __FILE__ ), array('jquery'), '1.0.0', true );
    echo "<script>document.set_to_post_id = ".get_option( 'media_selector_attachment_id', 0 )."</script>";
    wp_enqueue_style('admin-min-css', plugins_url( '../css/admin.css' , __FILE__ ));
    include( plugin_dir_path( __FILE__ ) . '../admin/wpbdf-edit-business-admin.php');
}



//Admin - view general settings
function wpbdf_settings(){  
    global $wpdb;
    global $wpbdf_version;
    wp_enqueue_style('font-awesome-min', plugins_url('../css/font-awesome.min.css',__FILE__));  
    wp_enqueue_style('admin-min-css', plugins_url( '../css/admin.css' , __FILE__ ));
    wp_enqueue_script( 'settings-min', plugins_url( '../js/settings-script.js' , __FILE__ ), array('jquery'), '1.0.0', true );
    include( plugin_dir_path( __FILE__ ) . '../admin/wpbdf-settings.php');
}


//Validate upload details on new business
function wpbdf_new_business_sanitation() {

    global $wpdb;
    global $wpbdf_listings_db;

    $ok = false;

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

    // if the submit button is clicked, send the email
    if ( current_user_can( 'edit_posts' )  && is_admin() && isset($_POST) && wp_verify_nonce($_POST['custom_meta_box_nonce'], 'wpbdf-safe-check-nonce')  ) {

        $ok = true;

        // sanitize form values
        $name = sanitize_text_field($_POST['name']);

        $address = sanitize_textarea_field($_POST["address"]);
        
        $postcode = sanitize_text_field($_POST['postcode']);
        
        $country = sanitize_text_field($_POST['country']);
        
        $cat = sanitize_text_field($_POST['cat']);
        
        $long = floatval(sanitize_text_field($_POST['long']));
        
        $lat = floatval(sanitize_text_field($_POST['lat']));
        
        $typ = sanitize_text_field($_POST['typ']);
        
        $email = sanitize_email($_POST['email']);
        
        $tel = sanitize_text_field($_POST['tel']);      
        
        $fax = sanitize_text_field($_POST['fax']);   
        
        $website = sanitize_text_field($_POST['website']);
        
        $social = sanitize_text_field($_POST['social']);
        
        $imgs = "";
        
        if($_POST['business_image_1']!=""){
            $imgs.=intval(sanitize_text_field($_POST['business_image_1'])) .":";
        } 
        if($_POST['business_image_2']!=""){
            $imgs.=intval(sanitize_text_field($_POST['business_image_2'])) .":";
        } 
        if($_POST['business_image_3']!=""){
            $imgs.=intval(sanitize_text_field($_POST['business_image_3'])) .":";
        } 
        if($_POST['business_image_4']!=""){
            $imgs.=intval(sanitize_text_field($_POST['business_image_4'])) .":";
        } 
        if($_POST['business_image_5']!=""){
            $imgs.=intval(sanitize_text_field($_POST['business_image_5'])) .":";
        }

        //$desc = wp_kses($_POST["desc"],$goodhtml);    
        
        $desc = $_POST['desc'];/*sanitize_text_field($_POST['desc']); */
      
        if($_POST['act']==1){
            $active = 1;
        }else{
            $active = 0;
        }

        if(isset($_POST['business_logo'])){
            $imgid = intval($_POST['business_logo']);
        }else{
            $imgid = 0;  
        }

               
        $data = array(
                '_name' => $name,
                '_address' => $address,
                '_postcode' => $postcode,
                '_country' => $country,
                '_cat' => $cat,
                '_imgid' => $imgid,
                '_images' => $imgs,
                '_lng'    => $long,
                '_lat'    => $lat,
                '_desc' => $desc,
                '_website' => $website,
                '_email' => $email,
                '_tel' => $tel,
                '_fax' => $fax,
                '_typ' => $typ,
                '_active'    => $active,
                '_social' => $social,
                '_update' => current_time( 'mysql' )
        );
        
        $format = array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%f',
                '%f',
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
        }

    }

    return $ok;
}


//edit business details
function wpbdf_edit_business_sanitation(){

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
        'i' => array(),
        'ul' => array(),
        'b' => array(),
        'hr' => array(),
        'strong' => array(),
    );

    $ok = true;

     // if the submit button is clicked, send the email
    if ( current_user_can( 'edit_posts' )  && is_admin() && @$_POST['formtype']=="edit" && isset($_POST['id']) && wp_verify_nonce($_POST['custom_meta_box_nonce'], 'wpbdf-safe-check-nonce')  ) {
    

        // sanitize form values

        $prevact = intval( $_POST['prevact']);
        
        if( is_admin() && @$_POST['act']==1){
            $active = 1;
        }else if( is_admin() && @$_POST['act']==2){
            $active = 2;
        }else{$active=0;}      

       
        if(isset($_POST['business_logo'])){
            $imgid = intval($_POST['business_logo']);
        }else{
            $imgid = 0;  
        }


        $name = sanitize_text_field($_POST['name']);

        $address = sanitize_textarea_field($_POST["address"]);
        
        $postcode = sanitize_text_field($_POST['postcode']);
        
        $country = sanitize_text_field($_POST['country']);
        
        $cat = sanitize_text_field($_POST['cat']);

        mail("jamestibbles.jt@gmail.com","cats are".$cat);
        
        $long = floatval(sanitize_text_field($_POST['long']));
        
        $lat = floatval(sanitize_text_field($_POST['lat']));
        
        $typ = sanitize_text_field($_POST['typ']);
        
        $email = sanitize_email($_POST['email']);
        
        $tel = sanitize_text_field($_POST['tel']);      
        
        $fax = sanitize_text_field($_POST['fax']);   
        
        $website = sanitize_text_field($_POST['website']);
        
        $social = sanitize_text_field($_POST['social']);
        
        $imgs = "";

        if($_POST['business_image_1']!=""){
            $imgs.=intval(sanitize_text_field($_POST['business_image_1'])) .":";
        } 
        if($_POST['business_image_2']!=""){
            $imgs.=intval(sanitize_text_field($_POST['business_image_2'])) .":";
        } 
        if($_POST['business_image_3']!=""){
            $imgs.=intval(sanitize_text_field($_POST['business_image_3'])) .":";
        } 
        if($_POST['business_image_4']!=""){
            $imgs.=intval(sanitize_text_field($_POST['business_image_4'])) .":";
        } 
        if($_POST['business_image_5']!=""){
            $imgs.=intval(sanitize_text_field($_POST['business_image_5'])) .":";
        }

        //$desc = wp_kses($_POST["desc"],$goodhtml);
        $desc = $_POST['desc'];//sanitize_text_field($_POST['desc']); 

        if(isset($_POST['business_logo'])){
            $imgid = intval(sanitize_text_field($_POST['business_logo']));
        }else{
            $imgid = 0;  
        }

               
        $data = array(
                '_name' => $name,
                '_address' => $address,
                '_postcode' => $postcode,
                '_country' => $country,
                '_cat' => $cat,
                '_imgid' => $imgid,
                '_images' => $imgs,
                '_lng'    => $long,
                '_lat'    => $lat,
                '_active'    => $active,
                '_tel' => $tel,
                '_fax' => $fax,
                '_desc' => $desc,                
                '_website' => $website,
                '_email' => $email,
                '_typ' => $typ,
                '_social' => $social,
                '_update' => current_time( 'mysql' )
        );
        
        $format = array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%f',
                '%f',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s'
        );

        global $wpbdf_listings_db;
        
        $success=$wpdb->update( 

                $wpbdf_listings_db, 
                $data, 
                array( 'id' => intval($_POST['id'] )), 
                $format, 
                array( '%d' ) 
        );

        // Print last SQL query Error
        echo $wpdb->last_error;      

        if(!$success){
                $ok = false;
        }


        if($ok){

            //If status is different from old status, update status
            if( $prevact != $active ){
                wpbdf_status_business(intval( $_POST['id']),$active);
            }

            
            if($prevact ==3){

                //If previous status = completely new business
                wpbdf_moderate_response("new",$name,$email,$active);

            }else if($prevact ==2 && ($active ==1 || $active ==0) ){

                //If previous status was not yet modified and new status is active
                wpbdf_moderate_response("edit",$name,$email,$active);

            }else if( ($prevact ==1 && $active==0) || ($prevact ==0 && $active==1) ){

                //If previous status was active and now it is deactivated, or previous status was deactivated and now it is activated
                wpbdf_activate_response($name,$email,$active);

            }
            //If prevact = 2 and it is not still 2 then there is no email sent out, and it remains in "not yet modified" mode. This is so user can make amends to the account without making a decision on active status, therefore the user isn't bombarded with emails when changes are made by the admin
        }

    }

    return $ok;

}

?>