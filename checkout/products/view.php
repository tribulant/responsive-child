<!-- Product View -->

<div class="<?php echo $this -> pre; ?>product <?php echo $this -> pre; ?>">
	<?php if (!is_feed() && current_user_can('checkout_products')) : ?>
		<p><small>
			<?php echo $wpcoHtml -> link(__('Edit Product', $this -> plugin_name), $wpcoHtml -> product_save_url($product -> id)); ?> |
			<?php echo $wpcoHtml -> link(__('Delete Product', $this -> plugin_name), $wpcoHtml -> product_delete_url($product -> id), array('onclick' => "if (!confirm('" . __('Are you sure you wish to remove this product?', $this -> plugin_name) . "')) { return false; }")); ?>
		</small></p>
	<?php endif; ?>
	
	<?php do_action('checkout_product_before', $product); ?>
    
    <?php if (apply_filters('checkout_product_images', true)) : ?>
	    <?php if ($this -> get_option('product_imagegallery') == "jqzoom" && $this -> is_plugin_active('jqzoom')) : ?>
	    	<?php if (apply_filters('checkout_product_jqzoom_internal', true)) : ?>
		    	<!-- Zoom Effect -->
		        <div class="<?php echo $this -> pre; ?>jqzoom <?php echo $this -> pre; ?>images">
		        	<div class="<?php echo $this -> pre; ?>productimage">
		                <a href="<?php echo $wpcoHtml -> image_url($product -> image -> name); ?>" title="<?php echo esc_attr(__($product -> title)); ?>" class="jqzoom" rel="jqzoom<?php echo $product -> id; ?>">
		                    <?php echo $wpcoHtml -> bfithumb_image($product -> image_url, $this -> get_option('thumbw'), $this -> get_option('thumbh'), $this -> get_option('thumbq'), ''); ?>
		                </a>
		            </div>
		            
		            <?php if (!empty($product -> images)) : ?>
		                <div class="<?php echo $this -> pre; ?>imglist" style="width:<?php echo $this -> get_option('thumbw'); ?>px;">
		                    <ul id="thumblist" style="width:<?php echo ((int) $this -> get_option('thumbw') + 22); ?>px; float:left; overflow:hidden;">
		                        <li><a title="<?php echo esc_attr(__($product -> title)); ?>" class="zoomThumbActive" href="javascript:void(0);" rel="{
		                        	gallery:'jqzoom<?php echo $product -> id; ?>',
		                        	smallimage:'<?php echo $wpcoHtml -> bfithumb_url(); ?>?src=<?php echo $product -> image_url; ?>&w=<?php echo $this -> get_option('thumbw'); ?>&h=<?php echo $this -> get_option('thumbh'); ?>&q=<?php echo $this -> get_option('thumbq'); ?>',
		                        	largeimage:'<?php echo $wpcoHtml -> image_url($product -> image -> name); ?>'
		                        	}"><img src="<?php echo $wpcoHtml -> bfithumb_url(); ?>?src=<?php echo $product -> image_url; ?>&w=<?php echo $this -> get_option('smallw'); ?>&h=<?php echo $this -> get_option('smallh'); ?>&q=<?php echo $this -> get_option('smallq'); ?>" /></a></li>
		                        <?php foreach ($product -> images as $image) : ?>
		                            <li><a title="<?php echo esc_attr($image -> title); ?>" href="javascript:void(0);" rel="{
		                            	gallery:'jqzoom<?php echo $product -> id; ?>',
		                            	smallimage:'<?php echo addslashes($wpcoHtml -> bfithumb_url() . '?src=' . $image -> image_url . '&w=' . $this -> get_option('thumbw') . '&h=' . $this -> get_option('thumbh') . '&q=' . $this -> get_option('thumbq')); ?>',
		                            	largeimage:'<?php echo $wpcoHtml -> image_url($image -> filename); ?>',
		                            	title:'<?php echo esc_attr($image -> title); ?>'
		                            	}"><img src="<?php echo $wpcoHtml -> bfithumb_url(); ?>?src=<?php echo $image -> image_url; ?>&w=<?php echo $this -> get_option('smallw'); ?>&h=<?php echo $this -> get_option('smallh'); ?>&q=<?php echo $this -> get_option('smallq'); ?>" /></a></li>
		                        <?php endforeach; ?>
		                    </ul>
		                    <br class="<?php echo $this -> pre; ?>cleaner" />
		                </div>
		            <?php endif; ?>
		        </div>
		    <?php endif; ?>
		    <?php do_action('checkout_product_jqzoom', $product); ?>
	    <?php else : ?>
	    	<!-- Lightbox Effect -->
	        <div class="<?php echo $this -> pre; ?>images">
	            <?php if ($this -> get_option('cropthumb') == "Y") : ?>
	                <?php 
	                
	                $imagefull = $wpcoHtml -> uploads_path() . DS . $this -> plugin_name . DS . 'images' . DS . $product -> image -> name; 
	                $forceold = (file_exists($imagefull)) ? false : true;
	                $imagefull = $wpcoHtml -> uploads_path($forceold) . DS . $this -> plugin_name . DS . 'images' . DS . $product -> image -> name;
	                
	                ?>
	                <?php if (file_exists($imagefull) && filesize($imagefull) > 0) : ?>
	                    <div class="<?php echo $this -> pre; ?>productimage">
	                        <?php echo $wpcoHtml -> link('<span class="zoom_hover">Zoom</span>' . $wpcoHtml -> bfithumb_image($product -> image_url, $this -> get_option('thumbw'), $this -> get_option('thumbh'), $this -> get_option('thumbq'), ""), $wpcoHtml -> image_url($product -> image -> name), array('class' => "colorbox", 'rel' => $wpcoHtml -> sanitize(__($product -> title)) . '-images', 'title' => __($product -> title))); ?>
	                    </div>
	                <?php else : ?>
	                    <div class="<?php echo $this -> pre; ?>productimage"><?php echo $wpcoHtml -> image($wpcoHtml -> thumb_name($product -> image -> name), false, $product -> image -> name); ?></div>
	                <?php endif; ?>
	            <?php else : ?>
	                <div class="<?php echo $this -> pre; ?>productimage"><?php echo $wpcoHtml -> image($product -> image -> name, false, $product -> image -> name); ?></div>
	            <?php endif; ?>
	            
	            <?php if (!empty($product -> images)) : ?>
	                <?php if ($this -> get_option('gallerytab') == "N" || ($this -> get_option('gallerytab') == "Y" && empty($product -> contents))) : ?>
	                    <div class="<?php echo $this -> pre; ?>imglist">						
	                        <ul>
	                            <?php $imgcount = 1; ?>
	                            <?php foreach ($product -> images as $image) : ?>
	                                <?php if ($imgcount <= $this -> get_option('pimgcount')) : ?>
	                                    <li><?php echo $wpcoHtml -> link($wpcoHtml -> bfithumb_image($image -> image_url, $this -> get_option('smallw'), $this -> get_option('smallh'), $this -> get_option('smallq')), $wpcoHtml -> image_url($image -> filename), array('class' => 'colorbox', 'rel' => $wpcoHtml -> sanitize(__($product -> title)) . '-images', 'title' => $image -> title)); ?></li>
	                                <?php else : ?>
	                                    <?php break; ?>
	                                <?php endif; ?>
	                                <?php $imgcount++; ?>
	                            <?php endforeach; ?>
	                        </ul>
	                        <br class="<?php echo $this -> pre; ?>cleaner" />
	                        
	                        <?php if (count($product -> images) > $this -> get_option('pimgcount')) : ?>
	                            <div class="viewallextraimageslink"><?php echo $wpcoHtml -> link(__('View all images &raquo;', $this -> plugin_name), $wpcoHtml -> retainquery($this -> pre . 'method=images', $_SERVER['REQUEST_URI']), false); ?></div>
	                        <?php endif; ?>
	                    </div>
	                <?php elseif ($this -> get_option('gallerytab') == "Y") : ?>
	                    <div class="viewllextraimageslink"><a href="" class="view-all-images-link"><?php _e('View all images &raquo;', $this -> plugin_name); ?></a></div>
	                <?php endif; ?>
	            <?php endif; ?>
	        </div>
	    <?php endif; ?>
	<?php endif; ?>
	<?php do_action('checkout_product_images_below', $product); ?>
	
    <!-- BEG Product Information Holder -->
    <div class="productinfoholder" style="width:<?php echo $this -> get_option('product_infoholderwidth'); ?>px;">
		<?php if ($this -> get_option('product_descriptionposition') == "above") : ?>
            <?php if (empty($product -> contents) || !is_array($product -> contents)) : ?>
                <div class="productdescriptionview"><?php echo wpautop(do_shortcode(stripslashes(__($product -> description)))); ?></div>
            <?php endif; ?>
        <?php endif; ?>
        
        <?php if ($this -> get_option('showcase') == "N" && $product -> showcase == "N") : ?>
            <!-- NOT SHOWCASE -->
        
            <!-- Price -->
            <?php $productprice = $Product -> unit_price($product -> id, 999999, false, false, false, false); ?>
            <div class="pricewrap">
            	<!-- tiered product pricing -->
                <?php if ($product -> price_type == "tiers") : ?>
                    <?php $productprice = $Product -> unit_price($product -> id, 999999, false, false, false, true); ?>
                    <?php echo (!empty($product -> sprice) && $product -> sprice != "0.00") ? '<span class="sprice"><strike>' . $wpcoHtml -> currency_price($product -> sprice, true, true) . '</strike></span>' : ''; ?>
                    <span id="productprice<?php echo $product -> id; ?>" class="price"><?php echo (!empty($product -> price_type) && $product -> price_type == "tiers" && $product -> price_display != "high") ? __('From', $this -> plugin_name) . ' ' : ''; ?><?php echo $wpcoHtml -> currency_price($productprice, true, true); ?></span>
                    <?php $this -> render('products' . DS . 'tax', array('product' => $product), true, 'default'); ?>
                <!-- donate product pricing -->
                <?php elseif ($product -> price_type == "donate") : ?>
                    <span id="productprice<?php echo $product -> id; ?>" class="price"></span>
                    <?php $this -> render('products' . DS . 'tax', array('product' => $product), true, 'default'); ?>
                    <?php if (!empty($product -> donate_caption)) : ?>
                        <p class="donatecaption"><?php echo stripslashes($product -> donate_caption); ?></p>
                    <?php endif; ?>
                <!-- per square pricing -->
                <?php elseif ($product -> price_type == "square" && !empty($product -> square_price)) : ?>
                    <span id="productprice<?php echo $product -> id; ?>" class="price"><?php _e('Fill in width and length', $this -> plugin_name); ?></span>
                    <?php $this -> render('products' . DS . 'tax', array('product' => $product), true, 'default'); ?>
                    <?php if (!empty($product -> square_price_text)) : ?>
                        <p class="squareprice"><small><strong><?php echo stripslashes($product -> square_price_text); ?></strong></small></p>
                    <?php else : ?>
                        <p class="squareprice"><small><strong><?php echo $wpcoHtml -> currency_price($product -> square_price, true, true); ?></strong> <?php _e('per square', $this -> plugin_name); ?> <?php echo $product -> lengthmeasurement; ?></small></p>
                    <?php endif; ?>
                <!-- per measurement pricing -->
                <?php elseif ($product -> price_type == "measurement" && !empty($product -> measurement_price)) : ?>
                	<span id="productprice<?php echo $product -> id; ?>" class="price"><?php _e('Fill in length', $this -> plugin_name); ?></span>
                	<?php $this -> render('products' . DS . 'tax', array('product' => $product), true, 'default'); ?>
                	<?php if (!empty($product -> measurement_price_text)) : ?>
                		<p class="measurementprice"><?php echo stripslashes($product -> measurement_price_text); ?></p>
                	<?php else : ?>
                		<p class="measurementprice"><?php echo sprintf(__('%s per %s', $this -> plugin_name), $wpcoHtml -> currency_price($product -> measurement_price, true, true), $product -> lengthmeasurement); ?></p>
                	<?php endif; ?>
                <!-- regular products with fixed pricing -->
                <?php else : ?>
                    <?php echo (!empty($product -> sprice) && $product -> sprice != "0.00") ? '<span class="sprice"><strike>' . $wpcoHtml -> currency_price($product -> sprice, true, true) . '</strike></span>' : ''; ?>
                    <?php if (!empty($product -> price) && $product -> price != "0.00") : ?>
                        <span id="productprice<?php echo $product -> id; ?>" class="price productprice"><?php echo $wpcoHtml -> currency_price($productprice, true, true); ?></span>
                    <?php else : ?>
                        <span id="productprice<?php echo $product -> id; ?>" class="price productprice"><?php echo stripslashes($this -> get_option('product_zerotext')); ?></span>
                    <?php endif; ?>
                    <?php $this -> render('products' . DS . 'tax', array('product' => $product), true, 'default'); ?>
                <?php endif; ?>
                <?php if (!empty($product -> checkout_type) && $product -> checkout_type == "recurring") : ?>
	                <div class="recurringinfo">
	                	<?php echo $wpcoHtml -> recurring_info($product); ?>
	                </div>
	            <?php endif; ?>
            </div>
            
            <?php do_action('checkout_product_after_price', $product); ?>
            
            <!-- Specs -->		
            <?php if ($this -> get_option('product_showspecs') == "Y") : ?>
				<?php if (!empty($product -> weight) || !empty($product -> width) || !empty($product -> height) || !empty($product -> length)) : ?>
					<div class="wpco_productspecs">
						<?php if (!empty($product -> weight)) : ?>
								<div class="wpco_productspec">
									<span class="wpco_productspecname"><?php _e('Weight: ', $this -> plugin_name); ?></span><span class="wpco_productweight"><?php echo $product -> weight; ?><?php echo $this -> get_option('weightm'); ?></span>
								</div>
						<?php endif; ?>
						
						<?php if (!empty($product -> lengthmeasurement)) : ?>
							<?php if (!empty($product -> width)) : ?>
								<div class="wpco_productspec">
									<span class="wpco_productspecname"><?php _e('Width: ', $this -> plugin_name); ?></span><span class="wpco_productwidth"><?php echo $product -> width; ?><?php echo $product -> lengthmeasurement; ?></span>
								</div>
							<?php endif; ?>
							
							<?php if (!empty($product -> height)) : ?>
								<div class="wpco_productspec">
									<span class="wpco_productspecname"><?php _e('Height: ', $this -> plugin_name); ?></span><span class="wpco_productheight"><?php echo $product -> height; ?><?php echo $product -> lengthmeasurement; ?></span>
								</div>
							<?php endif; ?>
							
							<?php if (!empty($product -> length)) : ?>
								<div class="wpco_productspec">
									<span class="wpco_productspecname"><?php _e('Length: ', $this -> plugin_name); ?></span><span class="wpco_productlenght"><?php echo $product -> length; ?><?php echo $product -> lengthmeasurement; ?></span>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
            <?php endif; ?>
        
            <?php if ($product -> price_type == "tiers") : ?>					
                <fieldset class="<?php echo $this -> pre; ?>">
                    <legend><?php _e('Your Price', $this -> plugin_name); ?></legend>
                        <table class="<?php echo $this -> pre; ?>">
                            <tbody>
                                <?php $t = 1; ?>
                                <?php $class = 'erow'; ?>
                                <?php $price = maybe_unserialize($product -> price); ?>
                                <?php foreach ($price as $tier) : ?>
                                	<?php
                                
                                	$newprice = $tier['price'];
                                	if ($this -> get_option('tax_includeinproductprice') == "Y") {
                                		$newprice = ($tier['price'] + $wpcoTax -> product_tax($product -> id, $tier['price']));
                                	}
                                
                                	?>
	                                <?php $tierstring = ($t == count($price)) ? $tier['min'] . ' ' . __('or more', $this -> plugin_name) : $tier['min'] . ' ' . __('to', $this -> plugin_name) . ' ' . $tier['max'] ; ?>
	                                <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
	                                    <td><?php echo $tierstring; ?></td>
	                                    <td>=</td>
	                                    <td><b><?php echo $wpcoHtml -> currency_price($newprice, true, true); ?></b> <?php _e('per unit', $this -> plugin_name); ?></td>
	                                </tr>
	                                <?php $t++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                </fieldset>
            <?php endif; ?>
            
            <?php if (empty($product -> oos) || $product -> oos != true) : ?>	
                <?php echo $wpcoHtml -> addtocart_action($product -> id, false); ?>
                    <?php echo $wpcoForm -> hidden('Item.product_id', array('value' => $product -> id)); ?>
                    
                    <?php global $user_ID; ?>
                    <?php echo $wpcoForm -> hidden('Item.user_id', array('value' => $user_ID)); ?>	
                    
                    <?php if ($product -> price_type == "square" && !empty($product -> square_price)) : ?>
                        <!-- Price per square meter -->
                        <div class="pricetype_square_input">
                        	<?php echo $wpcoForm -> text('Item.width', array('error' => false, 'width' => "45px", 'value' => $_POST['Item']['width'], 'onkeyup' => "wpco_updateproductprice('" . $product -> id . "', '" . __('Calculating...', $this -> plugin_name) . "');")); ?> <?php echo $product -> lengthmeasurement; ?> <?php _e('X', $this -> plugin_name); ?>
							<?php echo $wpcoForm -> text('Item.length', array('error' => false, 'width' => "45px", 'value' => $_POST['Item']['length'], 'onkeyup' => "wpco_updateproductprice('" . $product -> id . "', '" . __('Calculating...', $this -> plugin_name) . "');")); ?> <?php echo $product -> lengthmeasurement; ?>
							<?php echo $wpcoForm -> hidden('Item.count', array('value' => 1)); ?>
                        </div>
                    <?php elseif ($product -> price_type == "measurement" && !empty($product -> measurement_price)) : ?>
                    	<div class="pricetype_measurement_input">
                    		<?php echo $wpcoForm -> text('Item.length', array('error' => false, 'width' => "65px", 'value' => $_POST['Item']['length'], 'onkeyup' => "wpco_updateproductprice('" . $product -> id . "', '" . __('Calculating...', $this -> plugin_name) . "');")); ?> <?php echo $product -> lengthmeasurement; ?>
                    	</div>
                    <?php endif; ?>				
            
                    <?php if ($this -> get_option('fieldsintab') == "N" || ($this -> get_option('fieldsintab') == "Y" && empty($product -> contents))) : ?>		
                        <?php if (!empty($product -> styles) && !empty($product -> options)) : ?>
                            <?php foreach ($product -> styles as $style_id) : ?>
                                <?php echo $this -> render_style($style_id, $product -> options[$style_id], true, $product -> id); ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
    
                        <?php if (!empty($product -> cfields)) : ?>
                            <?php foreach ($product -> cfields as $field_id) : ?>
                                <?php if (!empty($field_id)) : ?>
                                    <?php $this -> render_field($field_id, true, false, $product -> id); ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endif; ?>
        
                    <?php if ($this -> get_option('howmany') == "Y" && $product -> price_type != "donate" && $product -> price_type != "square" && $product -> price_type != "measurement") : ?>
                        <div class="<?php echo $this -> pre; ?>howmany">						
                            <b><?php echo sprintf(__('How many %s?', $this -> plugin_name), __($product -> measurement)); ?></b>
                            <?php $cvaluet = (empty($product -> min_order)) ? '1' : $product -> min_order; ?>
                            <?php $cvalue = (empty($_POST['Item']['count'])) ? $cvaluet : $_POST['Item']['count']; ?>
                            <?php echo $wpcoForm -> text('Item.count', array('error' => false, 'value' => $cvalue, 'width' => '45px', 'onkeyup' => "wpco_updateproductprice('" . $product -> id . "', 'Calculating...');")); ?>
                            <?php if (!empty($product -> inventory) && $product -> inventory > 0 && $this -> get_option('product_showstock') == "Y") : ?>
                                <span class="stockcount"><?php echo $product -> inventory; ?> <?php _e('units in stock.', $this -> plugin_name); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php elseif ($product -> price_type == "donate") : ?>
                        <?php echo $wpcoHtml -> currency_html('<input type="text" name="Item[donate_price]" value="' . esc_attr(empty($_POST['Item']['donate_price']) ? $wpcoHtml -> field_value('Item.donate_price') : $_POST['Item']['donate_price']) . '" id="Item.donate_price" class="donateprice" onkeyup="wpco_updateproductprice(\'' . $product -> id . '\', \'' . __('Calculating...', $this -> plugin_name) . '\');" />'); ?>
                        <!-- Variable Price Product -->
                        <?php echo $wpcoForm -> hidden('Item.count', array('value' => 1)); ?>                        
                    <?php else : ?>
                        <?php /*hidden field for quantity as 1*/ ?>
                        <?php echo $wpcoForm -> hidden('Item.count', array('value' => 1)); ?>
                    <?php endif; ?>
                    
                    <?php if (!empty($product -> checkout_type) && $product -> checkout_type == "recurring" && !empty($product -> recurring_onceoff)) : ?>
	                    <div class="recurring_onceoff">
		                	<label><input onclick="if (jQuery(this).is(':checked')) { jQuery('.recurringinfo').hide(); } else { jQuery('.recurringinfo').show(); }" type="checkbox" name="Item[recurring_onceoff]" value="1" id="Item_recurring_onceoff" /> <?php _e('Pay once-off instead of recurring', $this -> plugin_name); ?></label>
		                </div>
		            <?php endif; ?>
                    
                    <span class="wpcobuttonwrap">
                        <?php if ($this -> get_option('buynow') == "Y" || (!empty($product -> checkout_type) && ($product -> checkout_type == "recurring" || $product -> checkout_type == "buynow"))) : ?>
                            <!-- BEG Buy Now -->
                            <?php if ($this -> get_option('loop_btntxt') == "txt") : ?>
                                <?php if (!empty($product -> affiliate) && $product -> affiliate == "Y") : ?>
                                    <span id="submit<?php echo $product -> id; ?>" class="productsubmit"><a class="<?php echo $this -> pre; ?>buylink" target="_<?php echo $product -> affiliatewindow; ?>" href="<?php echo $wpcoHtml -> retainquery($this -> pre . 'method=affiliate&amp;id=' . $product -> id); ?>" title="<?php echo __($product -> title); ?>"><?php echo __($product -> buttontext); ?></a></span>
                                <?php else : ?>
                                    <span id="submit<?php echo $product -> id; ?>" class="productsubmit"><a href="" title="<?php _e('Buy this product now', $this -> plugin_name); ?>" onclick="jQuery('#addtocart<?php echo $product -> id; ?>').submit(); return false;" class="<?php echo $this -> pre; ?>buylink"><?php echo __($product -> buttontext); ?></a></span>
                                <?php endif; ?>
                            <?php else : ?>
                                <span id="submit<?php echo $product -> id; ?>" class="productsubmit"><?php echo $wpcoForm -> submit(__($product -> buttontext)); ?></span>
                            <?php endif; ?>
                        <?php elseif (!empty($product -> affiliate) && $product -> affiliate == "Y" && !empty($product -> affiliateurl)) : ?>
                            <!-- BEG Affiliate Product -->
                            <?php if ($this -> get_option('loop_btntxt') == "txt") : ?>
                                <span class="productsubmit productsubmittext affiliateproductsubmit" id="submit<?php echo $product -> id; ?>"><a href="<?php echo $product -> affiliateurl; ?>" <?php echo (!empty($product -> affiliatewindow) && $product -> affiliatewindow == "blank") ? 'target="_blank"' : 'target="_self"'; ?> title="<?php echo __($product -> buttontext); ?>" class="<?php echo $this -> pre; ?>buylink"><?php echo __($product -> buttontext); ?></a></span>
                            <?php else : ?>
                                <span class="productsubmit productsubmitbutton affiliateproductsubmit" id="submit<?php echo $product -> id; ?>"><?php echo $wpcoForm -> submit(__($product -> buttontext)); ?></span>
                            <?php endif; ?>
                        <?php elseif (false && !empty($product -> price_type) && $product -> price_type == "donate") : ?>
                            <!-- BEG Variable Price Product -->
                            
                            <!-- END Variable Price Product -->
                        <?php else : ?>
                            <!-- BEG Normal Product -->
                            <?php if ($this -> get_option('loop_btntxt') == "txt") : ?>
                                <?php if (!empty($product -> affiliate) && $product -> affiliate == "Y") : ?>
                                    <span id="submit<?php echo $product -> id; ?>"><a href="<?php echo $wpcoHtml -> retainquery($this -> pre . 'method=affiliate&amp;id=' . $product -> id); ?>" class="<?php echo $this -> pre; ?>buylink" target="_<?php echo $product -> affiliatewindow; ?>" title="<?php echo __($product -> title); ?>"><?php echo __($product -> buttontext); ?></a></span>
                                <?php else : ?>
                                    <?php if ($this -> get_option('cart_addajax') == "Y") : ?>
                                        <span class="productsubmit productsubmittext" id="submit<?php echo $product -> id; ?>"><a href="" title="<?php _e('Add this product to your shopping cart', $this -> plugin_name); ?>" onclick="checkout_cart_addproduct(jQuery('#addtocart<?php echo $product -> id; ?>'), '<?php echo $product -> id; ?>', '<?php echo $this -> widget_active('cart'); ?>'); return false;" class="<?php echo $this -> pre; ?>buylink"><?php echo __($product -> buttontext); ?></a></span>
                                    <?php else : ?>
                                        <span class="productsubmit productsubmittext" id="submit<?php echo $product -> id; ?>"><a href="" onclick="jQuery('#addtocart<?php echo $product -> id; ?>').submit(); return false;" class="<?php echo $this -> pre; ?>buylink" title="<?php _e('Add this product to your shopping cart', $this -> plugin_name); ?>"><?php echo __($product -> buttontext); ?></a></span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php else : ?>
                                <?php if ($this -> get_option('cart_addajax') == "Y") : ?>
                                    <span id="submit<?php echo $product -> id; ?>" class="productsubmit productsubmitbutton"><input type="submit" name="submit" value="<?php echo __($product -> buttontext); ?>" /></span>
                                <?php else : ?>
                                    <span id="submit<?php echo $product -> id; ?>" class="productsubmit productsubmitbutton"><?php echo $wpcoForm -> submit(__($product -> buttontext)); ?></span>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <!-- favorites link -->
                        <?php $this -> render('favorites' . DS . 'link', array('product' => $product), true, 'default'); ?>
                        
                        <br class="wpcocleaner" />
                    </span>
                    
                    <?php if ($product -> inhonorof == "Y") : ?>
                        <?php if (!empty($product -> inhonorof) && $product -> inhonorof == "Y") : ?>
                            <?php if ($product -> inhonorofreq == "N") : ?>
                                <div class="<?php echo $this -> pre; ?>inhonorofcheckbox">
                                    <label><input onclick="if (this.checked == true) { jQuery('#<?php echo $this -> pre; ?>inhonorof<?php echo $product -> id; ?>').show(); } else { jQuery('#<?php echo $this -> pre; ?>inhonorof<?php echo $product -> id; ?>').hide(); }" type="checkbox" name="inhonorofreq" value="1" id="inhonorofreq<?php echo $product -> id; ?>" /> <?php _e('Specify beneficiary details?', $this -> plugin_name); ?></label>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    
                        <div style="display:<?php echo (!empty($product -> inhonorofreq) && $product -> inhonorofreq == "Y") ? 'block' : 'none'; ?>;" class="<?php echo $this -> pre; ?>inhonorof" id="<?php echo $this -> pre; ?>inhonorof<?php echo $product -> id; ?>">
                            <fieldset>
                                <legend><?php _e('In Honor Of...', $this -> plugin_name); ?></legend>
                                
                                <table>
                                    <tbody>
                                        <tr>
                                            <td><?php _e('Your Name:', $this -> plugin_name); ?></td>
                                            <td><?php echo $wpcoForm -> text('Item.iof_name'); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php _e('Beneficiary Name', $this -> plugin_name); ?></td>
                                            <td><?php echo $wpcoForm -> text('Item.iof_benname'); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php _e('Beneficiary Email', $this -> plugin_name); ?></td>
                                            <td><?php echo $wpcoForm -> text('Item.iof_benemail'); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </fieldset>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($this -> get_option('fieldsintab') == "Y" && (!empty($product -> styles) || !empty($product -> cfields)) && !empty($product -> contents) && (is_array($product -> contents) || is_object($product -> contents))) : ?>
                        <?php if ($this -> get_option('optionslinktb') == "B") : ?>
                            <p class="<?php echo $this -> pre; ?>optionslink"><?php echo $wpcoHtml -> link(__('Choose product options/variations &raquo;', $this -> plugin_name), "", array('class' => "product-options-link")); ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php else : ?>
                    <p class="<?php echo $this -> pre; ?>oos"><?php echo $wpcocaptions['product']['oos']; ?></p>
                <?php endif; ?>
                    
                <p class="<?php echo $this -> pre; ?>error" id="message<?php echo $product -> id; ?>" style="display:none;"></p>
            </div>
			
			<?php if (!empty($product -> contents) && (is_array($product -> contents) || is_object($product -> contents))) : ?>
				<?php 
				
				$tabscount = 1; 
				$customooptionstab = false;
				
				?>
                <?php $tabscount2 = $gallerytab = 1; ?>
				<div style="clear:both; display:block; height:1px; width:100%;"></div>
			
				<div id="tabs<?php echo $product -> id; ?>">
                	<!-- BEG Tabs Menu -->
                	<ul>
                    	<li><a href="#tabs<?php echo $product -> id; ?>-1"><?php _e('Description', $this -> plugin_name); ?></a></li>
                        <?php $tabscount2++; ?>
                        <?php foreach ($product -> contents as $content) : ?>
                        	<?php
                        	
                        	if (preg_match("/(\[checkout\_product\_options\])/si", __($content -> content))) {
	                        	$customooptionstab = true;
                        	}
                        	
                        	?>
                        	<li><a href="#tabs<?php echo $product -> id; ?>-<?php echo $tabscount2; ?>"><?php echo __($content -> title); ?></a></li>
                        	<?php $tabscount2++; ?>
                        <?php endforeach; ?>
                        <?php if (empty($customooptionstab) || $customooptionstab == false) : ?>
	                        <?php if (empty($product -> oos) || $product -> oos == false) : ?>
								<?php if (!$this -> get_option('fieldsintab') || $this -> get_option('fieldsintab') == "Y") : ?>
	                                <?php if (!empty($product -> styles) || !empty($product -> cfields)) : ?>
	                                	<li><a href="#tabs<?php echo $product -> id; ?>-<?php echo $tabscount2; ?>"><?php _e('Options', $this -> plugin_name); ?></a></li>
	                                    <?php $productoptionstab = $tabscount2; ?>
	                                    <?php $tabscount2++; ?>
	                                <?php endif; ?>
	                            <?php endif; ?>
	                        <?php endif; ?>
	                    <?php endif; ?>
                        <?php if (!$this -> get_option('gallerytab') || $this -> get_option('gallerytab') == "Y") : ?>
							<?php if (!empty($product -> images)) : ?>
                            	<li><a href="#tabs<?php echo $product -> id; ?>-<?php echo $tabscount2; ?>"><?php _e('Gallery', $this -> plugin_name); ?></a></li>
                                <?php $gallerytab = $tabscount2; ?>
                                <?php $tabscount2++; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if (!empty($product -> related) && $this -> get_option('relatedintab') == "Y") : ?>
                        	<li><a href="#tabs<?php echo $product -> id; ?>-<?php echo $tabscount2; ?>"><?php _e('Related Products', $this -> plugin_name); ?></a></li>
                            <?php $tabscount2++; ?>
                        <?php endif; ?>
                    </ul>
                    <!-- END Tabs Menu -->
                
					<div id="tabs<?php echo $product -> id; ?>-<?php echo $tabscount; ?>">
						<h3><?php _e('Description', $this -> plugin_name); ?></h3>
						<div>
							<?php echo wpautop(do_shortcode(stripslashes(__($product -> description)))); ?>
							
							<?php if ($this -> get_option('unitextbox') == "Y") : ?>
								<?php $message = $this -> get_option('unitextboxmessage'); ?>
								<?php if (!empty($message) && $this -> get_option('unitextboxintabs') == "Y") : ?>
									<div class="<?php echo $this -> pre; ?>unitextbox">
										<?php echo wpautop(stripslashes($message)); ?>
									</div>
								<?php endif; ?>
							<?php endif; ?>
						</div>
					</div>
					<?php $tabscount++; ?>
					<?php foreach ($product -> contents as $content) : ?>
						<div id="tabs<?php echo $product -> id; ?>-<?php echo $tabscount; ?>">
							<h3><?php echo __($content -> title); ?></h3>
							<div>
								<?php if (preg_match("/\[checkout\_product\_options\]/si", __($content -> content))) : ?>
									<?php echo do_shortcode(stripslashes(__($content -> content))); ?>
								<?php else : ?>
									<?php echo wpautop(do_shortcode(stripslashes(__($content -> content)))); ?>
								<?php endif; ?>
								
								<?php if ($this -> get_option('unitextbox') == "Y") : ?>
								<?php $message = $this -> get_option('unitextboxmessage'); ?>
								<?php if (!empty($message) && $this -> get_option('unitextboxintabs') == "Y") : ?>
									<div class="<?php echo $this -> pre; ?>unitextbox">
										<?php echo wpautop(stripslashes($message)); ?>
									</div>
								<?php endif; ?>
							<?php endif; ?>
							</div>
						</div>
						<?php $tabscount++; ?>
					<?php endforeach; ?>
                    <!-- BEG Custom Fields & Variations in Tab -->
                    <?php if (empty($customooptionstab) || $customooptionstab == false) : ?>
						<?php if (empty($product -> oos) || $product -> oos == false) : ?>
							<?php if (!$this -> get_option('fieldsintab') || $this -> get_option('fieldsintab') == "Y") : ?>
								<?php if (!empty($product -> styles) || !empty($product -> cfields)) : ?>
									<div id="tabs<?php echo $product -> id; ?>-<?php echo $tabscount; ?>">
										<h3><?php _e('Options', $this -> plugin_name); ?></h3>
										<div>
											<?php $this -> render('products' . DS . 'options', array('product' => $product), true, 'default'); ?>
										</div>
									</div>
									<?php $tabscount++; ?>
								<?php endif; ?>
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
					<!-- END Custom Fields & Variations in Tab -->
                    <!-- BEG Gallery/extra Images in Tab -->
					<?php if (!$this -> get_option('gallerytab') || $this -> get_option('gallerytab') == "Y") : ?>
						<?php if (!empty($product -> images)) : ?>
							<div id="tabs<?php echo $product -> id; ?>-<?php echo $tabscount; ?>">
								<h3><?php _e('Gallery', $this -> plugin_name); ?></h3>
								<div>
									<div class="<?php echo $this -> pre; ?>imglist <?php echo $this -> pre; ?>imglistfull">
										<ul>
											<?php foreach ($product -> images as $image) : ?>
												<li><?php echo $wpcoHtml -> link($wpcoHtml -> bfithumb_image($image -> image_url, $this -> get_option('ithumbw'), $this -> get_option('ithumbh'), 100, ''), $wpcoHtml -> image_url($image -> filename), array('class' => 'colorbox', 'rel' => $wpcoHtml -> sanitize(__($product -> title)) . '-images', 'title' => $image -> title)); ?></li>
											<?php endforeach; ?>
										</ul>
										<br class="<?php echo $this -> pre; ?>cleaner" />
									</div>
									
									<?php if ($this -> get_option('unitextbox') == "Y") : ?>
										<?php $message = $this -> get_option('unitextboxmessage'); ?>
										<?php if (!empty($message) && $this -> get_option('unitextboxintabs') == "Y") : ?>
											<div class="<?php echo $this -> pre; ?>unitextbox">
												<?php echo wpautop(stripslashes($message)); ?>
											</div>
										<?php endif; ?>
									<?php endif; ?>
								</div>
							</div>
                            <?php $tabscount++; ?>
						<?php endif; ?>
					<?php endif; ?>
					<!-- END Gallery/extra Images in Tab -->
                    <!-- BEG Related Products in Tab -->
					<?php if (!empty($product -> related) && $this -> get_option('relatedintab') == "Y") : ?>
						<?php $rproducts = array(); ?>
						<?php foreach ($product -> related as $rproduct) : ?>
							<?php $wpcoDb -> model = $Product -> model; ?>
							<?php $rproducts[] = $wpcoDb -> find(array('id' => $rproduct -> related_id)); ?>
						<?php endforeach; ?>
						<div id="tabs<?php echo $product -> id; ?>-<?php echo $tabscount; ?>">
							<h3 id="related"><?php _e('Related Products', $this -> plugin_name); ?></h3>
							<div>
								<?php $this -> render('products' . DS . 'loop', array('products' => $rproducts, 'related' => true, 'tabber' => true, 'noaddtob' => true), true, 'default'); ?>
							</div>
						</div>
                        <?php $tabscount++; ?>
					<?php endif; ?>
                    <!-- END Related Products in Tab -->
				</div>
				<!-- END Tabber -->
			<?php endif; ?>
		<?php if (empty($product -> oos) || $product -> oos == false) : ?>
				<?php if ($this -> get_option('buynow') == "Y" || (!empty($product -> checkout_type) && ($product -> checkout_type == "recurring" || $product -> checkout_type == "buynow"))) : ?>
					<input type="hidden" name="buynow" value="Y" />
					<input type="hidden" name="checkout_type" value="<?php echo $product -> checkout_type; ?>" />
				<?php endif; ?>
                
                <input type="hidden" name="fromproductpage" value="Y" />
                
                <?php if (!empty($_POST['fromproductpage'])) : ?>
					<script type="text/javascript">
					eval("request<?php echo $product -> id; ?> = false;");
                    jQuery(document).ready(function(e) {
                        wpco_updateproductprice_new('<?php echo $product -> id; ?>', '<?php _e('Calculating...', $this -> plugin_name); ?>');
                    });
                    </script>
                <?php endif; ?>
			</form>
		<?php endif; ?>
		
		<?php if ($this -> get_option('fieldsintab') == "Y" && (!empty($product -> styles) || !empty($product -> cfields)) && !empty($product -> contents) && (is_array($product -> contents) || is_object($product -> contents))) : ?>
			<?php if ($this -> get_option('optionslinktb') == "T") : ?>
				<fieldset class="<?php echo $this -> pre; ?> <?php echo $this -> pre; ?>optionslinkfieldset">
					<legend><?php _e('Product Options', $this -> plugin_name); ?></legend>
					<span class="<?php echo $this -> pre; ?>optionslink"><?php echo $wpcoHtml -> link(__('Choose product options/variations &raquo;', $this -> plugin_name), "", array('class' => "product-options-link")); ?></span>
				</fieldset>
			<?php endif; ?>
		<?php endif; ?>
	<?php else : ?>		
		<!-- SHOWCASE -->
        <?php $showcasemsg = $this -> get_option('showcasemsg'); ?>
        <p class="checkout_product_showcasemsg"><?php echo (empty($product -> showcasemsg)) ? $showcasemsg : __($product -> showcasemsg); ?></p>
        </div>
        
        <!-- favorites link -->
        <?php $this -> render('favorites' . DS . 'link', array('product' => $product), true, 'default'); ?>
        
		<?php if (!empty($product -> contents) && (is_array($product -> contents) || is_object($product -> contents))) : ?>
			<?php $tabscount = 1; ?>
            <?php $tabscount2 = 1; ?>
			<div style="clear:both; display:block; height:1px; width:100%;"></div>
		
			<div id="tabs<?php echo $product -> id; ?>">
            	<!-- BEG Tabs Menu -->
                <ul>
                    <li><a href="#tabs<?php echo $product -> id; ?>-1"><?php _e('Description', $this -> plugin_name); ?></a></li>
                    <?php $tabscount2++; ?>
                    <?php foreach ($product -> contents as $content) : ?>
                        <li><a href="#tabs<?php echo $product -> id; ?>-<?php echo $tabscount2; ?>"><?php echo __($content -> title); ?></a></li>
                        <?php $tabscount2++; ?>
                    <?php endforeach; ?>
                    <?php if (!$this -> get_option('gallerytab') || $this -> get_option('gallerytab') == "Y") : ?>
                        <?php if (!empty($product -> images)) : ?>
                            <li><a href="#tabs<?php echo $product -> id; ?>-<?php echo $tabscount2; ?>"><?php _e('Gallery', $this -> plugin_name); ?></a></li>
                            <?php $tabscount2++; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if (!empty($product -> related) && $this -> get_option('relatedintab') == "Y") : ?>
                        <li><a href="#tabs<?php echo $product -> id; ?>-<?php echo $tabscount2; ?>"><?php _e('Related Products', $this -> plugin_name); ?></a></li>
                        <?php $tabscount2++; ?>
                    <?php endif; ?>
                </ul>
                <!-- END Tabs Menu -->
            
				<div id="tabs<?php echo $product -> id; ?>-<?php echo $tabscount; ?>">
					<h3><?php _e('Description', $this -> plugin_name); ?></h3>
					<div>
						<?php echo wpautop(do_shortcode(stripslashes(__($product -> description)))); ?>
						
						<?php if ($this -> get_option('unitextbox') == "Y") : ?>
							<?php $message = $this -> get_option('unitextboxmessage'); ?>
							<?php if (!empty($message) && $this -> get_option('unitextboxintabs') == "Y") : ?>
								<div class="<?php echo $this -> pre; ?>unitextbox">
									<?php echo wpautop(stripslashes($message)); ?>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
				<?php $tabscount++; ?>
				<?php foreach ($product -> contents as $content) : ?>
					<div id="tabs<?php echo $product -> id; ?>-<?php echo $tabscount; ?>">
						<h3><?php echo __($content -> title); ?></h3>
						<div>
							<?php echo wpautop(do_shortcode(stripslashes(__($content -> content)))); ?>
							
							<?php if ($this -> get_option('unitextbox') == "Y") : ?>
							<?php $message = $this -> get_option('unitextboxmessage'); ?>
							<?php if (!empty($message) && $this -> get_option('unitextboxintabs') == "Y") : ?>
								<div class="<?php echo $this -> pre; ?>unitextbox">
									<?php echo wpautop(stripslashes($message)); ?>
								</div>
							<?php endif; ?>
						<?php endif; ?>
						</div>
					</div>
					<?php $tabscount++; ?>
				<?php endforeach; ?>
				
				<!-- GALLERY IN TAB --> 
				<?php if (!$this -> get_option('gallerytab') || $this -> get_option('gallerytab') == "Y") : ?>
					<?php if (!empty($product -> images)) : ?>
						<div id="tabs<?php echo $product -> id; ?>-<?php echo $tabscount; ?>">
							<h3><?php _e('Gallery', $this -> plugin_name); ?></h3>
							<div>
								<div class="<?php echo $this -> pre; ?>imglist <?php echo $this -> pre; ?>imglistfull">
									<ul>
										<?php foreach ($product -> images as $image) : ?>
											<li><?php echo $wpcoHtml -> link($wpcoHtml -> bfithumb_image($image -> image_url, $this -> get_option('ithumbw'), $this -> get_option('ithumbh'), 100, ''), $wpcoHtml -> image_url($image -> filename), array('class' => 'colorbox', 'rel' => $wpcoHtml -> sanitize(__($product -> title)) . '-images', 'title' => $image -> title)); ?></li>
										<?php endforeach; ?>
									</ul>
									<br class="<?php echo $this -> pre; ?>cleaner" />
								</div>
								
								<?php if ($this -> get_option('unitextbox') == "Y") : ?>
									<?php $message = $this -> get_option('unitextboxmessage'); ?>
									<?php if (!empty($message) && $this -> get_option('unitextboxintabs') == "Y") : ?>
										<div class="<?php echo $this -> pre; ?>unitextbox">
											<?php echo wpautop(stripslashes($message)); ?>
										</div>
									<?php endif; ?>
								<?php endif; ?>
							</div>
						</div>
                        <?php $tabscount++; ?>
					<?php endif; ?>
				<?php endif; ?>
				
				<!-- RELATED PRODUCTS -->
				<?php if (!empty($product -> related) && $this -> get_option('relatedintab') == "Y") : ?>
					<?php $rproducts = array(); ?>
					<?php foreach ($product -> related as $rproduct) : ?>
						<?php $wpcoDb -> model = $Product -> model; ?>
						<?php $rproducts[] = $wpcoDb -> find(array('id' => $rproduct -> related_id)); ?>
					<?php endforeach; ?>
					<div id="tabs<?php echo $product -> id; ?>-<?php echo $tabscount; ?>">
						<h3 id="related"><?php _e('Related Products', $this -> plugin_name); ?></h3>
						<div>
							<?php $this -> render('products' . DS . 'loop', array('products' => $rproducts, 'related' => true, 'tabber' => true, 'noaddtob' => true), true, 'default'); ?>
						</div>
					</div>
                    <?php $tabscount++; ?>
				<?php endif; ?>
			</div>
			<!-- END TABBER -->
		<?php endif; ?>	
	<?php endif; ?>

	<?php if (!empty($product -> categories) && $this -> get_option('product_showcategories') == "Y") : ?>	
		<fieldset class="<?php echo $this -> pre; ?>">
			<?php if (count($product -> categories) == 1) : ?>
				<legend><?php echo $wpcocaptions['product']['category']; ?></legend>
			<?php else : ?>
				<legend><?php echo $wpcocaptions['product']['categories']; ?></legend>
			<?php endif; ?>
			
			<?php $c = 1; ?>
			<?php foreach ($product -> categories as $category_id) : ?>
				<?php $wpcoDb -> model = $Category -> model; ?>
				<?php if ($category = $wpcoDb -> find(array('id' => $category_id))) : ?>
					<a href="<?php echo get_permalink($category -> post_id); ?>" title="<?php echo __($category -> title); ?>"><?php echo __($category -> title); ?></a>
					<?php echo ($c < count($product -> categories)) ? ', ' : ''; ?>
				<?php endif; ?>
				<?php $c++; ?>
			<?php endforeach; ?>
		</fieldset>
	<?php endif; ?>
	
	<?php if ($this -> get_option('unitextbox') == "Y" && $this -> get_option('unitextfieldset') == "Y") : ?>
		<?php $message = $this -> get_option('unitextboxmessage'); ?>
		<?php if (!empty($message)) : ?>
			<fieldset class="<?php echo $this -> pre; ?>">
				<legend><?php _e('Attention', $this -> plugin_name); ?></legend>
				<div class="<?php echo $this -> pre; ?>unitextbox">
					<?php echo wpautop(stripslashes($message)); ?>
				</div>
			</fieldset>
		<?php endif; ?>
	<?php endif; ?>
	
	<?php if (!empty($product -> supplier_id) && $this -> get_option('hidesuppliers') == "N") : ?>
		<fieldset class="<?php echo $this -> pre; ?>">
			<legend><?php echo $wpcocaptions['product']['supplier']; ?></legend>
			<?php if ($this -> get_option('supplierpages') == "Y" && !empty($product -> supplier -> post_id)) : ?>
				<?php if ($product -> supplier -> image == "Y" && !empty($product -> supplier -> imagename)) : ?>
					<?php /*<?php echo $wpcoHtml -> link($wpcoHtml -> image($product -> supplier -> imagename, array('folder' => "suppliers"), $product -> supplier -> imagename), get_permalink($product -> supplier -> post_id), array('title' => $product -> supplier -> name)); ?>*/ ?>
                    <?php if ($this -> get_option('supimg') == "full") : ?>
                    	<?php echo $wpcoHtml -> link($wpcoHtml -> image($product -> supplier -> imagename, array('folder' => "suppliers"), $product -> supplier -> imagename), get_permalink($product -> supplier -> post_id), array('title' => __($product -> supplier -> name))); ?>
                    <?php else : ?>
                    	<?php echo $wpcoHtml -> link($wpcoHtml -> bfithumb_image($product -> supplier -> image_url, $this -> get_option('supthumbw'), $this -> get_option('supthumbh'), 100), get_permalink($product -> supplier -> post_id), array('title' => __($product -> supplier -> name))); ?>
                    <?php endif; ?>
				<?php else : ?>
					<?php echo $wpcoHtml -> link(__($product -> supplier -> name), get_permalink($product -> supplier -> post_id), array('title' => __($product -> supplier -> name))); ?>
				<?php endif; ?>
			<?php else : ?>
				<?php echo __($product -> supplier -> name); ?>
			<?php endif; ?>
		</fieldset>
	<?php endif; ?>
	
	<?php if (!empty($product -> kws) && is_array($product -> kws) && $this -> get_option('product_showkeywords') == "Y") : ?>
		<fieldset class="<?php echo $this -> pre; ?>">
			<legend><?php echo $wpcocaptions['product']['keywords']; ?></legend>
			<div class="<?php echo $this -> pre; ?>keywords">
				<?php $k = 1; ?>
				<?php foreach ($product -> kws as $kw) : ?>
					<?php echo $wpcoHtml -> link(__($kw), $wpcoHtml -> retainquery($this -> pre . 'searchterm=' . urlencode(__($kw)), get_permalink($this -> get_option('searchpage_id'))), array('title' => __($kw))); ?>
					<?php echo ($k < count($product -> kws)) ? ', ' : ''; ?>
					<?php $k++; ?>
				<?php endforeach; ?>
			</div>
		</fieldset>
	<?php endif; ?>	
	
	<?php if (!empty($product -> min_order)) : ?>
		<fieldset class="<?php echo $this -> pre; ?>">
			<legend><?php _e('Minimum Order', $this -> plugin_name); ?></legend>
			<?php echo $product -> min_order; ?> <?php _e('units', $this -> plugin_name); ?>
		</fieldset>
	<?php endif; ?>
	
	<?php if ($this -> get_option('unitextbox') == "Y") : ?>
		<?php $message = $this -> get_option('unitextboxmessage'); ?>
		<?php if (!empty($message)) : ?>
			<div class="<?php echo $this -> pre; ?>unitextbox">
				<?php echo wpautop(stripslashes($message)); ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
    
    <?php if ($this -> get_option('product_descriptionposition') == "below") : ?>
		<?php if (empty($product -> contents) || !is_array($product -> contents)) : ?>
        	<br class="<?php echo $this -> pre; ?>cleaner" />
            <?php echo wpautop(do_shortcode(stripslashes(__($product -> description)))); ?>
        <?php endif; ?>
    <?php endif; ?>
    
    <?php do_action($this -> pre . '_product_after', $product); ?>
	
	<?php if (!empty($product -> related) && ($this -> get_option('relatedintab') == "N" || empty($product -> contents))) : ?>
		<br class="<?php echo $this -> pre; ?>cleaner" />
	
		<?php $rproducts = array(); ?>
		<?php foreach ($product -> related as $rproduct) : ?>
			<?php $wpcoDb -> model = $Product -> model; ?>
			<?php $rproducts[] = $wpcoDb -> find(array('id' => $rproduct -> related_id)); ?>
		<?php endforeach; ?>
		<h3 id="related"><?php _e('Related Products', $this -> plugin_name); ?></h3>
		<?php $this -> render('products' . DS . 'loop', array('products' => $rproducts, 'related' => true, 'tabber' => false), true, 'default'); ?>
	<?php endif; ?>
    
    <?php if ($this -> get_option('product_sharingbuttons') == "Y") : ?>
        <?php /*<!-- AddThis Button BEGIN -->
        <div class="addthis_toolbox addthis_default_style ">
        <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
        <a class="addthis_button_tweet"></a>
        <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
		<a class="addthis_button_pinterest_pinit" pi:pinit:url="<?php echo get_permalink($product -> post_id); ?>" pi:pinit:media="<?php echo site_url('/') . $product -> image_url; ?>" pi:pinit:layout="horizontal"></a> 
        <a class="addthis_counter addthis_pill_style"></a>
        </div>
        <script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e5ef8193f008bd1"></script>
        <!-- AddThis Button END -->*/ ?>
        
		<div class="addthis_sharing_toolbox"></div>
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e2560526be8dd61"></script>
    <?php endif; ?>
</div>

<?php if (!is_feed()) : ?>
	<script type="text/javascript">
	<?php if (!empty($tabscount) && $tabscount > 1) : ?>
		jQuery(document).ready(function() {
			tabs = jQuery('#tabs<?php echo $product -> id; ?>').tabs();
			
			jQuery('.product-options-link').live('click', function() {
				wpco_scroll(jQuery('#tabs<?php echo $product -> id; ?>'));
				tabs.tabs('option', 'active', <?php echo ($productoptionstab - 1); ?>);
				return false;
			});
			
			jQuery('.view-all-images-link').live('click', function() {
				wpco_scroll(jQuery('#tabs<?php echo $product -> id; ?>'));
				tabs.tabs('option', 'active', <?php echo ($gallerytab - 1); ?>);
				return false;	
			});
		});
	<?php endif; ?>
	</script>
<?php endif; ?>

<?php if (!empty($product -> styles)) : ?>
	<script type="text/javascript">
	eval("request<?php echo $product -> id; ?> = false;");
	jQuery(document).ready(function() {
		wpco_updateproductprice_new('<?php echo $product -> id; ?>', '<?php _e('Calculating...', $this -> plugin_name); ?>');
	});
	</script>
<?php endif; ?>