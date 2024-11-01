<?php 
/*V1.0.0
Business Details Page
------
Please retain the above lines of code.
You can amend the HTML code below, but please ensure function calls and variables remain in place in order to retain correct functionality*/
?>

<script>

document.claim_error = '<?php echo __("There was an error. Please try again.","wpbdf");?>';
document.MapIconBase = "<?php echo plugin_dir_url(dirname(__FILE__)).'template/img/pin_spacing.png'; ?>";
document.MapIconBaseFeature = "<?php echo plugin_dir_url(dirname(__FILE__)).'template/img/pin_spacing_featured.png'; ?>";
document.MapTextColour = "#d94641";
document.MapTextColourFeature = "#d5ad40";

</script>

<div class='wpbdf-container wpbdf-business'>

    <div class='wpbdf-breadcrumb'>

        <a href='<?php echo $main_page."?".$arrs; ?>'><?php echo __("Business Directory","wpbdf"); ?> » </a><?php echo $name; ?></a>

    </div>

    <?php if($canmap){ ?><div class='wpbdf-map'><?php echo $the_gmap_widget; ?></div><?php } ?>
    
    <div class='left' <?php  if($the_slideshow_widget==""){echo "style='width:100% !important;display:block !important;padding-right: 0;'"; } ?>>
    
        <div class='wpbdf-header'>

            <?php 

            if($main_img_src!=""){

                echo "<div class='logo-div'><img src='".$main_img_src."' alt='".$name."' /></div>";

            }

            ?><div class='intro-div'>

                <h2 class='entry-title'>

                    <?php echo $name; ?>

                </h2>

                <div class='details-address'><span class='icon address'></span><div class='address-text'><?php echo $address;?><br><?php echo $postcode;?><br><?php echo $country;?></div></div>


                <?php

                if($types!=""){ 

                    echo "<div class='business-types'>Business Type(s): <span>".$types."</span></div>";

                }

                if($cats!=""){ 

                    echo "<div class='business-cat-frees'>Category(s): <span>".$cats."</span></div>";

                }

                ?>

            </div>

            <div class='clear'></div>

        </div>

        <div class='details list'>

            <?php

            if($tel!=""){

                echo "<div class='details-tel'><a href='tel:".$tel."'><span class='icon tel'></span>".$tel."</a></div>";

            }

            if($email!=""){

                echo "<div class='details-email'><a href='mailto:".$email."' target='_blank'><span class='icon email'></span>".$email."</a></div>";

            }

            if($website!=""){

                echo "<div class='details-web'><a href='".$website."' target='_blank'><span class='icon website'></span>".$website_no_http."</a></div>";

            }

            if($fax!=""){

                echo "<div class='details-fax'><span class='icon fax'></span>".$fax."</div>";

            }

            if($the_social_widget !=""){

                echo "<div class='details-social'><span class='icon social'></span>".$the_social_widget."</div>";

            }

            ?>

        </div>

        <div class='clear'></div>

        <?php if($desc!=""){?>

            <div class='description'>

                <h3>Business Information</h3>

                <div class="description-text">
                    <?php echo $desc; ?>
                </div>
    
            </div>

        <?php } ?>

        <div id='footer-placemarker-top'></div><!--LEAVE THIS HERE - footer-content may move depending on screen size -->

        <div class='footer-content'>

            <div class="button_section">

                <?php echo $backbutton;?>

                <a href="javascript:window.print()" class="btn red"><span class='fa'></span> Print Details</a>

            </div><div class="social_share_section">

                <!-- This is a good place to add like / share buttons here. For more information visit https://blog.hubspot.com/blog/tabid/6307/bid/29544/the-ultimate-cheat-sheet-for-creating-social-media-buttons.aspx -->

            </div>

        </div>

    </div><?php

        if($the_slideshow_widget!=""){?><div class='right'>

        

            <div class='wpbdf-image-slideshow'><?php echo $the_slideshow_widget; ?></div>
        
        

    </div><?php }

        ?>

    <div class='clear'></div>
    
    <div id='footer-placemarker-bottom'></div><!--LEAVE THIS HERE - footer-content may move depending on screen size -->

    <div class='clear'></div>

</div>