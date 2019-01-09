<?php
$mb_table ='';
if(function_exists('cop_get')){
	$mb_table =  cop_get('u_member_settings','u-member-table');
}
$member_id = get_post_meta(get_the_ID(),'member_id', true );
if(class_exists('U_event')){
	$args = array(
		'post_type' => 'u_event',
		'posts_per_page' => -1,
		'meta_key' => 'u-startdate',
		'orderby' => 'meta_value_num',
		'order' => 'DESC',
		'post_status' => 'publish',
		'meta_query' => array (
		  array (
			'key' => 'member_id',
			'value' => get_the_ID(),
						'compare' => 'LIKE'
		  ),
		) 
	);
	$time_now =  strtotime("now");
	if($mb_table=='on'){
		$args += array('meta_key' => 'u-startdate', 'meta_value' => $time_now, 'meta_compare' => '>');
		$args['orderby'] ='meta_value_num';
		if($order==''){$args['order'] ='ASC';}
		//print_r($args);exit;
	}
	global $the_query;
	$date_format = get_option('date_format');
	$the_query = new WP_Query( $args ); 
	 if ( $the_query->have_posts() ) : 
	?>
    <?php if($mb_table=='on'){?>
		<h3 class="h2"><?php _e('Upcoming Events','cactusthemes'); ?></h3>
    <?php }else{?>
    	<h3 class="h2"><?php _e('Events','cactusthemes'); ?></h3>
    <?php }?>
	<div class="courses-list">
	 <table class="table course-list-table">
	  <thead class="main-color-1-bg dark-div">
		<tr>
		  <th><?php _e('ID','cactusthemes'); ?></th>
		  <th><?php _e('Event Name','cactusthemes'); ?></th>
		  <th><?php _e('Duration','cactusthemes'); ?></th>
		  <th><?php _e('Start Date','cactusthemes'); ?></th>
		</tr>
	  </thead>
	  <tbody>
	  <?php
		$startdate = $enddate = $week = $label = '';
		 while ( $the_query->have_posts() ) : $the_query->the_post();
				$startdate = get_post_meta(get_the_ID(),'u-startdate', true );
				if($startdate){
					$startdate = gmdate("Y-m-d\TH:i:s\Z", $startdate);// convert date ux
					$con_date = new DateTime($startdate);
					$start_datetime = $con_date->format($date_format);
				}
				$enddate = get_post_meta(get_the_ID(),'u-enddate', true );
				if($enddate){
					$enddate = gmdate("Y-m-d\TH:i:s\Z", $enddate);
					$conv_enddate = new DateTime($enddate);
					$end_datetime = $conv_enddate->format($date_format);
				} else {
					$end_datetime = $start_datetime;
				}
				$time_duration = (strtotime($end_datetime) - strtotime($start_datetime)) / (60 * 60 * 168);
				$time_duration = round($time_duration);
				if($time_duration == 0){
					$time_duration = (strtotime($end_datetime) - strtotime($start_datetime)) / (60 * 60 * 24);
					$label = esc_html__('%d Days','cactusthemes');
					if($time_duration == 0){
						if($enddate){
							$time_duration = (strtotime($enddate) - strtotime($startdate))/ (60 * 60 );
							$label = esc_html__('%d Hours', 'cactusthemes');
						} else {
							$time_duration = 1;
							$label = esc_html__('Full Day', 'cactusthemes');
						}
					}
				} else { $label = esc_html__('%d Weeks','cactusthemes');}
			 ?>
			<tr>
			  <td><?php echo get_post_meta(get_the_ID(),'u-eventid', true ); ?></td>
			  <td><a href="<?php echo get_permalink(); ?>"><?php the_title() ?></a></td>
			  <td><?php echo sprintf($label, $time_duration); ?></td>
			  <td><?php if($start_datetime){ echo date_i18n( get_option('date_format'), strtotime($start_datetime)); } ?></td>
			</tr>
		<?php endwhile; ?>
	  </tbody>
	</table>
	</div><!--/courses-list-->
	<?php endif;
	wp_reset_postdata();
	if($mb_table=='on'){
		$args = array(
			'post_type' => 'u_event',
			'posts_per_page' => -1,
			'meta_key' => 'u-startdate',
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
			'post_status' => 'publish',
			'meta_query' => array (
			  array (
				'key' => 'member_id',
				'value' => get_the_ID(),
							'compare' => 'LIKE'
			  ),
			) 
		);
		$time_now =  strtotime("now");
		
		$args += array('meta_key' => 'u-startdate', 'meta_value' => $time_now, 'meta_compare' => '<=');
		$date_format = get_option('date_format');
		$the_query = new WP_Query( $args ); 
		 if ( $the_query->have_posts() ) : 
		?>
		<h3 class="h2"><?php _e('Other Events','cactusthemes'); ?></h3>
		<div class="courses-list">
		 <table class="table course-list-table">
		  <thead class="main-color-1-bg dark-div">
			<tr>
			  <th><?php _e('ID','cactusthemes'); ?></th>
			  <th><?php _e('Event Name','cactusthemes'); ?></th>
			  <th><?php _e('Duration','cactusthemes'); ?></th>
			  <th><?php _e('Start Date','cactusthemes'); ?></th>
			</tr>
		  </thead>
		  <tbody>
		  <?php
			$startdate = $enddate = $week = $label = '';
			 while ( $the_query->have_posts() ) : $the_query->the_post();
					$startdate = get_post_meta(get_the_ID(),'u-startdate', true );
					if($startdate){
						$startdate = gmdate("Y-m-d\TH:i:s\Z", $startdate);// convert date ux
						$con_date = new DateTime($startdate);
						$start_datetime = $con_date->format($date_format);
					}
					$enddate = get_post_meta(get_the_ID(),'u-enddate', true );
					if($enddate){
						$enddate = gmdate("Y-m-d\TH:i:s\Z", $enddate);
						$conv_enddate = new DateTime($enddate);
						$end_datetime = $conv_enddate->format($date_format);
					}
					$time_duration = (strtotime($end_datetime) - strtotime($start_datetime)) / (60 * 60 * 168);
					$time_duration = round($time_duration);
					if($time_duration == 0){
						$time_duration = (strtotime($end_datetime) - strtotime($start_datetime)) / (60 * 60 * 24);
						$label = __('%d Days', 'cactusthemes');
						if($time_duration == 0){
							if($enddate){
								$time_duration = (strtotime($enddate) - strtotime($startdate))/ (60 * 60 );
								$label = __('%d Hours', 'cactusthemes');
							} else {
								$time_duration = 1;
								$label = esc_html__('Full Day', 'cactusthemes');
							}
						}
					} else { $label = __('%d Weeks', 'cactusthemes');}
				 ?>
				<tr>
				  <td><?php echo get_post_meta(get_the_ID(),'u-eventid', true ); ?></td>
				  <td><a href="<?php echo get_permalink(); ?>"><?php the_title() ?></a></td>
				  <td><?php echo sprintf($label, $time_duration); ?></td>
				  <td><?php if($start_datetime){ echo date_i18n( get_option('date_format'), strtotime($start_datetime)); } ?></td>
				</tr>
			<?php endwhile; ?>
		  </tbody>
		</table>
		</div><!--/courses-list-->
		<?php endif;
		wp_reset_postdata();
	}

}
 ?>

  
<!--COUNT LIST-->
<?php
if(class_exists('U_course')){
	$args = array(
		'post_type' => 'u_course',
		'posts_per_page' => -1,
		'meta_key' => 'u-course-start',
		'orderby' => 'meta_value_num',
		'order' => 'DESC',
		'post_status' => 'publish',
		'meta_query' => array (
		  array (
			'key' => 'course_member_id',
			'value' => get_the_ID(),
						'compare' => 'LIKE'
		  ),
		) 
	);
	$time_now =  strtotime("now");
	if($mb_table=='on'){
		$args += array('meta_key' => 'u-course-start', 'meta_value' => $time_now, 'meta_compare' => '>');
		$args['orderby'] ='meta_value_num';
		if($order==''){$args['order'] ='ASC';}
	}
	global $the_query;
	$date_format = get_option('date_format');
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) : 
	?>
	<?php if($mb_table=='on'){?>
		<h3 class="h2"><?php _e('Upcoming Courses','cactusthemes'); ?></h3>
    <?php }else{?>
    	<h3 class="h2"><?php _e('Courses','cactusthemes'); ?></h3>
    <?php }?>
	<div class="courses-list">
	 <table class="table course-list-table">
	  <thead class="main-color-1-bg dark-div">
		<tr>
		  <th><?php _e('ID','cactusthemes'); ?></th>
		  <th><?php _e('Course Name','cactusthemes'); ?></th>
		  <th><?php _e('Duration','cactusthemes'); ?></th>
		  <th><?php _e('Start Date','cactusthemes'); ?></th>
		</tr>
	  </thead>
	  <tbody>
	  <?php 
		$startdate = $enddate = $week = $label = '';
		 while ( $the_query->have_posts() ) : $the_query->the_post();
				$startdate = get_post_meta(get_the_ID(),'u-course-start', true );
				if($startdate){
					$startdate = gmdate("Y-m-d\TH:i:s\Z", $startdate);// convert date ux
					$con_date = new DateTime($startdate);
					$start_datetime = $con_date->format($date_format);
				}
				$time_duration = get_post_meta(get_the_ID(),'u-course-dur', true );
			 ?>
			<tr>
			  <td><?php echo get_post_meta(get_the_ID(),'u-courseid', true ); ?></td>
			  <td><a href="<?php echo get_permalink(); ?>"><?php the_title() ?></a></td>
			  <td><?php echo $time_duration;?></td>
			  <td><?php if($start_datetime){ echo date_i18n( get_option('date_format'), strtotime($start_datetime)); } ?></td>
			</tr>
		<?php endwhile; ?>
	  </tbody>
	</table>
	</div><!--/courses-list-->
	<?php endif;
	wp_reset_postdata();
	if($mb_table=='on'){
		$args = array(
			'post_type' => 'u_course',
			'posts_per_page' => -1,
			'meta_key' => 'u-course-start',
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
			'post_status' => 'publish',
			'meta_query' => array (
			  array (
				'key' => 'course_member_id',
				'value' => get_the_ID(),
							'compare' => 'LIKE'
			  ),
			) 
		);
		$time_now =  strtotime("now");
		if($mb_table=='on'){
			$args += array('meta_key' => 'u-course-start', 'meta_value' => $time_now, 'meta_compare' => '<=');
		}
		$date_format = get_option('date_format');
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) : 
		?>
		<h3 class="h2"><?php _e('Other Courses','cactusthemes'); ?></h3>
		<div class="courses-list">
		 <table class="table course-list-table">
		  <thead class="main-color-1-bg dark-div">
			<tr>
			  <th><?php _e('ID','cactusthemes'); ?></th>
			  <th><?php _e('Course Name','cactusthemes'); ?></th>
			  <th><?php _e('Duration','cactusthemes'); ?></th>
			  <th><?php _e('Start Date','cactusthemes'); ?></th>
			</tr>
		  </thead>
		  <tbody>
		  <?php 
			$startdate = $enddate = $week = $label = '';
			 while ( $the_query->have_posts() ) : $the_query->the_post();
					$startdate = get_post_meta(get_the_ID(),'u-course-start', true );
					if($startdate){
						$startdate = gmdate("Y-m-d\TH:i:s\Z", $startdate);// convert date ux
						$con_date = new DateTime($startdate);
						$start_datetime = $con_date->format($date_format);
					}
					$time_duration = get_post_meta(get_the_ID(),'u-course-dur', true );
				 ?>
				<tr>
				  <td><?php echo get_post_meta(get_the_ID(),'u-courseid', true ); ?></td>
				  <td><a href="<?php echo get_permalink(); ?>"><?php the_title() ?></a></td>
				  <td><?php echo $time_duration;?></td>
				  <td><?php if($start_datetime){ echo date_i18n( get_option('date_format'), strtotime($start_datetime)); } ?></td>
				</tr>
			<?php endwhile; ?>
		  </tbody>
		</table>
		</div><!--/courses-list-->
		<?php endif;
		wp_reset_postdata();
		
	}
}
 ?>
<!--Learndash-->
<?php
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if(is_plugin_active( 'sfwd-lms/sfwd_lms.php' )){
	  $args = array(
		  'post_type' => 'sfwd-courses',
		  'posts_per_page' => -1,
		  'post_status' => 'publish',
		  'meta_query' => array (
			array (
			  'key' => 'learndash_member_id',
			  'value' => get_the_ID(),
						  'compare' => 'LIKE'
			),
		  ) 
	  );
	  $the_query = new WP_Query( $args );
	  if ( $the_query->have_posts() ) : 
	  ?>
	  <h3 class="h2"><?php _e('Online Courses','cactusthemes'); ?></h3>
	  <div class="courses-list">
	   <table class="table course-list-table">
		<thead class="main-color-1-bg dark-div">
		  <tr>
			<th><?php _e('Course Name','cactusthemes'); ?></th>
			<th><?php _e('Course Price Type','cactusthemes'); ?></th>
		  </tr>
		</thead>
		<tbody>
		<?php 
		   while ( $the_query->have_posts() ) : $the_query->the_post();
			  $info_course = (get_post_meta(get_the_ID(),'_sfwd-courses', true ));
			  $option_ld =  get_option('sfwd_cpt_options');
			  $currency_ld = $option_ld['modules']['sfwd-courses_options']['sfwd-courses_paypal_currency'];
			   ?>
			  <tr>
				<td><a href="<?php echo get_permalink(); ?>"><?php the_title() ?></a></td>
				<td style="text-transform: capitalize;"><?php 
					if($info_course['sfwd-courses_course_price_type']=='paynow'){
						echo $info_course['sfwd-courses_course_price'].' '.$currency_ld;
					}else if($info_course['sfwd-courses_course_price_type']=='subscribe'){
						$course_price_billing_p3 = (get_post_meta(get_the_ID(),'course_price_billing_p3', true ));
						$course_price_billing_t3 = (get_post_meta(get_the_ID(),'course_price_billing_t3', true ));
						if($course_price_billing_t3== 'W'){ 
							if($course_price_billing_p3<2){
								$course_price_billing_t3 = __('Week','cactusthemes');
							}else{
								$course_price_billing_t3 = __('Weeks','cactusthemes');
							}
						}
						elseif($course_price_billing_t3== 'D'){ 
							if($course_price_billing_p3<2){
								$course_price_billing_t3 = __('Day','cactusthemes');
							}else{
								$course_price_billing_t3 = __('Days','cactusthemes');
							}
						}
						elseif($course_price_billing_t3== 'M'){ 
							if($course_price_billing_p3<2){
								$course_price_billing_t3 = __('Month','cactusthemes');
							}else{
								$course_price_billing_t3 = __('Months','cactusthemes');
							}
						}elseif($course_price_billing_t3== 'Y'){ 
							if($course_price_billing_p3<2){
								$course_price_billing_t3 = __('Year','cactusthemes');
							}else{
								$course_price_billing_t3 = __('Years','cactusthemes');
							}
						}
						echo $info_course['sfwd-courses_course_price'].' '.$currency_ld.' / '.$course_price_billing_p3.' '.$course_price_billing_t3;
					}else{ echo $info_course['sfwd-courses_course_price_type'];}
				?></td>
			  </tr>
		  <?php endwhile; ?>
		</tbody>
	  </table>
	  </div><!--/courses-list-->
	  <?php endif;
	  wp_reset_postdata();
}
 ?>
