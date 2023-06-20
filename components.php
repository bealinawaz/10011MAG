<?php
function bb_components($k) { ob_start(); // UM COMPONENTS
	$row = "bb-row";
	$col0 = "bb-col-12 mar-none";
	$col1 = "bb-col-4 mar-none";
	$col2 = "bb-col-8 mar-none";
	$value = $k["value"];
	$option = $k["option"];
	$label = $k["label"];
	$depend = $k["depend"];
	$typo_args = array( "title" => $k["title"], "description" => $k["description"], "class" => $k["class"], "id" => $k["id"], "label" => $label, ); // TYPO ARGS
?>
<?php if($k["type"] == "options-import-export") { // OPTIONS RESULTS ?>
	<div class="bb-row"><div class="bb-col-12"><?php bb_components(array ( "type" => "title", "title" => "Import", "heading" => "h3" )); // TITLE ?></div></div>
	<div class="bb-row"><div class="bb-col-12">
		<?php bb_components(array ( "type" => "textarea", "title" => "Import Data", "description" => "Import Data: Paste the content and save to import the blackbox options.", "id" => "import-data", "class" => "import-data", "name" => "import-data")); ?>
	</div></div>
	<div class="bb-row"><div class="bb-col-12">
		<?php bb_components(array ( "type" => "submit", "id" => "import-data-btn", "class" => "import-data-btn", "name" => "import-data-btn", "value" => "Import Data")); ?>
    </div></div>
	<div class="bb-row"><div class="bb-col-12"><?php bb_components(array ( "type" => "title", "title" => "Export", "heading" => "h3" )); // TITLE ?></div></div>
	<div class="bb-row"><div class="bb-col-12">
		<a id="exportJSON" class="exportJSON bb-button button ui positive active" onclick="exportJson(this);">Export JSON</a>
        <script type="text/javascript">
			function exportJson(el) {
				var obj = <?php echo bb_theme_options_export_values(); ?>;
				var data = "text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(obj));
				// what to return in order to show download window?			
				el.setAttribute("href", "data:"+data); el.setAttribute("download", "VentixThemeOptions.json");
			}
        </script>
		<?php // $export_data_value = bb_theme_options_export_values(); bb_components(array ( "type" => "textarea", "title" => "Export Data", "description" => "Export Data: Copy his content and save in a txt file.", "id" => "export-data", "class" => "export-data", "name" => "export-data", "value" => $export_data_value)); ?>
    </div></div>
<?php } // OPTIONS EXPORT ?>

<?php if($k["type"] == "options-results") { // OPTIONS RESULTS ?>
	<h3>Current Values</h3>
	<table>
    	<tr><td>Keys</td><td>Values</td></tr>
        <?php $data = bb_theme_options_default_values(); foreach( $data as $data_k => $data_v ) { // FOREACH ?>
	    	<tr><td><?php echo $data_k; ?></td><td><?php var_dump(get_option($data_k)); ?></td></tr>
        <?php } // FOREACH ?>
    </table>
	<h3>Default Values</h3>
	<table>
    	<tr><td>Keys</td><td>Values</td></tr>
        <?php $data = bb_theme_options_default_values(); foreach( $data as $data_k => $data_v ) { // FOREACH ?>
	    	<tr><td><?php echo $data_k; ?></td><td><?php var_dump($data_v); ?></td></tr>
        <?php } // FOREACH ?>
    </table>
<?php } // OPTIONS RESULTS ?>

<?php if($k["type"] == "divider") { ?><hr/><?php } ?>

<?php if($k["type"] == "title") { ?>
	<?php if($k["heading"] == "") { $k["heading"] = "h4"; } echo '<'.$k["heading"].' class="bb-headings" title="'.$k["title"].'">'.$k["title"].'</'.$k["heading"].'>'; ?>
<?php } ?>

<?php if($k["type"] == "button" || $k["type"] == "submit") { // TYPE BUTTON ?>
    <input class="bb-button button ui positive active <?php echo $k["class"]; ?>" type="<?php echo $k["type"]; ?>" id="<?php echo $k["id"]; ?>" name="<?php echo $k["name"]; ?>" value="<?php echo $value; ?>" />
<?php } // TYPE BUTTON ?>


<?php if($k["type"] == "feature") { // TYPE TEXT ?>
	<style>
		#multi_feature { margin-bottom: 15px; }
		#multi_feature .remove-items { position: relative; margin-bottom: 15px; }
		#multi_feature .remove-items i { position: absolute; top: 50%; right: 15px; font-size: 30px; transform: translateY(-50%); cursor: pointer; }
	</style>
	<div id="multi_feature">
		<?php foreach($value as $v) { ?>
			<div class="remove-items"><input class="bb-text <?php echo $k["class"]; ?>" type="text" id="<?php echo $k["id"]; ?>" name="<?php echo $k["name"]; ?>[]" value="<?php echo $v; ?>" /><i onClick="jQuery(this).parent().remove();">X</i></div>
		<?php } ?>
	</div>
	<div class="button button-primary button-large" id="add_new_feature">+Add New</div>
	<script>jQuery("#add_new_feature").click(function(){
		jQuery("#multi_feature").append('<div class="remove-items"><input class="bb-text <?php echo $k["class"]; ?>" type="text" id="<?php echo $k["id"]; ?>" name="<?php echo $k["name"]; ?>[]" value="" /><i onClick="jQuery(this).parent().remove();">X</i></div>');
	});</script>
<?php } // TYPE TEXT ?>

<?php if($k["type"] == "text") { // TYPE TEXT ?>
	<?php if($option["join"] === true) { ?>
		<div class="data-join data-join-<?php echo $option["side"]; ?>">
		<span class="data-join-unit data-join-<?php echo $option["side"]; ?>"><?php echo $option["unit"]; ?></span>
	<?php } ?>
		<?php if(empty($option["width"])) { $option["width"] = 100; } ?>
		<input class="bb-text <?php echo $k["class"]; ?>" type="text" id="<?php echo $k["id"]; ?>" name="<?php echo $k["name"]; ?>" value="<?php echo $value; ?>" style="width:<?php echo $option["width"]; ?>%;" />
	<?php if($option["join"] === true) { ?></div><?php } ?>
<?php } // TYPE TEXT ?>

<?php if($k["type"] == "textarea") { ?>
	<textarea class="bb-textarea <?php echo $k["class"]; ?>" name="<?php echo $k["name"]; ?>" id="<?php echo $k["id"]; ?>" rows="10"><?php echo stripslashes($value); ?></textarea>
<?php } ?>

<?php if($k["type"] == "select") { // SELECT ?>
	<select class="bb-select <?php echo $k["class"]; ?>" id="<?php echo $k["id"]; ?>">
		<?php if(is_array($option)) { foreach($option as $opt_k => $opt_v) { ?>
			<option <?php selected($value, $opt_k); ?> value="<?php echo $opt_k; ?>"><?php echo $opt_v; ?></option>
		<?php } } ?>
	</select>
    <input type="hidden" name="<?php echo $k["name"]; ?>" id="<?php echo $k["id"]; ?>-input" value="<?php echo $value; ?>" />
    <script>jQuery(document).ready(function(e) {
        jQuery("#<?php echo $k["id"]; ?>").change(function() {
			var change_select = jQuery("#<?php echo $k["id"]; ?>").val();
			jQuery("#<?php echo $k["id"]; ?>-input").val(change_select);
			jQuery("#<?php echo $k["id"]; ?>-input").addClass("info-update");
		});
    });</script>
<?php } // SELECT ?>

<?php if($k["type"] == "select-nav") { // NAV SELECT ?>
    <?php $typo_args["type"] = "select"; $typo_args["name"] = $k["name"]; $typo_args["value"] = $value; $typo_args["option"] = menu_list($option); bb_components($typo_args); ?>
<?php } // NAV SELECT ?>

<?php if($k["type"] == "select-sidebar") { // SIDEBAR SELECT ?>
    <?php $typo_args["type"] = "select"; $typo_args["name"] = $k["name"]; $typo_args["value"] = $value; $typo_args["option"] = sidebar_list($option); bb_components($typo_args); ?>
<?php } // SIDEBAR SELECT ?>

<?php if($k["type"] == "select-rev-slider") { // REV SLIDER SELECT ?>
    <?php $typo_args["type"] = "select"; $typo_args["name"] = $k["name"]; $typo_args["value"] = $value; $typo_args["option"] = rev_slider_list($option); bb_components($typo_args); ?>
<?php } // REV SLIDER SELECT ?>

<?php if($k["type"] == "color") { #COLOR ?>
    <div class="bb-color"><input type="text" class="<?php echo $k["class"]; ?> spectrbb-color" id="<?php echo $k["id"]; ?>" name="<?php echo $k["name"]; ?>" value="<?php echo $value; ?>" /></div>
<?php } #COLOR ?>

<?php if($k["type"] == "checkbox") { // CHECKBOX ?>
	<div class="bb-checkbox"><div id="<?php echo $k["id"]; ?>-toggle" class="ui toggle checkbox">		            
        <input type="checkbox" class="<?php echo $k["class"]; ?>" id="<?php echo $k["id"]; ?>" name="<?php echo $k["name"]; ?>" value="1" <?php checked($value, 1); ?> />
        <label for="<?php echo $k["id"]; ?>"></label>
    </div></div>
<?php } // CHECKBOX ?>

<?php /* if($k["type"] == "checkbox") { // CHECKBOX ?>
	<?php if(is_array($option)) { $count = 0; foreach($option as $get_k => $get_v) { // IF // FOREACH ?><div class="bb-checkbox">
    	<div id="<?php echo $k["id"]; ?>-depend-obj" class="ui toggle checkbox">
        	<input type="checkbox" class="<?php echo $k["class"]; ?>" id="<?php echo $k["id"].$count; ?>" name="<?php echo $k["name"]; ?>[check<?php echo $count; ?>]" value="<?php echo $get_k; ?>" <?php if(is_array($value)) { foreach($value as $val) { checked($val, $get_k); } } ?> />
            <label for="<?php echo $k["id"].$count; ?>"><?php echo $get_v; ?></label>
		</div>
    </div><?php $count++; } } // FOREACH // IF ?>
<?php } // CHECKBOX */ ?>

<?php if($k["type"] == "radio-image") { // RADIO IMAGE ?>
	<div class="bb-radio-image">
		<?php if(is_array($k["option"])) { $count = 0; foreach($k["option"] as $opt_k => $opt_v) { ?>
        	<input type="radio" class="<?php echo $k["class"]; ?>" id="<?php echo $k["id"].$opt_k; ?>" name="<?php echo $k["name"]; ?>" value="<?php echo $opt_k; ?>" <?php checked($value, $opt_k); ?> /><label for="<?php echo $k["id"].$opt_k; ?>"><?php echo $opt_v; ?></label>
		<?php $count++; } } ?>
        <script>jQuery(document).ready(function(e) { jQuery(".bb-radio-image input[type=radio]").each(function(index, element) {
			var radioBtn = jQuery(this);
			radioBtn.click(function(){
				radioBtn.parent("div").children("input").each(function(index, element) { jQuery(this).removeClass("info-update"); });
				radioBtn.addClass("info-update");
			});
		}); });</script>
    </div>
<?php } // RADIO IMAGE ?>

<?php if($k["type"] == "radio") { // RADIO ?>
	<div class="bb-radio"><?php if(is_array($k["option"])) { $count = 0; foreach($k["option"] as $opt_k => $opt_v) { ?><input type="radio" class="<?php echo $k["class"]; ?>" id="<?php echo $k["id"].$count; ?>" name="<?php echo $k["name"]; ?>" value="<?php echo $opt_k; ?>" <?php checked($value, $opt_k); ?> /><label for="<?php echo $k["id"].$count; ?>"><?php echo $opt_v; ?></label><?php $count++; } } ?></div>
<?php } // RADIO ?>

<?php if($k["type"] == "switch") { // SWITCH ?>
	<div class="ui buttons">
		<span id="off-<?php echo $k["id"]; ?>" class="ui positive button <?php echo ($value == $k["off"]) ? "active" : ""; ?>"><?php echo $k["off"]; ?></span>
		<div class="or"></div>
		<span id="on-<?php echo $k["id"]; ?>" class="ui positive button <?php echo ($value == $k["on"]) ? "active" : ""; ?>"><?php echo $k["on"]; ?></span>
	</div>
	<input class="<?php echo $k["class"]; ?>" type="hidden" id="<?php echo $k["id"]; ?>" name="<?php echo $k["name"]; ?>" value="<?php echo $value; ?>" />
	<script>jQuery(document).ready(function(e) {
		jQuery("#off-<?php echo $k["id"]; ?>").click(function(){
			jQuery("#<?php echo $k["id"]; ?>").addClass("info-update");
			jQuery("#<?php echo $k["id"]; ?>").val("<?php echo $k["off"]; ?>");
			<? /* jQuery("#off-<?php echo $k["id"]; ?>").removeClass("inactive"); jQuery("#on-<?php echo $k["id"]; ?>").removeClass("inactive"); */ ?>
			jQuery("#off-<?php echo $k["id"]; ?>").removeClass("active"); jQuery("#on-<?php echo $k["id"]; ?>").removeClass("active");
			jQuery("#off-<?php echo $k["id"]; ?>").addClass("active"); <? /* jQuery("#on-<?php echo $k["id"]; ?>").addClass("inactive"); */ ?>
		});
		jQuery("#on-<?php echo $k["id"]; ?>").click(function(){
			jQuery("#<?php echo $k["id"]; ?>").addClass("info-update");
			jQuery("#<?php echo $k["id"]; ?>").val("<?php echo $k["on"]; ?>");
			<? /*jQuery("#on-<?php echo $k["id"]; ?>").removeClass("inactive"); jQuery("#off-<?php echo $k["id"]; ?>").removeClass("inactive"); */ ?>
			jQuery("#on-<?php echo $k["id"]; ?>").removeClass("active"); jQuery("#off-<?php echo $k["id"]; ?>").removeClass("active");
			jQuery("#on-<?php echo $k["id"]; ?>").addClass("active"); <? /* jQuery("#off-<?php echo $k["id"]; ?>").addClass("inactive"); */ ?>
		});
	});</script>
<?php } // SWITCH ?>

<?php if($k["type"] == "on-off") { // ON-OFF ?>
	<div class="ui buttons">
		<span id="off-<?php echo $k["id"]; ?>" class="ui positive button inactive_h <?php echo ($value != 1) ? "inactive" : ""; ?>"><?php echo $k["off"]; ?></span>
		<div class="or"></div>
		<span id="on-<?php echo $k["id"]; ?>" class="ui positive button <?php echo ($value == 1) ? "active" : ""; ?>"><?php echo $k["on"]; ?></span>
	</div>
    <input class="<?php echo $k["class"]; ?>" type="hidden" id="<?php echo $k["id"]; ?>" name="<?php echo $k["name"]; ?>" value="<?php echo $value; ?>" />
	<script>jQuery(document).ready(function(e) {
		jQuery("#off-<?php echo $k["id"]; ?>").click(function(){
			jQuery("#<?php echo $k["id"]; ?>").val(0);
			jQuery("#off-<?php echo $k["id"]; ?>").removeClass("inactive"); jQuery("#on-<?php echo $k["id"]; ?>").removeClass("inactive");
			jQuery("#off-<?php echo $k["id"]; ?>").removeClass("active"); jQuery("#on-<?php echo $k["id"]; ?>").removeClass("active");
			jQuery("#off-<?php echo $k["id"]; ?>").addClass("inactive");
		});
		jQuery("#on-<?php echo $k["id"]; ?>").click(function(){
			jQuery("#<?php echo $k["id"]; ?>").val(1);
			jQuery("#on-<?php echo $k["id"]; ?>").removeClass("inactive"); jQuery("#off-<?php echo $k["id"]; ?>").removeClass("inactive");
			jQuery("#on-<?php echo $k["id"]; ?>").removeClass("active"); jQuery("#off-<?php echo $k["id"]; ?>").removeClass("active");
			jQuery("#on-<?php echo $k["id"]; ?>").addClass("active");
		});
	});</script>
<?php } // ON-OFF ?>

<?php if($k["type"] == "border") { // BORDER ?>
	<div class="bb-border">
        <div class="bb-col-12 mar-none">
        	<label for="<?php echo $k["id"]."-width"; ?>">Width</label>
			<?php $typo_args["type"] = "text"; $typo_args["id"] = $k["id"]."[width]"; $typo_args["name"] = $k["name"]."[width]"; $typo_args["value"] = $value["width"]; bb_components($typo_args); ?>
        </div>
        <div class="bb-col-12 mar-none">
        	<label for="<?php echo $k["id"]."-style"; ?>">Style</label><?php $typo_args["type"] = "radio"; $typo_args["id"] = $k["id"]."[style]"; $typo_args["name"] = $k["name"]."[style]"; $typo_args["value"] = $value["style"]; $typo_args["option"] = array("solid" => "Solid", "dashed" => "Dashed", "dotted" => "Dotted", "double" => "Double", "groove" => "Groove", "outset" => "Outset", "ridge" => "Ridge"); bb_components($typo_args); ?>
        </div>
        <div class="bb-col-12 mar-none">
			<?php $typo_args["type"] = "color"; $typo_args["name"] = $k["name"]; $typo_args["value"] = $value; $typo_args["label"] = array("color" => "Color"); $typo_args["default_value"] = array("color" => $k["default_value"]["color"]); bb_components($typo_args); ?>
        </div>
    </div>
<?php } // BORDER ?>

<?php if($k["type"] == "typography") { // TYPOGRAPHY ?>

	<div class="bb-typography">

		<div class="bb-row mar-child-none">

			<?php if($option["backup-font"] !== false) { // Visible ?>

			<div class="bb-col-12"><label for="<?php echo $k["id"]; ?>">Backup Font</label><?php $typo_args["type"] = "select"; $typo_args["id"] = $k["id"]."-backup-font"; $typo_args["name"] = $k["name"]."[backup-font]"; $typo_args["value"] = $value["backup-font"]; $typo_args["option"] = backupfonts(); bb_components($typo_args); ?></div>

			<?php } // Visible ?>

		</div>

		<div class="bb-row mar-child-none">

			<?php if($option["font"] !== false) { // Visible ?>

			<div class="bb-col-6">
            	<label for="<?php echo $k["id"]; ?>">Font Family</label><?php $typo_args["type"] = "select"; $typo_args["id"] = $k["id"]."-font"; $typo_args["name"] = $k["name"]."[font]"; $typo_args["value"] = $value["font"]; $typo_args["option"] = googlefonts(); bb_components($typo_args); ?>
            </div>

			<?php } // Visible ?>

			<?php if($option["weight"] !== false) { // Visible ?>

			<? /* <div class="bb-col-6"><label for="<?php echo $k["id"]; ?>">Font Weight</label><?php $typo_args["type"] = "select"; $typo_args["name"] = $k["name"]."[weight]"; $typo_args["value"] = $value["weight"]; $typo_args["option"] = font_weight($value["font"]); bb_components($typo_args); ?></div> */ ?>
            <div class="bb-col-6">
            	<label for="<?php echo $k["id"]."-weight"; ?>">Font Weight <img src="<?php echo get_template_directory_uri() . '/frameworks/blackbox-framework/images/ajax-loader.gif'; ?>" class="<?php echo $k["id"]."-ajax-loader-img"; ?>" style="display:none;" /></label>
	        	<input type="hidden" name="<?php echo $k["name"]."[weight]"; ?>" id="<?php echo $k["id"]."-weight"; ?>" value="<?php echo $value["weight"]; ?>" />
	            <div id="<?php echo $k["id"]."-ajax-font"; ?>"></div>
				<script type="text/javascript">
                    jQuery(document).ready(function(e) {
						jQuery(document).ajaxStart(function(e) { jQuery( ".<?php echo $k["id"]."-ajax-loader-img"; ?>" ).show(); });
						jQuery(document).ajaxComplete(function(e) { jQuery( ".<?php echo $k["id"]."-ajax-loader-img"; ?>" ).hide(); });
                        var font=jQuery('#<?php echo $k["id"]."-font"; ?>').val();
                        typo_fontfamily_weight_ajax({dataVal:{font:font, type:"select", class:"<?php echo $k["class"]."-weight"; ?>", id:"<?php echo $k["id"]."-weight"; ?>", name:"<?php echo $k["name"]."[weight]"; ?>", value:"<?php echo $value["weight"]; ?>", }, url:"<?php echo get_template_directory_uri() . '/frameworks/blackbox-framework/ajax/ajax.php'; ?>", susID:"#<?php echo $k["id"]."-ajax-font"; ?>"});
                        jQuery("#<?php echo $k["id"]."-font"; ?>").change(function(){
                            var font=jQuery('#<?php echo $k["id"]."-weight"; ?>').val("");
                            var font=jQuery('#<?php echo $k["id"]."-font"; ?>').val();
							typo_fontfamily_weight_ajax({dataVal:{font:font, type:"select", class:"<?php echo $k["class"]."-weight"; ?>", id:"<?php echo $k["id"]."-weight"; ?>", name:"<?php echo $k["name"]."[weight]"; ?>", value:"<?php echo $value["weight"]; ?>", }, url:"<?php echo get_template_directory_uri() . '/frameworks/blackbox-framework/ajax/ajax.php'; ?>", susID:"#<?php echo $k["id"]."-ajax-font"; ?>"});
                        });
                    });
                </script>
            </div>

			<?php } // Visible ?>

			<?php /* if($option["subset"] !== false) { // Visible ?><div class="bb-col-6"><label for="<?php echo $k["id"]; ?>">Font Subset</label><?php $typo_args["type"] = "select"; $typo_args["name"] = $k["name"]."[subset]"; $typo_args["value"] = $value["subset"]; $typo_args["option"] = font_subset(); bb_components($typo_args); ?></div><?php } // Visible */ ?>

		</div>

		<div class="bb-row mar-child-none">

			<?php if($option["size"] !== false) { // Visible ?>

			<div class="bb-col-4"><label for="<?php echo $k["id"]; ?>">Font Size</label><?php $typo_args["type"] = "text"; $typo_args["id"] = $k["id"]."-size"; $typo_args["name"] = $k["name"]."[size]"; $typo_args["value"] = $value["size"]; bb_components($typo_args); ?></div>

			<?php } // Visible ?>

			<?php if($option["line-height"] !== false) { // Visible ?>

			<div class="bb-col-4"><label for="<?php echo $k["id"]; ?>">Line Height</label><?php $typo_args["type"] = "text"; $typo_args["id"] = $k["id"]."-line-height"; $typo_args["name"] = $k["name"]."[line-height]"; $typo_args["value"] = $value["line-height"]; bb_components($typo_args); ?></div>

			<?php } // Visible ?>

			<?php if($option["letter-spacing"] !== false) { // Visible ?>

			<div class="bb-col-4"><label for="<?php echo $k["id"]; ?>">Letter Spacing</label><?php $typo_args["type"] = "text"; $typo_args["id"] = $k["id"]."-letter-spacing"; $typo_args["name"] = $k["name"]."[letter-spacing]"; $typo_args["value"] = $value["letter-spacing"]; bb_components($typo_args); ?></div>

			<?php } // Visible ?>

		</div>

		<div class="bb-row mar-child-none">

			<?php if($option["margin-top"] !== false) { // Visible ?>

			<div class="bb-col-6"><label for="<?php echo $k["id"]; ?>">Top Margin</label><?php $typo_args["type"] = "text"; $typo_args["id"] = $k["id"]."-margin-top"; $typo_args["name"] = $k["name"]."[margin-top]"; $typo_args["value"] = $value["margin-top"]; bb_components($typo_args); ?></div>

			<?php } // Visible ?>

			<?php if($option["margin-bottom"] !== false) { // Visible ?>

			<div class="bb-col-6"><label for="<?php echo $k["id"]; ?>">Bottom Margin</label><?php $typo_args["type"] = "text"; $typo_args["id"] = $k["id"]."-margin-bottom"; $typo_args["name"] = $k["name"]."[margin-bottom]"; $typo_args["value"] = $value["margin-bottom"]; bb_components($typo_args); ?></div>

			<?php } // Visible ?>

		</div>

		<?php if($option["font-color"] !== false) { // Visible ?>

			<?php $typo_args["type"] = "color"; $typo_args["id"] = $k["id"]."-color"; $typo_args["name"] = $k["name"]; $typo_args["value"] = $value; $typo_args["label"] = array("font-color" => "Font Color", "hover-color" => "Hover Color"); $typo_args["default_value"] = array("font-color" => $k["default_value"]["font-color"], "hover-color" => $k["default_value"]["hover-color"]); bb_components($typo_args); ?>

		<?php } // Visible ?>

	</div>

<?php } // TYPOGRAPHY ?>

<?php if($k["type"] == "social-media") { // SOCIAL MEDIA ?>
    <div class="bb-row">
        <div class="bb-col-6"><label for="<?php echo $k["id"]; ?>">Social Media</label><?php $typo_args["type"] = "select"; $typo_args["name"] = $k["name"]."[social-media]"; $typo_args["value"] = $value["social-media"]; $typo_args["option"] = social_media(); bb_components($typo_args); ?></div>
        <div class="bb-col-6"><label for="<?php echo $k["id"]; ?>">Social Link</label><?php $typo_args["type"] = "text"; $typo_args["name"] = $k["name"]."[social-link]"; $typo_args["value"] = $value["social-link"]; bb_components($typo_args); ?></div>
    </div>
<?php } // SOCIAL MEDIA ?>

<?php if($k["type"] == "dimension") { // DIMENSION ?>
	<?php $CMP = array( "type" => "text", "title" => $k["title"], "description" => $k["description"], "class" => $k["class"], "id" => $k["id"], ); // CMP ?>
	<div class="bb-dimension mar-child-none">
		<?php if($option["width"] !== false) { // Visible ?>
		<div class="bb-col-6 relative"><span class="bb-float-icon"><i class="fa fa-arrows-h"></i></span><?php $CMP["type"] = "text"; $CMP["name"] = $k["name"]."[width]"; $CMP["value"] = $value["width"]; bb_components($CMP); ?></div>
		<?php } // Visible ?>
		<?php if($option["height"] !== false) { // Visible ?>
		<div class="bb-col-6 relative"><span class="bb-float-icon"><i class="fa fa-arrows-v"></i></span><?php $CMP["type"] = "text"; $CMP["name"] = $k["name"]."[height]"; $CMP["value"] = $value["height"]; bb_components($CMP); ?></div>
		<?php } // Visible ?>
	</div>
<?php } // DIMENSION ?>



<?php if($k["type"] == "position") { // POSITION ?>

	<?php $CMP = array( "type" => "text", "title" => $k["title"], "description" => $k["description"], "class" => $k["class"], "id" => $k["id"], ); // CMP ?>

	<div class="bb-position mar-child-none">

		<?php if($option["top"] !== false) { // Visible ?>

		<div class="bb-col-3 relative"><span class="bb-float-icon"><i class="fa fa-arrow-up"></i></span><?php $CMP["name"] = $k["name"]."[top]"; $CMP["value"] = $value["top"]; bb_components($CMP); ?></div>

		<?php } // Visible ?>

		<?php if($option["right"] !== false) { // Visible ?>

		<div class="bb-col-3 relative"><span class="bb-float-icon"><i class="fa fa-arrow-right"></i></span><?php $CMP["name"] = $k["name"]."[right]"; $CMP["value"] = $value["right"]; bb_components($CMP); ?></div>

		<?php } // Visible ?>

		<?php if($option["bottom"] !== false) { // Visible ?>

		<div class="bb-col-3 relative"><span class="bb-float-icon"><i class="fa fa-arrow-down"></i></span><?php $CMP["name"] = $k["name"]."[bottom]"; $CMP["value"] = $value["bottom"]; bb_components($CMP); ?></div>

		<?php } // Visible ?>

		<?php if($option["left"] !== false) { // Visible ?>

		<div class="bb-col-3 relative"><span class="bb-float-icon"><i class="fa fa-arrow-left"></i></span><?php $CMP["name"] = $k["name"]."[left]"; $CMP["value"] = $value["left"]; bb_components($CMP); ?></div>

		<?php } // Visible ?>

	</div>

<?php } // POSITION ?>



<?php if($k["type"] == "number-slider") { // NUMBER SLIDER ?>

	<?php if( empty( $k["option"]["step"] ) ) { $k["option"]["step"] = 1; } $CMP = array( "type" => "text", "title" => $k["title"], "description" => $k["description"], "class" => $k["class"], "id" => $k["id"]."-amount", ); // CMP ?>

	<div class="bb-number-slider mar-child-none">

		<div class="bb-col-4"><?php $CMP["name"] = $k["name"]; if(empty($value)) { $value = $k["option"]["min"]; } $CMP["value"] = $value; bb_components($CMP); ?></div>

		<div class="bb-col-8">

		<script> jQuery( function() { 

		jQuery( "#<?php echo $k["id"]; ?>-slider-range-min" ).slider({ range: "min", value: <?php echo $value; ?>, step: <?php echo $k["option"]["step"]; ?>, min: <?php echo $k["option"]["min"]; ?>, max: <?php echo $k["option"]["max"]; ?>, slide: function( event, ui ) { jQuery( "#<?php echo $k["id"]; ?>-amount" ).val( ui.value ); jQuery( "#<?php echo $k["id"]; ?>-amount" ).addClass("info-update"); } }); 

		jQuery( "#<?php echo $k["id"]; ?>-amount" ).val( jQuery( "#<?php echo $k["id"]; ?>-slider-range-min" ).slider( "value" ) ); } ); 

		jQuery( "#<?php echo $k["id"]; ?>-amount" ).change(function(){

			jQuery( "#<?php echo $k["id"]; ?>-slider-range-min" ).slider({ range: "min", value: jQuery(this).val(), step: <?php echo $k["option"]["step"]; ?>, min: <?php echo $k["option"]["min"]; ?>, max: <?php echo $k["option"]["max"]; ?>, slide: function( event, ui ) { jQuery( "#<?php echo $k["id"]; ?>-amount" ).val( ui.value ); jQuery( "#<?php echo $k["id"]; ?>-amount" ).addClass("info-update"); } }); 

		});

		</script><div id="<?php echo $k["id"]; ?>-slider-range-min"></div>

		</div>

	</div>

<?php } // NUMBER SLIDER ?>

<?php if($k["type"] == "media") { // MEDIA ?>
	<div class="bb-media">
		<div class="bb-row mar-child-none">
			<div class="bb-col-6 media-button-img">
			<?php if(is_array($value)) { foreach($value as $get_k => $get_v) {
				$src = wp_get_attachment_metadata($get_v);
				$src["file"] = (!empty($src["file"])) ? $src["file"] : "";
				$baseurl = wp_upload_dir();
				$baseurl = $baseurl["baseurl"]."/".$src["file"];
			?>
	            <img id="<?php echo $k["id"]; ?>-img" src="<?php echo $baseurl; ?>" width="<?php echo $src["width"]; ?>" height="<?php echo $src["height"]; ?>" />
            <?php } } else { ?>
	            <img id="<?php echo $k["id"]; ?>-img" src="<?php echo $value; ?>" />
            <?php } ?>
            </div>
        </div>
		<div class="bb-col-3 txtleft md-txtcenter"><span id="<?php echo $k["id"]; ?>-remove-btn" class="ui button positive">Remove</span></div>
		<div class="bb-col-3 txtright md-txtcenter"><span id="<?php echo $k["id"]; ?>-upload-btn" class="ui button positive active">Upload</span></div>
		<?php if(is_array($value)) { foreach($value as $get_k => $get_v) { ?>
        	<input type="hidden" name="<?php echo $k["name"]; ?>[id]" id="<?php echo $k["id"]; ?>-input" value="<?php echo $get_v; ?>" />
		<?php } } else { ?>
        	<input type="hidden" name="<?php echo $k["name"]; ?>" id="<?php echo $k["id"]; ?>-input" value="<?php echo $value; ?>" />
        <?php } ?>
		<script>
			jQuery(document).ready(function(e) {
				jQuery("#<?php echo $k["id"]; ?>-remove-btn").click(function() {
					jQuery("#<?php echo $k["id"]; ?>-img").attr("src", "");
					jQuery("#<?php echo $k["id"]; ?>-input").val("");
					jQuery('#<?php echo $k["id"]; ?>-input').addClass("info-update");
				});
				jQuery("#<?php echo $k["id"]; ?>-upload-btn").click(function() {
					var image = wp.media({ title: 'Upload Image', multiple: <?php if($option["multiple"] == "true") { echo "true"; } else { echo "false"; } ?> }).open().on('select', function(e){
						var uploaded_image = image.state().get('selection').first(); console.log(uploaded_image);
						var image_url = uploaded_image.toJSON().url; jQuery('#<?php echo $k["id"]; ?>-img').attr('src', image_url);
						<?php if(is_string($value)) { ?>var image_url = uploaded_image.toJSON().url; jQuery('#<?php echo $k["id"]; ?>-input').attr('name', "<?php echo $k["name"]; ?>[id]");<?php } ?>
						var image_id = uploaded_image.toJSON().id; jQuery('#<?php echo $k["id"]; ?>-input').val(image_id); jQuery('#<?php echo $k["id"]; ?>-input').addClass("info-update");
					});
				});
			});
		</script>
	</div>
<?php } // MEDIA ?>

<?php if($k["type"] == "gallery") { // MEDIA ?>
	<style type="text/css">
    	.bb-gallery-imgs { width:50px; height:50px; margin:0px 5px 5px 0px; text-align:center; float:left; background:#ccc; }
    </style>
	<div class="bb-media">
		<div id="<?php echo $k["id"]; ?>-add-img" class="bb-row">
        	<?php if(!empty($value)) { $img_val = $value; $img_val = rtrim($img_val,','); $img_val = explode(",",$img_val); foreach($img_val as $v) { $src = wp_get_attachment_image_src($v); ?>
				<div class="bb-flex bb-gallery-imgs"><img src="<?php echo $src[0]; ?>" /></div>
            <?php } } ?>
        </div>
        <input type="hidden" name="<?php echo $k["name"]; ?>" id="<?php echo $k["id"]; ?>-input" value="<?php echo $value; ?>" />
		<div class="bb-row"><span id="<?php echo $k["id"]; ?>-upload-btn" class="ui button positive active">Gallery</span></div>
		<div class="bb-row"><span id="<?php echo $k["id"]; ?>-remove-btn" class="ui button positive">Remove</span></div>
		<script>
			jQuery(document).ready(function(e) {
				jQuery("#<?php echo $k["id"]; ?>-remove-btn").click(function() {
					jQuery("#<?php echo $k["id"]; ?>-add-img").html("");
					jQuery("#<?php echo $k["id"]; ?>-input").val("");
					jQuery('#<?php echo $k["id"]; ?>-input').addClass("info-update");
				});
				jQuery("#<?php echo $k["id"]; ?>-upload-btn").click(function() {
					var image = wp.media({ button:{text: 'Gallery'}, title: 'Gallery Images', multiple: true }).open().on('select', function(e){
						jQuery("#<?php echo $k["id"]; ?>-add-img").html("");
						jQuery("#<?php echo $k["id"]; ?>-input").val("");
						var uploaded_image = image.state().get('selection').toJSON(); console.log(uploaded_image);
						jQuery.each(uploaded_image, function( index, value ) {
							var input_val = jQuery("#<?php echo $k["id"]; ?>-input").val();
							var input_val = input_val.concat(value["id"]+",");
							jQuery("#<?php echo $k["id"]; ?>-input").val(input_val);
							jQuery("#<?php echo $k["id"]; ?>-add-img").append('<div class="bb-flex bb-gallery-imgs"><img src="'+value["url"]+'" /></div>');
						});
						jQuery('#<?php echo $k["id"]; ?>-input').addClass("info-update");
					});
				});
			});
		</script>
	</div>
<?php } // MEDIA ?>

<?php if($k["type"] == "background") { // BACKGROUND IMAGE ?>

	<div class="bb-background-image">

		<div id="<?php echo $k["id"]; ?>-color-depend">

			<?php $typo_args["type"] = "color"; $typo_args["name"] = $k["name"]."[bg-color]"; $typo_args["value"] = $value["bg-color"]; $typo_args["label"] = array("bg-color" => ""); $typo_args["default_value"] = $k["default_value"]; bb_components($typo_args); ?>

        </div>

		<div id="<?php echo $k["id"]; ?>-image-depend">

            <div class="bb-row"><div class="bb-col-12 mar-left-none mar-right-none">

                <?php $typo_args["type"] = "media"; $typo_args["id"] = $k["id"]; $typo_args["name"] = $k["name"]."[bg-image]"; $typo_args["value"] = $value["bg-image"]; bb_components($typo_args); ?>

            </div></div>

            <div class="bb-row"><div class="bb-col-12 mar-left-none mar-right-none">

                <?php $typo_args["type"] = "radio"; $typo_args["id"] = $k["id"]."-bg-repeat"; $typo_args["name"] = $k["name"]."[bg-repeat]"; $typo_args["value"] = $value["bg-repeat"]; $typo_args["option"] = array("repeat" => "Repeat", "no-repeat" => "No Repeat", "repeat-x" => "Repeat X", "repeat-y" => "Repeat Y"); bb_components($typo_args); ?>

            </div></div>

            <div class="bb-row">

                <div class="bb-col-6 mar-left-none mar-right-none">

                    <?php $typo_args["type"] = "radio"; $typo_args["id"] = $k["id"]."-bg-size"; $typo_args["name"] = $k["name"]."[bg-size]"; $typo_args["value"] = $value["bg-size"]; $typo_args["option"] = array("contain" => "Contain", "cover" => "Cover"); bb_components($typo_args); ?>

                </div>

                <div class="bb-col-6 mar-left-none mar-right-none">

                    <?php $typo_args["type"] = "radio"; $typo_args["id"] = $k["id"]."-bg-attachment"; $typo_args["name"] = $k["name"]."[bg-attachment]"; $typo_args["value"] = $value["bg-attachment"]; $typo_args["option"] = array("fixed" => "Fixed", "scroll" => "Scroll"); bb_components($typo_args); ?>

                </div>

            </div>

            <div class="bb-row"><div class="bb-col-12 mar-left-none mar-right-none">

                <?php $typo_args["type"] = "select"; $typo_args["name"] = $k["name"]."[bg-position]"; $typo_args["value"] = $value["bg-position"]; $typo_args["option"] = array( "top left" => "Top Left", "top center" => "Top Center", "top right" => "Top Right", "center left" => "Center Left", "center center" => "Center Center", "center right" => "Center Right", "bottom left" => "Bottom Left", "bottom center" => "Bottom Center", "bottom right" => "Bottom Right" ); bb_components($typo_args); ?>

            </div></div>

        </div>

    </div>

<?php } // BACKGROUND IMAGE ?>

<?php if($k["type"] == "group") { // GROUP ?>
	<div id="<?php echo $k["id"]; ?>" class="bb-group <?php echo $k["class"]; ?>">
		<?php if(is_array($option)) { foreach($option as $get_opt) { // OPTION ?>
			<div class="bb-row"><div class="bb-col-12 mar-none">
				<?php
					if(isset($_POST["save-changes"]) && $_POST["hidden_field_name"] == "Y") { // SUBMIT ACTION
						$value = $_POST[ $get_opt["name"] ]; if(empty($value)) { $value = $get_opt["default_value"]; } // POST VALUE
						update_option( $get_opt["name"], $value ); // UPDATE OPTION
					} // SUBMIT ACTION

					$value = get_option($get_opt["name"]); if(empty($value)) { $value = $get_opt["default_value"]; } // GET OPTION

					$args = array( // UM COMPONENETS ARGS
						"type" => (!empty($get_opt["type"])) ? $get_opt["type"] : "none",
						"id" => $get_opt["id"],
						"title" => $get_opt["title"],
						"sub-title" => $get_opt["sub-title"],
						"class" => $get_opt["class"],
						"name" => $get_opt["name"]."[]",
						"description" => $get_opt["description"],
						"option" => $get_opt["option"],
						"label" => $get_opt["label"],
						"depend" => $get_opt["depend"],
						"off" => $get_opt["off"],
						"on" => $get_opt["on"],
						"value" => $value,
					); // UM COMPONENETS ARGS
				?>
				<div class="bb-component-title"><?php echo $get_opt["title"]; ?></div><?php // TITILE ?>

				<div class="bb-component-description"><?php echo $get_opt["description"]; ?></div><?php //DESCRIPTION ?>

				<div id="<?php echo $k["id"]; ?>-option" class="<?php echo $k["id"]; ?>-option">
					<?php if(is_array($value)) { $args["value"] = $value[0]; bb_components($args); } else { bb_components($args); } // UM COMPONENETS ?>
				</div>
			</div></div>
		<?php } } // OPTION ?>
		<div id="<?php echo $k["id"]; ?>-clone">
			<?php $value_length = count($value); $value_length = $value_length - 1; if($value_length >= 1) { for($x=1;$x<=$value_length;$x++) { ?>
				<div>
				<?php $args["value"] = $value[$x]; bb_components($args); ?>
				<span id="<?php echo $get_opt["id"]; ?>-remove" class="ui button positive remove" onclick="jQuery(this).parent().remove();">x</span>
				</div>
			<?php } } // UM COMPONENETS ?>
		</div>
		<span id="<?php echo $k["id"]; ?>-add-new" class="ui button positive active">+Add New</span>
		<script>
			jQuery(document).ready(function(e) {
				$clone = 0;
				jQuery("#<?php echo $k["id"]; ?>-add-new").on("click", function(){
					jQuery("#<?php echo $k["id"]; ?>-option").clone().appendTo("#<?php echo $k["id"]; ?>-clone").attr("id", jQuery(this).attr("id")+$clone).append('<span id="<?php echo $k["id"]; ?>-remove" class="ui button positive remove" onclick="jQuery(this).parent().remove();">x</span>');
					$clone++;
				});
			});
		</script>
	</div>
<?php } // GROUP ?>

<?php if(!empty($depend)) { #DEPEND ?><script>jQuery(document).ready(function(e) {
	
	<?php $data_val = "";
	if(is_array($depend["value"])) {
		$count = count($depend["value"]); $a = 1; foreach($depend["value"] as $dk) { $data_val .= $dk; if($a < $count) { $data_val .= ","; } $a++; }
		?>dependency( {"element":"<?php echo $depend["element"]; ?>", "id":"<?php echo $k["id"]; ?>", "value":[<?php echo $data_val; ?>] } );<?php
	} else {
		$data_val = $depend["value"];
		?>dependency( {"element":"<?php echo $depend["element"]; ?>", "id":"<?php echo $k["id"]; ?>", "value":"<?php echo $data_val; ?>" } );<?php
	} ?>

	<?php /*
	var dependency_obj = jQuery("#bb-header-top-left-depend");
	var dependency_val_obj = jQuery("input[name='select-header']:checked");
	var dependency_val_obj_id = jQuery("#select-header-depend input");
	var dependency_val = dependency_val_obj.val();
	if(dependency_val == "1") { dependency_obj.show("slow"); } else { dependency_obj.hide("slow"); }
	dependency_val_obj_id.on("change", function(){
		var dependency_obj = jQuery("#bb-header-top-left-depend");
		var dependency_val_obj = jQuery("input[name='select-header']:checked");
		var dependency_val = dependency_val_obj.val();
		if(dependency_val == "1") { dependency_obj.show("slow"); } else { dependency_obj.hide("slow"); }
	});

	<?php if($k["type"] == "checkbox") { foreach($depend["value"] as $get_k => $get_v) { // IF // FOREACH ?>
		var selector = jQuery('#<?php echo $k["id"]; ?>-depend-obj input[name="<?php echo $k["name"]; ?>[]"]:checked');
		if( selector.length == <?php echo $get_k; ?> ) { <?php foreach($get_v as $get_val) { ?> jQuery("#<?php echo $get_val; ?>-depend").slideDown("slow"); <?php } ?> }
		else { <?php foreach($get_v as $get_val) { ?> jQuery("#<?php echo $get_val; ?>-depend").slideUp("slow"); <?php } ?> }
		jQuery("#<?php echo $k["id"]; ?>-depend-obj").click(function() {
			var selector = jQuery('#<?php echo $k["id"]; ?>-depend-obj input[name="<?php echo $k["name"]; ?>[]"]:checked');
			if( selector.length == <?php echo $get_k; ?> ) { <?php foreach($get_v as $get_val) { ?> jQuery("#<?php echo $get_val; ?>-depend").slideDown("slow"); <?php } ?> }
			else { <?php foreach($get_v as $get_val) { ?> jQuery("#<?php echo $get_val; ?>-depend").slideUp("slow"); <?php } ?> }
		});
	<?php } } #FOREACH #IF ?>
	
	<?php if($k["type"] == "radio") { $count = 0; foreach($depend["value"] as $get_k => $get_v) { // IF // FOREACH ?>
		var selector = jQuery("#<?php echo $k["id"] . $count; ?>");
		if( selector.val() == "<?php echo $get_k; ?>" && selector.is(":checked")) {
			<?php foreach($get_v as $get_val) { ?> jQuery("#<?php echo $get_val; ?>").slideDown("slow"); <?php } ?>
		} else {
			<?php foreach($get_v as $get_val) { ?> jQuery("#<?php echo $get_val; ?>").slideUp("slow"); <?php } ?>
		}
		jQuery("#<?php echo $k["id"] . $count; ?>").next("label").click(function() {
			var selector = jQuery("#<?php echo $k["id"] . $count; ?>");
			if( selector.val() == "<?php echo $get_k; ?>" && selector.is(":checked")) {
				<?php foreach($get_v as $get_val) { ?> jQuery("#<?php echo $get_val; ?>").slideDown("slow"); <?php } ?>
			} else {
				<?php foreach($get_v as $get_val) { ?> jQuery("#<?php echo $get_val; ?>").slideUp("slow"); <?php } ?>
			}
		});
	<?php $count++; } } #FOREACH #IF ?>
	
	<?php if($k["type"] == "select") { foreach($depend["value"] as $get_k => $get_v) { // IF // FOREACH ?>
		var selector = jQuery('#<?php echo $k["id"]; ?>').val();
		if( selector == "<?php echo $get_k; ?>" ) { <?php foreach($get_v as $get_val) { ?> jQuery("#<?php echo $get_val; ?>-depend").slideDown("slow"); <?php } ?> }
		else { <?php foreach($get_v as $get_val) { ?> jQuery("#<?php echo $get_val; ?>-depend").slideUp("slow"); <?php } ?> }
		jQuery('#<?php echo $k["id"]; ?>').change(function(){
			var selector = jQuery('#<?php echo $k["id"]; ?>').val();
			if( selector == "<?php echo $get_k; ?>" ) { <?php foreach($get_v as $get_val) { ?> jQuery("#<?php echo $get_val; ?>-depend").slideDown("slow"); <?php } ?> }
			else {  <?php foreach($get_v as $get_val) { ?> jQuery("#<?php echo $get_val; ?>-depend").slideUp("slow"); <?php } ?> }
		});
	<?php } } #FOREACH #IF ?>
	
	<?php if($k["type"] == "text") { foreach($depend["value"] as $get_k => $get_v) { //IF // FOREACH ?>
		var selector = jQuery('#<?php echo $k["id"]; ?>').val();
		if( selector == "<?php echo $get_k; ?>" <?php if($get_k == "not_empty") { echo '|| selector != ""'; } ?>) { 
			<?php foreach($get_v as $get_val) { ?> jQuery("#<?php echo $get_val; ?>-depend").slideDown("slow"); <?php } ?> }
		else { <?php foreach($get_v as $get_val) { ?> jQuery("#<?php echo $get_val; ?>-depend").slideUp("slow"); <?php } ?> }
		jQuery('#<?php echo $k["id"]; ?>').keyup(function(){
			var selector = jQuery('#<?php echo $k["id"]; ?>').val();
			if( selector == "<?php echo $get_k; ?>"  <?php if($get_k == "not_empty") { echo '|| selector != ""'; } ?>) { 
				<?php foreach($get_v as $get_val) { ?> jQuery("#<?php echo $get_val; ?>-depend").slideDown("slow"); <?php } ?> }
			else {  <?php foreach($get_v as $get_val) { ?> jQuery("#<?php echo $get_val; ?>-depend").slideUp("slow"); <?php } ?> }
		});
	<?php } } #FOREACH #IF */ ?>

});</script><?php } #DEPEND ?>

<?php $output = ob_get_contents(); ob_end_clean(); echo $output; } // bb_components

function bb_components_style() { $declare = BB_DECLARE(); ob_start(); // bb_components_style ?><style>

<? // Media button ?> .media-button-img { background: #e0e1e2; height: 220px; display:flex; } .bb-media img { width: auto; height: auto; display: block; max-width: 100%; max-height: 100%; margin:auto; }

<? // Slider ?> .ui-widget-content { background: #e0e0e0; } .ui-slider { position: relative; text-align: left; } .ui-slider-horizontal { height: 4px;     margin-top: 18px; } .ui-slider-horizontal .ui-slider-range-min { left: 0; } .ui-slider-horizontal .ui-slider-range { top: 0; height: 100%; } .ui-slider .ui-slider-range { position: absolute; z-index: 1; display: block; border: 0; background-position: 0 0; } .ui-widget-header { background: <?php echo $declare["primary-clr"]; ?>; } .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active { background: <?php echo $declare["primary-clr"]; ?>; } .ui-slider-horizontal .ui-slider-handle { top: -8px; margin-left: -10px; } .ui-slider .ui-slider-handle { position: absolute; z-index: 2; width: 20px; height: 20px; cursor: default; -ms-touch-action: none; touch-action: none; border-radius:50%; }

<? // Input ?> .bb-input, input[type=text], input[type=search], input[type=tel], input[type=time], input[type=url], input[type=week], input[type=password], input[type=color], input[type=date], input[type=datetime], input[type=datetime-local], input[type=email], input[type=month], input[type=number], .bb-textarea, textarea, .bb-select, select { border:1px solid #e0e0e0; font-size:13px; font-weight:400; width:100%; -webkit-box-shadow:2px 2px 4px rgba(237,237,237,0.50) inset; -moz-box-shadow:2px 2px 4px rgba(237,237,237,0.50) inset; -ms-box-shadow:2px 2px 4px rgba(237,237,237,0.50) inset; -o-box-shadow:2px 2px 4px rgba(237,237,237,0.50) inset; box-shadow:2px 2px 4px rgba(237,237,237,0.50) inset; margin:0px; }

.bb-input, input[type=text], input[type=search], input[type=tel], input[type=time], input[type=url], input[type=week], input[type=password], input[type=color], input[type=date], input[type=datetime], input[type=datetime-local], input[type=email], input[type=month], input[type=number], .bb-select, select { height:39px !important; }

<? // JOIN ?> .data-join { position: relative; } .data-join.data-join-left input { padding-left:52px; } .data-join.data-join-right input { padding-right:52px; } .data-join-unit { position: absolute; top: 0px; width: 36px; height: 100%; line-height: 39px; font-size: 14px; font-weight: 300; text-align: center; background-color: #e8e8e8; color: #6a6a75; } .data-join-unit.data-join-left { left:0px; } .data-join-unit.data-join-right { right:0px; }

<? // Dimension ?> .bb-dimension input { background-color: #f8f8f8; padding-left: 52px; } .bb-dimension .bb-float-icon { font-size: 12px; color: <?php echo $declare["primary-clr"]; ?>; background-color: #FFFFFF; width: 37px; height: 37px; line-height: 37px; position: absolute; top: 1px; left: 1px; text-align: center; border-right: 1px solid #e0e0e0; }

<? // Position ?> .bb-position input { background-color: #f8f8f8; padding-left: 52px; } .bb-position .bb-float-icon { font-size: 12px; color: <?php echo $declare["primary-clr"]; ?>; background-color: #FFFFFF; width: 37px; height: 37px; line-height: 37px; position: absolute; top: 1px; left: 1px; text-align: center; border-right: 1px solid #e0e0e0; }

<? // Color ?> .wp-color-result { height: 37px; padding-left: 36px; } .wp-color-result:after { font-size: 14px; line-height: 37px; padding: 0 20px; } .wp-picker-container input[type=text].wp-color-picker { line-height: 1; margin-left: 15px; width: 75px !important; } .wp-picker-container .button { width: 75px !important; }

<? // Heading ?> .bb-headings  { margin:0px; font-size:16px; font-weight:700; background-color:#f3f3f3; padding:16px 20px; }

<? // Button ?> .ui.button { cursor:pointer; display:inline-block; min-height:1em; outline:none; border:none; vertical-align:baseline; background:#E0E1E2 none; color:rgba(0, 0, 0, 0.6); margin:0em 0.25em 0em 0em; padding:0.78571429em 1.5em 0.78571429em; text-transform:none; text-shadow:none; font-weight:bold; line-height:1em; font-style:normal; text-align: center; text-decoration:none; border-radius:0.28571429rem; box-shadow: 0px 0px 0px 1px transparent inset, 0px 0em 0px 0px rgba(34, 36, 38, 0.15) inset; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; -webkit-transition: opacity 0.1s ease, background-color 0.1s ease, color 0.1s ease, box-shadow 0.1s ease, background 0.1s ease; transition: opacity 0.1s ease, background-color 0.1s ease, color 0.1s ease, box-shadow 0.1s ease, background 0.1s ease; will-change: ''; -webkit-tap-highlight-color: transparent; } .ui.button { background:#e0e1e2 none; color:#6c6c73; font-family: open sans; font-size: 13px; font-weight: 700; line-height: 1; padding: 15px 30px 25px; width:auto !important; }
@media screen and (max-width: 780px) { .ui.button { padding: 15px 30px 15px; } }

<? // Or Buttons ?> .ui.buttons .or { position: relative; width: 0.3em; height: 2.57142857em; z-index: 3; display:inline; } .ui.buttons .or:before { position: absolute; text-align: center; border-radius: 500rem; content: 'or'; top: 50%; left: 50%; background-color: #FFFFFF; text-shadow: none; margin-top: -0.89285714em; margin-left: -0.89285714em; width: 1.78571429em; height: 1.78571429em; line-height: 1.78571429em; color: rgba(0, 0, 0, 0.4); font-style: normal; font-weight: bold; box-shadow: 0px 0px 0px 1px transparent inset; } .ui.buttons .or[data-text]:before { content: attr(data-text); }

<? // Positive ?> .ui.positive.buttons .active.button, .ui.positive.buttons .active.button:active, .ui.positive.active.button, .ui.positive.button .active.button:active { background-color:#0073aa; color:#FFFFFF; text-shadow: none; } .ui.positive.buttons .inactive.button, .ui.positive.buttons .inactive.button:active, .ui.positive.inactive.button, .ui.positive.button .inactive.button:active { background-color:#303241; color:#FFFFFF; text-shadow:none; }

<? // Hover ?> .ui.button:hover { background-color:#0073aa !important; background-image:none; box-shadow:0px 0px 0px 1px transparent inset, 0px 0em 0px 0px rgba(34, 36, 38, 0.15) inset; color:#FFFFFF; } .ui.button:hover .icon { opacity: 0.85; } .ui.button.inactive_h.button:hover { background-color:#303241 !important; color:#FFFFFF; text-shadow:none; }

<? // CheckBox ?> .bb-checkbox { margin-bottom: 5px; } .ui.checkbox{position:relative;display:inline-block;-webkit-backface-visibility:hidden;backface-visibility:hidden;outline:0;vertical-align:baseline;font-style:normal;min-height:17px;font-size:1rem;line-height:17px;min-width:17px} .ui.toggle.checkbox{min-height:1.5rem} .ui.toggle.checkbox input{display:none; } .ui.toggle.checkbox label{min-height:1.5rem;padding-left:4.5rem;color:rgba(0,0,0,.87); padding-top:.15em;} .ui.toggle.checkbox label:before{display:block;position:absolute;content:'';z-index:1;-webkit-transform:none;-ms-transform:none;transform:none;border:none;top:0;background:rgba(0,0,0,.05);width:3.5rem;height:1.5rem;border-radius:500rem} .ui.toggle.checkbox label:after{background:-webkit-linear-gradient(transparent,rgba(0,0,0,.05)) #FFF;background:linear-gradient(transparent,rgba(0,0,0,.05)) #FFF;position:absolute;content:''!important;opacity:1;z-index:2;border:none;box-shadow:0 1px 2px 0 rgba(34,36,38,.15),0 0 0 1px rgba(34,36,38,.15) inset;width:1.5rem;height:1.5rem;top:0;left:0;border-radius:500rem;-webkit-transition:background .3s ease,left .3s ease;transition:background .3s ease,left .3s ease} .ui.toggle.checkbox input~label:after{left:-.05rem} .ui.toggle.checkbox input:focus~label:before,.ui.toggle.checkbox label:hover::before{background-color:rgba(0,0,0,.15);border:none} .ui.toggle.checkbox input:checked~label{color:rgba(0,0,0,.95)!important} .ui.toggle.checkbox input:checked~label:before{background-color:<?php echo $declare["primary-clr"]; ?> !important } .ui.toggle.checkbox input:checked~label:after{left:2.15rem}.ui.toggle.checkbox input:focus:checked~.box,.ui.toggle.checkbox input:focus:checked~label{color:rgba(0,0,0,.95)!important} .ui.toggle.checkbox input:focus:checked~label:before{background-color:#0d71bb!important} .ui.fitted.checkbox label{padding-left:0!important}.ui.fitted.slider.checkbox,.ui.fitted.toggle.checkbox{ width:3.5rem; }

<? // Radio ?> .bb-radio {} .bb-radio input[type=radio] { display:none; } .bb-radio label { display:inline-block; background-color:#FFF; border:1px solid #e0e0e0; border-right-width:0px; padding:13px; font-size:13px; font-weight:400; color:#6a6a75; } .bb-radio label:last-child { border-right-width:1px; } .bb-radio label:hover, .bb-radio input[type="radio"]:checked + label { background-color:<?php echo $declare["primary-clr"]; ?>; color:#FFFFFF; }

<? // Radio Image ?> .bb-radio-image {} .bb-radio-image input[type=radio] { display:none; } .bb-radio-image label { border:4px solid #e0e0e0; margin-bottom:5px; display:inline-block; } .bb-radio-image label img { display:block; } .bb-radio-image label:hover, .bb-radio-image input[type="radio"]:checked + label { border-color:<?php echo $declare["primary-clr"]; ?>; }

</style><?php $output = ob_get_contents(); ob_end_clean(); echo $output; } // bb_components_style

function BB_DECLARE() { return array( "primary-clr" => "#0073aa", "baisc-clr" => "#e0e1e2", "inactive" => "#303241", ); } // VENTIX DECLARE

function get_media_img($img) {
	$data = ""; $data = array();
	if(is_array($img)) { foreach($img as $get_v) {
		$src = wp_get_attachment_metadata($get_v); if(empty($src["file"])) { return false; }
		$baseurl = wp_upload_dir(); $baseurl = $baseurl["baseurl"]."/".$src["file"]; $data[] = $baseurl;
	} return $data; } else { return false; }
} // GET MEDIA IMAGE

function get_media_img_url($img) {
	$data = "";
	if(is_array($img)) { foreach($img as $get_v) {
		$src = wp_get_attachment_metadata($get_v); if(empty($src["file"])) { return false; }
		$baseurl = wp_upload_dir(); $baseurl = $baseurl["baseurl"]."/".$src["file"]; $data = $baseurl;
	} return $data; } else { return $img; }
} // GET MEDIA IMAGE

if( is_admin() && ! empty ( $_SERVER['PHP_SELF'] ) && 'admin.php?page=blackbox-options' !== basename( $_SERVER['PHP_SELF'] ) ) {
    function BB_ADMIN_SCRIPTS() { wp_enqueue_media(); } add_action( 'admin_enqueue_scripts', 'BB_ADMIN_SCRIPTS' );
}

?>