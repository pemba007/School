<?php 
/*
 *  Courses List
 */
get_header();
?>
	<?php
	global $page_title;
	$page_title = __('Courses', 'cactusthemes'); //overwrite page title
	get_template_part( 'header', 'heading' ); ?>
    <div id="body">
    	<div class="container">
        	<div class="content-pad-3x">
            <?php
			$date_format = get_option('date_format');
			global $post;
			 ?>
             	<div class="row">
                    <div id="content" class="col-md-9">
						<?php
							if(function_exists('cop_get')){
								$slug_pt =  cop_get('u_course_settings','ucourse-slug');
								$filter =  cop_get('u_course_settings','ucourse-filter');
							}  
							if($slug_pt==''){
								$slug_pt = 'course';
							}
							ct_filter_order_lis($post_type='u_course');
							if($filter==1){
								ct_filter_bar($taxono='u_course_cat',$slug_pt);
								?>
								<style type="text/css">.courses-list{ padding-top:0}</style>
								<?php
							}
						?>
                        <div class="courses-list">
                         <?php if (have_posts() ) :
						    $query_count = 0;
							while ( have_posts() ) : the_post(); 
								$query_count++;
								
								$startdate = get_post_meta(get_the_ID(),'u-course-start', true );
								if($startdate){
									$startdate = gmdate("Y-m-d\TH:i:s\Z", $startdate);// convert date ux
									$con_date = new DateTime($startdate);
									$month = $con_date->format('M');
									$day = $con_date->format('d');
									$start_datetime = $con_date->format(get_option('date_format'));
								}
							?>
                                    <div class="post-item row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="content-pad">
                                                <div class="item-thumbnail">
                                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
														<?php if(has_post_thumbnail()){
                                                            $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'thumb_526x526', true);
                                                        }else{
                                                            $thumbnail = u_get_default_image('blog-square');
                                                        }?>
                                                        <img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="content-pad">
                                                <div class="item-content">
                                                    <h3 class="item-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="main-color-1-hover"><?php the_title(); ?></a></h3>
                                                    <?php
													$showprice = '';
													if(function_exists('cop_get')){
														$showprice =  cop_get('u_course_settings','ucourse-showprice');
													} 
													if($showprice =='1'){
													?>
                                                    <div class="price main-color-1"><?php 
													if(class_exists('U_course')){
														$u_course = new U_course;
														$price = $u_course->getPrice();
														$getPrice_num = $u_course->getPrice_num_course();
														$vailable = $u_course->getAvailable();
													}
													$product_id = get_post_meta(get_the_ID(),'product_id_course', true );
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
														if($price['number'] != 0){
														   $currency_pos = get_option( 'woocommerce_currency_pos' );
														   if($currency_pos=='left'){ echo get_woocommerce_currency_symbol(); }
														   else if($currency_pos=='left_space'){ echo get_woocommerce_currency_symbol().' '; }
														   echo  ($price['number']); 
														   if($currency_pos=='right'){ echo get_woocommerce_currency_symbol(); }
														   else if($currency_pos=='right_space'){ echo ' '.get_woocommerce_currency_symbol(); }
														}else{
															 echo $price['text'];
														}
													} ?></div>
                                                    <?php 
													}?>
                                                    <div class="shortcode-blog-excerpt"><?php the_excerpt(); ?></div>
                                                    <div class="item-meta">
                                                        <a class="btn btn-default btn-lighter" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php  _e('Details ','cactusthemes');?> <i class="fa fa-angle-right"></i></a>
                                                        <a href="<?php the_permalink(); ?>#comment" class="main-color-1-hover" title="<?php _e('View comments','cactusthemes'); ?>"><?php comments_number(__('0 COMMENTS','cactusthemes'),__('1 COMMENT','cactusthemes'),__('% COMMENTS','cactusthemes')); ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--/post-item-->
                            <?php endwhile; ?>
						  <?php endif;
						  wp_reset_postdata(); ?>
                        </div><!--/courses-list-->
                        <?php if(function_exists('wp_pagenavi')){
							wp_pagenavi();
						}else{
							cactusthemes_content_nav('paging');
						}?>
                    </div><!--/content-->
                    <?php get_sidebar(); ?>
                 </div><!--/row-->
            </div><!--/content-pad-->
        </div><!--/container-->
    </div><!--/body-->
<?php get_footer(); ?>