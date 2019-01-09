<?php 
/*
 *  Member List
 */
get_header(); ?>
	<?php
	global $page_title;
	$page_title = __('Professors', 'cactusthemes'); //overwrite page title
	if(is_tax('u_department')){
		$page_title =  single_term_title("", false); 
	}
	global $layout;
	$layout = ot_get_option('page_layout','right');
	get_template_part( 'header', 'heading' ); ?>
    <div id="body">
    	<div class="container">
        	<div class="content-pad-3x">
            <?php

			global $wp;
			if(get_option('permalink_structure') != ''){
				$curent_url = home_url( $wp->request );
				if(function_exists('qtrans_getLanguage') && qtrans_getLanguage()!=''){
					$curent_url = '//'.$_SERVER["HTTP_HOST"].$_SERVER['REDIRECT_URL'];
				}
			}else{
				$query_string = $wp->query_string;
				if(isset($_GET['lang'])){
					$query_string = $wp->query_string.'&lang='.$_GET['lang'];
				}
				$curent_url = add_query_arg( $query_string, '', home_url( $wp->request ) );
			}
			if(function_exists('cop_get')){
			$filter_bar =  cop_get('u_member_settings','u-member-filter');
			$slug_mb  =  cop_get('u_member_settings','umember-slug');
			if($slug_mb==''){$slug_mb='member';}
			}
			?>
                <div class="row">
                    <div id="content" class="<?php echo ($layout != 'full' && $layout != 'true-full')?'col-md-9':'col-md-12' ?><?php echo ($layout == 'left') ? " revert-layout":"";?>">
                    <?php if($filter_bar!='off'){?>	
                        <div class="content-pad">
                            <ul class="list-inline member-filter">
                                <li><a class="inherit-color <?php echo isset($_GET['orderby'])?'':'main-color-1' ?>" href="<?php echo esc_url(add_query_arg( array('' =>''), $curent_url )); ?>"><?php _e('All','cactusthemes'); ?></a></li>
                                <?php 
								if(is_tax()){
									$curent_url =home_url().'/'.$slug_mb.'/';
								}
								$startCapital = 65;
                                for($i = 0;$i<26;$i++){
                                ?>
                            	<li><a class="inherit-color <?php echo (isset($_GET['orderby']) && chr($startCapital + $i)==$_GET['orderby'])?'main-color-1':'' ?>" href="<?php echo esc_url(add_query_arg( array('orderby' => chr($startCapital + $i)), $curent_url )); ?>"><?php echo chr($startCapital + $i); ?></a></li>
                              	<?php }?>
                            </ul>
                        </div>
                        <?php }
						if(function_exists('cop_get')){
							$slug_pt =  cop_get('u_member_settings','umember-slug');
							$filter =  cop_get('u_member_settings','u-mb-filter-dep');
						} 
						if($slug_pt==''){
							$slug_pt = 'memeber';
						}
						if($filter=='on'){
							ct_filter_bar($taxono='u_department',$slug_pt);
							?>
                            <style type="text/css">.courses-list{ padding-top:0}</style>
                            <?php
						}
						?>
                        <div class="member-listing">
                            <div class="content-pad">
                                <div class="row">
                                <?php 
								if(isset($_GET['orderby'])){
									$args_mb = array(
										'orderby'         => 'post_date',
										'order'           => 'DESC',
										'posts_per_page' => -1,
										'post_type'       => 'u_member',
										'post_status'     => 'publish',
										'suppress_filters' => true 
									);
									$posts_array = get_posts( $args_mb );
									$post_list = array();
									foreach($posts_array as $post){
										$post_data = array('id' => $post->ID, 'post_title'=>$post->post_title, 'post_content'=>wp_trim_words( $post->post_content, $num_words = 55, $more = null ));
										array_push($post_list,$post_data);
									}
									$mem_count = 0;
									foreach($post_list as $mb_item){
										if (( $mb_item['post_title'][0] == $_GET['orderby']) || ( $mb_item['post_title'][0] == $_GET['orderby'])) {
											$id_mb = $mb_item['id'];
											$exc_mb = $mb_item['post_content'];
											global $id_mb;global $exc_mb;
											$mem_count++;
											get_template_part('u-member/classic-list-item-alphab');
											if( $layout == 'full' && ($mem_count % 4 == 0) ){
												echo '</div><div class="row">';
											}elseif( $layout != 'full' && ($mem_count % 3 == 0) ){
												echo '</div><div class="row">';
											}
										}
									}
								}else if(!isset($_GET['orderby'])){
									$mem_count = 0;

                                    if ( have_posts() ) : 
                           			while ( have_posts() ) : the_post();
										$mem_count++;
                                    	get_template_part('u-member/classic-list');
										if( $layout == 'full' && ($mem_count % 4 == 0) ){
											echo '</div><div class="row">';
										}elseif( $layout != 'full' && ($mem_count % 3 == 0) ){
											echo '</div><div class="row">';
										}
                                    endwhile;
                                    endif; 
								}?>
								<?php if(function_exists('wp_pagenavi')){
                                    wp_pagenavi();
                                }else{
                                    cactusthemes_content_nav('paging');
                                }?>

                                </div>
                            </div><!--/content-pad-->
                        </div><!--/member-listing-->
                    </div><!--/content-->
                    <?php if($layout != 'full' && $layout != 'true-full'){get_sidebar();} ?>
                </div><!--/row-->
            </div><!--/content-pad-->
        </div><!--/container-->
    </div><!--/body-->
<?php get_footer(); ?>