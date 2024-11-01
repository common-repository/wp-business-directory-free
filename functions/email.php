<?php 


/*Init emails in the db*/
function wpbdf_init_emails(){

    global $wpdb,$wpbdf_emailer,$data; 
            
    $format = array('%d','%d','%s','%s','%s' );

    $wpdb->insert($wpbdf_emailer,  $data, $format);

    //new business - accepted, no membership name

    $data = array(
                    '_type'    => 1,
                    '_html' => 0,
                    '_subject' => 'Your business submission has been moderated at [website-name]',
                    '_message'    => 'Hi,
Thanks for your recent business submission \'[business-name]\'.
We are happy to inform you that your business has been accepted and added to our business directory.

Many thanks
[website-name]
[website-url]',              
                    '_updated'        => current_time( 'mysql' )
    );
            
    $wpdb->insert($wpbdf_emailer,  $data, $format);

    //new business - accepted but disabled

    $data = array(
                    '_type'    => 2,
                    '_html' => 0,
                    '_subject' => 'Your business submission has been moderated at [website-name]',
                    '_message'    => 'Hi,
Thanks for your recent business submission \'[business-name]\'.
Your business has been accepted and added to our business directory, but has been temporarily disabled. This means users cannot currently view your business details.
You will be notified once your business is enabled and live.

Many thanks
[website-name]
[website-url]',              
                    '_updated'        => current_time( 'mysql' )
    );
            
    $wpdb->insert($wpbdf_emailer,  $data, $format);

    //new business - rejected

    $data = array(
                    '_type'    => 3,
                    '_html' => 0,
                    '_subject' => 'Your business submission request has been rejected at [website-name]',
                    '_message'    => 'Hi,
Thanks for your recent business submission \'[business-name]\'.
Unfortunately your submission was rejected. For more information please contact us directly at [website-email].

Many thanks
[website-name]
[website-url]',              
                    '_updated'        => current_time( 'mysql' )
    );
            
    $wpdb->insert($wpbdf_emailer,  $data, $format);


    //Business - generic, removed

    $data = array(
                    '_type'    => 4,
                    '_html' => 0,
                    '_subject' => 'Your business has been removed from [website-name]',
                    '_message'    => 'Hi,
We are contacting you to inform you that your business \'[business-name]\' has been removed from our business directory [website-name]. For more information please contact us directly at [website-email].

Many thanks
[website-name]
[website-url]',              
                    '_updated'        => current_time( 'mysql' )
    );
            
    $wpdb->insert($wpbdf_emailer,  $data, $format);

    //Business - generic, activated

    $data = array(
                    '_type'    => 5,
                    '_html' => 0,
                    '_subject' => 'Your business has been activated at [website-name]',
                    '_message'    => 'Hi,
We are contacting you to inform you that your business \'[business-name]\' has been activated on our business directory [website-name], and can now be seen by our visitors.

Many thanks
[website-name]
[website-url]',              
                    '_updated'        => current_time( 'mysql' )
    );
            
    $wpdb->insert($wpbdf_emailer,  $data, $format);

    //Business - generic, de-activated

    $data = array(
                    '_type'    => 6,
                    '_html' => 0,
                    '_subject' => 'Your business has been de-activated at [website-name]',
                    '_message'    => 'Hi,
We are contacting you to inform you that your business \'[business-name]\' has been de-activated on our business directory [website-name]. This might be a temporary measure, and may or may not have been requested by yourself or another business.
For more information please contact us directly at [website-email].

Many thanks
[website-name]
[website-url]',              
                    '_updated'        => current_time( 'mysql' )
    );
            
    $wpdb->insert($wpbdf_emailer,  $data, $format);


}


/*Return email template*/
function wpbdf_return_email_template($type,$placeholders){

    if($placeholders){
        //return with placeholders wapped out for real deal.
        //placeholders should be an array with placeholdername and real value, ie ['website-name' => 'The website site', 'website-url'=>'www.some-url.com' ]
        global $wpdb;
        global $wpbdf_emailer;
        $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpbdf_emailer} where _type=%d",array($type) ));
        $message=$row->_message;
        $subject=$row->_subject;
        foreach($placeholders as $key=>$val){
            $message = str_replace($key,$val,$message);
            $subject = str_replace($key,$val,$subject);
        }
        $html = $row->_html;
        if($html==1){
                $message = str_replace("\n","<br>",$message);
        }else if($html==0){
                $message = str_replace("<br>","\n",$message);
        }
        return array($subject,$message,$html);
    }else{
        return null;
    }

}

//And return all
function wpbdf_return_email_templates(){
        global $wpdb;
        global $wpbdf_emailer;
        $row = $wpdb->get_results("SELECT _type,_html,_subject,_message FROM {$wpbdf_emailer} ORDER by _type ASC");
        $data = array();
        foreach($row as $r){
            $newdata = [$r->_type,$r->_html,$r->_subject,$r->_message];
            $data[] = $newdata;
        }
        return $data;

}



/*Allow the admin to change the body of the automated emails*/
function wpbdf_email_options(){

    global $ms;
    global $types;

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

    $ms=0;

   if(isset($_POST['email_nonce']) && current_user_can( 'edit_posts' )  && is_admin() && isset($_POST) && wp_verify_nonce($_POST['email_nonce'], 'wpbdf-email-nonce')  ) {
        
        //update amends
        $ok = true;
        for($i=0;isset($_POST['email_subject_'.$i]);$i++){
            if($ok){
                $data = array(
                            '_html'    =>    sanitize_email($_POST['email_type_'.$i]), 
                            '_subject'    => sanitize_text_field($_POST['email_subject_'.$i]), 
                            '_message'    => wp_kses($_POST['email_message_'.$i],$goodhtml),
                            '_updated'        => current_time( 'mysql' )
                );
                    
                $format = array(
                            '%d',
                            '%s',
                            '%s',
                            '%s'
                 );

                global $wpdb;
                global $wpbdf_emailer;
                
                $success=$wpdb->update( 
                        $wpbdf_emailer, 
                        $data, 
                        array( '_type' => ($i+1) ), 
                        $format, 
                        array( '%d' ) 
                );

                if(!$success){
                    $ok = false;
                }
            }

        }

        if($ok){
            $ms = 1;
        }else{
            $ms=-1;
        }

   }
   $types = wpbdf_return_email_templates();
   
    wp_enqueue_style('font-awesome-min', plugins_url('../css/font-awesome.min.css',__FILE__));  
    wp_enqueue_style('admin-min-css', plugins_url( '../css/admin.css' , __FILE__ ));
    wp_enqueue_script( 'email-options-min', plugins_url( '../js/email-script.js' , __FILE__ ), array('jquery'), '1.0.0', true );
    include( plugin_dir_path( __FILE__ ) . '../admin/wpbdf-view-all-emails.php');
}

/*--------------------------------------------------EMAIL FUNCTIONS--------------------------------------------*/

//USER emails-----------------------------------------------

function wpbdf_moderate_response($typ,$businessname,$email,$uid,$active){

    $arr = array();
    list($main_page,$view_business,$add_business) = wpbdf_get_urls(false);

    $arr["[business-name]"]=$businessname;
    $arr["[website-name]"]=get_bloginfo();
    $arr["[website-url]"]=network_site_url( '/' );
    $arr["[website-email]"]=wpbdf_getAdminEmail();

    if($active==1){
        //1
        list($subject,$msg,$html) = wpbdf_return_email_template(1,$arr);
    }else if($active==0){
         //2
        list($subject,$msg,$html) = wpbdf_return_email_template(2,$arr);
    }

  

    if($html==1){
        $headers = array('Content-Type: text/html; charset=UTF-8');
    }else{
        $headers = "";
    }
    wp_mail( $email, stripslashes($subject), stripslashes($msg), $headers );

}





function wpbdf_removal_response($businessname,$email,$status){

    $arr = [];
    $arr["[business-name]"]=$businessname;
    $arr["[website-name]"]=get_bloginfo();
    $arr["[website-email]"]=wpbdf_getAdminEmail();
    $arr["[website-url]"]=network_site_url( '/' );

    list($subject,$msg,$html) = wpbdf_return_email_template(4,$arr);
   
    if($html==1){
        $headers = array('Content-Type: text/html; charset=UTF-8');
    }else{
        $headers = "";
    }
    wp_mail( $email, stripslashes($subject), stripslashes($msg), $headers );
}


function wpbdf_activate_response($businessname,$email,$status){
    
    $arr = array();
    $arr["[business-name]"]=$businessname;
    $arr["[website-name]"]=get_bloginfo();
    $arr["[website-email]"]=wpbdf_getAdminEmail();
    $arr["[website-url]"]=network_site_url( '/' );

    if($status==1){

        list($subject,$msg,$html) = wpbdf_return_email_template(5,$arr);

    }else if($status==0){

        list($subject,$msg,$html) = wpbdf_return_email_template(6,$arr);
    
    }

    
    if($html==1){

        $headers = array('Content-Type: text/html; charset=UTF-8');

    }else{

        $headers = "";

    }
    
    wp_mail( $email, stripslashes($subject), stripslashes($msg), $headers );

}

//Contact  user if Account is Enabled/Disabled
function wpbdf_sendUserNotification($email,$status,$bid){
    
    $arr = array();
    $arr["[business-name]"]= wpbdf_getbusinessName($bid);
    $arr["[website-name]"]=get_bloginfo();
    $arr["[website-email]"]=wpbdf_getAdminEmail();
    $arr["[website-url]"]=network_site_url( '/' );

    if($status==1){
        list($subject,$msg,$html) = wpbdf_return_email_template(5,$arr);
    }else{
        list($subject,$msg,$html) = wpbdf_return_email_template(6,$arr);
    }
    if($html==1){
        $headers = array('Content-Type: text/html; charset=UTF-8');
    }else{
        $headers = "";
    }
    if(wp_mail( $email, stripslashes($subject), stripslashes($msg), $headers )){ 
        return true;
    }else{
        return false;
    }
}



//ADMIN emails----------------------------------------------------------

function wpbdf_EmailAdmin($id,$email){

    $msg = "This is an automated email:\n\n";

    $subject = "A new business has been added to the directory. Please administer.";

    $msg .= "A new business has been added to the directory. The details need to be moderated before they can be added to the website.\n\n";

    $msg.= "To check these details please ensure you are logged in as administrator to the website, then visit the following url:\n\n";

    $msg.= get_site_url()."/wp-admin/admin.php?page=wpbdf_edit_business&id=".$id."\n\n";

    $msg.="";

    wp_mail( $email, stripslashes($subject), stripslashes($msg) );

}


?>