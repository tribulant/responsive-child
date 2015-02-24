<?php $co_id = $Order -> cart_order(); ?>
<?php $items_count = (!empty($co_id)) ? $Item -> item_count($co_id, 'items') : false; ?>
<?php $units_count = (!empty($co_id)) ? $Item -> item_count($co_id, 'units') : false; ?>
<?php $subtotal = (!empty($co_id)) ? $Order -> total($co_id, false, false, true, true, false, false) : false; ?>
<?php $couponsaffectts = ($this -> get_option('couponsaffectts') == "Y") ? true : false; ?>
<?php $discount_total = (!empty($co_id)) ? $Order -> total($co_id, $couponsaffectts, false, true, true, $couponsaffectts, $couponsaffectts, true) : false; ?>
<?php $discount = (!empty($co_id)) ? $Discount -> total($co_id, $discount_total) : false; ?>
<?php $shipping = (!empty($co_id)) ? $Order -> shipping_total($subtotal, $co_id, true) : false; ?>
<?php $tax_total = (!empty($co_id)) ? $Order -> tax_total($co_id, true) : false; ?>
<?php $total_price = (!empty($co_id)) ? $Order -> total($co_id, true, true) : false; ?>

<div class="checkout_loading_overlay_wrapper">
	<div class="checkout_loading_overlay">Loading...</div>
</div>

<?php if (!empty($instance['cart_hidewhenempty']) && $instance['cart_hidewhenempty'] == 1 && empty($items_count)) : ?>	
	<div class="widget_checkout_<?php echo $instance['display']; ?>">
		<!-- hidden when empty -->
	</div>
	
	<style type="text/css">
	.widget_checkout_wrapper_<?php echo $instance['display']; ?> { display:none; }
	</style>
<?php else : ?>
	<div class="widget_checkout_<?php echo $instance['display']; ?>">
	<?php if (!empty($items_count)) : ?>
		<?php do_action($this -> pre . '_cart_widget_hasitems_top', $co_id, $subtotal, $total_price); ?>
	<?php endif; ?>

    <?php if (!empty($errors)) : ?>
        <ul class="<?php echo $this -> pre; ?>errors">
            <?php foreach ($errors as $err) : ?>
                <li class="<?php echo $this -> pre; ?>error"><?php echo $err; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    
    <?php if (!empty($successmsg)) : ?>
    	<div id="widget-cart-success">
        	<ul class="checkout_ul">
            	<li class="<?php echo $this -> pre; ?>successmsg"><?php echo $successmsg; ?></li>
        	</ul>
        </div>
    <?php endif; ?>
    
    <?php if (empty($instance['cart_show']) || $instance['cart_show'] == "normal") : ?>
        <ul class="checkout_ul">
        	<?php if (!empty($instance['cart_showproducts']) && $instance['cart_showproducts'] == "Y") : ?>
        		<?php 

				if (!empty($co_id['id'])) {
        			$wpcoDb -> model = $Item -> model;
					$items = $wpcoDb -> find_all(array($co_id['type'] . '_id' => $co_id['id']));
				}
        		
        		?>
        		<?php if (!empty($items)) : ?>
            		<li style="border:none;">
            			<?php if (!empty($instance['cart_showproducts_thumbs'])) : ?>
            				<ul class="<?php echo $this -> pre; ?>widgetproducts">
            			<?php else : ?>
            				<ul style="margin:0; padding:0;">
            			<?php endif; ?>
            				<?php foreach ($items as $item) : ?>
            					<li>
            						<?php if (!empty($instance['cart_showproducts_thumbs'])) : ?>
            							<span class="<?php echo $this -> pre; ?>widgetthumb"><?php echo $wpcoHtml -> link($wpcoHtml -> bfithumb_image($item -> product -> image_url, 50, 50, 100, 'dropshadow'), get_permalink($item -> product -> post_id), array('title' => __($item -> product -> title), 'class' => $this -> pre . "widgetthumblink")); ?></span>
            						<?php endif; ?>
									<?php echo $wpcoHtml -> link(__($item -> product -> title), get_permalink($item -> product -> post_id), array('title' => __($item -> product -> title))); ?> (<?php echo $item -> count; ?>)
            					</li>
            				<?php endforeach; ?>
            			</ul>
            		</li>
            	<?php endif; ?>
            <?php else : ?>
            	<li><?php _e('Total Items', $this -> plugin_name); ?>: <strong><?php echo $units_count; ?></strong></li>
        	<?php endif; ?>
            <?php if (!empty($items_count) && $items_count != 0) : ?>
                <?php if ($this -> get_option('shippingcalc') == "Y" || $this -> get_option('enablecoupons') == "Y" || $this -> get_option('handling') == "Y") : ?>
                    <li><?php _e('Sub Total', $this -> plugin_name); ?> <?php if ($this -> get_option('tax_calculate') == "Y") : ?><span class="taxwrap">(<?php _e('Excl.', $this -> plugin_name); ?> <?php echo $this -> get_option('tax_name'); ?>)</span><?php endif; ?>: <strong><?php echo $wpcoHtml -> currency_price($subtotal, true, true); ?></strong></li>
                    <?php if ($this -> get_option('handling') == "Y") : ?>
                		<?php if ($handling = $Order -> handling($co_id)) : ?>
                			<li><?php echo __($this -> get_option('handling_title')); ?>: <strong><?php echo $wpcoHtml -> currency_price($handling, true, true); ?></strong></li>
                		<?php endif; ?>
                	<?php endif; ?>
                    <?php if ($this -> get_option('shippingcalc') == "Y" && !empty($shipping) && $shipping != 0) : ?>
                        <li><?php _e('Shipping', $this -> plugin_name); ?>: <strong><?php echo $wpcoHtml -> currency_price($shipping, true, true); ?></strong></li>
                    <?php endif; ?>
                    <?php if ($this -> get_option('tax_calculate') == "Y" && !empty($tax_total)) : ?>
		                <li><?php echo $this -> get_option('tax_name'); ?> (<?php echo $wpcoTax -> get_tax_percentage(false); ?>&#37;): <strong><?php echo $wpcoHtml -> currency_price($tax_total, true, true); ?></strong></li>
		            <?php endif; ?>
                    <?php if ($this -> get_option('enablecoupons') && !empty($discount) && $discount != 0) : ?>
                        <li><?php _e('Discount', $this -> plugin_name); ?>: <strong>-<?php echo $wpcoHtml -> currency_price($discount, true, true); ?></strong></li>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
            <li><?php _e('Total:', $this -> plugin_name); ?> <strong><?php echo $wpcoHtml -> currency_price($total_price, true, true); ?></strong></li>
        </ul>
    <?php else : ?>
        <ul class="checkout_ul">
            <li><?php _e('Total:', $this -> plugin_name); ?> <strong><?php echo $wpcoHtml -> currency_price($total_price, true, true); ?></strong></li>
        </ul>
    <?php endif; ?>
    
    <?php if ((!empty($items_count) && $items_count != 0) || $this -> has_downloads() || $hasorders == true) : ?>
    	<?php if (!empty($items_count)) : ?>
    		<?php $completetext = __('Start Checkout &raquo;', $this -> plugin_name); ?>
            <?php if ($wpcoField -> globalfields('cart')) : ?>
                <?php $method = 'cart'; ?>
                <?php $completeurl = $wpcoHtml -> cart_url(); ?>
                <?php $completetext = __('Start Checkout &raquo;', $this -> plugin_name); ?>
            <?php else : ?>
                <?php global $user_ID; ?>
                <?php $tempmethod = ($Order -> do_shipping($co_id)) ? 'shipping' : 'billing'; ?>
                <?php $method = ($user_ID || apply_filters('checkout_guestcheckout', false, 'widget_cart')) ? $tempmethod : 'contacts'; ?>
                <?php
                
                $completeurl = $wpcoHtml -> cart_url();
				$completetext = __('Go to Cart &raquo;', $this -> plugin_name);
                
                switch ($method) {
                    case 'contacts'			:
                        $completeurl = $wpcoHtml -> contacts_url(true);
						$completetext = __('Start Checkout &raquo;', $this -> plugin_name);
                        break;
                    case 'shipping'			:
                        $completeurl = $wpcoHtml -> ship_url();
						$completetext = __('Start Checkout &raquo;', $this -> plugin_name);
                        break;
                    case 'billing'			:
                        $completeurl = $wpcoHtml -> bill_url();
						$completetext = __('Start Checkout &raquo;', $this -> plugin_name);
                        break;
                    default					:
                        $completeurl = $wpcoHtml -> cart_url();
						$completetext = __('Go to Cart &raquo;', $this -> plugin_name);
                        break;
                }
                
                ?>
            <?php endif; ?>
    		<a class="<?php echo $this -> pre; ?>button button" href="<?php echo $completeurl; ?>" title="<?php _e('Complete your order', $this -> plugin_name); ?>"><?php echo $completetext; ?></a>          
    	<?php endif; ?>
        <ul class="checkout_ul">
        	<?php if (!empty($items_count)) : ?>
                <li><a href="<?php echo $wpcoHtml -> cart_url(); ?>" title="<?php _e('View your shopping cart', $this -> plugin_name); ?>"><?php _e('View Shopping Cart', $this -> plugin_name); ?></a></li>
                <?php if ($this -> get_option('cart_addajax') == "Y") : ?>
                	<li><a href="javascript:void(0);" onclick="if (!confirm('<?php _e('Are you sure you wish to remove all items from your shopping cart?', $this -> plugin_name); ?>')) { return false; } else { wpco_emptycart('<?php echo $this -> widget_active('cart'); ?>'); }" title="<?php _e('Remove all items from your shopping cart', $this -> plugin_name); ?>"><?php _e('Empty Shopping Cart', $this -> plugin_name); ?></a></li>
                <?php else : ?>
                	<li><a href="<?php echo $wpcoHtml -> retainquery($this -> pre . 'method=cart&empty=1', $wpcoHtml -> cart_url()); ?>" onclick="if (!confirm('<?php _e('Are you sure you wish to remove all items from your shopping cart?', $this -> plugin_name); ?>')) { return false; }" title="<?php _e('Remove all items from your shopping cart', $this -> plugin_name); ?>"><?php _e('Empty Shopping Cart', $this -> plugin_name); ?></a></li>
                <?php endif; ?>
            <?php endif; ?>
            
            <?php global $user_ID; ?>
	        <?php if ($user_ID) : ?>
	            <?php $wpcoDb -> model = $Order -> model; ?>
	            <?php $orderscount = $wpcoDb -> count(array('completed' => "Y", 'user_id' => $user_ID)); ?>
	            <?php $hasorders = (!empty($orderscount)) ? true : false; ?>
	        <?php endif; ?>
            <?php if ($this -> has_downloads() || $hasorders == true) : ?>
                <?php if ($this -> has_downloads()) : ?>
                    <li><a href="<?php echo $wpcoHtml -> downloads_url(); ?>" title="<?php _e('View all your downloads', $this -> plugin_name); ?>"><?php _e('Downloads Management', $this -> plugin_name); ?></a></li>
                <?php endif; ?>
                <?php if ($hasorders == true) : ?>
                    <li><a href="<?php echo $wpcoHtml -> account_url(); ?>" title="<?php _e('View your complete orders history', $this -> plugin_name); ?>"><?php _e('Orders History', $this -> plugin_name); ?></a></li>
                <?php endif; ?>
	        <?php endif; ?>
        </ul>
    <?php endif; ?>
    <br class="<?php echo $this -> pre; ?>cleaner" />
	<?php if ($instance['cart_enablecoupons'] == "Y") : ?>
		<?php $wpcoDb -> model = $Coupon -> model; ?>
		<?php $couponscount = $wpcoDb -> count(); ?>
		<?php if ($this -> get_option('enablecoupons') == "Y" && !empty($couponscount)) : ?>
			<?php $wpcoDb -> model = $Discount -> model; ?>
			<?php $dcount = (!empty($co_id)) ? $wpcoDb -> count(array($co_id['type'] . '_id' => $co_id['id'])) : false; ?>
			<?php if ($this -> get_option('multicoupon') == "Y" || (empty($dcount) && $this -> get_option('multicoupon') == "N")) : ?>
				<?php $this -> render('couponform', false, true, 'default'); ?>
				<br class="checkout_clear" />
			<?php endif; ?>
		<?php endif; ?>
	<?php endif; ?>
	</div>
<?php endif; ?>

<script type="text/javascript">
jQuery(document).ready(function(e) {
	if (jQuery.isFunction(jQuery.fn.button)) {
    	jQuery('.wpcobutton').button();
    }
});
</script>