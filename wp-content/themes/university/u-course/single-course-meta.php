<div class="content-pad single-event-meta single-course-meta">
	<?php
	$product_id = get_post_meta(get_the_ID(),'product_id_course', true );
	$date_format = get_option('date_format');
	$startdate = get_post_meta(get_the_ID(),'u-course-start', true );
	if($startdate){
		$startdate = gmdate("Y-m-d\TH:i:s\Z", $startdate);// convert date ux
		$con_date = new DateTime($startdate);
		$start_datetime = $con_date->format($date_format);
	}
	$id_course = get_post_meta(get_the_ID(),'u-courseid', true );
	$time_duration = get_post_meta(get_the_ID(),'u-course-dur', true );
	$u_credit = get_post_meta(get_the_ID(),'u-course-cre', true );
	$u_dl = get_post_meta(get_the_ID(),'u-course-dl', true );
	$u_sub = get_post_meta(get_the_ID(),'u-course-sub', true );
	$u_label = get_post_meta(get_the_ID(),'u-course-label', true );
	if($u_label==''){$u_label = 'SIGN UP NOW';}
	$u_label_bro = get_post_meta(get_the_ID(),'u-course-label-bro', true );
	if($u_label_bro==''){$u_label_bro = 'DOWNLOAD PROCHURE ';}
	 ?>
    <div class="item-thumbnail">
    	<?php echo get_the_post_thumbnail( get_the_ID(), 'thumb_263x263' ); ?>
    </div><!--/item-thumbnail-->
        <div class="event-description course-des">
        	<p class="course-exc"><?php if(has_excerpt( get_the_ID())){ echo get_the_excerpt();} ?></p>
            <?php if($u_dl){ ?>
        	<p class="course-dl"><a class="btn btn-primary btn-block btn-grey" href="<?php echo $u_dl; ?>"><?php _e($u_label_bro,'cactusthemes');?> <i class="fa fa-angle-right"></i></a></p>
            <?php }?>
            <div class="course-meta">
			<?php if($start_datetime){ ?>
                <?php _e('START:','cactusthemes');?>
                <div class="course-start"><?php echo date_i18n( get_option('date_format'), strtotime($startdate));?></div>
            <?php }?>
            <?php if($time_duration){ ?>
                <?php _e('DURATION:','cactusthemes');?>
                <div class="course-start"><?php echo $time_duration; ?></div>
            <?php }?>
            <?php if($id_course){ ?>
                <?php _e('ID:','cactusthemes');?>
                <div class="course-start"><?php echo $id_course; ?></div>
            <?php }?>
            <?php if($u_credit){ ?>
                <?php _e('CREDIT:','cactusthemes'); ?>
                <div class="course-start"><?php echo $u_credit; ?></div>
            <?php }?>
            </div>
        </div>

        <div class="event-action">
		<?php 
		if(class_exists('U_course')){
			$u_course = new U_course;
			$price = $u_course->getPrice();
			$vailable = $u_course->getAvailable();
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
            <div class="element-pad" style="display:none">
                <label for="quantity" class="small-text"><?php _e('NUMBER OF TICKETS','cactusthemes'); ?></label>
                <div class="input-group quantity-group">
                    <span class="input-group-btn">
                        <button class="btn btn-primary btn-lg" id="minus" type="button">-</button>
                    </span>
                    <input class="quantity form-control" id="num" name="num_ticket" value="1" type="hidden" max="1" max="0" step="1" placeholder="0">
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
			if(method_exists($u_course,'ct_wc_disposit_form')){
				$u_course->ct_wc_disposit_form($product_id);
			}?>
            <div class="element-pad sold-out">
				<?php 
                $stock_status = get_post_meta($product_id, '_stock_status',true);
                if($stock_status!='outofstock'){?>
                    <a href="#" class="button medium price-button submit-button left"  name="join_event">
                    <button class="btn btn-primary btn-lg btn-block"><?php _e('TAKE THIS COURSE','cactusthemes') ?></button>
                    </a>
                 <?php }else{?>
                	<span><?php _e('Sold Out','cactusthemes') ?></span>
                 <?php }?>  
            </div>
        </form>
        <?php } else if($vailable == 'simple'){?>
        <form action="<?php get_permalink(get_the_ID()) ?>" method="POST">
            <div class="element-pad"  style="display:none">
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
            <div class="element-pad" style="display:none">
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
			if(method_exists($u_course,'ct_wc_disposit_form')){
				$u_course->ct_wc_disposit_form($product_id);
			}?>
                <div class="element-pad sold-out">
				<?php 
                $stock_status = get_post_meta($product_id, '_stock_status',true);
                if($stock_status!='outofstock'){?>
                    <a href="#" class="button medium price-button submit-button left" name="join_event">
                    <button class="btn btn-primary btn-lg btn-block btn-slg"><?php _e('TAKE THIS COURSE','cactusthemes') ?></button>
                    </a>
				<?php }else{?>
                	<span><?php _e('Sold Out','cactusthemes') ?></span>
                <?php }?>
                </div>
        </form>
        <?php } else {?>
            <?php if($u_sub){ ?>    
                <div class="element-pad">
                <a href="<?php echo $u_sub; ?>" class="btn btn-primary btn-lg btn-block"><?php _e( $u_label,'cactusthemes') ?>
                </a>
                </div>
			<?php }?>
       <?php }?>
    </div>
    		<script >
             jQuery(document).ready(function($) {
                $("#u-price").html($("#event_variation").find('option:selected').attr("class"));
                $("#event_variation").change(function(){
					$("#u-price").html('');
                    $("#u-price").html($(this).find('option:selected').attr("class"));
                    
                });
             });
        </script>
</div>