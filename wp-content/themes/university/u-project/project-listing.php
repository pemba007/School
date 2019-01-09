<?php 
get_header();
$layout='full';
global $page_title;
$page_title = __('Project Listing', 'cactusthemes'); //overwrite page title
?>
	<?php get_template_part( 'header', 'heading' ); ?>   
    <div id="body">
    	<div class="container">
        	<div class="content-pad-3x">
            	<div class="row">
                    <div id="content" class="<?php echo $layout!='full'?'col-md-9':'col-md-12' ?><?php echo ($layout == 'left') ? " revert-layout":"";?>">
                        <div class="project-listing">
							<?php if(function_exists('cop_get')){
                                $filter =  cop_get('u_project_settings','uproject-filter');
                            }
                            if($filter!=1){
                            ?>
                        	<div class="filter-cat">
                            	<?php
								$pageURL = 'http';
								 if(isset($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] == "on")) {$pageURL .= "s";}
								 $pageURL .= "://";
								 if ($_SERVER["SERVER_PORT"] != "80") {
								  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
								 } else {
								  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
								 }
								
								if(function_exists('cop_get')){
									$slug_pro =  cop_get('u_project_settings','uproject-slug');
								}  
								if($slug_pro==''){
									$slug_pro = 'project';
								}
								$project_cat = home_url().'/'.$slug_pro.'/';
								$selected ='';
								$bg_cr ='';
								if(strpos($pageURL, $project_cat) !== false){$bg_cr = 'style="background-color: #666666;border-color: #666666; color:#fff"';$selected = 'selected="selected"';}
								?>
                            	<a href="<?php echo $project_cat; ?>" class="btn btn-lighter" <?php echo $bg_cr ?> ><?php echo __('All','cactusthemes'); ?></a>
                                <?php 
								$pro_cat = get_terms( 'u_project_cat', 'orderby=count&hide_empty=1' );
								foreach ($pro_cat as $p_term) {
									$link_t = get_term_link($p_term->slug, 'u_project_cat');
									$bg_cr2 ='';
									if(strpos($pageURL, $link_t) !== false){$bg_cr2 = 'style="background-color: #666666;border-color: #666666; color:#fff"';}
									echo '<a href="'.get_term_link($p_term->slug, 'u_project_cat').'" class="btn btn-lighter" '.$bg_cr2.'>'.$p_term->name.'</a> ';
								}?>
                                <select id="uni-project">
                                <option value="<?php echo $project_cat; ?>" <?php echo $selected ?>><?php echo __('All','cactusthemes'); ?></option>
								<?php
								foreach ($pro_cat as $p_term) {
									$link_t = get_term_link($p_term->slug, 'u_project_cat');
									$selected ='';
									if(strpos($pageURL, $link_t) !== false){$selected = 'selected="selected"';}
									echo '<option value="'.get_term_link($p_term->slug, 'u_project_cat').'" '.$selected.' ><a href="'.get_term_link($p_term->slug, 'u_project_cat').'" class="btn btn-lighter">'.$p_term->name.'</a></option>';
								}
								?>
                                </select>
                            </div>
                            <?php }?>
                        	<div class="row">
                        	<?php
							wp_enqueue_style( 'lightbox2', get_template_directory_uri() . '/js/colorbox/colorbox.css');
							wp_enqueue_script( 'colorbox', get_template_directory_uri() . '/js/colorbox/jquery.colorbox-min.js', array('jquery'), '', true );
							// The Loop
							//$the_query = new WP_Query( $args );
							if ( have_posts() ) : 
                            while ( have_posts() ) : the_post(); ?>
                            	<div class="col-md-3">
                            	<div class="project-item main-color-1-bg-hover project-item-<?php the_ID() ?>">
                                	<div class="item-thumbnail dark-div">
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                            <?php if(has_post_thumbnail()){ 
												$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'thumb_409x258', true); ?>
                                            	<img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
                                            <?php }?>
                                        </a>
                                        <div class='thumbnail-hoverlay main-color-1-bg'></div>
                                        <div class='thumbnail-hoverlay-icon'>
                                            <a title="<?php _e('Quick view','cactusthemes') ?>" href="#" class="colorbox-grid" data-content=".project-item-<?php the_ID() ?>"><i class="fa fa-search"></i></a>
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><i class="fa fa-link"></i></a>
                                        </div>
                                    </div><!--item-thumbnail-->
                                    <div class="project-item-content text-center">
                                    	<div class="project-item-title">
                                        	<div class="project-item-title-inner">
                                                <h4 class="item-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
                                                <div class="project-item-tax small-text">
                                                  <?php 
													$terms = wp_get_post_terms( get_the_ID(), 'u_project_cat');
													$count = 0; $i=0;
														foreach ($terms as $term) {
															$count ++;
														}
														foreach ($terms as $term) {
															$i++;
															echo '<a href="'.get_term_link($term->slug, 'u_project_cat').'" class="cat-link">'.$term->name.'</a> ';
															if($i!=$count){ echo ', ';}
														}
													?>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="project-item-excerpt">
                                        	<div class="exerpt-text"><?php echo wp_trim_words( get_the_excerpt(), 15, '...' ); ?></div>
                                        </div>
                                    </div><!--item-content-->
                                    <div class="hidden">
                                        <div class="popup-data dark-div">
                                            <?php
											$attachment_id = get_post_thumbnail_id(get_the_ID());
											$thumbnail = wp_get_attachment_image_src($attachment_id,'full', true); ?>
                                            <img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
                                            <div class="popup-data-content">
                                                <h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
                                                <div><?php the_excerpt(); ?></div>
                                                <a class="btn btn-default" href="javascript:void(0)" data-toggle="collapse" data-target="#share-in-popup-<?php echo get_the_ID().$attachment_id;?>"><?php _e('SHARE','cactusthemes'); ?> <i class="fa fa-share"></i></a>
                                            	<a href="<?php echo get_permalink(get_the_ID()); ?>#comment" class="btn btn-default popup-gallery-comment" title="<?php _e('View comments','cactusthemes'); ?>"><?php _e('COMMENTS','cactusthemes'); ?></a>
                                                <div id="share-in-popup-<?php echo get_the_ID().$attachment_id;?>" class="popup-share collapse">
                                                    <ul class="list-inline social-light">
                                                        <?php cactus_social_share(get_the_ID()); ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--/hidden-->
                                </div>
                            </div><!--col-md-3-->
							<?php endwhile;
                                  endif;  ?>
                            </div>
                        </div>
                        <?php if(function_exists('wp_pagenavi')){
							wp_pagenavi();
						}else{
							cactusthemes_content_nav('paging');
						}?>
                    </div><!--/content-->
                    <?php if($layout != 'full'){get_sidebar();} ?>
                </div><!--/row-->
            </div><!--/content-pad-->
        </div><!--/container-->
    </div><!--/body-->
<?php get_footer(); ?>