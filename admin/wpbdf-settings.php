
<div class='admin-padd'>
    <div class='admin-header'>
        <div class='admin-header-left'>
            <img src='<?php echo plugin_dir_url(dirname(__FILE__)); ?>/img/logo_small.png' alt='WP Business Directory FREE Admin'/>
        </div><div class='admin-header-right'><div class='title'>Settings</div>
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

    if ( ! current_user_can( 'edit_pages' ) ) {
        echo "<div class='error'>You do not have the correct privileges to access this page</div>"; 
        die();
    }else{

        if(isset($_POST['google_api'])){
            $result = wpbdf_setBusinessSettings();
            if($result){
                echo "<div class='success'>Settings have been updated.</div>"; 
            }else{
                echo "<div class='error'>Settings could not be updated at this time.</div>"; 
            }   
        }
        list($google_api,$map,$dir,$admin_email,$_tcs,$admin_timezone,$admin_dateformat) = wpbdf_getBusinessSettings();
        
        ?>
    <form  method="post" action="" enctype="multipart/form-data" onsubmit="return wpdbf_validate()">
        <input type="hidden" name="custom_meta_box_nonce" value="<?php echo wp_create_nonce('wpbdf-safe-check-nonce'); ?>" />

                    <div class='uid-mod-details'>
                        <div class='form-option'>
                            <div class='label-title'>Admin Email</div>
                            <small>We strongly advise you to use an email address with the same domain name as this website. Failure to do so may result in your automatically generated emails being flagged as spam.</small>
                            <input type="email" name="admin_email" id="admin_email" value="<?php echo esc_attr(stripslashes($admin_email)); ?>" size="75" required />    
                        </div> 
                    </div>

                    <div class='uid-mod-details'>
                        <div class='form-option'>
                            <div class='label-title'>Date Format</div>
                            <small>Visual date format in admin area and some front-end sections.</small>
                            <select id="admin_dateformat" name="admin_dateformat" required>
                                <option value="d/m/Y" <?php if($admin_dateformat == "d/m/Y"){echo "selected";}?>>dd/mm/yy</option>
                                <option value="Y-m-d" <?php if($admin_dateformat == "Y-m-d"){echo "selected";}?>>yy-mm-dd</option>                  
                            </select> 
                        </div> 
                    </div>

                    <div class='uid-mod-details'>              
                        <div class='form-option'>
                            <div class='label-title'>Google API Key</div>
                            <small>In order to utilise distance searching and/or Google Maps you will need a FREE <a href='https://developers.google.com/maps/documentation/javascript/get-api-key#key' target='_blank'>Google API key</a>. Follow the steps requested and enter your API key below.<br>If no API key is presented the distance field will be removed from the search, and Google Maps will be excluded (even if enabled).</small>  
                            <input type="text" name="google_api" id="google_api" value="<?php echo esc_attr(stripslashes($google_api)); ?>" size="100" />    
                        </div>         
                        <div class='form-option'>
                            <div class='label-title'>Google Maps</div>
                            <small>Google Mapping is optional. Switching this option off does not affect distance sarching, but will not the location map.</small>
                            <input type="checkbox" name="map" id="map" value="1" <?php if ( (isset( $_POST["map"] ) && intval($_POST["map"]==1)) || $map==1  ){echo "checked";} ?> > Enable Google Maps
                        </div>         
                    </div>

                    <div class='uid-mod-details'>
                        <div class='form-option'>
                            <div class='label-title'>User Ownership / Claiming  (Pro version only)</div>
                            <small>Your registered members can "Claim" ownership of their business. Once approved (by yourself) they will have access to edit those details (which also requires admin confirmation).<br>Registered users can manage their businesses from their User Dashboard page.</small>
                            <div><a href='http://www.wpbusinessdirectorypro.com' target='_blank'>Get the Pro version now</a></div>
                        </div> 
                    </div>

                    <div class='uid-mod-details'>
                        <div class='form-option'>
                            <div class='label-title'>User Rating &amp; Reviews (Pro version only)</div>
                            <small>Users can rate and review a business. All reviews must be moderated before they are made live.</small>  
                            <div><a href='http://www.wpbusinessdirectorypro.com' target='_blank'>Get the Pro version now</a></div>
                        </div>

                    </div>

                    <div class='uid-mod-details'>
                        <div class='form-option'>
                            <div class='label-title'>Terms &amp; Conditions of Use</div>
                            <small>Users who add a business to the directory must agree to the following terms and conditions.<br>
                                Please be sure to cover everything regarding data protection, handling of subscripitons and (where applicable) renewals and upgrades.</small>  
                        </div>
                        <div class='form-option'>
                            <textarea name="_tcs" style="min-height:150px;min-width:70%;"><?php if ( @$_POST["_tcs"]!="0" && isset( $_POST["_tcs"]) ){echo esc_attr(stripslashes($_POST['_tcs'])); }else{ echo esc_attr(stripslashes($_tcs)); } ?></textarea>
                        </div> 

                    </div>

                    <div class='uid-mod-details'>
                        <div class='form-option'>
                            <div class='label-title'>Page Links</div>
                            <small>It is important that business directory page urls are correct. Please ensure the links below are up to date or your business directory may not function correctly.</small>  
                        </div>
                        <div class='form-option'><div class='label-title'>» Main Directory Page</div>
                            <?php list($main_page,$view_business,$add_business) = wpbdf_get_urls(true); ?>
                            <?php 
                            $args = array(
                                'selected' => $main_page,
                                'name' => 'main_directory',
                                'id'  => 'main_directory',
                                'class' => 'smaller_select',
                                'post_type' => 'page',
                            );
                            wp_dropdown_pages($args); ?> 
                        </div>
                        <div class='form-option'><div class='label-title'>» Business View Page</div>
                            <?php 
                            $args = array(
                                'selected' => $view_business,
                                'name' => 'view_business',
                                'id'  => 'view_business',
                                'class' => 'smaller_select',
                                'post_type' => 'page',
                            );
                            wp_dropdown_pages($args); ?> 
                        </div>
                        <div class='form-option'><div class='label-title'>» Add Business Page</div>
                            <?php 
                            $args = array(
                                'selected' => $add_business,
                                'name' => 'directory_add_business',
                                'id'  => 'directory_add_business',
                                'class' => 'smaller_select',
                                'post_type' => 'page',
                            );
                            wp_dropdown_pages($args); ?> 
                        </div>
                        <div class='form-option'><div class='label-title'>» User Dashboard / Business List  (Pro version only)</div>
                            <div><a href='http://www.wpbusinessdirectorypro.com' target='_blank'>Get the Pro version now</a></div>
                        </div>
                        <div class='form-option'><div class='label-title'>» Edit Business Page (Pro version only)</div>
                            <div><a href='http://www.wpbusinessdirectorypro.com' target='_blank'>Get the Pro version now</a></div>
                        </div>
                        <div class='form-option'><div class='label-title'>» Business Subscription / Processing Page (Pro version only)</div>
                            <div><a href='http://www.wpbusinessdirectorypro.com' target='_blank'>Get the Pro version now</a></div>
                        </div>
                       
                    </div>

                    <div class='uid-mod-details'>
                        <div class='form-option'>
                            <div class='label-title'>Subscription Payment System (Pro version only):</div>
                            <small>You can choose to charge your customers for inclusion in to your subscription packages. This process is quick and simple.</small>
                            <div><a href='http://www.wpbusinessdirectorypro.com' target='_blank'>Get the Pro version now</a></div> 
                        </div>
                    </div>
                    

                    <div class='uid-mod-details'>                     
                    
                        <input type='button' class='button' value='Cancel &amp; Go Back' onclick='document.location.href="/wp-admin/admin.php?page=wpbdf_view_entries"'> <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Details">
               
                    </div>

    </form>
    <div class='clear'></div>

    <?php 
    }
    ?>




    <div class='admin-footer'>
        <div class='admin-footer-left'>
             WP Business Directory FREE <strong>v<?php echo $wpbdf_version;?></strong>
        </div><div class='admin-footer-right'>For support, or to review benefits of the PRO version visit <a href='http://www.wpbusinessdirectorypro.com' target='_blank' style='color:#6ca23a;'>www.wpbusinessdirectorypro.com</a></div>
    </div>

</div>