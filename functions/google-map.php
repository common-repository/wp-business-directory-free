<?php 
/* Google Map functions */
/************************************Ajax Google Map long lat lookup *****************************************/

//Check if we've got this address/postcode in our db - if we have then no need to use our Google API quota
function wpbdf_checkLongLat(){

    if($_POST['_tcp']=="" && $_POST['_country']==""){
        echo "[]";
    }else{
        global $wpdb;
        global $wpbdf_postcode_recycle;
        $tcp = $_POST['_tcp'];
        $country = $_POST['_country'];
        $tcpshort = str_replace(" ","",$tcp);
        $details = $wpdb->get_results($wpdb->prepare("SELECT _lat,_lng FROM {$wpbdf_postcode_recycle} WHERE _address=%s or _address=%s;",array($tcpshort." ".$country,$tcp." ".$country) ));

        if(count($details)<1){ 
          return( json_encode(array("ok"=>"0"))  );
        }else{
          foreach($details as $ent){ 
              $lng = $ent->_lng;
              $lat = $ent->_lat;     
          }
          echo( json_encode( array("ok"=>"1","lng"=>$lng,"lat"=>$lat) )  );
        }
    }
    exit;

}
add_action('wp_ajax_checkLongLat','wpbdf_checkLongLat');
add_action('wp_ajax_nopriv_checkLongLat','wpbdf_checkLongLat');

//Save long/lat/town,county,postcode,country for future recycling
function wpbdf_storeLongLat($lng,$lat,$tcp,$country){
   global $wpdb;
   global $wpbdf_postcode_recycle;
   if(strlen($lng)>1 && strlen($lat)>1 && strlen($tcp) >= 4 && strlen($tcp) <= 250){              
        $data = array(
                '_lat' => $lat,
                '_lng'    => $lng,
                '_address'    => str_replace(" ","",$tcp)." ".$country,
                '_update'    => current_time( 'mysql' )
        );        
        $format = array(
                '%f',
                '%f',
                '%s',
                '%s'
        );        
        $wpdb->insert( $wpbdf_postcode_recycle, $data, $format );
    }
}

//Get long and lat of a business
function wpbdf_get_longlat($id){
    global $wpdb;
    global $wpbdf_listings_db;
    $inf = $wpdb->get_row($wpdb->prepare("SELECT _lng,_lat from {$wpbdf_listings_db} where id=%d;",array($id))); 
    return array($inf->_lng,$inf->_lat);
}

//print the google map widget on the business page
function wpbdf_createGmapWidget($lng,$lat,$api){
	return "<div id='map'></div>
            <script>
                var map_wpbdf;
                var markers = [];
                var infoWindow;
                var _lng = ".$lng.";
                var _lat = ".$lat.";
                var myLatLng = {lat: ".$lat.", lng: ".$lng."};

                function wpbdf_initMap() {
                    map = new google.maps.Map(document.getElementById('map'), {
                        center: myLatLng,
                        zoom: 16
                    });

                    if(!document.isFeatured){

                        if(document.MapIconBase!=null){
                            var pin = document.MapIconBase;
                        }else{
                            pin = '/wp-content/plugins/wp-business-directory-free/img/pin.png';
                        }
                        if(document.MapTextColour!=null){
                            var textColor = document.MapTextColour;
                        }else{
                            textColor = '#FFFFFF';
                        }

                    }else{

                        if(document.MapIconBaseFeature!=null){
                            pin = document.MapIconBaseFeature;
                        }else{
                            pin = '/wp-content/plugins/wp-business-directory-free/img/pin.png';
                        }
                        if(document.MapTextColourFeature!=null){
                            textColor = document.MapTextColourFeature;
                        }else{
                            textColor = '#FFFFFF';
                        }

                    }

                    var marker = new google.maps.Marker({
                        position: myLatLng,
                        map: map,
                        icon: pin,
                        textColor: textColor,
                        color: '#FFFFFF',
                    });
                }
                wpbdf_initMap();
            </script>";
}
?>