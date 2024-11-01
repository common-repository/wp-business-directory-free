<?php
global $wpbdf_version;
    $ok=-1;
    if(isset($_POST['formtype'])){
            $ok = wpbdf_edit_business_sanitation();
            if($ok){
                echo "<div style='padding:10px;'>Please wait...</div>";
                echo '<script>window.location = "admin.php?page=wpbdf_view_entries&edit=1";</script>'; 
                die;
            }
    }

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
            'strong' => array()
    );
?>

<div class='admin-padd'>
    <div class='admin-header'>
        <div class='admin-header-left'>
            <img src='<?php echo plugin_dir_url(dirname(__FILE__)); ?>/img/logo_small.png' alt='WP Business Directory FREE Admin'/>
        </div><div class='admin-header-right'><div class='title'>Edit Business</div>
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
list($df,$apikey,$googlelink) = get_admin_requests();
?> 

<?php
    $dateFormat_code_view = $df;

    if($df=="d/m/Y"){
        $dateFormat_text_view = "dd/mm/yy";
    }else if($df=="Y-m-d"){
        $dateFormat_text_view = "yy-mm-dd";
    }

?>
<?php

if ( ! current_user_can( 'edit_posts' ) ) {
    echo "<div class='error'>You do not have the correct privileges to access this page</div>"; 
    die();
}else if ( !isset($_GET['id']) ) {
    echo "<div class='error'>Missing ID</div>"; 
    echo '<script>window.location = "admin.php?page=wpbdf_view_entries";</script>'; 
    die();
}else{
    echo '<script>document.dateFormat = "'.$dateFormat_text_view.'";</script>';
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
    
    ?>
    <div class="wrap">
    <?php
    if($ok==0){echo "<div class='error'>Could not edit this business. Please check details and try again</div>";}


    list($name,$address,$postcode,$country,$long,$lat,$imgid,$imgs,$act,$cat,$tel,$fax,$desc,$typ,$website,$email,$social) = wpbdf_getBusinessDetails(intval($_GET['id']));



    $cat_array = explode("|",$cat);
    $typ_array = explode("|",$typ);

    $social_array = explode("|",$social);

    list($n,$tw) = explode("^",$social_array[1]);
    list($n,$fb) = explode("^",$social_array[2]);
    list($n,$gp) = explode("^",$social_array[3]);
    list($n,$li) = explode("^",$social_array[4]);
    list($n,$in) = explode("^",$social_array[5]);
    list($n,$yt) = explode("^",$social_array[6]);

    if($address=="" || $postcode==""){
        echo "<div class='error'>We could not retrieve the details for this business.</div>"; 
    }

    $address = sanitize_textarea_field($address);
    $newaddress = sanitize_textarea_field($_POST["address"]);

    $imgs_array = explode(":",$imgs);

	?>
    <?php
    if ( ((isset( $_POST["act"] ) && @$_POST["act"]==2) || $act==2 ) && $_curr_year_status!="2" ){
    ?>
	    <div class="notice">
            <strong>Administration required</strong> - The owner of this business has recently amended this listing. Please check and confirm the details. If you are satisfied please <strong>Re-enable</strong> this listing.
        </div>
    <?php 
    }else if ( (isset( $_POST["act"] ) && @$_POST["act"]==3) || $act==3  ){
    ?>
        <div class="notice">
            <strong>Administration required</strong> - This is a new business submission and requires moderating. Please check and confirm the details. If you are satisfied please <strong>enable</strong> this listing.
        </div>
    <?php 
    }else if (( (isset( $_POST["act"] ) && @$_POST["act"]==2) || $act==2 ) && $_curr_year_status=="2" ){
    ?>
        <div class="notice">
            <strong>Administration required</strong> - This business submission requires moderating but is also awaiting payment. Please check and confirm the details. Once payment has been made please <strong>enable</strong> this listing.
        </div>
    <?php 
    }
    ?>
        <p><i>Edit business details below (* = required).</i></p>
        <form  method="post" action="" enctype="multipart/form-data" id="business_form" name="business_form" onsubmit="return validate_business_form();">

            <div class='tab'>

                <h3>Business Information</h3>
                
                <div class='left'>

                    <input id="formtype" name="formtype" value="edit" type="hidden" />
                    <input type="hidden" name="id" id="id" value="<?php echo ( isset( $_POST["id"] ) ?  intval($_POST["id"]) : intval($_GET["id"]) ); ?>" />
                    <input type='hidden' name='prevact' id='prevact' value='<?php echo $act;?>' />
                	<input type="hidden" name="custom_meta_box_nonce" value="<?php echo wp_create_nonce('wpbdf-safe-check-nonce'); ?>" />
                    <input type='hidden' id='social' name='social' value='' />
                    <div class='form-option'>
                        <div class='label-title'>Business Name *</div>
            	       <input type="text" name="name" id="name" value="<?php echo ( isset( $_POST["name"] ) ? stripslashes(sanitize_text_field($_POST["name"])) : stripslashes(sanitize_text_field($name)) ); ?>" size="100"  maxlength="250" required />    
                    </div>
                    
                    <div class='form-option' style="margin-bottom:0;">
                        <div class='label-title'>Business Type</div>
                    </div>
                    <div class='form-option columns'>
                        <?php 
                        if ($business_types ) {
                              foreach ($business_types as $tax ) {
                                echo '<input type="checkbox" name="types[]" value="'.$tax->slug.'" ';
                                foreach($typ_array as $t){
                                    if($t==$tax->slug){
                                        echo " checked";
                                    }
                                }
                                echo '> '.$tax->name.'<br>';                   
                              }
                        }else{
                             echo "<input type='hidden' name='types[]' value='' />";
                            echo "<i>No business types have been added yet.<br><a href='edit-tags.php?taxonomy=business-type-free'>Click Here</a> to add some now</i>";
                        }
                        ?>
                        <input type="hidden" name="typ" id="typ" value="" /> 
                    </div>
                    <div class='form-option'><div class='label-title'>Email *</div>
                       <input type="email" name="email" id="email"  value="<?php echo stripslashes(sanitize_email($email)); ?>"  maxlength="75" required />    
                    </div>                   
                    <div class='form-option'><div class='label-title'>Website</div>
                               <input type="text" name="website" id="website" placeholder="http://..." value="<?php echo ( isset( $website ) ? stripslashes(sanitize_text_field($website)) : '' ); ?>" />    
                    </div>  
                    <div class='form-option' style='margin-bottom:0;'>
                        <div class='label-title'>Categories</div>
                    </div>
                    <div class='form-option columns'>                
                            <?php 
                            if ($business_cats ) {
                                  foreach ($business_cats as $tax ) {
                                    echo '<input type="checkbox" name="cats[]" value="'.$tax->slug.'" ';
                                    foreach($cat_array as $c){
                                        if($c==$tax->slug){
                                            echo " checked";
                                        }
                                    }
                                    echo '> '.$tax->name.'<br>';                   
                                  }
                            }else{
                                echo "<i>No categories have been added yet.<br><a href='/edit-tags.php?taxonomy=business-cat-free'>Click Here</a> to add some now</i>";
                            }
                            ?>  
                    </div>   
                     <input type="hidden" name="cat" id="cat" value="" />   
                     <div class='form-option'><div class='label-title'>Social Links </div><small>Enter all that apply</small>
                        <ul style='margin-top:10px;padding-top:0;' id='socialgroup'>
                            <li class='twitter-admin'>
                                <div class='label-title'>Twitter Handle</div>
                                <div class='twitter-admin logo fa'></div><input type="text" name="tw" id="tw" value="<?php echo ( isset( $_POST['tw'] ) ? stripslashes(sanitize_text_field($_POST['tw'])) : stripslashes(sanitize_text_field($tw)) ); ?>" placeholder="ie. @BusinessName" maxlength="180" /> 
                            </li>
                            <li class='facebook-admin'>
                                <div class='label-title'>Facebook Page</div>
                                <div class='facebook-admin logo fa'></div><input type="text" name="fb" id="fb" value="<?php echo ( isset( $_POST['fb'] ) ? stripslashes(sanitize_text_field($_POST['fb'])) :  stripslashes(sanitize_text_field($fb)) ); ?>" placeholder="ie. https://www.facebook.com/BusinessNameHere" maxlength="180" /> 
                            </li>
                            <li class='google-admin'>
                                <div class='label-title'>Google+ Page</div>
                                <div class='google-admin logo fa'></div><input type="text" name="gp" id="gp" value="<?php echo ( isset( $_POST['gp'] ) ? stripslashes(sanitize_text_field($_POST['gp'])) :  stripslashes(sanitize_text_field($gp)) ); ?>" placeholder="ie. https://plus.google.com/BusinessNameHere" maxlength="180" /> 
                            </li>
                            <li class='linkedin-admin'>
                                <div class='label-title'>LinkedIn Page</div>
                                <div class='linkedin-admin logo fa'></div><input type="text" name="li" id="li" value="<?php echo ( isset( $_POST['li'] ) ? stripslashes(sanitize_text_field($_POST['li'])) :  stripslashes(sanitize_text_field($li)) ); ?>" placeholder="ie. https://www.linkedin.com/in/BusinessNameHere" maxlength="180" /> 
                            </li>
                            <li class='insta-admin'>
                                <div class='label-title'>Instagram Page</div>
                                <div class='insta-admin logo fa'></div><input type="text" name="in" id="in" value="<?php echo ( isset( $_POST['in'] ) ? stripslashes(sanitize_text_field($_POST['in'])) :  stripslashes(sanitize_text_field($in)) ); ?>" placeholder="ie. https://www.instagram.com/BusinessNameHere" maxlength="180" /> 
                            </li>
                            <li class='yt-admin'>
                                <div class='label-title'>YouTube Page</div>
                                <div class='yt-admin logo fa'></div><input type="text" name="yt" id="yt" value="<?php echo ( isset( $_POST['yt'] ) ? stripslashes(sanitize_text_field($_POST['yt'])) :  stripslashes(sanitize_text_field($yt)) ); ?>" placeholder="ie. https://www.youtube.com/user/BusinessNameHere" maxlength="180" /> 
                            </li>
                        </ul>
                    </div>

                    <div class="thumbnailer form-option">                    
                                <div class='logo-title'>
                                    <div class='label-title'>Logo</div>
                                    <small>
                                        Images should be approx 500px wide by 450px tall. Jpeg, gif or png.</small>
                                </div>
                                <div class='image_par image_par_logo'>      
                                    <div class='thumbnail_container'>
                                        <?php 
                                        $default = str_replace("/admin","",plugins_url( 'img/default.jpg', __FILE__ )); 
                                        $url = wp_get_attachment_image_src($imgid, "bd-thumbnail", false);  

                                        if($url[0]==""){
                                            echo "<img src='".$default."' data-default='".$default."'  />";  
                                        }else{
                                                echo "<img src='".$url[0]."' data-default='".$default."'  />"; 
                                        } 
                                        ?>
                                    </div>
                                    <input id="business_logo" name="business_logo" type="hidden" value="<?php echo intval($imgid); ?>" />               
                                    <input id="logo_selector_button" class="button img-button" name="library_selector_button" type="button" value="Choose Image" /><input id="logo_remove_button" class="button img-button del-btn-small" name="library_remover_button" type="button" value="Delete" <?php if($url[0]==""){ echo 'style="display:none;"';} ?> data-default="<?php echo $default; ?>" />
                                </div>
                    </div> 



                    
                </div><div class='right'>
                    <div class='form-option'><div class='label-title'>Telephone</div>
                               <input type="text" name="tel" id="tel" value="<?php echo ( isset( $_POST["tel"] ) ? stripslashes(sanitize_text_field($_POST['tel'])) : stripslashes(sanitize_text_field($tel)) );  ?>"  maxlength="30" />    
                    </div>          
                    <div class='form-option'><div class='label-title'>Fax</div>
                               <input type="text" name="fax" id="fax" value="<?php echo ( isset( $_POST["fax"] ) ? stripslashes(sanitize_text_field($_POST['fax'])) : stripslashes(sanitize_text_field($fax)) ); ?>"  maxlength="30" />    
                    </div> 
                    <div class='form-option'><div class='label-title'>Address *</div>
                        <textarea rows="5" cols="35" name="address" id="address" required><?php echo(  $newaddress!="" ? $newaddress : $address ); ?></textarea>
                    </div>            
                    <div class='form-option'><div class='label-title'>Postcode *</div>
                       <input type="text" name="postcode" id="postcode"  value="<?php echo ( isset( $_POST["postcode"] ) ? stripslashes(sanitize_text_field($_POST['postcode'])) : stripslashes(sanitize_text_field($postcode)) ); ?>"  maxlength="50" required />    
                    </div>
                    <div class="form-option"><div class='label-title'>Country *</div>
                    <select id="country" name="country" required>
                        <option value="<?php echo stripslashes(sanitize_text_field($country)); ?>" selected><?php echo stripslashes(sanitize_text_field($country)); ?></option>
                        <option value="Afghanistan">Afghanistan</option>
                        <option value="Albania">Albania</option>
                        <option value="Algeria">Algeria</option>
                        <option value="American Samoa">American Samoa</option>
                        <option value="Andorra">Andorra</option>
                        <option value="Angola">Angola</option>
                        <option value="Anguilla">Anguilla</option>
                        <option value="Antartica">Antarctica</option>
                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                        <option value="Argentina">Argentina</option>
                        <option value="Armenia">Armenia</option>
                        <option value="Aruba">Aruba</option>
                        <option value="Australia">Australia</option>
                        <option value="Austria">Austria</option>
                        <option value="Azerbaijan">Azerbaijan</option>
                        <option value="Bahamas">Bahamas</option>
                        <option value="Bahrain">Bahrain</option>
                        <option value="Bangladesh">Bangladesh</option>
                        <option value="Barbados">Barbados</option>
                        <option value="Belarus">Belarus</option>
                        <option value="Belgium">Belgium</option>
                        <option value="Belize">Belize</option>
                        <option value="Benin">Benin</option>
                        <option value="Bermuda">Bermuda</option>
                        <option value="Bhutan">Bhutan</option>
                        <option value="Bolivia">Bolivia</option>
                        <option value="Bosnia and Herzegowina">Bosnia and Herzegowina</option>
                        <option value="Botswana">Botswana</option>
                        <option value="Bouvet Island">Bouvet Island</option>
                        <option value="Brazil">Brazil</option>
                        <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                        <option value="Brunei Darussalam">Brunei Darussalam</option>
                        <option value="Bulgaria">Bulgaria</option>
                        <option value="Burkina Faso">Burkina Faso</option>
                        <option value="Burundi">Burundi</option>
                        <option value="Cambodia">Cambodia</option>
                        <option value="Cameroon">Cameroon</option>
                        <option value="Canada">Canada</option>
                        <option value="Cape Verde">Cape Verde</option>
                        <option value="Cayman Islands">Cayman Islands</option>
                        <option value="Central African Republic">Central African Republic</option>
                        <option value="Chad">Chad</option>
                        <option value="Chile">Chile</option>
                        <option value="China">China</option>
                        <option value="Christmas Island">Christmas Island</option>
                        <option value="Cocos Islands">Cocos (Keeling) Islands</option>
                        <option value="Colombia">Colombia</option>
                        <option value="Comoros">Comoros</option>
                        <option value="Congo">Congo</option>
                        <option value="Congo">Congo, the Democratic Republic of the</option>
                        <option value="Cook Islands">Cook Islands</option>
                        <option value="Costa Rica">Costa Rica</option>
                        <option value="Cota D'Ivoire">Cote d'Ivoire</option>
                        <option value="Croatia">Croatia (Hrvatska)</option>
                        <option value="Cuba">Cuba</option>
                        <option value="Cyprus">Cyprus</option>
                        <option value="Czech Republic">Czech Republic</option>
                        <option value="Denmark">Denmark</option>
                        <option value="Djibouti">Djibouti</option>
                        <option value="Dominica">Dominica</option>
                        <option value="Dominican Republic">Dominican Republic</option>
                        <option value="East Timor">East Timor</option>
                        <option value="Ecuador">Ecuador</option>
                        <option value="Egypt">Egypt</option>
                        <option value="El Salvador">El Salvador</option>
                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                        <option value="Eritrea">Eritrea</option>
                        <option value="Estonia">Estonia</option>
                        <option value="Ethiopia">Ethiopia</option>
                        <option value="Falkland Islands">Falkland Islands (Malvinas)</option>
                        <option value="Faroe Islands">Faroe Islands</option>
                        <option value="Fiji">Fiji</option>
                        <option value="Finland">Finland</option>
                        <option value="France">France</option>
                        <option value="France Metropolitan">France, Metropolitan</option>
                        <option value="French Guiana">French Guiana</option>
                        <option value="French Polynesia">French Polynesia</option>
                        <option value="French Southern Territories">French Southern Territories</option>
                        <option value="Gabon">Gabon</option>
                        <option value="Gambia">Gambia</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Germany">Germany</option>
                        <option value="Ghana">Ghana</option>
                        <option value="Gibraltar">Gibraltar</option>
                        <option value="Greece">Greece</option>
                        <option value="Greenland">Greenland</option>
                        <option value="Grenada">Grenada</option>
                        <option value="Guadeloupe">Guadeloupe</option>
                        <option value="Guam">Guam</option>
                        <option value="Guatemala">Guatemala</option>
                        <option value="Guinea">Guinea</option>
                        <option value="Guinea-Bissau">Guinea-Bissau</option>
                        <option value="Guyana">Guyana</option>
                        <option value="Haiti">Haiti</option>
                        <option value="Heard and McDonald Islands">Heard and Mc Donald Islands</option>
                        <option value="Holy See">Holy See (Vatican City State)</option>
                        <option value="Honduras">Honduras</option>
                        <option value="Hong Kong">Hong Kong</option>
                        <option value="Hungary">Hungary</option>
                        <option value="Iceland">Iceland</option>
                        <option value="India">India</option>
                        <option value="Indonesia">Indonesia</option>
                        <option value="Iran">Iran (Islamic Republic of)</option>
                        <option value="Iraq">Iraq</option>
                        <option value="Ireland">Ireland</option>
                        <option value="Israel">Israel</option>
                        <option value="Italy">Italy</option>
                        <option value="Jamaica">Jamaica</option>
                        <option value="Japan">Japan</option>
                        <option value="Jordan">Jordan</option>
                        <option value="Kazakhstan">Kazakhstan</option>
                        <option value="Kenya">Kenya</option>
                        <option value="Kiribati">Kiribati</option>
                        <option value="Democratic People's Republic of Korea">Korea, Democratic People's Republic of</option>
                        <option value="Korea">Korea, Republic of</option>
                        <option value="Kuwait">Kuwait</option>
                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                        <option value="Lao">Lao People's Democratic Republic</option>
                        <option value="Latvia">Latvia</option>
                        <option value="Lebanon">Lebanon</option>
                        <option value="Lesotho">Lesotho</option>
                        <option value="Liberia">Liberia</option>
                        <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                        <option value="Liechtenstein">Liechtenstein</option>
                        <option value="Lithuania">Lithuania</option>
                        <option value="Luxembourg">Luxembourg</option>
                        <option value="Macau">Macau</option>
                        <option value="Macedonia">Macedonia, The Former Yugoslav Republic of</option>
                        <option value="Madagascar">Madagascar</option>
                        <option value="Malawi">Malawi</option>
                        <option value="Malaysia">Malaysia</option>
                        <option value="Maldives">Maldives</option>
                        <option value="Mali">Mali</option>
                        <option value="Malta">Malta</option>
                        <option value="Marshall Islands">Marshall Islands</option>
                        <option value="Martinique">Martinique</option>
                        <option value="Mauritania">Mauritania</option>
                        <option value="Mauritius">Mauritius</option>
                        <option value="Mayotte">Mayotte</option>
                        <option value="Mexico">Mexico</option>
                        <option value="Micronesia">Micronesia, Federated States of</option>
                        <option value="Moldova">Moldova, Republic of</option>
                        <option value="Monaco">Monaco</option>
                        <option value="Mongolia">Mongolia</option>
                        <option value="Montserrat">Montserrat</option>
                        <option value="Morocco">Morocco</option>
                        <option value="Mozambique">Mozambique</option>
                        <option value="Myanmar">Myanmar</option>
                        <option value="Namibia">Namibia</option>
                        <option value="Nauru">Nauru</option>
                        <option value="Nepal">Nepal</option>
                        <option value="Netherlands">Netherlands</option>
                        <option value="Netherlands Antilles">Netherlands Antilles</option>
                        <option value="New Caledonia">New Caledonia</option>
                        <option value="New Zealand">New Zealand</option>
                        <option value="Nicaragua">Nicaragua</option>
                        <option value="Niger">Niger</option>
                        <option value="Nigeria">Nigeria</option>
                        <option value="Niue">Niue</option>
                        <option value="Norfolk Island">Norfolk Island</option>
                        <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                        <option value="Norway">Norway</option>
                        <option value="Oman">Oman</option>
                        <option value="Pakistan">Pakistan</option>
                        <option value="Palau">Palau</option>
                        <option value="Panama">Panama</option>
                        <option value="Papua New Guinea">Papua New Guinea</option>
                        <option value="Paraguay">Paraguay</option>
                        <option value="Peru">Peru</option>
                        <option value="Philippines">Philippines</option>
                        <option value="Pitcairn">Pitcairn</option>
                        <option value="Poland">Poland</option>
                        <option value="Portugal">Portugal</option>
                        <option value="Puerto Rico">Puerto Rico</option>
                        <option value="Qatar">Qatar</option>
                        <option value="Romania">Romania</option>
                        <option value="Russia">Russian Federation</option>
                        <option value="Rwanda">Rwanda</option>
                        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> 
                        <option value="Saint LUCIA">Saint LUCIA</option>
                        <option value="Saint Vincent">Saint Vincent and the Grenadines</option>
                        <option value="Samoa">Samoa</option>
                        <option value="San Marino">San Marino</option>
                        <option value="Sao Tome and Principe">Sao Tome and Principe</option> 
                        <option value="Saudi Arabia">Saudi Arabia</option>
                        <option value="Senegal">Senegal</option>
                        <option value="Seychelles">Seychelles</option>
                        <option value="Sierra">Sierra Leone</option>
                        <option value="Singapore">Singapore</option>
                        <option value="Slovakia">Slovakia (Slovak Republic)</option>
                        <option value="Slovenia">Slovenia</option>
                        <option value="Solomon Islands">Solomon Islands</option>
                        <option value="Somalia">Somalia</option>
                        <option value="South Africa">South Africa</option>
                        <option value="South Georgia">South Georgia and the South Sandwich Islands</option>
                        <option value="Span">Spain</option>
                        <option value="SriLanka">Sri Lanka</option>
                        <option value="St. Helena">St. Helena</option>
                        <option value="St. Pierre and Miguelon">St. Pierre and Miquelon</option>
                        <option value="Sudan">Sudan</option>
                        <option value="Suriname">Suriname</option>
                        <option value="Svalbard">Svalbard and Jan Mayen Islands</option>
                        <option value="Swaziland">Swaziland</option>
                        <option value="Sweden">Sweden</option>
                        <option value="Switzerland">Switzerland</option>
                        <option value="Syria">Syrian Arab Republic</option>
                        <option value="Taiwan">Taiwan, Province of China</option>
                        <option value="Tajikistan">Tajikistan</option>
                        <option value="Tanzania">Tanzania, United Republic of</option>
                        <option value="Thailand">Thailand</option>
                        <option value="Togo">Togo</option>
                        <option value="Tokelau">Tokelau</option>
                        <option value="Tonga">Tonga</option>
                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                        <option value="Tunisia">Tunisia</option>
                        <option value="Turkey">Turkey</option>
                        <option value="Turkmenistan">Turkmenistan</option>
                        <option value="Turks and Caicos">Turks and Caicos Islands</option>
                        <option value="Tuvalu">Tuvalu</option>
                        <option value="Uganda">Uganda</option>
                        <option value="Ukraine">Ukraine</option>
                        <option value="United Arab Emirates">United Arab Emirates</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="United States">United States</option>
                        <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                        <option value="Uruguay">Uruguay</option>
                        <option value="Uzbekistan">Uzbekistan</option>
                        <option value="Vanuatu">Vanuatu</option>
                        <option value="Venezuela">Venezuela</option>
                        <option value="Vietnam">Vietnam</option>
                        <option value="Virgin Islands (British)">Virgin Islands (British)</option>
                        <option value="Virgin Islands (U.S)">Virgin Islands (U.S.)</option>
                        <option value="Wallis and Futana Islands">Wallis and Futuna Islands</option>
                        <option value="Western Sahara">Western Sahara</option>
                        <option value="Yemen">Yemen</option>
                        <option value="Yugoslavia">Yugoslavia</option>
                        <option value="Zambia">Zambia</option>
                        <option value="Zimbabwe">Zimbabwe</option>
                    </select>
                </div>   

                <div class='form-option'><div class='label-title'>Mapping &amp; Distance</div>   
                    <small><?php if($apikey==""){?>Please enter the longitude/latitude fields below. As there is no Google API available we cannot obtain these details automatically. <a href='https://developers.google.com/maps/documentation/javascript/get-api-key#key' target='_blank'>Click Here</a> to get your free API key now and then update your <a href='/wp-admin/admin.php?page=wpbdf_settings'>Settings.</a><br>Alternatively, you can locate the longitude and latitude details at <a href='https://www.gps-coordinates.org/' target='_blank'>gps-coordinates.org</a><br><?php } ?>
                    <?php if($apikey!=""){?>Click the "Auto-fill long/lat" button to find the longitude/latitude details, or enter them manually if you know them.<br><?php } ?>
                    <strong><i>Why is longitude/latitude important?</i></strong> Storing the longitude and latitude values allows us to calculate distances without using the Google Maps API for every front-end search (which also has a daily limit on the number of address->long/lat conversions and may slow search results down).</small>
                    <div style='display:inline-block;vertical-align: top;'><div class='label-title'>Latitude *</div>
                           <input type="text" name="lat" id="lat" value="<?php echo ( isset( $_POST["lat"] ) ? stripslashes(sanitize_text_field($_POST["lat"])) : stripslashes(sanitize_text_field($lat)) ); ?>" required style='max-width:90px;' class="decimal" />    
                    </div><div style='display:inline-block;vertical-align: top;'><div class='label-title'>Longitude *</div>
                           <input type="text" name="long" id="long" value="<?php echo ( isset( $_POST["long"] ) ? stripslashes(sanitize_text_field($_POST["long"])) :   stripslashes(sanitize_text_field($long)) ); ?>" required style='max-width:90px;' class="decimal" />    
                    </div><?php if($apikey!=""){?><div style='display:inline-block;vertical-align: top;'><div class='label-title'>&nbsp;</div>
                           <input type='button' class="button button-orange getlonglat" id="getlonglat" value="Auto-fill long / lat"/>   
                    </div><?php } ?>
                    <?php if($apikey!=""){?>
                    <div class='longlaterr errorsmall' style='display:none'>Could not detect longitude / latitude co-ordinates from this address. Please check address and click the "Auto-fill long / lat" button</div>
                    <?php } ?>
                </div>

                <div class='form-option'>
                <?php if($apikey!=""){

                    if($googlelink==0){                            
                                ?><small>The Google Map function has not been enabled, therefore no map will be visible on the main business directory.</small><?php                    
                    }?>  
                        
                        <div id="map" style="width:100%;max-width: 700px; height: 300px;display:block"></div>
                        <script>
                                var map;
                                document.canmap=true;
                                var markers = [];
                                var infoWindow;
                                var locationSelect;
                                function wpbdf_initMap() {
                                       map = new google.maps.Map(document.getElementById('map'), {
                                              center: {lat: 51.2465549, lng: -2.10865020000002},
                                              zoom: 14
                                       });
                                       infoWindow = new google.maps.InfoWindow();
                                       locationSelect = document.getElementById("locationSelect");
                                }
                        </script>
                        <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $apikey; ?>&callback=wpbdf_initMap" async defer type="text/javascript"></script>
                        <?php
                }else{
                        ?><script>
                                document.canmap=false;
                          </script><p><i>If you want to utilise Google Maps and/or it's longitude/latitude look-up system you will need a free Google API key.<br><a href='https://developers.google.com/maps/documentation/javascript/get-api-key#key' target='_blank'>Click Here</a> to get your free key now and update your <a href='/wp-admin/admin.php?page=wpbdf_settings'>Settings</a> to utilise this section.</i></p><?php
                }?>
                </div>
                    
            </div>

            <div class="images_thumbnailer form-option">
                            <div class='logo-title'>
                                <div class='label-title'>Images</div>
                            </div>
                            <small>Upload up to 5 images per business. Jpeg, gif or png.</small>
                            <div class='image_par'>
                                <div class='image_1_thumbnail_container'>
                                <?php 
                                    $url = wp_get_attachment_image_src(intval( $imgs_array[0]), "bd-thumbnail", false);  
                                    if($url[0]==""){
                                        echo "<img src='".$default."' data-default='".$default."'  />";  
                                    }else{
                                            echo "<img src='".$url[0]."' data-default='".$default."'  />"; 
                                    } 
                                ?>
                                </div>
                                <input id="business_image_1" name="business_image_1" type="hidden" value="<?php if($imgs_array[0]!=""){echo intval( $imgs_array[0]);}?>" />
                                <input id="image_1_selector_button" class="button img-button" name="image_library_selector_button" type="button" value="Choose Image 1" /> <input id="image_1_remove_button" class="button img-button del-btn-small" name="image_library_remover_button" type="button" value="Delete" <?php if($url[0]==""){ echo 'style="display:none;"';} ?> data-default="<?php echo $default; ?>" /><br>
                            </div><div class='image_par'>
                            <div class='image_2_thumbnail_container'>                            
                                <?php 
                                    $url = wp_get_attachment_image_src(intval($imgs_array[1]), "bd-thumbnail", false);  
                                    if($url[0]==""){
                                        echo "<img src='".$default."' data-default='".$default."'  />";  
                                    }else{
                                            echo "<img src='".$url[0]."' data-default='".$default."'  />"; 
                                    }
                                ?>
                            </div>
                            <input id="business_image_2" name="business_image_2" type="hidden" value="<?php if($imgs_array[1]!=""){echo intval($imgs_array[1]);}?>" />
                            <input id="image_2_selector_button" class="button img-button" name="image_library_selector_button" type="button" value="Choose Image 2" /> <input id="image_2_remove_button" class="button img-button del-btn-small" name="image_library_remover_button" type="button" value="Delete" <?php if($url[0]==""){ echo 'style="display:none;"';} ?> data-default="<?php echo $default; ?>" /><br>
                            </div><div class='image_par'>
                            <div class='image_3_thumbnail_container'>

                                <?php 
                                    $url = wp_get_attachment_image_src(intval($imgs_array[2]), "bd-thumbnail", false);  
                                    if($url[0]==""){
                                        echo "<img src='".$default."' data-default='".$default."'  />";  
                                    }else{
                                            echo "<img src='".$url[0]."' data-default='".$default."'  />"; 
                                    }
                                            
                                ?>
                            </div>
                            <input id="business_image_3" name="business_image_3" type="hidden" value="<?php if($imgs_array[2]!=""){echo intval($imgs_array[2]);}?>" />
                            <input id="image_3_selector_button" class="button img-button" name="image_library_selector_button" type="button" value="Choose Image 3" /> <input id="image_3_remove_button" class="button img-button del-btn-small" name="image_library_remover_button" type="button" value="Delete" <?php if($url[0]==""){ echo 'style="display:none;"';} ?> data-default="<?php echo $default; ?>" /><br>
                            </div><div class='image_par'>
                            <div class='image_4_thumbnail_container'>

                                <?php 
                                    $url = wp_get_attachment_image_src(intval( $imgs_array[3]), "bd-thumbnail", false);  
                                    if($url[0]==""){
                                        echo "<img src='".$default."' data-default='".$default."'  />";  
                                    }else{
                                            echo "<img src='".$url[0]."' data-default='".$default."'  />"; 
                                    }
                                ?>
                            </div>
                            <input id="business_image_4" name="business_image_4" type="hidden" value="<?php if($imgs_array[3]!=""){echo intval($imgs_array[3]);}?>" />
                            <input id="image_4_selector_button" class="button img-button" name="image_library_selector_button" type="button" value="Choose Image 4" /> <input id="image_4_remove_button" class="button img-button del-btn-small" name="image_library_remover_button" type="button" value="Delete" <?php if($url[0]==""){ echo 'style="display:none;"';} ?> data-default="<?php echo $default; ?>" /><br>
                            </div><div class='image_par'>
                            <div class='image_5_thumbnail_container'>
                                <?php 
                                    $url = wp_get_attachment_image_src(intval( $imgs_array[4]), "bd-thumbnail", false);  
                                    if($url[0]==""){
                                        echo "<img src='".$default."' data-default='".$default."'  />";  
                                    }else{
                                            echo "<img src='".$url[0]."' data-default='".$default."'  />"; 
                                    }
                                ?>
                            </div>
                            <input id="business_image_5" name="business_image_5" type="hidden" value="<?php if($imgs_array[4]!=""){echo intval( $imgs_array[4]);}?>" />
                            <input id="image_5_selector_button" class="button img-button" name="image_library_selector_button" type="button" value="Choose Image 5" /> <input id="image_5_remove_button" class="button img-button del-btn-small" name="image_library_remover_button" type="button" value="Delete" <?php if($url[0]==""){ echo 'style="display:none;"';} ?> data-default="<?php echo $default; ?>" /><br>
                            </div> 
                </div>  


                    
                <div class='form-option'><div class='label-title'>Description</div> 
                        <?php
                            $content   = stripslashes(wp_kses($desc,$goodhtml));
                            $editor_id = 'desc';
                            $settings  = array( 'media_buttons' => true );                         
                            wp_editor( $content, $editor_id, $settings );
                        ?>
                </div>
                
            </div>

            <div class='tab'>
                <?php if($act==3){?>
                    <div class='noticesmall'>
                            <div class='form-option'>
                                <div class='label-title'>Accept New Business?</div>
                                <small>If you don't accept this business it will be removed from your database entirely. The user will be notified of your decision by email.</small>
                                <select name="act" id="act">
                                    <option value="1" <?php if($_POST["act"] === 1) {echo "selected";}?>>Accept &amp; Enable Business</option>
                                    <option value="0" <?php if($_POST["act"] === 0) {echo "selected";}?>>Accept but Disable Business</option>
                                    <option value="-2" <?php if($_POST["act"] === -2) {echo "selected";}?>>Decline and Remove Business</option>
                                </select>
                            </div>
                    </div>
                <?php }else if($act==2){?>
                    <div class='noticesmall'>
                            <div class='form-option'>
                                <div class='label-title'>Accept Amendments?</div>
                                <small>None-enabled businesses will be hidden from your users but they remain in the business directory database.<Br>
                                The user will be notified of your decision by email.</small>
                                <select name="act" id="act">
                                    <option value="2" <?php if($_POST["act"] === 2) {echo "selected";}?>>Accept Changes but Leave Status as "Under Moderation"</option>
                                    <option value="1" <?php if($_POST["act"] === 1) {echo "selected";}?>>Accept Changes &amp; Enable Business</option>
                                    <option value="-1" <?php if($_POST["act"] === -1) {echo "selected";}?>>Decline Changes and Disable Business</option>
                                </select>
                            </div>
                    </div>
                <?php }else{?>
                    <div class='form-option'>
                                <div class='label-title'>Enable or Disable Business</div>
                                <br><input type="checkbox" name="act" value="1" <?php if ( (isset( $_POST["act"] ) && @$_POST["act"]==1) || $act==1  ){echo "checked";} ?> > Enable business
                    </div>
                <?php } ?>


            </div> 

            <div class='tab'>

                <input type='button' class='button' value='Cancel &amp; Go Back' onclick='document.location.href="admin.php?page=wpbdf_view_entries"'> <input type="button" data-id="<?php echo ( isset( $_POST["id"] ) ?  intval($_POST["id"]) : intval($_GET['id']) ); ?>" class='button-primary delete-btn' value="Remove Business" style="background: #ba0000; border-color: #aa0000 #990000 #990000;-webkit-box-shadow: 0 1px 0 #006799;box-shadow: 0 1px 0 #990000;text-shadow: none;" /> <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php if($status==-1){echo "Confirm and ";} ?>Save / Update Details" />

            </div> 
            
        <div class="tab">
                <div class='form-option'>
                    <div class='label-title'>More Features Available with WP Business Directory <strong>PRO</strong></div><br>
                    <strong>WPBD Pro</strong> offers many more features, including:<br>
                    - Tiered Subscription Management (with flexible subscription periods and prices)<br>
                    - Featured Businesses<br>
                    - User Ownership / Claiming<br>
                    - Ratings and Reviews<br>
                    - Display Business Awards<br>
                    - Display Business Opening Hours<br>
                    - Bulk Importing<br><br>
                    To learn more about WPBD Pro, <a href='http://www.wpbusinessdirectorypro.com' target='_blank'>Click Here</a>.
                </div>
                    
        </div>
        </form>
    </div><?php if($apikey!=""){?><script>document.autoget=true;</script><?php } ?>
<?php 
}
?>


    <div class='admin-footer'>
        <div class='admin-footer-left'>
             WP Business Directory FREE <strong>v<?php echo $wpbdf_version;?></strong>
        </div><div class='admin-footer-right'>For support, or to review benefits of the PRO version visit <a href='http://www.wpbusinessdirectorypro.com' target='_blank' style='color:#6ca23a;'>www.wpbusinessdirectorypro.com</a></div>
    </div>

</div>