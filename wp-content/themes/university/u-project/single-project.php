<?php 
$content_padding = get_post_meta(get_the_ID(),'project-ctpadding',true);
$layout = get_post_meta(get_the_ID(),'project-sidebar',true);
if($layout=='def'){$layout ='';}
if(function_exists('cop_get') && $layout==''){
	$layout =  cop_get('u_project_settings','u-project-layout');
} 
//echo $layout;

get_header();
?>
	<?php get_template_part( 'header', 'heading' ); ?>   
    <div id="body">
    	<div class="container">
        	<div class="content-pad-3x">
                <div class="row">
                    <div id="content" class="<?php echo $layout!='full'?'col-md-9':'col-md-12' ?><?php echo ($layout == 'left') ? " revert-layout":"";?>" role="main">
                    <div class="row">
                    	<div class="col-md-8">
                        <article class="single-post-content single-content">
                        	<?php
							// The Loop
							while ( have_posts() ) : the_post();
							wp_enqueue_style( 'lightbox2', get_template_directory_uri() . '/js/colorbox/colorbox.css');
							wp_enqueue_script( 'colorbox', get_template_directory_uri() . '/js/colorbox/jquery.colorbox-min.js', array('jquery'), '', true );
							
							$images=get_children('post_type=attachment&numberposts=-1&post_mime_type=image&post_parent='.get_the_ID());
							if(count($images) > 0){ ?>
							<div class="is-carousel single-carousel post-gallery content-image" id="post-gallery-<?php the_ID() ?>">
							<?php
								foreach((array)$images as $attachment_id => $attachment){
									$image = wp_get_attachment_image_src( $attachment_id, 'full' ); ?>
									<div class="single-gallery-item single-gallery-item-<?php echo $attachment_id ?>">
										<a href="<?php echo get_permalink($attachment_id); ?>" class="colorbox-grid" data-rel="post-gallery-<?php the_ID() ?>" data-content=".single-gallery-item-<?php echo $attachment_id ?>">
										<img src='<?php echo $image[0]; ?>'>
										</a>
										<div class="hidden">
											<div class="popup-data dark-div">
												<?php $thumbnail = wp_get_attachment_image_src($attachment_id,'full', true); ?>
												<img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
												<div class="popup-data-content">
													<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
													<div><?php the_excerpt(); ?></div>
													<a class="btn btn-default" href="javascript:void(0)" data-toggle="collapse" data-target="#share-in-popup-<?php echo $attachment_id;?>"><?php _e('SHARE','cactusthemes'); ?> <i class="fa fa-share"></i></a>
													<a href="<?php echo get_permalink($attachment_id); ?>#comment" class="btn btn-default popup-gallery-comment" title="<?php _e('View comments','cactusthemes'); ?>"><?php _e('COMMENTS','cactusthemes'); ?></a>
													<div id="share-in-popup-<?php echo $attachment_id;?>" class="popup-share collapse">
														<ul class="list-inline social-light">
															<?php cactus_social_share($attachment_id); ?>
														</ul>
													</div>
												</div>
											</div>
										</div><!--/hidden-->
									</div>
								<?php }//foreach attachments ?>
							</div><!--/is-carousel-->
							<?php
							}else{//if count
								if(has_post_thumbnail()){
									$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(),'full', true); ?>
									<div class="content-image"><img src="<?php echo $thumbnail[0] ?>" alt="<?php the_title_attribute(); ?>" title="<?php the_title_attribute(); ?>"></div>
								<?php }
							}
							endwhile;
							?>
                            <?php the_content(); ?>
                        </article>
                        <?php comments_template( '', true ); ?>
                    </div>
                    <div id="sidebar" class="col-md-4 project-content">
                    	<div class="simple-navigation project-navigation">
                            <div class="row">
								<?php
								$cls_n = $cls_pre = $url_pre = $url_next = $next_pre='';
								if(function_exists('cop_get')){
									  $next_pre =  cop_get('u_project_settings','uproject-next-pre');
								}
								if($next_pre=='cat'){
									 $prev = get_adjacent_post(true, '', true, 'u_project_cat');
									 if($prev){
									 	$url_pre = get_permalink($prev->ID);  
									 }
									 $next = get_adjacent_post(true, '', false, 'u_project_cat');
									 if($next){
									 	$url_next = get_permalink($next->ID);
									 }
								}else{
									$prev = get_adjacent_post(false, '', true);
									if($prev){
									 	$url_pre = get_permalink($prev->ID);  
									 }
									$next = get_adjacent_post(false, '', false);
									if($next){
									 	$url_next = get_permalink($next->ID);
									 }
								}
								if($url_pre==''){
									$cls_pre ='style="display:none"';
									$cls_n ='style="width:100%; text-align:center"';?>
                                    <style type="text/css">
                                    @media(min-width:769px){
										.project-navigation .simple-navigation-item.text-right a{ width:auto !important; left:50% !important; margin-left:-35px !important}
									}
                                    </style>
                                    <?php
								}
								elseif($url_next==''){
									$cls_n ='style="display:none"';
									$cls_pre ='style="border:0; text-align:center; width:100%"';
								}
								
								if(!is_rtl()) {
								?>
                                <div class="simple-navigation-item col-md-6 col-sm-6 col-xs-6" <?php echo $cls_pre?>>
                                        <?php
										if($next_pre=='cat'){
											previous_post_link( '%link', '<i class="fa fa-angle-left pull-left"></i>'.__('Previous Project','cactusthemes'), TRUE, ' ', 'u_project_cat' ); 
										}else{
                                        	previous_post_link('%link', '<i class="fa fa-angle-left pull-left"></i>'.__('Previous Project','cactusthemes'));
										}?> 
                                            
                                </div>
                                <div class="simple-navigation-item col-md-6 col-sm-6 col-xs-6 text-right" <?php echo $cls_n?>>
                                		<?php 
										if($next_pre=='cat'){
											next_post_link( '%link', '<i class="fa fa-angle-right pull-right"></i>'.__('Next Project','cactusthemes'), TRUE, ' ', 'u_project_cat' ); 
										}else{
											next_post_link('%link', '<i class="fa fa-angle-right pull-right"></i>'.__('Next Project','cactusthemes')); 
										}
										?>
                                </div>
								<?php } else {?>
								<div class="simple-navigation-item col-md-6 col-sm-6 col-xs-6 next-post" <?php echo $cls_n?>>
                                		<?php 
										if($next_pre=='cat'){
											next_post_link( '%link', '<i class="fa fa-angle-right pull-right"></i>'.__('Next Project','cactusthemes'), TRUE, ' ', 'u_project_cat' ); 
										}else{
											next_post_link('%link', '<i class="fa fa-angle-right pull-right"></i>'.__('Next Project','cactusthemes')); 
										}
										?>
                                </div>
								<div class="simple-navigation-item col-md-6 col-sm-6 col-xs-6 text-right prev-post" <?php echo $cls_pre?>>
                                        <?php
										if($next_pre=='cat'){
											previous_post_link( '%link', '<i class="fa fa-angle-left pull-left"></i>'.__('Previous Project','cactusthemes'), TRUE, ' ', 'u_project_cat' ); 
										}else{
                                        	previous_post_link('%link', '<i class="fa fa-angle-left pull-left"></i>'.__('Previous Project','cactusthemes'));
										}?> 
                                            
                                </div>
                                
								<?php }?>
                            </div>
                        </div><!--/simple-nav-->
                        <h2 class="project-title"><?php the_title() ?></h2>
                        <div class="single-post-content-text project-content-text">
							<?php the_excerpt(); ?>
                        </div>
                        <div class="project-meta">
                        <?php
						if(function_exists('cop_get')){
							$tmr_options =  cop_get('u_project_settings','uproject-defmeta');
						}
                        $tmr_criteria = $tmr_options?explode(",", $tmr_options):'';
						?>
						<?php if($tmr_criteria){
                            foreach($tmr_criteria as $criteria){
                                $value = get_post_meta(get_the_ID(),'project_'.sanitize_title($criteria),true);
                                if($value){
                                ?>
                                <div class="project-meta-item">
                                    <div class="small-text"><?php echo $criteria ?></div>
                                    <div class="item-meta-value"><?php echo $value; ?></div>
                                </div>
                                <?php
                                }
                            }
                        }
                        
                        if($custom_meta = get_post_meta(get_the_ID(),'custom_meta',true)){
                            foreach($custom_meta as $meta){ ?>
                                    <div class="project-meta-item">
                                    	<div class="small-text"><?php echo $meta['title'] ?></div>
                                        <div class="item-meta-value"><?php echo $meta['conttent_custom']; ?></div>
                                    </div>
                                <?php
                            }
                        }
                        ?>
                        </div>
                        <div class="project-tax small-text">
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
                        <ul class="list-inline social-light">
							<?php cactus_social_share(); ?>
                        </ul>
                    </div>
                    
				<?php 
                if(function_exists('cop_get')){
                      $reletd_number =  cop_get('u_project_settings','uproject-rel-number');
                      $project_layout =  cop_get('u_project_settings','u-project-layout');
                }
                    $post_cat = get_the_terms( get_the_ID(), 'u_project_cat');
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
                                    'taxonomy' => 'u_project_cat',
                                    'field' => 'slug',
                                    'terms' => $iterm,
                                );
                        }
                    }else{
                        $texo = array(
                            array(
                                    'taxonomy' => 'u_project_cat',
                                    'field' => 'slug',
                                    'terms' => $cat_event,
                                )
                        );
                    }
                    if($project_layout=='full'){
                        $class_r = 'col-md-3';
                    }else{
                        $class_r = 'col-md-4';
                    }
                    if($reletd_number=='' && $project_layout=='full'){$reletd_number=4;}
                    else if($reletd_number==''){$reletd_number=3;}
                    $cr_id = get_the_ID();
                    $args = array(
                        'post_type' => 'u_project',
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
                    
                    <div class="col-md-12 related-projects">
                    	<div class="related-projects-inner">
                    	<h4 class="related-projects-title"><?php _e('Related Projects','cactusthemes'); ?></h4>
						<?php
                        //print_r($args);
                        $count_item = count($tm_query);
                        $i=0;?>
                    	<div class="row project-listing">
                        <?php
                        foreach ( $tm_query as $key => $post ) : setup_postdata( $post );
						$i++;
						?>
                            <div class="<?php echo $class_r; ?>">
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
                                                $terms = wp_get_post_terms( $post->ID, 'u_project_cat');
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
											$attachment_id = get_post_thumbnail_id($post->ID);
											$thumbnail = wp_get_attachment_image_src($attachment_id,'full', true); ?>
                                            <img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
                                            <div class="popup-data-content">
                                                <h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
                                                <div><?php the_excerpt(); ?></div>
                                                <a class="btn btn-default" href="javascript:void(0)" data-toggle="collapse" data-target="#share-in-popup-<?php echo get_the_ID().$attachment_id;?>"><?php _e('SHARE','cactusthemes'); ?> <i class="fa fa-share"></i></a>
                                            	<a href="<?php echo get_permalink($post->ID); ?>#comment" class="btn btn-default popup-gallery-comment" title="<?php _e('View comments','cactusthemes'); ?>"><?php _e('COMMENTS','cactusthemes'); ?></a>
                                                <div id="share-in-popup-<?php echo $post->ID.$attachment_id;?>" class="popup-share collapse">
                                                    <ul class="list-inline social-light">
                                                        <?php cactus_social_share($post->ID); ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--/hidden-->
                                </div>
                            </div><!--col-md-3-->
							<?php  
                            if(($project_layout=='full') && ($i%4==0) && ($count_item > $i)){?>
                                </div><div class="row">
                            <?php } elseif(($project_layout!='full') && ($i%3==0) && ($count_item > $i)){?>
                                </div><div class="row">
                            <?php }
							endforeach;
							?>
                        </div>
                        </div><!--/inner-->
                    </div><!--/related-projects-->
                    <?php }?>
                    </div>
                    </div><!--/content-->
                    <?php if($layout != 'full'){get_sidebar();} ?>
                </div><!--/row-->
                
            </div><!--/content-pad-->
        </div><!--/container-->
    </div><!--/body-->
<?php get_footer(); ?>