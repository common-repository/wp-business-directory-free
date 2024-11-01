<?php
/*Initial setup and preparation*/

global $wpdb;
global $wpbdf_settings;
global $wpbdf_listings_db;
global $wpbdf_postcode_recycle;
global $wpbdf_emailer;

$wpbdf_settings = $wpdb->prefix . 'wpbdf_settings';
$wpbdf_listings_db = $wpdb->prefix . 'wpbdf_listings';
$wpbdf_postcode_recycle = $wpdb->prefix . 'wpbdf_postcode_recycle';
$wpbdf_emailer = $wpdb->prefix . 'wpbdf_emailer';

add_image_size( 'bd-thumbnail', 400, 300, true );
add_image_size( 'bd-logo-small', 130, 130, true );



function wpbdf_install(){

    global $wpdb;
    global $wpbdf_listings_db;
    global $wpbdf_postcode_recycle;
    global $wpbdf_settings;
    global $wpbdf_emailer;
    global $data;

    $create_initial_emails = false; 
    $create_initial_settings = false;

    $sql="";

    if($wpdb->get_var("show tables like '$wpbdf_settings'") != $wpbdf_settings) 
    {

        $sql .= "CREATE TABLE " . $wpbdf_settings . " (
            `id` int(3) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `_google_api` varchar(100) NOT NULL,
            `_google_map` int(1) NOT NULL DEFAULT '0',
            `_google_dir` int(1) NOT NULL DEFAULT '0',
            `_admin_email` varchar(75) NOT NULL,
            `_tcs` TEXT NOT NULL,
            `_timezone` varchar(100) NOT NULL,
            `_dateformat` varchar(10) NOT NULL,
            `_page_ids` TEXT NOT NULL,
            `_update` datetime NOT NULL
        ) ENGINE=MYISAM;";

        $create_initial_settings = true;
    }

    if($wpdb->get_var("show tables like '$wpbdf_listings_db'") != $wpbdf_listings_db) 
    {

        $sql .= "CREATE TABLE " . $wpbdf_listings_db . " (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `_cat` varchar(180) NOT NULL,
            `_name` varchar(75) NOT NULL,
            `_address` text NOT NULL,
            `_postcode` text NOT NULL,
            `_country` text NOT NULL,
            `_tel` VARCHAR(30) NOT NULL,
            `_fax` VARCHAR(30) NOT NULL,
            `_website` VARCHAR(180) NOT NULL,
            `_email` VARCHAR(180) NOT NULL,
            `_desc` TEXT NOT NULL,
            `_social` text NOT NULL,
            `_typ` VARCHAR(35) NOT NULL,
            `_imgid` int(9) NOT NULL,
            `_images` TEXT NOT NULL,
            `_lat` float(10,6) NOT NULL,
            `_lng` float(10,6) NOT NULL,
            `_active` int(1) NOT NULL DEFAULT '0',
            `_update` datetime NOT NULL
        ) ENGINE=MYISAM;";
    }

    if($wpdb->get_var("show tables like '$wpbdf_postcode_recycle'") != $wpbdf_postcode_recycle) 
    {

        $sql .= "CREATE TABLE " . $wpbdf_postcode_recycle . " (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `_address` varchar(150) NOT NULL,
            `_lat` float(20,10) NOT NULL,
            `_lng` float(20,10) NOT NULL,
            `_update` datetime NOT NULL
        ) ENGINE=MYISAM;";
      
        $sql.="ALTER TABLE `" . $wpbdf_postcode_recycle . "` ADD UNIQUE( `_lat`, `_lng`); ALTER TABLE `" . $wpbdf_postcode_recycle . "` ADD UNIQUE(`_address`);";
    }


    if($wpdb->get_var("show tables like '$wpbdf_emailer'") != $wpbdf_emailer) 
    {

        $sql .= "CREATE TABLE " . $wpbdf_emailer . " (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `_type` int(2) NOT NULL DEFAULT '0',
            `_html` int(1) NOT NULL DEFAULT '0',
            `_subject` text NOT NULL DEFAULT '',
            `_message` text NOT NULL DEFAULT '',
            `_updated` datetime NOT NULL
        ) ENGINE=MYISAM;";

        $create_initial_emails = true;
    }
    

    if($sql!=""){

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($sql);

    }

    if($create_initial_settings){


        //default fill the settings

        $data = array(
                    '_google_api'    => '',
                    '_google_map'    => 0,
                    '_google_dir'    => 0,
                    '_admin_email'   => '',
                    '_page_ids' => '',
                    '_update'        => current_time( 'mysql' )
        );
            
        $format = array(
                    '%s',
                    '%d',
                    '%d',                    
                    '%s',                   
                    '%s',
                    '%s'
        );
            
        $wpdb->insert( 
                $wpbdf_settings, 
                $data, 
                $format 
        );

    }

    //If required pages don't already exist, create them

    //First, look to see if settings already has these linked

    $searchsql = "SELECT _page_ids from {$wpbdf_settings} where id=1;";

    $pages = $wpdb->get_var($searchsql); 

    //If no pages are there, create them, and save their links in settings

    if($pages==""){

            //Create the new pages that will go with this plugin
            $newpostid1 = wpbdf_add_new_page("Business Directory", "[wpbdf-directory]", "", true, 0);

            //Create the business details page
            if($newpostid1>0){
                $newpostid2 = wpbdf_add_new_page("Business Details", "[wpbdf-directory-details]", "", false, $newpostid1);
            }

            //Create the new business entry page
            if($newpostid2>0){
                $newpostid3 = wpbdf_add_new_page("New Business", "[wpbdf-signup-page]", "", false, $newpostid1);
            }


            $data = array(
                '_page_ids' => $newpostid1.":".$newpostid2.":".$newpostid3,
                '_update' =>current_time( 'mysql' )
            );
            
            $format = array(
                    '%s',
                    '%s'
            );
        
            $success = $wpdb->update( 
                    $wpbdf_settings, 
                    $data, 
                    array( 'id' => 1 ), 
                    $format, 
                    array( '%d' )
            );
    }else{

        //If they are already in the database, check they still exist. If they don't they will need to be re-created

        $pages_array = explode(":",$pages);


        for($count = 0; $count<=2; $count++){

            if(get_permalink($pages_array[$count])==null || get_permalink($pages_array[$count])==false && get_permalink($pages_array[$count])==""){

                if($count==0){
                    $newpostid1 = wpbdf_add_new_page("Business Directory", "[wpbdf-directory]", "", true, 0);
                }else if($count==1){
                    $newpostid2 = wpbdf_add_new_page("Business Details", "[wpbdf-directory-details]", "", false, $newpostid1);
                }else if($count==2){
                    $newpostid3 = wpbdf_add_new_page("New Business", "[wpbdf-signup-page]", "", false, $newpostid1);
                }
            }else{
                if($count==0){
                    $newpostid1 = $pages_array[$count];
                }else if($count==1){
                    $newpostid2 = $pages_array[$count];
                }else if($count==2){
                    $newpostid3 = $pages_array[$count];
                }
            }

        }
        //update list in db
        $data = array(
                '_page_ids' => $newpostid1.":".$newpostid2.":".$newpostid3,
                '_update' =>current_time( 'mysql' )
        );
            
        $format = array(
                    '%s',
                    '%s'
        );
        
        $wpdb->update( 
            $wpbdf_settings,  
            $data, 
            array( 'id' => 1 ), 
            $format, 
            array( '%d' )
        );

    }

    if($create_initial_emails){

        wpbdf_init_emails();

    }


}




function wpbdf_activate(){
    //on re-activating, perform any updates here   
}


function wpdbf_url_exists($url){
    $page = get_page_by_path($url);
    return $page;

}

//This will create the page
function wpbdf_add_new_page($title, $content, $template_file, $visible, $post_parent = 0) {

        $post = array();                                                 
        $post['post_title'] = $title;                                    
        $post['post_content'] = $content;                                
        $post['post_parent'] = $post_parent;                             
        $post['post_status'] = 'publish'; // Can be 'draft' / 'private' / 'pending' / 'future'
        $post['post_author'] = 1; // This should be the id of the admin.
        $post['post_type'] = 'page';
        $post_id = wp_insert_post($post);

        if(!$visible) update_post_meta( $post_id, '_visibility', 'hidden' ); //stops the menu being seen in a menu
                                              
        return $post_id;
}


add_action( 'admin_enqueue_scripts', 'wpbdf_media_enqueue' );
function wpbdf_media_enqueue($hook) {
    try{
        wp_enqueue_media();
    }catch(Exception $e){
    }
}


 
/**
 * Runs only when the plugin is activated.
 * @since 0.1.0
 */
function wpbdf_admin_notice_example_activation_hook() {
 
    /* Create transient data */
    set_transient( 'wpbdf-admin-notice-welcome', true, 5 );
}
 
 
/**
 * Admin Notice on Activation.
 * @since 0.1.0
 */
function wpbdf_admin_notice_example_notice(){

    if( get_transient( 'wpbdf-admin-notice-welcome' ) ){
        ?><style>
            .admin-header{padding:10px;}
            .admin-header .admin-header-right .title {
                font-size: 3em;
                font-weight: 300;
                padding: 20px 0 20px 10px;
                border-left: 2px solid rgba(0, 0, 0, 0.05);
                vertical-align: middle;
                display: block;
                color: rgba(0, 0, 0, 0.55);
            }
            .admin-header .admin-header-left{
                display:inline-block;
                text-align:left;
                -webkit-box-sizing: border-box;moz-box-sizing: border-box;box-sizing: border-box;
                vertical-align:middle;
                float:left;
                width:30%;
                max-width: 240px;
            }
            .admin-header .admin-header-right{
                display:inline-block;
                text-align:left;
                -webkit-box-sizing: border-box;moz-box-sizing: border-box;box-sizing: border-box;
                padding-left:20px;
                vertical-align:middle;
                float:left;
                width:40%
            }
            .admin-header .admin-header-right-ad{
                display:inline-block;
                text-align:left;
                -webkit-box-sizing: border-box;moz-box-sizing: border-box;box-sizing: border-box;
                padding-left:20px;
                vertical-align:middle;
                float:right;
                width:30%;
                max-width: 350px;
            }
            .button-orange {
                color: #FFF !important;
                background: #FF8F00 !important;
                border-color: #DA7C00 !important
            }
        </style><div class="updated notice is-dismissible">
                <div class='admin-header'>
                    <div class='admin-header-left'>
                            <img src='<?php echo plugin_dir_url(dirname(__FILE__)); ?>img/logo_small.png' alt='WP Business Directory FREE Admin'/>
                    </div><div class='admin-header-right'>
                        <div class='title'>Installed</div>
                        <p>You're almost ready to launch. Now head over to the <a href='admin.php?page=wpbdf_settings'>SETTINGS</a> page to complete your set up.<br>
                            For more information visit the tutorial pages at <a target='_blank' href='http://www.wpbusinessdirectorypro.com/tutorial/'>www.wpbusinessdirectorypro.com/tutorial/</a>.</p>
                    </div><div class='admin-header-right-ad'>
                    <div style='width:50%;vertical-align:top;-webkit-box-sizing: border-box;moz-box-sizing: border-box;box-sizing: border-box;display:inline-block;margin:auto;'>
                        <strong>READY TO GO PRO?</strong><br>
                        - Tiered Subscription System<br>
                        - Google friendly Ratings<br>
                        - User Reviews<br>
                        - Bulk Importing<br>
                        - User Ownership / Claiming<br>
                        - More Business Options</div><div style='width:50%;vertical-align:top;text-align:center;-webkit-box-sizing: border-box;moz-box-sizing: border-box;box-sizing: border-box;display:inline-block;margin:auto;'>
                        <strong>LOWEST EVER PRICE!</strong><br><br><a href='http://www.wpbusinessdirectorypro.com' class='button button-orange' style='height:auto;' target='_blank'>GET WPBD PRO</a>
                    </div>
              </div><div class='clear'></div>
                </div>
        </div><?php
        /* Delete transient, only display this notice once. */
        delete_transient( 'wpbdf-admin-notice-welcome' );
    }
}
?>