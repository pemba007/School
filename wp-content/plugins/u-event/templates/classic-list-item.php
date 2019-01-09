<article class="post-item row event-classic-item">
    <div class="col-md-4 col-sm-5">
        <div class="content-pad">
            <div class="item-thumbnail">
                <a href="<?php echo get_permalink( get_the_ID()); ?>" title="<?php the_title_attribute()?>">
                    <?php echo get_the_post_thumbnail( get_the_ID(), 'thumb_526x526' ); ?>
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
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-sm-7">
        <div class="content-pad">
        <?php 
		if(class_exists('U_event')){
			$u_event = new U_event;
			$price = $u_event->getPrice();
			$getPrice_num = $u_event->getPrice_num();
			$vailable = $u_event->getAvailable();
			global  $woocommerce;
		}
		?>
            <div class="item-content">
                <h3 class="item-title"><a href="<?php echo get_permalink( get_the_ID()); ?>" title="<?php the_title_attribute()?>" class="main-color-1-hover"><?php the_title_attribute() ?></a></h3>
                <div class="price main-color-1"><?php 
				if($vailable == 'variable'){
					 //print_r($price);
					 _e('From ','cactusthemes');
					 echo get_woocommerce_currency_symbol(); echo $getPrice_num;
					 //foreach($price as $items => $item){ ?>
                           <span><?php //echo strip_tags($item['price_html']) ?></span>
                     <?php //}
				} 
				else { 
					if($price['number']!=0){
						echo get_woocommerce_currency_symbol(); echo  ($price['number']); 
					}else{
						 echo $price['text'];
					}
						
					
				} ?></div>
                <p><?php echo get_the_excerpt() ?></p>
                <div class="event-time"><?php _e('At ','cactusthemes'); echo $start_datetime; ?></div>
                <div class="event-address"><?php echo get_post_meta(get_the_ID(),'u-adress', true );?></div>
            </div>
            <div class="item-meta">
                <a class="btn btn-default btn-lighter" href="<?php echo get_permalink( get_the_ID()); ?>" title="<?php the_title_attribute()?>"><?php _e('DETAILS  ','cactusthemes'); ?><i class="fa fa-angle-right"></i></a>
            </div>
        </div>
    </div>
</article>