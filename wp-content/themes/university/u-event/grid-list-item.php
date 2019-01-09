<div class="grid-item">
    <div class="grid-item-inner">
        <div class="grid-item-content event-item dark-div">
            <div class="event-thumbnail">
                <a href="<?php echo get_permalink( get_the_ID()); ?>" title="<?php the_title_attribute()?>">
                    <?php echo get_the_post_thumbnail( $product_id, 'thumb_554x674' ); ?>
                </a>
            </div>
			<?php 
            $startdate = get_post_meta(get_the_ID(),'u-startdate', true );
            if($startdate){
                $startdate = gmdate("Y-m-d\TH:i:s\Z", $startdate);// convert date ux
                $con_date = new DateTime($startdate);
				$month = $con_date->format('M');
				$day = $con_date->format('d');
                $start_datetime = $con_date->format(get_option('time_format'));
				//$date = $date->format(get_option('time_format'));
            }
            ?>
            <div class="date-block">
                <div class="month"><?php echo date_i18n( 'M', strtotime( $month ) ); ?></div>
                <div class="day"><?php echo $day; ?></div>
            </div>
            <?php 
			if(class_exists('U_event')){
				$u_event = new U_event;
				$price = $u_event->getPrice();
				$getPrice_num = $u_event->getPrice_num();
				$vailable = $u_event->getAvailable();
				global  $woocommerce;
			}
			?>
            <div class="event-overlay">
                <div class="overlay-top">
                    <h4><a href="<?php echo get_permalink( get_the_ID()); ?>" title="<?php the_title_attribute()?>"><?php the_title_attribute() ?></a></h4>
                    <span class="price yellow"><?php 
				if($vailable == 'variable'){
					 //print_r($price);
					 _e('From ','cactusthemes');
					 $currency_pos = get_option( 'woocommerce_currency_pos' );
					 if($currency_pos=='left'){ echo get_woocommerce_currency_symbol(); }
					 else if($currency_pos=='left_space'){ echo get_woocommerce_currency_symbol().' '; }
					 echo $getPrice_num;
					 if($currency_pos=='right'){ echo get_woocommerce_currency_symbol(); }
					 else if($currency_pos=='right_space'){ echo ' '.get_woocommerce_currency_symbol(); }
					 //foreach($price as $items => $item){ ?>
                           <span><?php //echo strip_tags($item['price_html']) ?></span>
                     <?php //}
				} 
				else { 
					if($price['number']!=0){
					   $currency_pos = get_option( 'woocommerce_currency_pos' );
					   if($currency_pos=='left'){ echo get_woocommerce_currency_symbol(); }
					   else if($currency_pos=='left_space'){ echo get_woocommerce_currency_symbol().' '; }
					   echo  ($price['number']); 
					   if($currency_pos=='right'){ echo get_woocommerce_currency_symbol(); }
					   else if($currency_pos=='right_space'){ echo ' '.get_woocommerce_currency_symbol(); }
					}else{
						 echo $price['text'];
					}
				} ?></span>
                </div>
                <div class="overlay-bottom">
                	<?php 
					$all_day = get_post_meta(get_the_ID(),'all_day', true );
					if($all_day !=1){
						?>
                    	<div> <?php _e('At ','cactusthemes'); echo $start_datetime; ?></div>
                        <?php
					}?>
                    <div><?php echo get_post_meta(get_the_ID(),'u-adress', true );?></div>
                </div>
            </div>
        </div><!--/event-item-->
    </div>
</div><!--/grid-item-->