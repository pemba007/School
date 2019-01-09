<?php
$member_id = get_post_meta(get_the_ID(),'member_id', true );
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
global $the_query;
$date_format = get_option('date_format');
$the_query = new WP_Query( $args ); 
 if ( $the_query->have_posts() ) : 
?>
<h3 class="h2">Events</h3>
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
				$label = ' Days';
			} else { $label = ' Weeks';}
		 ?>
        <tr>
          <td><?php echo get_post_meta(get_the_ID(),'u-eventid', true ); ?></td>
          <td><a href="<?php echo get_permalink(); ?>"><?php the_title() ?></a></td>
          <td><?php echo $time_duration; _e($label,'cactusthemes'); ?></td>
          <td><?php echo $start_datetime; ?></td>
        </tr>
    <?php endwhile; ?>
  </tbody>
</table>
</div><!--/courses-list-->
<?php endif;
wp_reset_postdata();
 ?>
  
<!--COUNT LIST-->
<?php
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
global $the_query;
$date_format = get_option('date_format');
$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) : 
?>
<h3 class="h2">Courses</h3>
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
          <td><?php echo $start_datetime; ?></td>
        </tr>
    <?php endwhile; ?>
  </tbody>
</table>
</div><!--/courses-list-->
<?php endif;
wp_reset_postdata();
 ?>
