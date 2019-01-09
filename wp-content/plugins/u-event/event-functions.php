<?php
//add_action( 'save_post', 'ev_save_postdata' );
/*Edit columns event*/
if(!function_exists('event_edit_columns')) {
	function event_edit_columns( $columns ) {
		$columns = array(
			'cb' 			=> '<input type="checkbox" />',
			'id' 			=> __( 'ID', 'cactusthemes' ),
			'title' 		=> __( 'Title', 'cactusthemes' ),
			'start_date' 	=> __( 'Start date', 'cactusthemes' ),
			'end_date' 		=> __( 'End date', 'cactusthemes' ),
			'author' 	=> __( 'Author', 'cactusthemes' ),
			'taxonomy-u_event_cat' 		=> __( 'U-Event Categories', 'cactusthemes' )
		);
		return $columns;
	}
	add_filter( 'manage_u_event_posts_columns', 'event_edit_columns' );
}
if(!function_exists('event_custom_columns')) {
	// return the values for each coupon column on edit.php page
	function event_custom_columns( $column ) {
		global $post;
		global $wpdb;
		$date_format = get_option('date_format');
		$hour_format = get_option('time_format');
		$startdate = get_post_meta($post->ID,'u-startdate', true );
		$start_datetime = '';
		$start_hourtime = '';
		if($startdate){
			$startdate_cal = gmdate("Ymd\THis", $startdate);
			$startdate = gmdate("Y-m-d\TH:i:s\Z", $startdate);// convert date ux
			$con_date = new DateTime($startdate);
			$con_hour = new DateTime($startdate);
			$start_datetime = $con_date->format($date_format);
		}
		$enddate = get_post_meta($post->ID,'u-enddate', true );
		$end_datetime = '';
		$end_hourtime = '';
		if($enddate){
			$enddate_cal = gmdate("Ymd\THis", $enddate);
			$enddate = gmdate("Y-m-d\TH:i:s\Z", $enddate);
			$conv_enddate = new DateTime($enddate);
			$conv_hourtime = new DateTime($enddate);
			$end_datetime = $conv_enddate->format($date_format);
		}
		switch ( $column ) {
			case 'start_date':
				echo date_i18n( get_option('date_format'), strtotime($startdate));
				break;
			case 'end_date':
				echo date_i18n( get_option('date_format'), strtotime($enddate));
				break;
		}
	}
	add_action( 'manage_posts_custom_column', 'event_custom_columns' );
}
function ev_save_postdata($post_id ){
	if('u_event' != get_post_type())
	return;
	$startdate_date = $_POST['startdate_date'];
	$enddate_date = $_POST['enddate_date'];
	$recurrence = $_POST['recurrence'];
	$startdate_date = strtotime($startdate_date['cmb-field-0']);//exit;
	$enddate_date = strtotime($enddate_date['cmb-field-0']);//exit;	
	if(!update_post_meta( $post_id, 'startdate_date_ux', $startdate_date)){
		add_post_meta( $post_id, 'startdate_date_ux', $startdate_date, true);
	}else{
		update_post_meta( $post_id, 'startdate_date_ux', $startdate_date);
	}
	if(!update_post_meta( $post_id, 'enddate_date_ux', $enddate_date) ){
		add_post_meta( $post_id, 'enddate_date_ux', $enddate_date, true);
	}else{
		update_post_meta( $post_id, 'enddate_date_ux', $enddate_date);
	}	
}

function uni_events_ical() {
	if(isset($_GET['ical_id'])&& $_GET['ical_id']>0){
		// - start collecting output -
		ob_start();
		
		// - file header -
		header('Content-type: text/calendar');
		header('Content-Disposition: attachment; filename="uni ical.ics"');
		global $post;
		// - content header -
		?>
        <?php
		$content = "BEGIN:VCALENDAR\r\n";
		$content .= "VERSION:2.0\r\n";
		$content .= 'PRODID:-//'.get_bloginfo('name')."\r\n";
		$content .= "CALSCALE:GREGORIAN\r\n";
		$content .= "METHOD:PUBLISH\r\n";
		$content .= 'X-WR-CALNAME:'.get_bloginfo('name')."\r\n";
		$content .= 'X-ORIGINAL-URL:'.get_permalink($_GET['ical_id'])."\r\n";
		$content .= 'X-WR-CALDESC:'.get_the_title($_GET['ical_id'])."\r\n";
		?>
		<?php
		
		// - grab date barrier -
		//$today6am = strtotime('today 6:00') + ( get_option( 'gmt_offset' ) * 3600 );
		//$limit = get_option('pubforce_rss_limit');
		
		// - query -
		//global $wpdb;
		// - loop -
		//setup_postdata($post);
		$date_format = get_option('date_format');
		$hour_format = get_option('time_format');
		$startdate = get_post_meta($_GET['ical_id'],'u-startdate', true );
		if($startdate){
			$startdate = gmdate("Ymd\THis", $startdate);// convert date ux
		}
		$enddate = get_post_meta($_GET['ical_id'],'u-enddate', true );
		if($enddate){
			$enddate = gmdate("Ymd\THis", $enddate);
		}
		
		// - custom variables -
		//$custom = get_post_custom(get_the_ID());
		//$sd = $custom["tf_events_startdate"][0];
		//$ed = $custom["tf_events_enddate"][0];
		//
		//// - grab gmt for start -
		//$gmts = date('Y-m-d H:i:s', $con_date);
		$gmts = get_gmt_from_date($startdate); // this function requires Y-m-d H:i:s, hence the back & forth.
		$gmts = strtotime($gmts);
		
		// - grab gmt for end -
		//$gmte = date('Y-m-d H:i:s', $conv_enddate);
		$gmte = get_gmt_from_date($enddate); // this function requires Y-m-d H:i:s, hence the back & forth.
		$gmte = strtotime($gmte);
		
		// - Set to UTC ICAL FORMAT -
		$stime = date('Ymd\THis', $gmts);
		$etime = date('Ymd\THis', $gmte);
		
		// - item output -
		?>
        <?php
		$content .= "BEGIN:VEVENT\r\n";
		$content .= 'DTSTART:'.$startdate."\r\n";
		$content .= 'DTEND:'.$enddate."\r\n";
		$content .= 'SUMMARY:'.get_the_title($_GET['ical_id'])."\r\n";
		$content .= 'DESCRIPTION:'.get_post($_GET['ical_id'])->post_excerpt."\r\n";
        $content .= 'LOCATION:'.get_post_meta($_GET['ical_id'],'u-adress', true )."\r\n";
		$content .= "END:VEVENT\r\n";
		$content .= "END:VCALENDAR\r\n";
		// - full output -
		$tfeventsical = ob_get_contents();
		ob_end_clean();
		echo $content;
		exit;
		}
}
add_action('init','uni_events_ical');
/**
 * Add a duplicate post link.
 *
 */
add_filter( 'post_row_actions', 'event_duplicator_action_row', 10, 2 );
function event_duplicator_action_row( $actions, $post ){

	// Get the post type object
	$post_type = get_post_type_object( $post->post_type );
	if ( $post->post_type != 'u_event' )
			return $actions;
	// Create a nonce & add an action
  	$actions['duplicate_post'] = '<a href="'.wp_nonce_url( admin_url( 'edit.php?post_type=u_event&duplicate_event=' . $post->ID ), 'duplicate_event' . $post->ID, '_wpnonce' ).'">Duplicate '.$post_type->labels->singular_name.'</a>';

	return $actions;
}
function duplicate_event(){
	if (!isset($_GET['trashed'])&&isset($_GET['_wpnonce']) && isset($_GET['duplicate_event']) && wp_verify_nonce($_GET['_wpnonce'], 'duplicate_event' . $_GET['duplicate_event'])) {
		if($_GET['duplicate_event'] && current_user_can('administrator') && is_admin){
			$duplicate = get_post( $_GET['duplicate_event'], 'ARRAY_A' );
			
			$duplicate['post_title'] = $duplicate['post_title'].' Copy';
		
		
			// Remove some of the keys
			unset( $duplicate['ID'] );
			unset( $duplicate['guid'] );
			unset( $duplicate['comment_count'] );
		
			// Insert the post into the database
			$duplicate_id = wp_insert_post( $duplicate );
			$taxonomies = get_object_taxonomies( $duplicate['post_type'] );
			foreach( $taxonomies as $taxonomy ) {
				$terms = wp_get_post_terms( $_GET['duplicate_event'], $taxonomy, array('fields' => 'names') );
				wp_set_object_terms( $duplicate_id, $terms, $taxonomy );
			}
			$custom_fields = get_post_custom( $_GET['duplicate_event']);
			foreach ( $custom_fields as $key => $value ) {
				  add_post_meta( $duplicate_id, $key, maybe_unserialize($value[0]) );
			}
		}
	}
}
add_action('init', 'duplicate_event');
?>