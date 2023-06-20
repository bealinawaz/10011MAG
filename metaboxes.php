<?php
function bb_meta_boxes_setup() { // Fire our meta box setup.
  add_action( 'add_meta_boxes', 'bb_add_meta_boxes' ); // Create one or more meta boxes
  add_action( 'save_post', 'BB_SAVE_META_BOX', 10, 2 );
} add_action( 'load-post.php', 'bb_meta_boxes_setup' ); add_action( 'load-post-new.php', 'bb_meta_boxes_setup' ); #Fire our meta box setup. #Fire our meta box setup.

function bb_add_meta_boxes() { // Create one or more meta boxes
	$get_post_meta_array = get_post_meta_array();
	foreach($get_post_meta_array as $x) {
		add_meta_box(
			$x["id"], // Unique ID
			$x["title"], // Title
			"bb_add_meta_box", // Display the post meta box.
			$x["pages"], // Admin page (or post type)
			$x["context"], // Context
			$x["priority"] // Priority
		);
	}
}

function bb_add_meta_box( $object, $box ) { // Display the post meta box.
	wp_nonce_field( 'myplugin_inner_custom_box', 'myplugin_inner_custom_box_nonce' );?>

    	<?php
			$row = "bb-row";
			$col0 = "bb-col-12 mar-none";
			$col1 = "bb-col-4 mar-none";
			$col2 = "bb-col-8 mar-none";
			$declare = BB_DECLARE();
		?>
        <style>
			body { font-family:Open Sans; }
			input, textarea { width:auto; }

			.blackbox-option-row { position:relative; max-width:100%; width:100%; margin:0px auto; }
			.blackbox-option-row:after { content:""; display:block; clear:both; }
			.blackbox-option-menu { max-width:250px; width:100%; float:left; }
			.blackbox-option-content { max-width:calc(100% - 250px); width:100%; float:left; }

			.bb-tab-content .bb-row { margin-bottom:50px; }
			
			.blackbox-option-title-bg { background-color:<?php echo $declare["primary-clr"]; ?>; }
			.blackbox-option-title-wrap { padding:47px 10px; text-align:center; }
			.blackbox-option-title,
			.blackbox-option-sub-title { font-size: 29px; color: #FFFFFF; font-weight:300; line-height:1; margin-bottom:10px; }
			.blackbox-option-sub-title { font-size: 12px; color: #024263; margin:0px; }
			.blackbox-option-title strong, 
			.blackbox-option-sub-title strong { font-weight:700; }
			
			.blackbox-option-content-header { background-color:#FFFFFF; padding:31px 0px; }
			.blackbox-option-content-header .wrap { background-color:#f3f3f3; padding:22px 0px; }

			.bb-component-title { font-size:14px; font-weight:700; color:#000; }
			.bb-component-description { font-size:13px; font-weight:300; color:#000; }

			.bb-tab { margin:0px; padding:0px; }
	        .bb-tab li { background:#303342; color:#FFF; font-size:14px; line-height:1; padding:16px; margin:0px; cursor:pointer; text-transform:uppercase; }
	        .bb-tab li.active, .bb-tab li:hover { background: #0172ac; }
	        .bb-tab li #icon { margin-right:12px; }
			.bb-tab .bb-tab-children li { background: #242633; padding-left: 46px; }
			.bb-tab .bb-tab-children li.active, .bb-tab .bb-tab-children li:hover { background: #0172ac; }
			@media screen and (max-width: 960px) {
				.blackbox-option-content { max-width:100%; }
				.blackbox-option-menu { position:absolute; z-index:10; top:0px; left:0px; }
			}
        </style>
        <?php bb_components_style(); // bb_components_style ?>
    
	<?php $get_post_meta_array = get_post_meta_array(); foreach($get_post_meta_array as $a) {
	foreach($a["option"] as $k) { if($box["id"] == $a["id"]) { // FOREACH OPTION ?>
    
    	<?php $value = get_post_meta( $object->ID, $k["name"], true ); if(empty($value)) { $value = $k["default_value"]; } ?>

		<?php $bb_components_args = array( // VM COMPONENETS ARGS
            "type" => (!empty($k["type"])) ? $k["type"] : "none",
            "id" => $k["id"],
            "title" => $k["title"],
            "sub-title" => $k["sub-title"],
            "class" => $k["class"],
            "name" => $k["name"],
            "description" => $k["description"],
            "option" => $k["option"],
            "label" => $k["label"],
            "depend" => $k["depend"],
            "off" => $k["off"],
            "on" => $k["on"],
            "value" => $value,
        ); // VM COMPONENETS ARGS ?>
    
		<?php if($k["type"] == "title" || $k["type"] == "divider" || $k["type"] == "options-results") { // TYPE IF ?>
            <div id="<?php echo $k["id"]; ?>-depend" class="bb-row"><div class="bb-col-12 mar-none"><?php bb_components($bb_components_args);  // VM COMPONENETS ?></div></div>
        <?php } else { // TYPE IF ?>
            <div id="<?php echo $k["id"]; ?>-depend" class="bb-row md-col-12">
            	<?php if($a["context"] == "side") { ?>
                    <p class="bb-component-title"><?php echo $k["title"]; ?></p>
                    <p class="bb-component-description"><?php echo $k["description"]; ?></p>
                    <?php bb_components($bb_components_args);  // VM COMPONENETS ?>
                <?php } else { ?>
                    <div class="bb-col-4">
                        <div class="bb-component-title"><?php echo $k["title"]; ?></div>
                        <div class="bb-component-description"><?php echo $k["description"]; ?></div>
                    </div>
                    <div class="bb-col-8"><?php bb_components($bb_components_args);  // VM COMPONENETS ?></div>
                <?php } ?>
            </div>
        <?php } // TYPE IF ?>

	<?php } } } // FOREACH OPTION
}

#BB_SAVE_META_BOX
function BB_SAVE_META_BOX( $post_id, $post ) {
	if ( ! isset( $_POST['myplugin_inner_custom_box_nonce'] ) ) { return $post_id; }
	$nonce = $_POST['myplugin_inner_custom_box_nonce'];
	if ( ! wp_verify_nonce( $nonce, 'myplugin_inner_custom_box' ) ) { return $post_id; }
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return $post_id; }

	$get_post_meta_array = get_post_meta_array(); foreach($get_post_meta_array as $a) { foreach($a["option"] as $x) {
		$meta_key = $x["name"];
		$new_meta_value = ( isset( $_POST[$meta_key] ) ? $_POST[$meta_key] : '' );
		if(empty($new_meta_value)) { $new_meta_value = $x["default_value"]; }
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		if ( $new_meta_value ) { update_post_meta( $post_id, $meta_key, $new_meta_value ); }
	} }
} add_action( 'save_post', 'BB_SAVE_META_BOX', 10, 2 );

#MAIN ARRAY
function get_post_meta_array() {
	$data = "";

	$BB_METABOX_ARR_FRAMEWORK_LIST = (function_exists("BB_METABOX_ARR_FRAMEWORK_LIST")) ? BB_METABOX_ARR_FRAMEWORK_LIST() : array();
	$BB_METABOX_ARR_LIST = (function_exists("BB_METABOX_ARR_LIST")) ? BB_METABOX_ARR_LIST() : array();
	$BB_METABOX_ARR = (function_exists("BB_METABOX_ARR")) ? BB_METABOX_ARR() : array();

	return $BB_METABOX_ARR;

	$LIST1 = array_merge($BB_METABOX_ARR, $BB_METABOX_ARR_FRAMEWORK_LIST);
	$LIST2 = array_merge($BB_METABOX_ARR_LIST, $BB_METABOX_ARR_FRAMEWORK_LIST);

	$data = (function_exists("BB_METABOX_ARR")) ? $LIST1 : $LIST2; return $data;
}

#BB_PM
if(!function_exists("BB_PM")) { function BB_PM($postID, $metabox) { $metabox = get_post_meta($postID, $metabox, true); return $metabox; } } #GET VENTIX METABOX VALUE

?>