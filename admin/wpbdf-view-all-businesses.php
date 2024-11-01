<?php 
global $wpbdf_version;     
$html = "";

$created = "";
if(!empty($_GET["created"])){
    stripslashes(sanitize_text_field($_GET["created"]));
}

$del = "";
if(!empty($_GET["del"])){
    $del = stripslashes(sanitize_text_field($_GET["del"]));
}

$dels = "";
if(!empty($_GET["dels"])){
    stripslashes(sanitize_text_field($_GET["dels"]));
}

$edit = "";
if(!empty($_GET["edit"])){
    stripslashes(sanitize_text_field($_GET["edit"]));
}

$act = "";
if(!empty($_GET["act"])){
    stripslashes(sanitize_text_field($_GET["act"]));
}

$acts = "";
if(!empty($_GET["acts"])){
    stripslashes(sanitize_text_field($_GET["acts"]));
}

$deact = "";
if(!empty($_GET["deact"])){
    stripslashes(sanitize_text_field($_GET["deact"]));
}

$deacts = "";
if(!empty($_GET["deacts"])){
    stripslashes(sanitize_text_field($_GET["deacts"]));
}

$filtername = "";
if(!empty($_GET["filter-name"])){
    stripslashes(sanitize_text_field($_GET["filter-name"]));
}

$filteremail = "";
if(!empty($_GET["filter-email"])){
    stripslashes(sanitize_text_field($_GET["filter-email"]));
}

$filtersort = "";
if(!empty($_GET["filter-sort"])){
    stripslashes(sanitize_text_field($_GET["filter-sort"]));
}

$filterascdesc = "";
if(!empty($_GET["filter-ascdesc"])){
    stripslashes(sanitize_text_field($_GET["filter-ascdesc"]));
}

$filterstatus = "";
if(!empty($_GET["filter-status"])){
    stripslashes(sanitize_text_field($_GET["filter-status"]));
}

?>

<div class='admin-padd'>
    <div class='admin-header'>
        <div class='admin-header-left'>
            <img src='<?php echo plugin_dir_url(dirname(__FILE__)); ?>/img/logo_small.png' alt='WP Business Directory FREE Admin'/>
        </div><div class='admin-header-right'>
                    <div class='title'>Businesses</div>
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
    if($created==1){
            $html.='<div class="success">New business was created successfully.</div>';
    }else if($del==1){
            $html.="<div class='success'>Business has been successfully removed.</div>";
    }else if($del==-1){
            $html.="<div class='error'>Error - business could not be removed at this time.</div>";
    }else if($dels==1){
            $html.="<div class='success'>Businesses have been successfully removed.</div>";
    }else if($dels==-1){
            $html.="<div class='error'>Error - One or more business could not be removed at this time. Please check the results in the table below.</div>";
    }else if($edit==1){  
            $html.="<div class='success'>Business has been successfully edited.</div>";
    }else if($edit==-1){
            $html.="<div class='error'>Error - Business could not be edited at this time.</div>";
    }else if($act==1){
            $html.="<div class='success'>Business has been enabled.</div>";
    }else if($act==-1){
            $html.="<div class='error'>Error - Business could not be enabled at this time.</div>";
    }else if($acts==1){
            $html.="<div class='success'>Businesses have been enabled.</div>";
    }else if($acts==-1){
            $html.="<div class='error'>Error - One or more businesses could not be enabled at this time. Please check the results in the table below.</div>";
    }else if($deact==1){
            $html.="<div class='success'>Business has been disabled.</div>";
    }else if($deact==-1){
            $html.="<div class='error'>Error - Business could not be disabled at this time.</div>";
    }else if($deacts==1){
            $html.="<div class='success'>Businesses have been disabled.</div>";
    }else if($deacts==-1){
            $html.="<div class='error'>Error - One or more businesses could not be disabled at this time. Please check the results in the table below.</div>";
    }
    echo $html;
    ?>
    <form action="" method="GET" class='wpbdf-filter-form'>
        <input type='hidden' name='page' value='<?php echo intval($_GET['page']); ?>' />
        <input type='hidden' name='pg' value='<?php echo intval($_GET['pg']); ?>' />
    <div class='wpbdf-form-title'>Business Filter:</div><div class='wpbdf-form-field'><input type='text' name='filter-name' id='filter-name' placeholder='Enter business name...' value='<?php echo $filtername; ?>' /></div><div class='wpbdf-form-title'>Email Filter:</div><div class='wpbdf-form-field'><input type='email' name='filter-email' id='filter-email' placeholder='Enter email...' value='<?php echo $filteremail; ?>' /></div><div class='wpbdf-form-title'>Status:</div><div class='wpbdf-form-field'><select name='filter-status' id='filter-status'><option value='' selected>Any</option><option value='1' <?php if($filterstatus=="1"){ echo "selected"; }?>>Enabled</option><option value='2' <?php if($filterstatus==2){ echo "selected"; }?>>Moderation Required</option><option value='0'  <?php if($filterstatus==0){ echo "selected"; }?>>Disabled</option></select></div> 
    <div class='wpbdf-form-title'>Sort By:</div><div class='wpbdf-form-field'><select name='filter-sort' id='filter-sort'><option value='' selected>Any</option><option value='company' <?php if($filtersort=="company"){ echo "selected"; }?>>Business</option><option value='email' <?php if($filtersort=="email"){ echo "selected"; }?>>Email</option><option value='newest' <?php if($filtersort=="newest"){ echo "selected"; }?>>Newest</option></select><select name='filter-ascdesc' id='filter-ascdesc'><option value='' selected>Any</option><option value='desc' <?php if($filterascdesc=="desc"){ echo "selected"; }?>>Descending</option><option value='asc' <?php if($filteascdesc=="asc"){ echo "selected"; }?>>Ascending</option></select> <input type='submit' class="button button-primary" value='Filter Results' /></div>
    </form>
    <div class="wpbdf-new-business-div"><a href='admin.php?page=wpbdf_add_business'  class='button button-primary'>+ New Business</a></div>
    <table class='wpbdf-all-table wp-list-table widefat fixed striped posts' style='max-width: 1700px;'>
        <thead><tr><th class='center' style='width:15px;'></th><th>Business Name</th><th class=''>Business Type</th><th class=''>Address</th><th>Postcode (zip)</th><th>Country</th><th>Email</th><th class='optionstd'>Options</th></tr></thead><?php


    if(isset($_GET['pg'])){
        $page = intval($_GET['pg']);
    }else{
        $page = 1;
    }
    if($page<1){
        $page=1;
    }

    $where = "";
    $order = "ORDER BY a._name ASC";
    if($filtername!=""){
        $where = "WHERE (a._name = '".$filtername."' or a._name REGEXP '".$filtername."' )";
    }
    if($filteremail!=""){
        if($where == ""){$where = "WHERE ";}else{$where .= " AND ";}
        $where .= "(a._email = '".$filteremail."' or a._email REGEXP '".$filteremail."' )";
    }
    if($filterstatus!=""){
        if($where == ""){$where = "WHERE ";}else{$where .= " AND ";}
        $where .= "(a._active = ".$filterstatus." )";
    }

    if($filtersort!=""){

        $order = "ORDER BY ";
        if($filtersort=='company'){
            $order .= "a._name "; 
        }else if($filtersort=='email'){
            $order .= "a._email "; 
        }else if($filtersort=='newest'){
            $order .= "a.id "; 
        }
        if($order != "ORDER BY " && $filterascdesc=="asc"){
            $order .= "asc";
        }else if($order != "ORDER BY " && $filterascdesc=="desc"){
            $order .= "desc";
        }
        
    }


    $sql = "SELECT COUNT(a.id) as cnt FROM {$wpbdf_listings_db} a ".$where." ".$order;
    $count = $wpdb->get_var($wpdb->prepare($sql, array() ) );

    $perpage=75;

    if($page>1){
        $start = ( ($page)*$perpage)-($perpage);
    }else{
        $start=0;
    }

    $sql = "SELECT a.* FROM {$wpbdf_listings_db} a ".$where." ".$order." LIMIT %d, %d";
    $results = $wpdb->get_results($wpdb->prepare($sql, array($start,$perpage) ) );

    //get types
    $taxonomy = 'business-type-free';
    $term_args=array(
      'hide_empty' => false,
      'orderby' => 'name',
      'order' => 'ASC'
    );
    $business_types=get_terms($taxonomy,$term_args); 
    $html = "";
    foreach($results as $key => $row) {
                
                $total++;
                $theid = $row->id;
                $act= $row->_active;
                $url = wp_get_attachment_image_src($theid, "thumbnail", false);
                if(!$url[0]){ $url[0] = plugins_url( '/img/default.jpg', __FILE__ ); }

                $img_code = "<img src='".$url[0]."' style='max-width:100px;width:100px;' />";  


                $html.="<tr";

                if($act==0){
                    $html.=" style='background-color:#FFEFEF !important;'";
                }else if($act==2 || $act==3){
                    //to be administered
                    $html.=" style='background-color:#fff4ea !important;'";
                }

                $html.=">";

                $cats = explode("|",$row->_cat); 
                $types = explode("|",$row->_typ);


                $typetext = "";
                if ($business_types && count($types)>0) {
                    foreach($types as $t){
                      foreach ($business_types as $tax ) {
                        if($tax->slug == $t){
                            $typetext.= $tax->name . '<br>';
                        }
                      }
                    }
                }  

                $html.="<td class='center'>";

                if($act!=2){
                    $html.="<input type='checkbox' class='multi-check 'name='multi-check' value='".$row->id."' />";
                }else{
                    $html.="<input type='checkbox' class='diabled-multi-check 'name='diabled-multi-check' disabled />";
                }

                $html.="</td><td class=''>".stripslashes($row->_name)."</td><td class=''>".rtrim($typetext,"<br>")."</td><td class=''>".stripslashes($row->_address)."</td><td class=''>".$row->_postcode."</td><td class=''>".$row->_country."</td><td class=''>".stripslashes($row->_email)."</td><td>";

                if($act==0){
                    $html.="<button class='button edit-btn' data-id='".$theid."'>Edit</button> <button class='button act-btn' data-id='".$theid."'>Enable</button> ";
                }else if($act==3){
                    //to be administered - and is brand new
                    $html.="<button class='button edit-btn conf-btn' data-id='".$theid."'>NEW - Moderate</button> ";
                }else if($act==2){
                    //to be administered
                    $html.="<button class='button edit-btn conf-btn' data-id='".$theid."'>Moderate</button> ";
                }else{
                    $html.="<button class='button edit-btn' data-id='".$theid."'>Edit</button> <button class='button deact-btn' data-id='".$theid."'>Disable</button> ";
                }

                $html.="<button class='button delete-btn' data-id='".$theid."'>Remove</button></td>";
           

                $html.="</td></tr>";
               
    }
    if($total == 0){
        $html.="<tr><td colspan='8'><i>No businesses found.<br><Br><a href='admin.php?page=wpbdf_add_business'>Click here to add a business</a></i></td></tr>";       
    }
        echo $html;
    ?>
    </table>
    <div class="under-table">
        <div class="left">
            <span id="multi-select-span">With Selected: </span><select id='multi-select-option'><option value=''>--Select--</option><option value='enable'>Enable</option><option value='disable'>Disable</option><option value='rem'>Remove</option></select>
        </div><div class="right">
            <?php echo wpbdf_pagination('admin.php?page=wpbdf_view_entries',$count,$perpage,$page); ?>    
        </div>
    </div>
 

    <div class='admin-footer'>
        <div class='admin-footer-left'>
             WP Business Directory FREE <strong>v<?php echo $wpbdf_version;?></strong>
        </div><div class='admin-footer-right'>For support, or to review benefits of the PRO version visit <a href='http://www.wpbusinessdirectorypro.com' target='_blank' style='color:#6ca23a;'>www.wpbusinessdirectorypro.com</a></div>
    </div>

</div>