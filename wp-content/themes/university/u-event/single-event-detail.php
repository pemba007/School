<div class="content-pad single-event-detail">
    <div class="event-detail">
    	<div class="event-speaker">
        <?php 
		$member_id = get_post_meta(get_the_ID(),'member_id', true );
		//print_r($member_id);
		if(is_array($member_id)){?>
        <h4 class="small-text"><?php _e('Speakers','cactusthemes') ?></h4>
        <div class="row">        
        <?php
		foreach($member_id as $item){
			//echo $item;
		?>                
        		<div class="col-md-6 col-sm-6">
                    <div class="media professor">
                        <div class="pull-left">
                            <a href="<?php echo get_permalink($item); ?>" class="main-color-2"><?php echo get_the_post_thumbnail( $item, 'thumb_50x50' ); ?></a>
                        </div>
                        <div class="media-body">
                            <h6 class="media-heading main-color-2"><a class="main-color-2" href="<?php echo get_permalink($item); ?>"><?php echo get_the_title($item); ?></a></h6>
                            <span><?php echo get_post_meta($item,'u-member-pos', true ); ?></span>
                        </div>
                    </div>
                </div>
           <?php }?>
		   </div>
		   <?php }?> 
        </div><!--/event-speaker-->
        <div class="event-info row content-pad">
        	<?php 
			$all_day = get_post_meta(get_the_ID(),'all_day', true );
			$date_format = get_option('date_format');
			$hour_format = get_option('time_format');
			$startdate = get_post_meta(get_the_ID(),'u-startdate', true );
			$start_datetime = '';
			$start_hourtime = '';
			if($startdate){
				$startdate_cal = gmdate("Ymd\THis", $startdate);
				$startdate = gmdate("Y-m-d\TH:i:s\Z", $startdate);// convert date ux
				$con_date = new DateTime($startdate);
				$con_hour = new DateTime($startdate);
				$start_datetime = $con_date->format($date_format);
				$start_hourtime = $con_date->format($hour_format);
			}
			$enddate = get_post_meta(get_the_ID(),'u-enddate', true );
			$end_datetime = '';
			$end_hourtime = '';
			if($enddate){
				$enddate_cal = gmdate("Ymd\THis", $enddate);
				$enddate = gmdate("Y-m-d\TH:i:s\Z", $enddate);
				$conv_enddate = new DateTime($enddate);
				$conv_hourtime = new DateTime($enddate);
				$end_datetime = $conv_enddate->format($date_format);
				$end_hourtime = $conv_enddate->format($hour_format);
			}
			?>
        	<div class="col-md-6 col-sm-6">
            	<h4 class="small-text"><?php _e('Start','cactusthemes') ?></h4>
                <p><?php if($startdate){ echo date_i18n( get_option('date_format'), strtotime($startdate));} if($start_datetime && $all_day !=1){ echo ' - '.$start_hourtime;}?></p>
                <h4 class="small-text"><?php _e('End','cactusthemes') ?></h4>
                <p><?php if($enddate){echo date_i18n( get_option('date_format'), strtotime($enddate));  } if($end_hourtime && $all_day !=1){ echo ' - '.$end_hourtime;}?></p>
            </div>
            <?php 
			$address = get_post_meta(get_the_ID(),'u-adress', true );
			if($address!=''){
			?>
            <div class="col-md-6 col-sm-6">
            	<h4 class="small-text"><?php _e('Address','cactusthemes') ?></h4>
                <?php echo $address;?>
                <a href="http://maps.google.com/?q=<?php echo esc_attr($address);?>" target="_blank" class="map-link small-text">&nbsp;&nbsp;<?php _e('View map','cactusthemes') ?> <i class="fa fa-angle-right"></i></a>
            </div>
            <?php }?>
            <?php 
			$single_ev_cat ='';
			if(function_exists('cop_get')){
				$single_ev_cat =  cop_get('u_event_settings','single_ev_cat');
		 	}
			$terms = wp_get_post_terms( get_the_ID(), 'u_event_cat');
			$count = 0; $i=0;
			foreach ($terms as $term) {
				$count ++;
			}
			if($count!=0 && $single_ev_cat ==1){
			?>
            <div class="col-md-6 col-sm-6">
            	<h4 class="small-text cate-ev"><?php _e('Categories','cactusthemes') ?></h4>
                <?php 
					foreach ($terms as $term) {
						$i++;
						echo '<a href="'.get_term_link($term->slug, 'u_event_cat').'" class="cat-link">'.$term->name.'</a> ';
						if($i!=$count){ echo ', ';}
					}
				?>
            </div>
            <?php }?>
        </div><!--/event-info-->
    </div><!--/event-detail-->
    <div class="event-content">
    	<div class="content-dropcap">
        	<?php the_content(); ?>
            
        </div>
        <?php
			$single_ev_tag ='';
			if(function_exists('cop_get')){
				 $single_ev_tag =  cop_get('u_event_settings','single_ev_tag');
		 	}
			$tag_terms = wp_get_post_terms( get_the_ID(), 'u_event_tags');
			$tag_count = 0; $i=0;
			foreach ($tag_terms as $tag_term) {
				$tag_count ++;
			}
			if($tag_count!=0 && $single_ev_tag==1){
			?>
            <div class="tag_ev">
            <?php _e('Tags:&nbsp;&nbsp;','cactusthemes') ?>
                <?php 
					foreach ($tag_terms as $tag_term) {
						$i++;
						echo '<span><a href="'.get_term_link($tag_term->slug, 'u_event_tags').'" >'.$tag_term->name.'</a></span>';
						if($i!=$tag_count){ echo '<span class="sep">|</span>';}
					}
				?>
             </div>
            <?php }?>
        <div class="content-pad calendar-import">
            <a class="btn btn-default btn-lighter" href="https://www.google.com/calendar/render?dates=<?php echo $startdate_cal;?>/<?php echo $enddate_cal;?>&action=TEMPLATE&text=<?php echo get_the_title(get_the_ID());?>&location=<?php echo get_post_meta(get_the_ID(),'u-adress', true );?>&details=<?php echo get_the_excerpt();?>">+ GOOGLE CALENDAR</a>&nbsp;
            <a href="<?php echo home_url().'?ical_id='.get_the_ID(); ?>" class="btn btn-default btn-lighter">+ ICAL IMPORT</a>
            <?php // tf_events_ical();?>
        </div>
        <div class="content-pad">
            <ul class="list-inline social-light">
            	<?php cactus_social_share(); ?>
            </ul>
        </div>
		
		<?php 
		
		$uni_event_website = get_post_meta(get_the_ID(),'u-website', true );
		$uni_event_phone = get_post_meta(get_the_ID(),'u-phone', true );
		$uni_event_email = get_post_meta(get_the_ID(),'u-email', true );
		
		if($uni_event_email || $uni_event_phone || $uni_event_website) {
		?>
        <div class="event-more-detail">
        	<h4><?php esc_html_e('MORE DETAIL','cactusthemes') ?></h4>
            <?php if($uni_event_website != ''){ ?>
            <h6 class="small-text"><?php esc_html_e('Website','cactusthemes') ?></h6>
            <p><a href="<?php echo get_post_meta(get_the_ID(),'u-website', true );?>" target="_blank"><?php echo get_post_meta(get_the_ID(),'u-website', true );?></a></p>
            <?php }
			if($uni_event_phone != ''){ ?>
            <h6 class="small-text"><?php esc_html_e('Phone','cactusthemes') ?></h6>
            <p><a href="tel:<?php echo get_post_meta(get_the_ID(),'u-phone', true );?>"><?php echo get_post_meta(get_the_ID(),'u-phone', true );?></a></p>
            <?php }
			if($uni_event_email != ''){ ?>
            <h6 class="small-text"><?php esc_html_e('Email','cactusthemes') ?></h6>
            <p><a href="mailto:<?php echo get_post_meta(get_the_ID(),'u-email', true );?>"><?php echo get_post_meta(get_the_ID(),'u-email', true );?></a></p>
            <?php } ?>
        </div>
        <?php 
		
		}
		$u_linkssub = '';
		$u_textsub = get_post_meta(get_the_ID(),'u-textsub', true );
		if($u_textsub ==''){$u_textsub ='BUY NOW';}
		$product_id = get_post_meta(get_the_ID(),'product_id', true );
		if($product_id == ''){$u_linkssub = get_post_meta(get_the_ID(),'u-linkssub', true );}
		$stock_status = '';
		$cls ='';
		if($product_id){
			$stock_status = get_post_meta($product_id, '_stock_status',true);
		}
		?>
        <div class="event-cta">
        	<?php if($stock_status !='outofstock'){?>
                <p><?php echo get_post_meta(get_the_ID(),'u-callaction', true );?></p>
                <?php if($product_id!='' || $u_linkssub!=''){?>
                <a class="btn btn-primary btn-lg btn-block btn-slg" href="<?php if($u_linkssub){ echo $u_linkssub;}else{echo '#join_event';}?>" <?php if($u_linkssub){?> target="_blank"<?php }?>><?php _e($u_textsub,'cactusthemes') ?></a>
            	<?php }?>
            <?php }else{
				$cls = 'out-stock';
				?>
            	<span class="out-stock"><?php _e('Sold Out','cactusthemes') ?></span>
            <?php }?>
        </div>
		  <?php 
		  if(function_exists('cop_get')){
          		$event_style =  cop_get('u_event_settings','uevent-related');
				$reletd_number =  cop_get('u_event_settings','uevent-rel-number');
				$event_layout =  cop_get('u_event_settings','u-event-layout');
		  }
		  if($event_style=='tags'){
			  $posttags = get_the_terms( get_the_ID(), 'u_event_tags');
			  $tags_event = array();
			  if ($posttags) {
				  foreach($posttags as $tag) {
					  $tags = $tag->slug; 
					  array_push($tags_event,$tags);
				  }
			  }
			  if(count($tags_event)>1){
				  $texo = array(
					  'relation' => 'OR',
				  );
				  foreach($tags_event as $iterm) {
					  $texo[] = 
						  array(
							  'taxonomy' => 'u_event_tags',
							  'field' => 'slug',
							  'terms' => $iterm,
						  );
				  }
			  }else{
				  $texo = array(
					  array(
							  'taxonomy' => 'u_event_tags',
							  'field' => 'slug',
							  'terms' => $tags_event,
						  )
				  );
			  }
		  }else{
			  $post_cat = get_the_terms( get_the_ID(), 'u_event_cat');
			  $cat_event = array();
			  if ($post_cat) {
				  foreach($post_cat as $cat) {
					  $cats = $cat->slug; 
					  array_push($cat_event,$cats);
				  }
			  }
			  if(count($cat_event)>1){
				  $texo = array(
					  'relation' => 'OR',
				  );
				  foreach($cat_event as $iterm) {
					  $texo[] = 
						  array(
							  'taxonomy' => 'u_event_cat',
							  'field' => 'slug',
							  'terms' => $iterm,
						  );
				  }
			  }else{
				  $texo = array(
					  array(
							  'taxonomy' => 'u_event_cat',
							  'field' => 'slug',
							  'terms' => $cat_event,
						  )
				  );
			  }
		  }
		  if($event_layout=='full'){
			  $class_r = 'col-md-4';
		  }else{
			  $class_r = 'col-md-6';
		  }
		  if($reletd_number=='' && $event_layout=='full'){$reletd_number=3;}
		  else if($reletd_number==''){$reletd_number=2;}
		  $cr_id = get_the_ID();
          $args = array(
              'post_type' => 'u_event',
              'posts_per_page' => $reletd_number,
              'orderby' => 'title',
              'order' => 'ASC',
              'post_status' => 'publish',
			  'post__not_in' => array($cr_id),
              'tax_query' => $texo
          );
		  $tm_query = get_posts($args);
		  if(count($tm_query)>0 && $reletd_number > 0){
		  ?>
       		<div class="related-event <?php echo $cls ?>">
            	<h3><?php _e('Related Events','cactusthemes') ?></h3>
                <div class="ev-content">
				  <?php
                  //print_r($args);
				  $count_item = count($tm_query);
				  $i=0;?>
                  <div class="row">
                  <?php
                  foreach ( $tm_query as $key => $post ) : setup_postdata( $post );
				  	$i++;
				  		$date_format = get_option('date_format');
						$hour_format = get_option('time_format');
						$startdate = get_post_meta($post->ID,'u-startdate', true );
						if($startdate){
							$startdate_cal = gmdate("Ymd\THis\Z", $startdate);
							$startdate = gmdate("Y-m-d\TH:i:s\Z", $startdate);// convert date ux
							$con_date = new DateTime($startdate);
							$con_hour = new DateTime($startdate);
							$start_datetime = $con_date->format($date_format);
							$start_hourtime = $con_date->format($hour_format);
						}
				  ?>
                    <div class="<?php echo $class_r;?> col-sm-6 related-item">
                    	<?php if(has_post_thumbnail($post->ID)){ ?> 
                    		<div class="thumb"><a href="<?php echo get_permalink($post->ID)?>"><?php echo get_the_post_thumbnail( $post->ID, 'thumb_80x80' ); ?></a></div>
                        <?php }?>
                        <h4 class="ev-title"><a href="<?php echo get_permalink($post->ID)?>" class="related-ev-title main-color-1-hover"><?php echo get_the_title( $post->ID); ?></a></h4>
                        <div class="ev-start small-text"><?php if($startdate){  echo date_i18n( get_option('date_format'), strtotime($startdate)).'  '; echo $start_hourtime; } ?></div>
                        <div class="clear"></div>
                    </div>
                  <?php  
				  if(($event_layout=='full') && ($i%3==0) && ($count_item > $i)){?>
					  </div><div class="row">
                  <?php } elseif(($event_layout!='full') && ($i%2==0) && ($count_item > $i)){?>
					  </div><div class="row">
                  <?php }
                  endforeach;
				  wp_reset_postdata();
                  ?>
                  </div>
               </div>
       </div>
       <?php }?>
    </div><!--/event-content-->
	<?php 
    comments_template( '', true );
    ?>
</div><!--/single-event-detail-->