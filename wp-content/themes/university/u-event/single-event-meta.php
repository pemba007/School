<div class="content-pad single-event-meta">
	<?php
	$product_id = get_post_meta(get_the_ID(),'product_id', true );
	if($product_id == ''){$product_id = get_the_ID();}
	$layout_event = get_post_meta(get_the_ID(),'event-layout-header', true );
	if($layout_event=='def' || $layout_event==''){
		if(function_exists('cop_get')){
			$layout_event =  cop_get('u_event_settings','u-event-layout-header');
		} 
	}

	 if($layout_event!='feature-image'){?>
    <div class="item-thumbnail">
    	<?php if(get_the_post_thumbnail( $product_id, 'thumb_263x263' )!=''){ echo get_the_post_thumbnail( $product_id, 'thumb_263x263' );}else{ echo get_the_post_thumbnail( get_the_ID(), 'thumb_263x263' );} ?>
    </div><!--/item-thumbnail-->
    <?php } if(has_excerpt( get_the_ID())&& $layout_event!='feature-image'){ ?>
    	    	<div class="event-description">
				<?php echo get_the_excerpt(); ?>
                </div>
    <?php } else {?>
                <div class="event-description">
                <?php echo wp_trim_words(get_post_field('post_content', $product_id),50,$more = ''); ?>
                </div>
    <?php }?>
    <div class="event-action">
		<?php 
		if(class_exists('U_event')){
			$u_event = new U_event;
			$price = $u_event->getPrice();
			$vailable = $u_event->getAvailable();
		}
        ?>
        <?php if($vailable == 'variable'){  ?>
        <form action="<?php get_permalink(get_the_ID()) ?>" method="POST">
            <div class="element-pad">
            	<input type="hidden" name="event_action" value="add" />
                <label for="seat" class="small-text"><?php _e('CHOOSE YOUR SEAT','cactusthemes') ?></label>
				<?php
				if(function_exists('wc_get_product')){
					$product = wc_get_product($product_id);
					$price['text'] = $product->get_price_html();
				}
						
						if(isset($product) && $product){?>
                <select id="event_variation" name="event_variation" class="form-control">
                     <?php
						
						$product_variations = $product->get_available_variations();
						
						foreach($product_variations as $variation){
							
							$attributes = array_values($variation['attributes']);
							$variation_name = implode(', ', $attributes);
							if(substr($variation_name, -2) === ', '){
								$variation_name = substr($variation_name, 0, strlen($variation_name) - 2);
							}
							?>
							<option value="<?php echo $variation['variation_id']; ?>" class="<?php echo esc_html($variation['price_html']); ?>"><?php echo $variation_name;  ?></option>
							<?php
						} ?>
                </select>
						<?php }
						?>
            </div>
            <?php 
			if(class_exists('Product_Addon_Display') && $product_id!=''){
				echo '<div class="element-pad">';
					$Product_Addon_Display = new Product_Addon_Display;
					echo $Product_Addon_Display->display($product_id);
				echo '</div>';
			}
			?>
            <?php 
           if ( shortcode_exists( 'currency_switcher' ) ) {
			   ?>
				<div class="element-pad currency_switcher">
					<?php
                	echo do_shortcode('[currency_switcher]');
					?>
                </div>
                <?php
            }?>
            <div class="element-pad">
                <label for="quantity" class="small-text"><?php _e('NUMBER OF TICKETS','cactusthemes') ?></label>
                <div class="input-group quantity-group">
                    <span class="input-group-btn">
                        <button class="btn btn-primary btn-lg" id="minus" type="button">-</button>
                    </span>
                    <input class="quantity form-control" id="num" name="num_ticket" value="1" type="text" min="0" step="1" placeholder="0">
                    <span class="input-group-btn">
                        <button class="btn btn-primary btn-lg" id="plus" type="button">+</button>
                    </span>
                </div>
            </div>
            <div class="element-pad">
                <div class="small-text"><?php _e('PRICE','cactusthemes') ?></div>
                <span class="price main-color-1" id="u-price"></span>
            </div>
            <?php 
			if(method_exists($u_event,'ct_wc_disposit_form')){
				$u_event->ct_wc_disposit_form($product_id);
			}?>
            <div class="element-pad sold-out">
				<?php 
                $stock_status = get_post_meta($product_id, '_stock_status',true);
                if($stock_status!='outofstock'){?>
                    <a href="#" class="button medium price-button submit-button left" name="join_event">
                    <button class="btn btn-primary btn-lg btn-block"><?php _e('JOIN THIS EVENT','cactusthemes') ?></button>
                    </a>
                <?php }else{?>
                	<span><?php _e('Sold Out','cactusthemes') ?></span>
                 <?php }?> 
            </div>
        </form>
        <?php } else if($vailable == 'simple'){?>
        <form action="<?php get_permalink(get_the_ID()) ?>" method="POST">
            <div class="element-pad">
            	<input type="hidden" name="event_action" value="add" />
            </div>
			<?php 
            if(class_exists('Product_Addon_Display') && $product_id!=''){
                echo '<div class="element-pad">';
                    $Product_Addon_Display = new Product_Addon_Display;
                    echo $Product_Addon_Display->display($product_id);
                echo '</div>';
            }
            ?>
            <?php 
            if ( shortcode_exists( 'currency_switcher' ) ) {
				?>
				<div class="element-pad currency_switcher">
					<?php
                    echo do_shortcode('[currency_switcher]');
                    ?>
                </div>
                <?php
            }?>
            <div class="element-pad">
                <label for="quantity" class="small-text"><?php _e('NUMBER OF TICKETS','cactusthemes') ?></label>
                <div class="input-group quantity-group">
                    <span class="input-group-btn">
                        <button class="btn btn-primary btn-lg" id="minus" type="button">-</button>
                    </span>
                    <input class="quantity form-control" id="num" name="num_ticket" value="1" type="text" min="0" step="1" placeholder="0">
                    <span class="input-group-btn">
                        <button class="btn btn-primary btn-lg" id="plus" type="button">+</button>
                    </span>
                </div>
            </div>
            <div class="element-pad">
                <div class="small-text"><?php _e('PRICE','cactusthemes') ?></div>
                <span class="price main-color-1" id="u-price"><?php echo  ($price['text']);  ?></span>
            </div>
            <?php 
			if(method_exists($u_event,'ct_wc_disposit_form')){
				$u_event->ct_wc_disposit_form($product_id);
			}?>
            <div class="element-pad sold-out">
				<?php 
                $stock_status = get_post_meta($product_id, '_stock_status',true);
                if($stock_status!='outofstock'){?>
                    <a href="#" class="button medium price-button submit-button left" name="join_event">
                    <button class="btn btn-primary btn-lg btn-block btn-slg"><?php _e('JOIN THIS EVENT','cactusthemes') ?></button>
                    </a>
                <?php }else{?>
                	<span><?php _e('Sold Out','cactusthemes') ?></span>
                <?php }?>
            </div>
        </form>
        <?php } else {
			$u_linkssub = get_post_meta(get_the_ID(),'u-linkssub', true );
			if($u_linkssub){
			?>
        	<div class="element-pad">
                <a href="<?php echo $u_linkssub; ?>" class="button-link" target="_blank">
                <button class="btn btn-primary btn-lg btn-block btn-slg"><?php _e('JOIN THIS EVENT','cactusthemes') ?></button>
                </a>
            </div>
       <?php }}?>
    </div>
    		<script >
             jQuery(document).ready(function($) {
				$("#plus").click(function(){
				   var $this = $(this);
				   var quantity = parseInt($("#num").val()) +1;
				   $("#num").val(quantity);
				   return false;
				});
				$("#minus").click(function(){
				   var $this = $(this);
				   if($("#num").val()>0){
				   		var quantity = parseInt($("#num").val()) -1;
				   		$("#num").val(quantity);
				   }
				   return false;
				});
                $("#u-price").html($("#event_variation").find('option:selected').attr("class"));
                $("#event_variation").change(function(){
					$("#u-price").html('');
                    $("#u-price").html($(this).find('option:selected').attr("class"));
                    
                });
             });
        </script>
</div>
