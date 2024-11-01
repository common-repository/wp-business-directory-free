<?php
    function wpbdf_getFileVersion($file){
        $arrs = array("\\","/","*","V","v","\n","\r","?","<",">");
        $v="";
        if (($handle = fopen($file, "r")) !== FALSE) {
            $line1 = fgets($handle);
            $line1 = str_replace($arrs,"",$line1 );
            $line2 = fgets($handle);
            $line2 = str_replace($arrs,"",$line2 );
            if($line1!="php" && $line1!="php " && $line1!=""){
                $v = $line1;
            }else if($line2!="php" && $line2!="php " && $line2!=""){ 
                $v = $line2;
            }else{
                $v = "";
            }
            
            fclose($f);
        }
        return $v;
    }

    function wpbdf_printrow($file,$org_files,$basepath,$currpath,$padd){

        global $pluginpath;

       $shortpath = str_replace($basepath,"",$currpath);

        if(is_file($currpath.$file)){

            if(in_array($shortpath.$file,$org_files)){

                //This is one of the base customisable files

                echo "<div style='padding-left:".$padd."px' class='file-div file matched-file ";

                //Get version number
                $wpbdf_version_files = wpbdf_getFileVersion($pluginpath.$shortpath.$file);
                
                $v  = wpbdf_getFileVersion($currpath.$file);

                if($v==$wpbdf_version_files){

                    echo "correct'><span class='fa'></span>".$file." <i>(v{$v})</i>"."</div>";

                }else{

                    echo "outofdate'><span class='fa'></span>".$file." <i>(v{$v}, latest should be v{$wpbdf_version_files}. This page may not function correctly until updated)</i>"."</div>";

                }
            
            }else{

                //This must be their own additional file

                echo "<div style='padding-left:".$padd."px;color: #999;' class='file-div file'><span class='fa'></span>".$file."</div>";

            }


        }else{

            //This must be a folder
            
            echo "<div style='padding-left:".$padd."px' class='file-div folder'><span class='fa'></span>".$file."</div>";

            $folder_files = array_slice(scandir($currpath.$file."/"), 2);

            foreach($folder_files as $folder_file){

                if(wpbdf_printrow($folder_file,$org_files,$basepath,$currpath.$file."/",$padd+40)){

                }
            }

        }
    }
?>


<div class='admin-padd'>
    <div class='admin-header'>
        <div class='admin-header-left'>
            <img src='<?php echo plugin_dir_url(dirname(__FILE__)); ?>/img/logo_small.png' alt='WP Business Directory FREE Admin'/>
        </div><div class='admin-header-right'><div class='title'>Custom Theme Files</div>
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

    //array of org themed files
    $org_files = [
        "wpbdf-directory-page.php",
        "wpbdf-business-details-page.php",
        "user-businesses/wpbdf-notice-page.php",
        "user-businesses/wpbdf-signup-page.php",
        "user-businesses/css/wpbdf-signup-page.css",
        "user-businesses/css/wpbdf-notice-page.css",
        "css/wpbdf-global-style.css",
        "css/wpbdf-business-directory-page.css",
        "css/wpbdf-business-details-page.css"
        ];


    ?><div class="wrap"><p>Customised front-end files (located in your theme/wpbdf/ folder) will overwrite the default theme files (located in the plugins/wpbdf/templates/ folder).<br>
    The list below shows all files and folders found within your theme/wpbdf/ folder. We have indicated where customised files are out of date.</p>
    <p>For more information regarding customisation please read our <a href='http://www.wpbusinessdirectorypro.com/tutorial/' target='_blank'>tutorial page</a></p>
    <div class='legend-container'>
        <h4>Legend</h4>
        <div style='padding-left:20px;width:25%;display:inline-block;float:left;-webkit-box-sizing: border-box;moz-box-sizing: border-box;box-sizing: border-box;' class='file-div folder'><span class='fa'></span>folder</div>
        <div style='padding-left:20px;width:25%;display:inline-block;float:left;-webkit-box-sizing: border-box;moz-box-sizing: border-box;box-sizing: border-box;' class='file-div file matched-file correct'><span class='fa'></span>file (customised, correct version number)</div>
        <div style='padding-left:20px;width:25%;display:inline-block;float:left;-webkit-box-sizing: border-box;moz-box-sizing: border-box;box-sizing: border-box;' class='file-div file matched-file outofdate'><span class='fa'></span>file (customised, out-dated version number)</div>
        <div style='padding-left:20px;color: #999;width:25%;display:inline-block;float:left;-webkit-box-sizing: border-box;moz-box-sizing: border-box;box-sizing: border-box;' class='file-div file'><span class='fa'></span>file (excluded from custom theme file list)</div>
        <div class='clear'></div>
    </div>

    <div class='files-container'>
        <h4>Files &amp; Folders</h4>
    <?php 

    $basepath = get_stylesheet_directory()."/wpbdf/";
    $baseurl = get_stylesheet_uri()."/wpbdf/";

    $files = array_slice(scandir($basepath), 2);

    if(count($files)<1){
        echo "<div class='file-div'><i>No customised files found</i></div>";
    }else{

        foreach($files as $file){

            wpbdf_printrow($file,$org_files,$basepath,get_stylesheet_directory()."/wpbdf/",20);

        }

    }

    ?>
   </div>

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