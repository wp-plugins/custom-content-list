<form class="ccl-form" st>
	<table class="form-table describe media-upload-form">
		
		<tr><td colspan="2"><h3><?php _e('Content type choice', 'ccl'); ?></h3></td></tr> 
		
		<tr valign="top" class="field">
			<th class="label" scope="row" style="width:300px;">
				<label for="ccl_post_type"><span class="alignleft"><?php _e('Select a post type', 'ccl'); ?></label>
			</th>
			<td>
				<select name="ccl_post_type" id="ccl_post_type">
						<option value="any"><?php _e('All post types', 'ccl'); ?></option>
					<?php
					foreach( (array) get_post_types(array( 'public' =>true ),'objects','and') as $post_type ) {
						echo '<option value="'.$post_type->name.'">'.$post_type->label.'</option>' . "\n";
					} ?>
				</select>
			</td>
		</tr>
		<tr valign="top" class="field">
			<th class="label" scope="row">
				<label for="ccl_taxonomy"><span class="alignleft"><?php _e('Select a taxonomy', 'ccl'); ?></label>
			</th>
			<td>
				<select name="ccl_taxonomy" id="ccl_taxonomy">
					<option value="any"><?php _e('All taxonomies', 'ccl'); ?></option>
					<?php
					foreach( (array) get_taxonomies(array( 'public' =>true ),'objects','and') as $taxonomy ) {
						echo '<option value="'.$taxonomy->name.'">'.$taxonomy->label.'</option>' . "\n";
					} ?>
				</select>
				<select name="ccl_terms" id="ccl_terms">
					<option value="all_taxo"><?php _e('All terms', 'ccl'); ?></option>
				</select>
			</td>
		</tr>
		
		<tr><td colspan="2"><h3><?php _e('Options', 'ccl'); ?></h3></td></tr> 
		
		<tr valign="top" class="field">
			<th class="label" scope="row"><label for="ccl_title"><span class="alignleft"><?php _e('Title: ', 'ccl'); ?></span></label></th>
			<td><input type="text" name="ccl_title" id="ccl_title" /></td>
		</tr>
		
		<tr valign="top" class="field">
			<th class="label" scope="row"><label for="ccl_orderby"><span class="alignleft"><?php _e('Sort by:', 'ccl'); ?></span></label></th>
			<td>
				<input type="radio" name="ccl_orderby" value="date" checked="checked" /> <?php _e('Date', 'ccl'); ?>
				<input type="radio" name="ccl_orderby" value="menu_order" /> <?php _e('Menu order', 'ccl'); ?>
				<input type="radio" name="ccl_orderby" value="title" /> <?php _e('Title', 'ccl'); ?>
			</td>
		</tr>
		
		<tr valign="top" class="field">
			<th class="label" scope="row"><label for="ccl_order"><span class="alignleft"><?php _e('Order: ', 'ccl'); ?></span></label></th>
			<td>
				<input type="radio" name="ccl_order" value="desc" checked="checked" /> <?php _e('DESC', 'ccl'); ?>
				<input type="radio" name="ccl_order" value="asc" /> <?php _e('ASC', 'ccl'); ?>
			</td>
		</tr>
		
		<tr valign="top" class="field">
			<th class="label" scope="row"><label for="ccl_showposts"><span class="alignleft"><?php _e('Number of posts to show: ', 'ccl'); ?></span></label></th>
			<td>
				<input type="number" min="0" max="1000" name="ccl_showposts" id="ccl_showposts" value="10" />
			</td>
		</tr>
		
		<tr valign="top" class="field">
			<th class="label" scope="row"><label for="ccl_see_all_label"><span class="alignleft"><?php _e('"Show all" link label: ', 'ccl'); ?></span></label></th>
			<td>
				<input type="text" name="ccl_see_all_label" id="ccl_see_all_label" />
			</td>
		</tr>
		
		<tr valign="top" class="field">
			<th class="label" scope="row"><label for="ccl_see_all_link"><span class="alignleft"><?php _e('"Show all" link url: ', 'ccl'); ?></span></label></th>
			<td>
				<input type="text" name="ccl_see_all_link" id="ccl_see_all_link" />
			</td>
		</tr>
		
		<tr valign="top" class="field">
			<td colspan="2">
				<input name="insert_custom_content_list" type="submit" class="button-primary" id="insert_custom_content_list" tabindex="5" accesskey="p" value="<?php _e('Insert the list', 'ccl'); ?>">
			</td>
		</tr>
		
	</table>
	
</form>
<script type="text/javascript">
	jQuery(function(){ 
		jQuery('#ccl_terms').hide();
		jQuery('#ccl_taxonomy').change(function() { 
			var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
			jQuery.ajax({
				url : ajaxurl,
				dataType: 'json',
				data : {
				action: 'ccl_reload_terms',
				taxonomy: jQuery(this).val()
				},
				beforeSend : function(){
					jQuery('#ccl_terms').hide('fast');
				},
				success:function(data){
					jQuery('#ccl_terms').show('fast');
					jQuery('#ccl_terms option:not(option:first)').remove();
					if (  typeof data == 'object' ) {
						var i = 0;
						var dataLength = data.length;
						for( i; i < dataLength ; i++ ) {
							var el= jQuery( '<option />' );
							el.attr(
								{ value : data[i].slug } 
							 ).html( data[i].name.substr(0,35)  );
							 
							el.appendTo( jQuery('#ccl_terms') );
						}
					}
				}
			})
		});
	});	
</script>