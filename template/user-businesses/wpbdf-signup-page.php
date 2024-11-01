<?php 
/*V1.0.0
New Business Signup Page
------
Please retain the above lines of code.
You can amend the HTML code below, but please ensure function calls and variables remain in place in order to retain correct functionality*/
?>

<?php  

$defaultimageurl =  plugin_dir_url()."wp-business-directory-free/"."img/default.jpg";

$defaultuploadedimageurl =  plugin_dir_url()."wp-business-directory-free/"."img/default_uploaded.jpg";

?>

<script> 

    document.defaultImage = "<?php echo $defaultimageurl; ?>";  

    document.defaultUploadedImage = "<?php echo $defaultuploadedimageurl; ?>"; 

</script>

<div class='wpbdf-container'>

    <div class='wpbdf-breadcrumb'>

        <a href='<?php echo $main_page; ?>'><?php echo __("Business Directory","wpbdf"); ?> » </a> </a><?php echo __("Add A New Business","wpbdf"); ?></a>

    </div>

    <form  method="post" action="" enctype="multipart/form-data" id="business_form" name="business_form">

    	   
        <!-- Leave the below hidden fields as they are - these are required -->

        <input type="hidden" name="custom_meta_box_nonce" value="<?php echo wp_create_nonce('wpbdf-new-business-safe-check'); ?>" />

        <input type="hidden" name="formis" id="formis" value="frontendadd" />  

        <input type="hidden" name="typ" id="typ" value="" />  

        <input type="hidden" name="cat" id="cat" value="" /> 

        <input type="hidden" id="social" name="social" value="" />

        <!-- -->

        <h2><?php echo __("Add A New Business","wpbdf");?></h2>

        <div class='top-text'><?php echo __("Please enter your business details below (* = required).","wpbdf");?></div>

        <div class='left'>               
                    
            <div class='form-option'>

            	<div class='form-label'>

            		<?php echo __("Business Name","wpbdf");?> *
            	
            	</div>
            
            	<div class='form-field'>

            		<input type="text" name="business_name" id="business_name"  value="" size="100" maxlength="250" required />    
                    
                </div>

            </div>   

            <?php 

            if ($business_types ) { ?>
                    
                <div class='form-option'>

                	<div class='form-label'>

                		<?php echo __("Business Type","wpbdf");?>
                	
                	</div>

                    <small><?php echo __("Choose as many as required","wpbdf");?></small>
                
                	<div class='form-field columns'>

                                <?php 

                                    foreach ($business_types as $tax ) {

                                        echo '<input type="checkbox" name="types[]" value="'.$tax->slug.'"> '.$tax->name.'<br>';                   

                                    }

                                ?>  
                        
                    </div>

                </div> 

            <?php

            }
                                    
            if ($business_cats ) { ?>

                            <div class='form-option'>

                                <div class='form-label'>

                                    <?php echo __("Categories","wpbdf");?>

                                        
                                </div>

                                <small><?php echo __("Choose as many as required","wpbdf");?></small>
                                    
                                <div class='form-field columns'>

                                     <?php 
                                          
                                            foreach ($business_cats as $tax ) {
                                                
                                                echo '<input type="checkbox" name="cats[]" value="'.$tax->slug.'"> '.$tax->name.'<br>';                   
                                            
                                            }                               
                                               
                                    ?>  
                                            
                                </div>

                            </div>

                        <?php 

            }

            ?>

            <div class='form-option'>

                <div class='form-label'>

                    <?php echo __("Address","wpbdf");?> *
                        
                </div>
                    
                <div class='form-field'>

                    <textarea rows="5" cols="35" name="address" id="address" required></textarea>
                            
                </div>

            </div>

            <div class='form-option'>

                <div class='form-label'>

                    <?php echo __("Postcode","wpbdf");?> *
                        
                </div>
                    
                <div class='form-field'>

                    <input type="text" name="postcode" id="postcode"  value=""  maxlength="50" required />  
                            
                </div>

            </div>

            <div class='form-option'>

                <div class='form-label'>

                    <?php echo __("Country","wpbdf");?> *
                        
                </div>
                    
                <div class='form-field'>

                    <select id="country" name="country" required>
                        <option value="United States" selected>United States</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="Canada">Canada</option>
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

            </div>

            <div class='form-option'>

                        <div class='form-label'>

                            <?php echo __("Email","wpbdf");?> *
                        
                        </div>
                    
                        <div class='form-field'>

                            <input type="email" name="email" id="email" value=""  maxlength="75" required />    
                            
                        </div>

                    </div>
                            
                    <div class='form-option'>

                        <div class='form-label'>

                            <?php echo __("Telephone","wpbdf");?>
                        
                        </div>
                    
                        <div class='form-field'>

                            <input type="text" name="tel" id="tel" value="" maxlength="30" /> 
                            
                        </div>

                    </div>
                            
                    <div class='form-option'>

                        <div class='form-label'>

                            <?php echo __("Fax","wpbdf");?>
                        
                        </div>
                    
                        <div class='form-field'>

                            <input type="text" name="fax" id="fax" value="" maxlength="30" />      
                            
                        </div>

                    </div>
                            
                    <div class='form-option'>

                        <div class='form-label'>

                            <?php echo __("Website","wpbdf");?>
                        
                        </div>
                    
                        <div class='form-field'>

                            <input type="text" name="website" id="website" placeholder="http://www..." value=""  maxlength="250" />      
                            
                        </div>

                    </div>
                             
                    <div class='form-option' >

                        <div class='form-label'>

                            <?php echo __("Social Links","wpbdf");?>
                        
                        </div>
                        
                         <small><?php echo __("Enter all that apply","wpbdf");?></small>
                    
                        <div class='form-field'>

                            <ul id='socialgroup'>

                                <li class='twitter-admin'>
                                    <span class='social-title'><?php echo __("Twitter Handle","wpbdf");?></span>
                                     <div class='twitter-admin logo fa'></div><input type="text" name="tw" id="tw" value="" placeholder="ie. @BusinessName" /> 
                                </li>

                                <li class='facebook-admin'>
                                    <span class='social-title'><?php echo __("Facebook Page","wpbdf");?></span>
                                     <div class='facebook-admin logo fa'></div><input type="text" name="fb" id="fb" value="" placeholder="ie. https://www.facebook.com/BusinessNameHere" /> 
                                </li>

                                <li class='google-admin'>
                                    <span class='social-title'><?php echo __("Google+ Page","wpbdf");?></span>
                                     <div class='google-admin logo fa'></div><input type="text" name="gp" id="gp" value="" placeholder="ie. https://plus.google.com/BusinessNameHere" /> 
                                </li>

                                <li class='linkedin-admin'>
                                    <span class='social-title'><?php echo __("LinkedIn Page","wpbdf");?><br>
                                     <div class='linkedin-admin logo fa'></div><input type="text" name="li" id="li" value="" placeholder="ie. https://www.linkedin.com/in/BusinessNameHere" /> 
                                </li>

                                <li class='insta-admin'>
                                    <span class='social-title'><?php echo __("Instagram Page","wpbdf");?></span>
                                     <div class='insta-admin logo fa'></div><input type="text" name="in" id="in" value="" placeholder="ie. https://www.instagram.com/BusinessNameHere" /> 
                                </li>

                                <li class='yt-admin'>
                                    <span class='social-title'><?php echo __("YouTube Page","wpbdf");?></span>
                                     <div class='yt-admin logo fa'></div><input type="text" name="yt" id="yt" value="" placeholder="ie. https://www.youtube.com/user/BusinessNameHere" /> 
                                </li>

                            </ul>   
                            
                        </div>

                    </div>  

            
             
            </div><div class='right'>


                                    
                        <div class='form-option'>

                            <div class='form-label'>

                                <?php echo __("Logo","wpbdf");?>
                                
                            </div>

                           <small><?php echo __("Logos should be approx 500px wide by 450px tall. Jpeg, gif or png format only.","wpbdf");?></small>
                            
                            <div class='form-field'>

                                <div class='image_par' style='width:210px !important;'>      

                                        <div id='img_file_view' class='previewer'>

                                            <img src='<?php echo $defaultimageurl; ?>' />

                                        </div>    

                                        <input type="hidden" id="logoid" name="logoid" value="" />   

                                        <input id="logo_remove_button" class="button img-button" name="library_remover_button" type="button" value="Delete" style="display:none;" />    

                                        <input name="img_file" type="file" id="img_file" value="Choose Logo" />

                                </div> 
                               
                                    
                            </div>

                        </div>

                        <div class='form-option'>

                            <div class='form-label'>

                                <?php echo __("Images","wpbdf");?>

                            </div>

                            <small><?php echo __("Upload up to 5 images per business. Images should be approx 780px wide by 350px tall.<br>Jpeg, gif or png format only.","wpbdf");?></small>
                            
                            
                            <div class='form-field allimages'>

                                <?php for($i=1; $i<=5; $i++){ ?>

                                    <div class='image_par'>      

                                        <div class='image_<?php echo $i; ?>_thumbnail_container'>
                                            
                                            <img src='<?php echo $defaultimageurl; ?>'  />
                                        
                                        </div>            
                                        
                                        <input type="hidden" id="img_<?php echo $i; ?>" name="img_<?php echo $i; ?>" value="" />
                                        
                                        <input class="button img-button library_remover_button" name="library_remover_button" type="button" data-img-id="<?php echo $i; ?>" value="Delete" style="display:none;" />
                                        
                                        <input name="img_file_<?php echo $i; ?>" type="file" id="img_file_<?php echo $i; ?>" value="Change Image <?php echo $i; ?>" />
                                        
                                    </div> 

                                <?php } ?>                        
                                    
                            </div>


                        </div>

                    

                    <div class='form-option'>

                    <div class='form-label'>

                        <?php echo __("Description","wpbdf");?>
                        
                    </div>
                    
                    <div class='form-field'>

                        <?php 

                            $content   = "";
                            $editor_id = 'desc';
                            $settings  = array( 'media_buttons' => false );                         
                            wp_editor( $content, $editor_id, $settings );

                       ?>    
                            
                    </div>

                </div>                   

                <?php if($terms!=""){ ?>

                    <div class='form-option'>

                                <div class='form-label'>

                                    Terms &amp; Conditions

                                </div>

                                <div class='form-field'> 
                                
                                    <textarea id='tcs'><?php echo $terms; ?></textarea>

                                    <label><input type="checkbox" required value="1"> <?php echo __("I accept the Terms and Conditions","wpbdf");?></label>

                                </div>

                    </div>

                 <?php } ?>   

                 <div class='form-option'>

                    <a href='<?php echo $main_page; ?>' class='btn back'><?php echo __("Cancel","wpbdf");?></a> <input type="submit" name="submit" id="submit" class="btn green" value="<?php echo __("Submit Business","wpbdf");?> ›">
                
                </div>     

            </div>

                
    </form>

</div>