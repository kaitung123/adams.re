<?php

function pmwi_pmxi_reimport($post_type, $post){

	if ( ! in_array($post_type, array('product')) and empty($post['is_override_post_type']) or ! class_exists('WooCommerce')) return;

	switch ($post_type) 
	{
		case 'product':
			
			$all_existing_attributes = array();
			$hide_taxonomies = array('product_type');
			$post_taxonomies = array_diff_key(get_taxonomies_by_object_type(array($post_type), 'object'), array_flip($hide_taxonomies));
			if (!empty($post_taxonomies)): 
				foreach ($post_taxonomies as $ctx):  if ("" == $ctx->labels->name or strpos($ctx->name, "pa_") === false) continue;
					$all_existing_attributes[] = $ctx->name;												
				endforeach;
			endif;
			if (!empty($existing_attributes)):
				foreach ($existing_attributes as $key => $attr) {
					$all_existing_attributes[] = $attr;												
				}
			endif;

			?>
			<div class="input">
				<input type="hidden" name="is_update_product_type" value="0" />
				<input type="checkbox" id="is_update_product_type_<?php echo $post_type; ?>" name="is_update_product_type" value="1" <?php echo $post['is_update_product_type'] ? 'checked="checked"': '' ?>  class="switcher"/>
				<label for="is_update_product_type_<?php echo $post_type; ?>"><?php _e('Product Type', 'wpai_woocommerce_addon_plugin') ?></label>
			</div>
			<div class="input">		
				<input type="hidden" name="attributes_list" value="0" />			
				<input type="hidden" name="is_update_attributes" value="0" />
				<input type="checkbox" id="is_update_attributes_<?php echo $post_type; ?>" name="is_update_attributes" value="1" <?php echo $post['is_update_attributes'] ? 'checked="checked"': '' ?>  class="switcher"/>
				<label for="is_update_attributes_<?php echo $post_type; ?>"><?php _e('Attributes', 'wpai_woocommerce_addon_plugin') ?></label>		
				<div class="switcher-target-is_update_attributes_<?php echo $post_type; ?>" style="padding-left:17px;">
					<div class="input">
						<input type="radio" id="update_attributes_logic_full_update_<?php echo $post_type; ?>" name="update_attributes_logic" value="full_update" <?php echo ( "full_update" == $post['update_attributes_logic'] ) ? 'checked="checked"': '' ?> class="switcher"/>
						<label for="update_attributes_logic_full_update_<?php echo $post_type; ?>"><?php _e('Update all Attributes', 'wpai_woocommerce_addon_plugin') ?></label>								
					</div>
					<div class="input">
						<input type="radio" id="update_attributes_logic_only_<?php echo $post_type; ?>" name="update_attributes_logic" value="only" <?php echo ( "only" == $post['update_attributes_logic'] ) ? 'checked="checked"': '' ?> class="switcher"/>
						<label for="update_attributes_logic_only_<?php echo $post_type; ?>"><?php _e('Update only these Attributes, leave the rest alone', 'wpai_woocommerce_addon_plugin') ?></label>								
						<div class="switcher-target-update_attributes_logic_only_<?php echo $post_type; ?> pmxi_choosen" style="padding-left:17px;">										
							
							<span class="hidden choosen_values"><?php if (!empty($all_existing_attributes)) echo implode(',', $all_existing_attributes);?></span>
							<input class="choosen_input" value="<?php if (!empty($post['attributes_list']) and "only" == $post['update_attributes_logic']) echo implode(',', $post['attributes_list']); ?>" type="hidden" name="attributes_only_list"/>																				
						</div>
					</div>
					<div class="input">
						<input type="radio" id="update_attributes_logic_all_except_<?php echo $post_type; ?>" name="update_attributes_logic" value="all_except" <?php echo ( "all_except" == $post['update_attributes_logic'] ) ? 'checked="checked"': '' ?> class="switcher"/>
						<label for="update_attributes_logic_all_except_<?php echo $post_type; ?>"><?php _e('Leave these attributes alone, update all other Attributes', 'wpai_woocommerce_addon_plugin') ?></label>								
						<div class="switcher-target-update_attributes_logic_all_except_<?php echo $post_type; ?> pmxi_choosen" style="padding-left:17px;">
							
							<span class="hidden choosen_values"><?php if (!empty($all_existing_attributes)) echo implode(',', $all_existing_attributes);?></span>
							<input class="choosen_input" value="<?php if (!empty($post['attributes_list']) and "all_except" == $post['update_attributes_logic']) echo implode(',', $post['attributes_list']); ?>" type="hidden" name="attributes_except_list"/>																														
						</div>
					</div>
				</div>
			</div>	
			<?php

			break;		
		
		default:
			# code...
			break;
	}	
}