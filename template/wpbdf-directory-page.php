<?php 
/*V1.0.0
Initial Search Page
------
Please retain the above lines of code.
You can amend the HTML code below, but please ensure function calls and variables remain in place in order to retain correct functionality*/
?>
<?php
$business_html = "";   //Outputed content
$count = 0;            //Current count
$t = 0;                //Total num of results
?>
<script>
document.location_not_found_message = '<?php echo __("Sorry, we couldn\'t find any businesses near this location.","wpbdf"); ?>';
document.business_not_found_message = '<?php echo __("It looks like your search is showing no results in the area.","wpbdf"); ?>';
document.MapIconBase = "<?php echo plugin_dir_url(dirname(__FILE__)).'template/img/pin_spacing.png'; ?>";
document.MapIconBaseFeature = "<?php echo plugin_dir_url(dirname(__FILE__)).'template/img/pin_spacing_featured.png'; ?>";
document.MapTextColour = "#d94641";
document.MapTextColourFeature = "#d5ad40";
</script>   

<div class='wpbdf-container'>

    <form action='' method='GET' name='wpbdf-form' id='wpbdf-form'>   

        <div class='wpbdf-search <?php if($startsearch) { echo "start-search"; } ?>'>
          
            <div class='search_bar'>
                
                <?php 

                //If multiple business types are set up, offer them as a dropdown to choose from.
                
                if ($business_types ) { ?>

                    <div class='column c25'>

                        <label><?php echo __("I'm looking for","wpbdf"); ?></label>

                        <select id='_typ' name='_typ'>

                            <option value=''><?php echo __("Any Business","wpbdf"); ?></option>

                            <?php echo $business_types_options; ?>

                        </select>

                    </div>

                    <?php    
                } 

                ?>

                <div class='column c25'>

                    <label><?php if ($business_types ) { echo __("Country","wpbdf");}else{ echo __("Looking for a business in","wpbdf");} ?></label>                   
                        
                    <select id="_country" name="_country" <?php if($_REQUEST['_tcp']!=""){echo "required";}?>>

                            <option value="">Everywhere</option>
                            
                            <?php 
                            
                            if($_REQUEST['_country']!=""){ ?>

                                 <option value="<?php echo esc_html($_REQUEST['_country']); ?>" selected><?php echo esc_html($_REQUEST['_country']); ?></option><?php
                                
                            }else{?>
                                 <option value="United Kingdom">United Kingdom</option>
                                 <option value="United States">United States</option>
                                 <option value="Canada">Canada</option>

                            <?php } ?>                    
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
                            <option value="Macedonia">Macedonia</option>
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
                            <option value="South Georgia">South Georgia &amp; South Sandwich Islands</option>
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

                <div class='column c25'>

                     <label><?php echo __("Town / City","wpbdf");?></label>

                    <input id='_tcp' name='_tcp' type='text' data-orgwithout="<?php echo __("Choose a country to enable this field","wpbdf");?>" data-orgwith="<?php echo __("Town, City and/or Postcode","wpbdf");?>" placeholder='<?php if($_REQUEST['_country']!=""){echo __("Town, City and/or Postcode","wpbdf");}else{echo __("Choose a country to enable this field","wpbdf");} ?>' value='<?php echo @$_REQUEST['_tcp']; ?>'  <?php if($_REQUEST['_country']==""){ echo "disabled"; } ?> /> 

                </div>

                <div class='column c25'>
                    <label>&nbsp;</label>
                    <input type="submit" id='wpbdf-search' class='btn green' value='Search ›'><div class='adv-btn' data-show-txt='<?php echo __("Show Advanced","wpbdf"); ?> »'  data-hide-txt='« <?php echo __("Hide Advanced","wpbdf"); ?>'><?php echo __("Show Advanced","wpbdf"); ?> »</div>
                </div>

                <div class='clear'></div> 
                <div class='err'></div>    

                <div class='advanced'>

                    <div class="content">

                        <div class='column c25' <?php if(!$canmap || $api==""){echo "style='display:none !important;'";}?>>

                            <div id="distance_option" >
                        
                                <label><?php echo __("Max Distance","wpbdf"); ?> <span class='small'>(<?php echo __("Location fields required","wpbdf"); ?>)</span></label>
                            
                                <select id="_radius" name="_radius" <?php if($_REQUEST['_tcp']==""){echo "disabled='true'";} ?>>
                                    <option value="25" selected>25 miles</option>
                                    <option value="50" <?php if($_radius==50){echo " selected";}?>>50 miles</option>
                                    <option value="75" <?php if($_radius==75){echo " selected";}?>>75 miles</option>
                                    <option value="100" <?php if($_radius==100){echo " selected";}?>>100 miles</option>
                                    <option value="150" <?php if($_radius==150){echo " selected";}?>>150 miles</option>
                                    <option value="200" <?php if($_radius==200){echo " selected";}?>>200 miles</option>
                                    <option value="500" <?php if($_radius==500){echo " selected";}?>>500 miles</option>
                                </select>

                            </div>

                        </div> 

                        <?php 

                        if ($business_cats ) {

                            ?>
                            
                            <div class='column c50 category-menu'>

                                <label>Categories</label>

                                <div class='columns' style='text-align:left;'>

                                    <?php echo $business_cats_options; ?>

                                </div>

                            </div>

                            <?php

                        } ?>

                        <div class='clear'></div>
      

                        <div class='column c25'>
                        
                            <label><?php echo __("Order By","wpbdf"); ?> <span class='small'>(<?php echo __("after featured","wpbdf"); ?>)</span></label>
                            <select id="_order" name="_order">
                                          <option value="" selected><?php echo __("Any","wpbdf"); ?></option>
                                          <option value="name" ><?php echo __("Name","wpbdf"); ?></option>
                                          <?php if($canmap==1){?> <option value="distance"  <?php if($_order=="distance"){echo " selected";}?> <?php if($_REQUEST['_tcp']==""){echo "disabled='true'";} ?>><?php echo __("Distance","wpbdf"); ?></option> <?php } ?>
                                          <option value="latest"  <?php if($_order=="latest"){echo " selected";}?>><?php echo __("Latest Added","wpbdf"); ?></option>
                            </select>

                       </div>

                        <div class='column c25'>
                            <label><?php echo __("Order Direction","wpbdf"); ?></label>
                            <select id="_ascdesc" name="_ascdesc">
                                          <option value="" selected>Any</option>
                                          <option value="asc" <?php if($_ascdesc=="asc"){echo " selected";}?>><?php echo __("Ascending","wpbdf"); ?></option>
                                          <option value="desc" <?php if($_ascdesc=="desc"){echo " selected";}?>><?php echo __("Descending","wpbdf"); ?></option>
                            </select>

                       </div>  

                       <div class='column c25'>
                        
                            <label><?php echo __("Results Per Page","wpbdf"); ?></label>
                            <select id="_amt" name="_amt">
                                          <option value="25" selected>25</option>
                                          <option value="50" <?php if($_amt==50){echo " selected";}?>>50</option>
                                          <option value="100" <?php if($_amt==100){echo " selected";}?>>100</option>
                                          <option value="150" <?php if($_amt==150){echo " selected";}?>>150</option>
                                          <option value="200" <?php if($_amt==200){echo " selected";}?>>200</option>
                                          <option value="250" <?php if($_amt==250){echo " selected";}?>>250</option>
                            </select>

                       </div>   

                        <!-- Leave the hidden fields below - these are required -->
                        <input type='hidden' id='_page' name='_page' value='1' />
                        <input type='hidden' id='_lat' name='_lat' value='' />
                        <input type='hidden' id='_lng' name='_lng' value='' />
                        <input type='hidden' id='_save_longlat' name='_save_longlat' value='0' />
                        <input type='hidden' id='_search' name='_search' value='1' />
                        <!-- End hidden fields -->

                        <div class='clear'></div> 

                    </div>
             
                </div>

            </div>

            <?php                   

            if($_REQUEST['_search']==1){

            ?>

                <div class='search_results'>

                <?php

                    //Let's get our results...

                    $results = wpbdf_getResults($_page,$_amt);
                     
                    //and json our results to send to our javascript map (only if map is available via settings and with included api key)

                    if($canmap && $api!=""){

                          $jsresults = json_encode($results);

                          echo "<script>document.map_array = ".$jsresults.";</script>";
                    }

                    //HTML code to show all businesses in results                              

                    if(count($results)>0){

                        //Our results loop

                        foreach($results as $store){

                            $count++;      

                            $addresssection = "";

                            $titlesection = "";

                            $dissection = "";

                            $logosection = "";

                            $pin = "";

                            //Only display distance from location if used had provided a location in the search parameters

                            if($_REQUEST['_tcp']!="" && $_REQUEST['_country']!=""){

                                $smalldist = round($store['distance'],1);

                                $dissection = "<div class='business-miles'>".$smalldist." ".__("miles from location", "wpbdf")."</div>";

                            }

                            //Turn the categories this business is linked to in to a string

                            $cats = wpdbf_stringify_cats($store['cat'],true,"");  //If true, return clickable categories which would refine the search to include the category. If false, just return text only

                            if($cats!=""){ $cats = "<div class='business-cat-frees'>".__("Category","wpbdf").": <span>".$cats."</span></div>";}

                            //Same with Business types

                            $types = wpdbf_stringify_typs($store['typ'],true,"");

                            if($types!=""){ $types = "<div class='business-types'>".__("Business Type","wpbdf").": <span>".$types."</span></div>";}


                            //Print out our display for this business

                            //1) Logo section

                                $logo = wpbdf_createLogo($store['_imgid']);                                                          

                                if($logo !=""){

                                    $logosection= "<div class='business-logo'><img src='".$logo."' /></div>";

                                    $logocheck = "";

                                }else{

                                    $logocheck = "nologo";

                                }

                            //2) Title, location and types section

                                $titlesection = "<div class='business-name'>".$store['name'];
                              
                                $bt = 'green';

                                $titlesection .= "</div>";

                                $addresssection = "<div class='business-address'>".$store['address']."</div>";


                            //3) Pin section

                                if($canmap && $api!=""){

                                    $pin = "<div class='pin_big'>".$count."</div>";

                                }
                            
                            $business_html .= "<div class='business' data-id='".$store['id']."'>
                                                <div class='business-head'>".$logosection."
                                                    <div class='business-data ".$logocheck."'>".
                                                        $titlesection.
                                                        $addresssection.
                                                        $dissection."
                                                        <div class='business-type-free_and_cats'>
                                                            ".$types.$cats."
                                                        </div>
                                                    </div>
                                                </div>".
                                                $pin."
                                                <a href='business-details?bid=".$store['id']."' class='btn ".$bt." business_btn' id='view_bus_".$store['id']."' alt='store-details'>".__("View Details","wpbdf")." ›</a>"."
                                            </div>";
                                             
                            $t = $store['t'];

                        }

                    }else{
                        
                        $business_html.= "<script>document.numresults=0;</script><div class='no-results-message'>".__("No results found","wpbdf")."</div>";

                    }

                    ?>

                    <div class='inner-text'>

                        <h2 class='business-directory'><?php echo __("Search Results","wpbdf"); ?></h2>

                        <?php if($t>0){ echo "<div class='wpbdf_total_amount'>".__("Total Num. Results","wpbdf")." : ".$t; } ?></div>

                    </div>

                    <?php echo $gmap ?>

                    <div id='businesses'>    

                        <?php echo $business_html; ?>

                        <div class='clear'></div>

                    </div> 

                    <div class='inner-text'>

                         <?php if($t>0){ echo wpbdf_fe_pagination($url."?",$t,$_amt,$_page); } ?>

                    </div>
                </div>

            <?php 
            } 
            ?>  

        </div>

    </form>   

</div>

