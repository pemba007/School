<div class="content-pad single-event-detail single-course-detail">
    <div class="event-detail">
    	<div class="event-speaker">
        <?php 
		$member_id = get_post_meta(get_the_ID(),'course_member_id', true );
		//print_r($member_id);
		if(is_array($member_id)){?>
        <h4 class="small-text"><?php _e('INSTRUCTORS:','cactusthemes') ?></h4>
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
           <?php }
		   }?> 
        </div><!--/event-speaker-->
        <div class="event-info row content-pad">
        	<?php 
			?>
        	<div class="col-md-6 col-sm-6">
            	<h4 class="small-text"><?php _e('Address','cactusthemes') ?></h4>
                <?php echo get_post_meta(get_the_ID(),'u-course-addr', true );?>
                <a href="#map" target="_blank" class="map-link small-text">&nbsp;&nbsp;<?php _e('View map','cactusthemes') ?> <i class="fa fa-angle-right"></i></a>
            </div>
            <div class="col-md-6 col-sm-6">
            	<h4 class="small-text"><?php _e('Categories','cactusthemes') ?></h4>
                <?php 
				$terms = wp_get_post_terms( get_the_ID(), 'u_course_cat');
				$count = 0; $i=0;
					foreach ($terms as $term) {
						$count ++;
					}
					foreach ($terms as $term) {
						$i++;
						echo '<a href="'.get_term_link($term->slug, 'u_course_cat').'" class="cat-link">'.$term->name.'</a> ';
						if($i!=$count){ echo ', ';}
					}
				?>
            </div>
        </div><!--/event-info-->
    </div><!--/event-detail-->
    <div class="event-content">
    	<div class="content-dropcap">
        	<?php the_content(); ?>
            
        </div>
        <div class="content-pad">
            <!--<a class="btn btn-default" href="#">+ GOOGLE CALENDAR</a>&nbsp;
            <a class="btn btn-default" href="#">+ ICAL IMPORT</a>-->
        </div>
        <div class="content-pad single-cours-social">
            <ul class="list-inline social-light">
            	<?php cactus_social_share(); ?>
            </ul>
        </div>
        <?php 
		$u_textsub = get_post_meta(get_the_ID(),'u-course-label', true );
		if($u_textsub ==''){$u_textsub ='SIGN UP NOW';}
		?>
        <div class="event-cta">
        	<p><?php echo get_post_meta(get_the_ID(),'u-cour-callaction', true );?></p>
            <a class="btn btn-primary btn-lg btn-block" href="<?php if($u_linkssub){ echo $u_linkssub;}else{echo '#join_event';}?>"><?php _e($u_textsub,'cactusthemes') ?></a>
        </div>
        
        
           <?php 
		  $course_layout = get_post_meta(get_the_ID(),'course-sidebar',true);   
		  if(function_exists('cop_get') && $course_layout=='def'){
				$course_layout =  cop_get('u_course_settings','u-course-layout');
		  } 
		  if(function_exists('cop_get')){
				$reletd_number =  cop_get('u_course_settings','ucourse-rel-number');
		  }
		  $post_cat = get_the_terms( get_the_ID(), 'u_course_cat');
		  $cat_course = array();
		  if ($post_cat) {
			  foreach($post_cat as $cat) {
				  $cats = $cat->slug; 
				  array_push($cat_course,$cats);
			  }
		  }
		  if(count($cat_course)>1){
			  $texo = array(
				  'relation' => 'OR',
			  );
			  foreach($cat_course as $iterm) {
				  $texo[] = 
					  array(
						  'taxonomy' => 'u_course_cat',
						  'field' => 'slug',
						  'terms' => $iterm,
					  );
			  }
		  }else{
			  $texo = array(
				  array(
						  'taxonomy' => 'u_course_cat',
						  'field' => 'slug',
						  'terms' => $cat_course,
					  )
			  );
		  }
		  if($course_layout=='full'){
			  $class_r = 'col-md-4';
		  }else{
			  $class_r = 'col-md-6';
		  }
		  if($reletd_number=='' && $course_layout=='full'){$reletd_number=3;}
		  else if($reletd_number==''){$reletd_number=2;}
		  $cr_id = get_the_ID();
          $args = array(
              'post_type' => 'u_course',
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
       		<div class="related-event">
            	<h3><?php _e('Related Course','cactusthemes') ?></h3>
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
						$startdate = get_post_meta($post->ID,'u-course-start', true );
						if($startdate){
							$startdate_cal = gmdate("Ymd\THis\Z", $startdate);
							$startdate = gmdate("Y-m-d\TH:i:s\Z", $startdate);// convert date ux
							$con_date = new DateTime($startdate);
							$con_hour = new DateTime($startdate);
							$start_datetime = $con_date->format($date_format);
						}
				  ?>
                    <div class="<?php echo $class_r;?> col-sm-6 related-item">
                    	<?php if(has_post_thumbnail($post->ID)){ ?> 
                    		<div class="thumb"><a href="<?php echo get_permalink($post->ID)?>"><?php echo get_the_post_thumbnail( $post->ID, 'thumb_80x80' ); ?></a></div>
                        <?php }?>
                        <div class="ev-title"> <a href="<?php echo get_permalink($post->ID)?>" class="related-ev-title main-color-1-hover"><?php echo get_the_title( $post->ID); ?></a></div>
                        <div class="ev-start small-text"><?php echo $start_datetime;?></div>
                        <div class="clear"></div>
                    </div>
                  <?php  
				  if(($course_layout=='full') && ($i%3==0) && ($count_item > $i)){?>
					  </div><div class="row">
                  <?php } elseif(($course_layout!='full') && ($i%2==0) && ($count_item > $i)){?>
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