<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 */
?>
		<section id="bottom-sidebar">
            <div class="container">
                <div class="row normal-sidebar">
                    <?php
                    if ( is_active_sidebar( 'bottom_sidebar' ) ) :
						
                        dynamic_sidebar( 'bottom_sidebar' );
						
                    endif;
                    ?>
                </div>
            </div>
        </section>
        <footer class="dark-div main-color-2-bg">
        	<section id="bottom">
            	<div class="section-inner">
                	<div class="container">
                    	<div class="row normal-sidebar">
							<?php
                            if ( is_active_sidebar( 'footer_sidebar' ) ) :
								global $wid_def;
								$wid_def=1;
                                dynamic_sidebar( 'footer_sidebar' );
								$wid_def=0;
                            endif;
                            ?>
                		</div>
                    </div>
                </div>
            </section>
            <div id="bottom-nav">
                <div class="container">
                    <div class="text-center line-under">
                    <?php if(ot_get_option('off_gototop')!='off'){?>
                        <a class="btn btn-default main-color-2-bg back-to-top" href="#top"><?php _e('TOP','cactusthemes') ?></a>
                    <?php }?>    
                    </div>
                    <div class="row footer-content">
                        <div class="copyright col-md-6">
                       		<?php if(ot_get_option('copyright')){  echo ot_get_option('copyright');  } else {echo __('WordPress Theme by (C) CactusThemes','cactusthemes'); }?>
                        </div>
                        <nav class="col-md-6 footer-social">
                        	<?php 
							$social_account = array(
								'facebook',
								'twitter',
								'linkedin',
								'tumblr',
								'google-plus',
								'pinterest',
								'youtube',
								'flickr',
								'vk',
							);
							?>
                            <ul class="list-inline pull-right social-list">
                            	<?php 
								$social_link_open = ot_get_option('social_link_open');
								foreach($social_account as $social){
									if($link = ot_get_option('acc_'.$social,false)){ ?>
                                            <li><a href="<?php echo $link ?>" <?php if($social_link_open=='on'){?>target="_blank" <?php }?> class="btn btn-default social-icon"><i class="fa fa-<?php echo $social ?>"></i></a></li>
								<?php }
								}//foreach
								if($custom_acc = ot_get_option('custom_acc')){
									foreach($custom_acc as $a_social){ ?>
										<li><a href="<?php echo $a_social['link'] ?>" <?php if($social_link_open=='on'){?>target="_blank" <?php }?> class="btn btn-default social-icon"><i class="fa <?php echo $a_social['icon'] ?>"></i></a></li>
									<?php }
								}
								?>
                            </ul>
                        </nav>
                    </div><!--/row-->
                </div><!--/container-->
            </div>
        </footer>
        </div><!--wrap-->
    </div><!--/body-wrap-->
    <div class="mobile-menu-wrap dark-div visible-xs">
        <a href="#" class="mobile-menu-toggle"><i class="fa fa-times-circle"></i></a>
        <ul class="mobile-menu">
            <?php
                if(has_nav_menu( 'primary-menus' )){
                    wp_nav_menu(array(
                        'theme_location'  => 'primary-menus',
                        'container' => false,
                        'items_wrap' => '%3$s',
                    ));	
                }else{?>
                    <li><a href="<?php echo home_url(); ?>"><?php _e('Home','cactusthemes') ?></a></li>
                    <?php wp_list_pages('depth=1&number=4&title_li=' ); ?>
            <?php } ?>
            <?php
                if(has_nav_menu( 'secondary-menus' )){
                    wp_nav_menu(array(
                        'theme_location'  => 'secondary-menus',
                        'container' => false,
                        'items_wrap' => '%3$s',
                    ));	
                }
            ?>
        </ul>
    </div>
<?php echo ot_get_option('google_analytics_code', ''); ?>    
<?php wp_footer(); ?>
</body>
</html>
