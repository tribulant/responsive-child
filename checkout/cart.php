<?php

$cart_quantity = $this -> get_option('cart_quantity');
$colspan = (!empty($cart_quantity)) ? 5 : 4;
$variations_option_priceperc = $this -> get_option('variations_option_priceperc');

?>

<?php if (!empty($order) && !empty($items)) : ?>
	<?php $theorder = $order; ?>	
	<?php do_action($this -> pre . '_cart_top', $order, $items); ?>
	<?php $this -> render('errors', array('errors' => $errors), true, 'default'); ?>
	
	<form id="wpco_cartform" <?php if ($this -> is_plugin_active('euvatex')) : ?>onsubmit="jQuery.Watermark.HideAll();"<?php endif; ?> class="<?php echo $this -> pre; ?>" action="<?php echo $wpcoHtml -> cart_url(); ?>" method="post">	
		<?php $co_id = $Order -> cart_order(); ?>
		<?php $weight = $Order -> weight($co_id); ?>
		<?php if (($this -> get_option('shiptierstype') == "weight" || !empty($shipmethod -> api) || true) && !empty($weight)) : ?>
			<div class="shippingmessageholder"><p class="shippingmessage"><?php _e('Your order has a total calculated weight of', $this -> plugin_name); ?> <strong><?php echo $weight; ?><?php echo $this -> get_option('weightm'); ?></strong></p></div>
		<?php endif; ?> 
	
		<table id="checkout_cart" class="<?php echo $this -> pre; ?> <?php echo $this -> pre; ?>cart">
			<thead>
				<tr>
					<th colspan="2" class="checkout_head_product"><?php _e('Product', $this -> plugin_name); ?></th>
					<th class="checkout_head_options"><?php _e('Options', $this -> plugin_name); ?></th>
					<th class="checkout_head_price"><?php _e('Price', $this -> plugin_name); ?></th>
					<?php if (!empty($cart_quantity)) : ?>
						<th class="checkout_head_quantity"><?php _e('Qty', $this -> plugin_name); ?></th>
					<?php endif; ?>
					<th class="checkout_head_total"><?php _e('Total', $this -> plugin_name); ?></th>
					<th class="checkout_head_remove"><?php _e('Remove', $this -> plugin_name); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php $class = 'erow'; ?>
				<?php $qties = 0; ?>
				<?php /*$ptotal = 0;*/ ?>
				<?php foreach ($items as $item) : ?>
					<tr id="checkout_cart_item<?php echo $item -> id; ?>" class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
						<td class="wpco_columnimage" style="width:<?php echo ((int) $this -> get_option('smallw') + 10); ?>px;"><?php echo $wpcoHtml -> link($wpcoHtml -> bfithumb_image($item -> product -> image_url, $this -> get_option('smallw'), $this -> get_option('smallh'), $this -> get_option('smallq'), ''), $wpcoHtml -> image_url($item -> product -> image -> name), array('class' => 'colorbox', 'title' => __($item -> product -> title), 'rel' => 'cart-images')); ?></td>
						<td class="wpco_columntitle">
							<?php echo $wpcoHtml -> link(__($item -> product -> title), get_permalink($item -> product -> post_id)); ?>
                        </td>
						<td class="wpco_columnvariations">    
							<?php do_action('checkout_cart_options', $item); ?>                            			
							<?php if (!empty($item -> styles) || !empty($item -> product -> cfields) || (!empty($item -> product -> inhonorof) && $item -> product -> inhonorof == "Y") || !empty($item -> width) || !empty($item -> length)) : ?>
								<table class="wpco_tablevariations">
									<tbody>
                                    	<?php if (!empty($item -> product -> inhonorof) && $item -> product -> inhonorof == "Y") : ?>
                                        	<?php if (!empty($item -> iof_name)) : ?>
                                                <tr>
                                                    <th><?php _e('Your Name', $this -> plugin_name); ?></th>
                                                    <td><?php echo stripslashes($item -> iof_name); ?></td>
                                                </tr>
                                            <?php endif; ?>
                                            <?php if (!empty($item -> iof_benname)) : ?>
                                                <tr>
                                                    <th><?php _e('Beneficiary Name', $this -> plugin_name); ?></th>
                                                    <td><?php echo stripslashes($item -> iof_benname); ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    	<?php if (!empty($item -> width)) : ?>
                                        	<tr>
                                            	<th><?php _e('Width', $this -> plugin_name); ?></th>
                                                <td><?php echo $item -> width; ?><?php echo $item -> product -> lengthmeasurement; ?>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if (!empty($item -> length)) : ?>
                                            <tr>
                                            	<th><?php _e('Length', $this -> plugin_name); ?></th>
                                                <td><?php echo $item -> length; ?><?php echo $item -> product -> lengthmeasurement; ?>
                                            </tr>
                                        <?php endif; ?>
										<?php if ($styles = maybe_unserialize($item -> styles)) : ?>
											<?php foreach ($styles as $style_id => $option_id) : ?>
												<?php $wpcoDb -> model = $Style -> model; ?>
												<?php if ($style = $wpcoDb -> find(array('id' => $style_id), array('id', 'title'))) : ?>
													<?php if (!empty($option_id) && is_array($option_id)) : ?>
														<?php $option_ids = $option_id; ?>
														<tr>
															<th><?php echo __($style -> title); ?></th>
															<td>
																<?php $o = 1; ?>
																<?php foreach ($option_ids as $option_id) : ?>
																	<?php $wpcoDb -> model = $Option -> model; ?>																
																	<?php if ($option = $wpcoDb -> find(array('id' => $option_id), array('id', 'title', 'addprice', 'price', 'operator', 'symbol'), array('id', "DESC"), true)) : ?>
																		<?php echo __($option -> title); ?><?php echo (!empty($variations_option_priceperc) && !empty($option -> addprice) && $option -> addprice == "Y") ? ' (' . $option -> symbol . $wpcoHtml -> currency_price($wpcoTax -> option_tax($option, $item -> product, true), true, true, $option -> operator) . ')' : ''; ?>
																		<?php echo ($o < count($option_ids)) ? ', ' : ''; ?>
																	<?php endif; ?>
																	<?php $o++; ?>
																<?php endforeach; ?>
															</td>
														</tr>
													<?php else : ?>
														<?php $wpcoDb -> model = $Option -> model; ?>
														<?php if ($option = $wpcoDb -> find(array('id' => $option_id), false, array('id', "DESC"), true, array('otheroptions' => $styles))) : ?>
															<tr>
																<th><?php echo __($style -> title); ?></th>
																<td>
																	<?php echo __($option -> title); ?>
																	<?php echo (!empty($variations_option_priceperc) && !empty($option -> addprice) && $option -> addprice == "Y" && !empty($option -> price)) ? ' (' . $option -> symbol . $wpcoHtml -> currency_price($wpcoTax -> option_tax($option, $item -> product, true), true, true, $option -> operator) . ')' : ''; ?>
																	<?php echo (!empty($option -> weight)) ? ' (' . $option -> weight . $this -> get_option('weightm') . ')' : ''; ?>
																</td>
															</tr>
														<?php endif; ?>
													<?php endif; ?>
												<?php endif; ?>
											<?php endforeach; ?>
										<?php endif; ?>
										<?php if (!empty($item -> product -> cfields)) : ?>
											<?php foreach ($item -> product -> cfields as $field_id) : ?>
												<?php $wpcoDb -> model = $wpcoField -> model; ?>
												<?php if ($field = $wpcoDb -> find(array('id' => $field_id))) : ?>
													<?php if (!empty($item -> {$field -> slug})) : ?>
														<tr>
															<th><?php echo __($field -> title); ?><?php echo (!empty($variations_option_priceperc) && !empty($field -> addprice) && $field -> addprice == "Y" && !empty($field -> price)) ? ' (' . $option -> symbol . $wpcoHtml -> currency_price($field -> price, true, true) . ')' : ''; ?></th>
															<td>
																<?php if ($field -> type == "file") : ?>
																	<?php echo $wpcoHtml -> file_custom_field($item -> {$field -> slug}); ?>
																<?php else : ?>
																	<?php echo $wpcoField -> get_value($field_id, $item -> {$field -> slug}); ?>
																<?php endif; ?>
															</td>
														</tr>
													<?php endif; ?>
												<?php endif; ?>
											<?php endforeach; ?>
										<?php endif; ?>
									</tbody>
								</table>
							<?php else : ?>
								<?php _e('none', $this -> plugin_name); ?>
							<?php endif; ?>
						</td>
						<td class="wpco_columnprice"><?php echo $wpcoHtml -> currency_price($Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true), true, true); ?></td>
						<?php if (!empty($cart_quantity)) : ?>
							<td class="wpco_columnqty">
								<input class="<?php echo $this -> pre; ?> <?php echo $this -> pre; ?>quantity" type="text" name="Item[count][<?php echo $item -> id; ?>]" style="width:25px;" value="<?php echo $item -> count; ?>" />
							</td>
						<?php else : ?>
							<input type="hidden" name="Item[count][<?php echo $item -> id; ?>]" value="<?php echo $item -> count; ?>" />
						<?php endif; ?>
						<td class="wpco_columntotal"><?php echo $wpcoHtml -> currency_price(($Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true) * $item -> count), true, true); ?></td>
						<td class="wpco_columnremove"><a href="<?php echo $wpcoHtml -> retainquery($this -> pre . 'method=deleteitem&item_id=' . $item -> id); ?>" onclick="if (!confirm('<?php _e('Are you sure you want to remove this item from your shopping cart?', $this -> plugin_name); ?>')) { return false; } else { <?php if ($this -> get_option('cart_addajax') == "Y") : ?>checkout_cart_removeproduct('<?php echo $item -> id; ?>'); return false;<?php endif; ?> }" class="checkout_cart_product_delete"></a></td>
					</tr>
					<?php $qties += $item -> count; ?>
					<?php /*$ptotal += $Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true);*/ ?>
				<?php endforeach; ?>
				
				<?php 
				
				$co_id = $Order -> cart_order();
				$items_count = $Item -> item_count($co_id, 'items');
				$units_count = $Item -> item_count($co_id, 'units');
				$subtotal = $Order -> total($co_id, false, false, true, true, false, false);
				$discount = $Discount -> total($co_id);
				$tax_total = $Order -> tax_total($co_id, true);
				$shipping_total = $Order -> shipping_total($subtotal, $co_id, true);
				$total_price = $Order -> total($co_id, true, true, true, true, true, true);
				
				global $subtotal;
				$subtotal = false;
				$wpcoDb -> model = $wpcoShipmethod -> model;
				$shipmethod = $wpcoDb -> find(array('id' => $theorder -> shipmethod_id));
				
				$couponsaffectts = ($this -> get_option('couponsaffectts') == "Y") ? true : false;
				$discount_total = $Order -> total($co_id, $couponsaffectts, false, true, true, $couponsaffectts, $couponsaffectts, true);
				
				?>

				<?php if (!empty($shipping_total)) : ?>				
					<?php if ($this -> get_option('shippingcalc') == "Y") : ?>
						<?php $wpcoHtml -> subtotal($co_id, false, $colspan); ?>	
						<?php if ($this -> get_option('shippingcalc') == "Y" && !empty($shipping_total) && $shipping_total != 0) : ?>
							<tr class="total">
								<td class="wpco_totaltext" colspan="<?php echo $colspan; ?>">
									<?php _e('Shipping &amp; Handling', $this -> plugin_name); ?>
									<?php $shipmethod_name = $wpcoHtml -> shipmethod_name($theorder -> shipmethod_id, $theorder -> id); ?>
									<?php if (!empty($shipmethod_name)) : ?>
										<small>(<?php echo $shipmethod_name; ?>)</small>
									<?php endif; ?>
								</td>
								<td><?php echo $wpcoHtml -> currency_price($shipping_total, true, true); ?></td>
								<td>&nbsp;</td>
							</tr>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
				<?php if ($this -> get_option('tax_calculate') == "Y" && !empty($tax_total) && $tax_total != "0.00") : ?>
                	<?php $wpcoHtml -> subtotal($co_id); ?>	
					<tr class="total">
						<td class="wpco_totaltext" colspan="<?php echo $colspan; ?>"><?php echo $this -> get_option('tax_name'); ?> (<?php echo $wpcoTax -> get_tax_percentage(false); ?>&#37;)</td>
						<td><?php echo $wpcoHtml -> currency_price($tax_total, true, true); ?></td>
						<td>&nbsp;</td>
					</tr>
				<?php endif; ?>
				<?php if ($this -> get_option('enablecoupons') == "Y") : ?>
					<?php $wpcoHtml -> subtotal($co_id); ?>
					<?php if (!empty($discounts)) : ?>
						<?php foreach ($discounts as $discount) : ?>
							<?php $coupon_discount = $Coupon -> discount($discount -> coupon -> id, $co_id, $discount_total);  ?>
							<?php if (!empty($coupon_discount)) : ?>
								<tr class="total">
									<td class="wpco_totaltext" colspan="<?php echo $colspan; ?>"><?php echo __($discount -> coupon -> title); ?> <?php echo $wpcoHtml -> link('', $wpcoHtml -> retainquery($this -> pre . "method=deletecoupon&amp;id=" . $discount -> id, $wpcoHtml -> cart_url()), array('class' => "checkout_discount_delete", 'onclick' => "if (!confirm('" . __('Are you sure you want to remove this discount coupon?', $this -> plugin_name) . "')) { return false; }")); ?></td>
									<td>
										<?php 
										
										if (is_numeric($coupon_discount)) {
											echo '-' . $wpcoHtml -> currency_price($coupon_discount, true, true);
										} else {
											echo $coupon_discount;
										}
										
										?>
									</td>
									<td>&nbsp;</td>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				<?php endif; ?>
				<tr class="total">
					<td class="wpco_totaltext" colspan="<?php echo $colspan; ?>"><?php _e('Total', $this -> plugin_name); ?></td>
					<td><?php echo $wpcoHtml -> currency_price($total_price, true, true); ?></td>
					<td>&nbsp;</td>
				</tr>
			</tbody>
		</table>
		
		<?php $this -> render('fields' . DS . 'global', array('order_id' => $co_id['id'], 'globalp' => "cart", 'globalerrors' => $globalerrors), true, 'default'); ?>
		<?php do_action($this -> pre . '_cart_after_global', $co_id['id']); ?>
		
		<?php $wpcoDb -> model = $Coupon -> model; ?>
		<?php $couponscount = $wpcoDb -> count(); ?>
		<?php if ($this -> get_option('enablecoupons') == "Y" && !empty($couponscount)) : ?>
			<?php $wpcoDb -> model = $Discount -> model; ?>
			<?php $dcount = $wpcoDb -> count(array($co_id['type'] . '_id' => $co_id['id'])); ?>
			<?php if ($this -> get_option('multicoupon') == "Y" || (empty($dcount) && $this -> get_option('multicoupon') == "N")) : ?>
				<?php $this -> render('couponform', array('inform' => true), true, 'default'); ?>
			<?php endif; ?>
		<?php endif; ?>
	
		<p class="<?php echo $this -> pre; ?>submit checkout_cart_submit">
			<input type="hidden" name="<?php echo $this -> pre; ?>method" value="updatecart" />			
			<input class="<?php echo $this -> pre; ?>button" style="cursor:pointer;" type="submit" name="update" value="<?php _e('Update Cart', $this -> plugin_name); ?>" onclick="if (!confirm('<?php _e('Are you sure you want to update the quantities?', $this -> plugin_name); ?>')) { return false; }" />
			<input class="<?php echo $this -> pre; ?>button" style="cursor:pointer;" type="submit" name="checkout" value="<?php _e('Checkout', $this -> plugin_name); ?> &raquo;" />
            
			<?php $tempmethod = ($this -> get_option('shippingdetails') == "Y") ? 'shipping' : 'billing'; ?>
			<?php global $user_ID; ?>
			<?php $method = ($user_ID) ? $tempmethod : 'contacts'; ?>
		</p>
	</form>
	
	<p>
		<ul class="checkout_ul">
			<?php if ($this -> get_option('cart_continuelink') == "Y") : ?>
				<li><?php echo $wpcoHtml -> link(__('Continue Shopping', $this -> plugin_name) . ' &raquo;', $this -> get_option('shopurl')); ?></li>
			<?php endif; ?>
			<li><?php echo $wpcoHtml -> link(__('Empty Shopping Cart', $this -> plugin_name) . ' &raquo;', $wpcoHtml -> retainquery("wpcomethod=cart&empty=1", $wpcoHtml -> cart_url()), array('onclick' => "if (!confirm('" . __('Are you sure you wish to empty your shopping cart?', $this -> plugin_name) . "')) { return false; }")); ?></li>
			<?php global $user_ID; ?>
			<?php if ($user_ID) : ?>
				<?php $wpcoDb -> model = $Order -> model; ?>
				<?php $orderscount = $wpcoDb -> count(array('completed' => "Y", 'user_id' => $user_ID)); ?>
				<?php $hasorders = (!empty($orderscount)) ? true : false; ?>
			<?php endif; ?>
			
			<?php if ($this -> has_downloads() || $hasorders == true) : ?>
				<?php if ($empty) : ?>
					<li><?php echo $wpcoHtml -> link(__('Continue Shopping', $this -> plugin_name) . ' &raquo;', $this -> get_option('shopurl')); ?></li>
				<?php endif; ?>
				<?php if ($this -> has_downloads()) : ?>
					<li><a href="<?php echo $wpcoHtml -> downloads_url(); ?>" title="<?php _e('View all your downloads', $this -> plugin_name); ?>"><?php _e('Downloads Management', $this -> plugin_name); ?></a></li>
				<?php endif; ?>
				<?php if ($hasorders == true) : ?>
					<li><a href="<?php echo $wpcoHtml -> account_url(); ?>" title="<?php _e('View your complete orders history', $this -> plugin_name); ?>"><?php _e('Orders History', $this -> plugin_name); ?></a></li>
				<?php endif; ?>
			<?php endif; ?>
		</ul>
	</p>
<?php else : ?>
	<div class="<?php echo $this -> pre; ?>error"><?php _e('There are no items in your shopping cart, please add some.', $this -> plugin_name); ?></div>
	<?php $empty = true; ?>
<?php endif; ?>