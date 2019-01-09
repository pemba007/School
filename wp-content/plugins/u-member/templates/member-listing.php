<?php 
/*
 *  Member List
 */
get_header(); ?>
	<?php
	global $page_title;
	$page_title = __('Professors', 'cactusthemes'); //overwrite page title
	get_template_part( 'header', 'heading' ); ?>
    <div id="body">
    	<div class="container">
        	<div class="content-pad-3x">
            <?php
			$bp = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$args = array(
				'post_type' => 'u_member',
				'posts_per_page' => get_option('posts_per_page'),
				'orderby' => '',
				'paged' => $bp,
				'post_status' => 'publish',
			);	
			$the_query = new WP_Query( $args );
			global $the_query;
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
			?>
                <div class="row">
                    <div id="content" class="col-md-9">
                        <div class="content-pad">
                            <ul class="list-inline member-filter">
                                <li><a class="inherit-color" href="<?php echo add_query_arg( array('' =>''), $curent_url ); ?>">All</a></li>
                                <?php 
								$startCapital = 65;
                                for($i = 0;$i<26;$i++){
                                ?>
                            	<li><a class="inherit-color" href="<?php echo add_query_arg( array('orderby' => chr($startCapital + $i)), $curent_url ); ?>"><?php echo chr($startCapital + $i); ?></a></li>
                              	<?php }?>
                            </ul>
                        </div>
                        <div class="member-listing">
                            <div class="content-pad">
                                <div class="row">
                                <?php 
								if($_GET['orderby']){
									$args_mb = array(
										'orderby'         => 'post_date',
										'order'           => 'DESC',
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
									foreach($post_list as $mb_item){
										if (( $mb_item['post_title'][0] == $_GET['orderby']) || ( $mb_item['post_title'][0] == $_GET['orderby'])) {
											$id_mb = $mb_item['id'];
											$exc_mb = $mb_item['post_content'];
											global $id_mb;global $exc_mb;
											get_template_part('u-member/classic-list-item-alphab');
										}
									}
								}else if(!$_GET['orderby']){
								?>
									<?php
                                    if ( $the_query->have_posts() ) : 
                                    while ( $the_query->have_posts() ) : $the_query->the_post();
                                    	get_template_part('u-member/classic-list');
                                    endwhile;
                                    endif; 
								}?>
								<?php if(function_exists('wp_pagenavi')){
                                    wp_pagenavi( array( 'query' => $the_query ) );
                                }else{
                                    cactusthemes_content_nav('paging');
                                }?>

                                </div>
                            </div><!--/content-pad-->
                        </div><!--/member-listing-->
                    </div><!--/content-->
                    <?php get_sidebar(); ?>
                </div><!--/row-->
            </div><!--/content-pad-->
        </div><!--/container-->
    </div><!--/body-->
<?php get_footer(); ?>