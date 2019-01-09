<?php
function parse_member_list($atts, $content){
	$ids = isset($atts['ids']) ? $atts['ids'] : '';
	$col = isset($atts['col']) ? $atts['col'] : '3';
	$link_member = isset($atts['link']) ? $atts['link'] : '';
	
	$department = isset($atts['department']) ? $atts['department'] : '';
	$count = isset($atts['count']) ? $atts['count'] : 6;
	$order = isset($atts['order']) ? $atts['order'] : 'DESC';
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : 'date';
	$meta_key = isset($atts['meta_key']) ? $atts['meta_key'] : '';

	//display	
	$args = array();
	if($ids!=''){ //specify IDs
		$ids = explode(",", $ids);
		$args = array(
			'post_type' => 'u_member',
			'post__in' => $ids,
			'posts_per_page' => '-1',
			'post_status' => 'publish',	
			'orderby' => 'post__in',	
			'ignore_sticky_posts' => 1,
		);
	}elseif($ids==''){
		$args = array(
			'post_type' => 'u_member',
			'posts_per_page' => $count,
			'order' => $order,
			'orderby' => $orderby,
			'ignore_sticky_posts' => 1,
		);
		if(!is_array($department) && $department!='') {
			$cats = explode(",",$department);
			if(is_numeric($cats[0])){
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'u_department',
						'field'    => 'id',
						'terms'    => $cats,
						'operator' => 'IN',
					)
				);
			}else{
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'u_department',
						'field'    => 'slug',
						'terms'    => $cats,
						'operator' => 'IN',
					)
				);
			}
		}elseif(count($department) > 0 && $department!=''){
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'u_department',
					'field'    => 'id',
					'terms'    => $department,
					'operator' => 'IN',
				)
			);
		}
		$args += array(
		'meta_key' => $meta_key
		);
	}
	$args['suppress_filters'] = 0;

	$html = '
		<div class="row">
	';
	$item = 0;
	$the_query = new WP_Query( $args );
	if($the_query->have_posts()){
		while($the_query->have_posts()){ $the_query->the_post();
			$item++;
			$html .= '
				<div class="member-item col-md-'.$col.' ">
					<div class="member-item-inner">
						<div class="item-thumbnail">';
							if($link_member!=='no'){
								$html .= '<a href="'.get_permalink( get_the_ID()).'" title="'.the_title_attribute('echo=0').'">';
							}
								if(has_post_thumbnail(get_the_ID())){
									$html .= get_the_post_thumbnail( get_the_ID(), 'thumb_526x526' );
								}else{
									$thumbnail = u_get_default_image('blog-square'); 
									$html .= '
									<img src="'.$thumbnail[0].'" width="'.$thumbnail[1].'" height="'.$thumbnail[2].'" title="'.the_title_attribute('echo=0').'" alt="'.the_title_attribute('echo=0').'">';
								}
							if($link_member!='no'){
								$html .= '</a>';
							}
							$html .= '
						</div>
						<div class="item-content">
							<h3 class="item-title">';
								if($link_member!='no'){
									$html .= '<a href="'.get_permalink(get_the_ID()).'" title="title" class="main-color-1-hover">';
								}
								$html .=  the_title_attribute('echo=0');
								if($link_member!='no'){
									$html .= '</a>';
								}
							$html .= '
							</h3>
							<h4 class="small-text">'.get_post_meta( get_the_ID(),'u-member-pos', true ).'</h4>
							<p>'.get_the_excerpt().'</p>';
							$social_account = array(
								'facebook',
								'instagram',
								'envelope',
								'twitter',
								'linkedin',
								'tumblr',
								'google-plus',
								'pinterest',
								'youtube',
								'flickr',
								'github',
								'dribbble',
								'vk',
							);
							$html .= '
							<ul class="list-inline social-light">';
							foreach($social_account as $social){
							if($link = get_post_meta(get_the_ID(),'umb-'.$social, true )){
								if($social=='envelope'){
									$html .= '
									<li><a class="btn btn-default social-icon" href="mailto:'.$link .'"> <i class="fa fa-'.$social .'"></i></a></li>';
								} else{
									$html .= '
									<li><a class="btn btn-default social-icon" href="'.$link.'"><i class="fa fa-'.$social.'"></i></a></li>';
									  } 
								}
							} 
							$html .= '
							</ul>
						</div>
					</div>
				</div>
			';
			if($col==3 && $item%4==0){
				$html .= '
					</div>
					<div class="row">
				';
			}
			if($col==4 && $item%3==0){
				$html .= '
					</div>
					<div class="row">
				';
			}
		}
	}
	$html .= '
		</div>
	';
	
	
	wp_reset_postdata();
	return $html;

}
add_shortcode( 'member', 'parse_member_list' );
add_action( 'after_setup_theme', 'reg_member_list' );
function reg_member_list(){
	if(function_exists('vc_map')){
		/* Register shortcode with Visual Composer */
		vc_map( array(
		   "name" => __("Member",'cactusthemes'),
		   "base" => "member",
		   "class" => "",
		   "controls" => "full",
		   "category" => 'Content',
		   "icon" => "icon-member",
		   "params" => array(
			  array(
				 "type" => "textfield",
				 "admin_label" => true,
				 "class" => "",
				 "heading" => __("Ids", 'cactusthemes'),
				 "param_name" => "ids",
				 "value" =>"",
				 "description" => __("List of member Ids, separated by a comma", "cactusthemes"),
			  ),
			  array(
				 "type" => "dropdown",
				 "admin_label" => true,
				 "class" => "",
				 "heading" => __("Width", 'cactusthemes'),
				 "param_name" => "col",
				 "value" => array(
				 	__('3/12 width', 'cactusthemes') => 3,
					__('4/12 width', 'cactusthemes') => 4,
					__('Fullwidth', 'cactusthemes') => 12,
				 ),
				 "description" => __('Width of each member item box - select (default is 3)', "cactusthemes")
			  ),
			  array(
				  "type" => "textfield",
				  "heading" => __("Department", "cactusthemes"),
				  "param_name" => "department",
				  "value" => "",
				  "description" => __("list of Department, separated by a comma", "cactusthemes"),
			  ),
			  array(
				  "type" => "textfield",
				  "heading" => __("Count", "cactusthemes"),
				  "param_name" => "count",
				  "value" => "6",
				  "description" => __("Number of posts to show. Default is 6", 'cactusthemes'),
			  ),
			  array(
				   "type" => "dropdown",
				   "holder" => "div",
				   "class" => "",
				   "heading" => __("Order", 'cactusthemes'),
				   "param_name" => "order",
				   "value" => array(
					  __('DESC', 'cactusthemes') => 'DESC',
					  __('ASC', 'cactusthemes') => 'ASC',
				   ),
				   "description" => ''
			  ),
			  array(
				   "type" => "dropdown",
				   "holder" => "div",
				   "class" => "",
				   "heading" => __("Order by", 'cactusthemes'),
				   "param_name" => "orderby",
				   "value" => array(
					  __('Date', 'cactusthemes') => 'date',
					  __('ID', 'cactusthemes') => 'ID',
					  __('Author', 'cactusthemes') => 'author',
					  __('Title', 'cactusthemes') => 'title',
					  __('Name', 'cactusthemes') => 'name',
					  __('Modified', 'cactusthemes') => 'modified',
					  __('Parent', 'cactusthemes') => 'parent',
					  __('Random', 'cactusthemes') => 'rand',
					  __('Comment count', 'cactusthemes') => 'comment_count',
					  __('Menu order', 'cactusthemes') => 'menu_order',
					  __('Meta value', 'cactusthemes') => 'meta_value',
					  __('Meta value num', 'cactusthemes') => 'meta_value_num',
					  __('Post__in', 'cactusthemes') => 'post__in',
					  __('Start Date, Upcoming Events or Course', 'cactusthemes') => 'upcoming',
					  __('Start Date, Recent Events or Course', 'cactusthemes') => 'recent',
					  __('None', 'cactusthemes') => 'none',
				   ),
				   "description" => ''
			  ),
			  array(
				 "type" => "dropdown",
				 "admin_label" => true,
				 "class" => "",
				 "heading" => __("Link to single member", 'cactusthemes'),
				 "param_name" => "link",
				 "value" => array(
				 	__('Yes', 'cactusthemes') => '',
					__('No', 'cactusthemes') => 'no',
				 ),
				 "description" => __('', "cactusthemes")
			  ),

		   )
		) );
	}
}