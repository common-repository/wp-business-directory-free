<?php 
/*V1.0.0
Notice/Endpoint Page
------
Please retain the above lines of code.
You can amend the HTML code below, but please ensure function calls and variables remain in place in order to retain correct functionality*/
?>
<div class='wpbdf-container'>

    <div class='wpbdf-breadcrumb'>

    	<?php 

    	$notification_type = "Error";

    	if(isset($signup_success)){
    		$notification_type = "Add A New Business"; 
    	}
    	?>

        <a href='<?php echo $main_page; ?>'><?php echo __("Business Directory","wpbdf"); ?> » </a> <?php echo __($notification_type,"wpbdf"); ?></a>

    </div>

    <h2><?php echo __($notification_type,"wpbdf"); ?></h2>

	<div class='top-text'>

		<?php

		if($signup_success === 1){

		    echo "<p><strong>".__("Thanks for your submission.","wpbdf")."</strong></p><p>".__("Your information must now be moderated by our admin team. We will notify you via email once this is completed.","wpbdf")."</p>";

		}else if($signup_success === 0){ 

		    echo "<p><strong>".__("Thanks for your submission.","wpbdf")."</strong></p><p>".__("Unfortunately there was an error.","wpbdf")."<a href='window.history.go(-1);'>".__("Please try again","wpbdf")."</a>.</p>";

		}

		?>

	</div>
	<div>
		<a href='<?php echo $main_page;?>' class='btn back'><?php echo __("Back To Business Directory","wpbdf"); ?></a>
	</div>
</div>