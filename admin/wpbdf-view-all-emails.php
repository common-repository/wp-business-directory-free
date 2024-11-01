<?php 
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
?>
<div class='admin-padd'>
    <div class='admin-header'>
        <div class='admin-header-left'>
            <img src='<?php echo plugin_dir_url(dirname(__FILE__)); ?>/img/logo_small.png' alt='WP Business Directory FREE Admin'/>
        </div><div class='admin-header-right'><div class='title'>Email Options</div>
              </div><div class='admin-header-right-ad'>
                    <div style='width:50%;vertical-align:top;-webkit-box-sizing: border-box;moz-box-sizing: border-box;box-sizing: border-box;display:inline-block;margin:auto;'>
                        <strong>READY TO GO PRO?</strong><br>
                        - Tiered Subscription System<br>
                        - Google friendly Ratings<br>
                        - User Reviews<br>
                        - Bulk Importing<br>
                        - User Ownership / Claiming<br>
                        - More Business Options</div><div style='width:50%;vertical-align:top;text-align:center;-webkit-box-sizing: border-box;moz-box-sizing: border-box;box-sizing: border-box;display:inline-block;margin:auto;'>
                        <strong>LOWEST EVER PRICE!</strong><br><br><a href='http://www.wpbusinessdirectorypro.com' class='button button-orange' style='height:auto;' target='_blank'><span class='fa' style='font-size:2em;padding-top:10px;'></span><br>GET WPBD PRO</a>
                    </div>
              </div><div class='clear'></div>
        </div>

    <?php	
    if ( ! current_user_can( 'edit_posts' ) ) {
        echo "<div class='error'>You do not have the correct privileges to access this page</div>"; 
        die();
    }
    ?><div class="wrap"><p>The user is sent an automated email in response to certain actions. The emails subject and message can be edited below.<br>
    Every email contains various "placeholders" that will be swaped out for the real data when the email is sent.</p>
    <p><strong>You must press the "Save Changes" at the bottom of the page to save any amendments.</strong></p>
    <form method="post" action="">
         <input type="hidden" name="email_nonce" value="<?php echo wp_create_nonce('wpbdf-email-nonce'); ?>" />
    <?php

    $response = "";
    if($ms==1){
            $response="<div class='success'>Emails have been successfully updated.</div>";
    }else if($ms==-1){
            $response="<div class='error'>Error - Some or all emails could not be updated. Please check the data and try again.</div>";
    }
    echo $response;
    ?>
    
    <?php 
    

    $titles = array(
        "New business moderated and approved",
        "New business moderated/approved but disabled",
        "New business rejected",
        "Business removed",
        "Business activated",
        "Business de-activated"
        );
    $placeholders = array(
        "[business-name], [website-name], [website-url], [website-email]",
        "[business-name], [website-name], [website-url], [website-email]",
        "[business-name], [website-name], [website-url], [website-email]",        
        "[business-name], [website-name], [website-url], [website-email]",
        "[business-name], [website-name], [website-url], [website-email]",
        "[business-name], [website-name], [website-url], [website-email]"
        );
    $count=0;
    foreach($types as $data){
        //$msg = $data[3];
        //$msg = str_replace("\\n","",$msg);
        //$msg=stripslashes($msg);
        $msg = stripslashes(wp_kses($data[3],$goodhtml));
        $title = stripslashes(sanitize_text_field($titles[$count]));
        ?>
    <div class='email_item'>
        <div class='form-option'>
            <h3><?php echo $title;?></h3>
            <div>Placeholders: <i><?php echo $placeholders[$count];?></i></div>
        </div><div class='form-option'>
            <div class='label-title'>Email Type</div>
            <div><select name='email_type_<?php echo $count;?>' id='email_type_<?php echo $count;?>'><option value='0' <?php if($data[1]==0){echo "selected";} ?>>Basic Text</option><option value='1' <?php if($data[1]==1){echo "selected";} ?>>HTML Text (not recommended, may be sent to junk mail)</option></select></div>
        </div><div class='form-option'>
            <div class='label-title'>Subject (must be plain text)</div>
            <div><input type='text' name='email_subject_<?php echo $count;?>'id='email_subject_<?php echo $count;?>' value='<?php echo $data[2]; ?>' maxchars="250"></div>
        </div><div class='form-option'>
            <div class='label-title'>Message</div>
            <div><textarea style='height:200px !important;' name='email_message_<?php echo $count;?>' id='email_message_<?php echo $count;?>'><?php
                            echo $msg;
           ?></textarea></div>
        </div><div class='form-option'>
            <div><input type="button" class='button' value="Preview Email" onclick="wpdbf_previewData('<?php echo $count;?>');" /></div>
        </div>
    </div>
    <?php 
        $count++;
    }
    ?>

    <div class='form-option'>
        <input type="submit" class='button button-primary' value="Save Changes">
    </div>
</form>

   </div>
    <div class='admin-footer'>
        <div class='admin-footer-left'>
             WP Business Directory FREE <strong>v<?php echo $wpbdf_version;?></strong>
        </div><div class='admin-footer-right'>For support, or to review benefits of the PRO version visit <a href='http://www.wpbusinessdirectorypro.com' target='_blank' style='color:#6ca23a;'>www.wpbusinessdirectorypro.com</a></div>
    </div>

</div>

<div id='email-preview-container'>
    <div id='email-preview'></div>
</div>