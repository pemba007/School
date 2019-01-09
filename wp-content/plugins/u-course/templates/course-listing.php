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
                    	<!--<h3 class="h2">Falcuty of Law</h3>-->
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
                                                    <div class="shortcode-blog-excerpt"><?php the_excerpt(); ?></div>
                                                    <div class="item-meta">
                                                        <a class="btn btn-default btn-lighter" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php  _e('Details ','cactusthemes');?> <i class="fa fa-angle-right"></i></a>
                                                        <a href="<?php the_permalink(); ?>#comment" class="main-color-1-hover" title="<?php _e('View comments','cactusthemes'); ?>"><?php comments_number(__('0 COMMENTS','cactusthemes'),__('1 COMMENT','cactusthemes'),__('% COMMENTS','cactusthemes')); ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--/post-item-->
							<?php
							if($query_count%2==0 && $query_count != $post->post_count){ ?>
                            	</div><!--/row-->
                                <div class="row">
							<?php
							}?>

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