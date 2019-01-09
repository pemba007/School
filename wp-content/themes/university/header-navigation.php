<?php
global $global_nav_style;
$nav_style = $global_nav_style?$global_nav_style:ot_get_option('nav_style','1');
$nav_sticky = ot_get_option('nav_sticky');
?>
			<div id="top-nav" class="dark-div nav-style-<?php echo $nav_style ?>">
                <nav class="navbar navbar-inverse main-color-1-bg" role="navigation">
                    <div class="container">
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="top-menu">
                            <ul class="nav navbar-nav hidden-xs">
                              <?php
									if(has_nav_menu( 'secondary-menus' )){
										wp_nav_menu(array(
											'theme_location'  => 'secondary-menus',
											'container' => false,
											'items_wrap' => '%3$s',
											'walker'=> new custom_walker_nav_menu()
										));	
									}
								?>
                            </ul>
                            <button type="button" class="mobile-menu-toggle visible-xs">
                            	<span class="sr-only"><?php _e('Menu','cactusthemes') ?></span>
                            	<i class="fa fa-bars"></i>
                            </button>
                            <?php if(ot_get_option('enable_search')!='off'){ ?>
                            <a class="navbar-right search-toggle collapsed" data-toggle="collapse" data-target="#nav-search" href="#"><i class="fa fa-search"></i></a>
                            <?php }?>
                            <?php if (class_exists('Woocommerce')) {
								global $woocommerce;
								$cart_url = wc_get_cart_url();
								$checkout_url = wc_get_checkout_url();
								if($woocommerce->cart->get_cart_contents_count()){ 
								?>
                                <ul class="nav navbar-right">
                                    <li class="main-menu-item sub-menu-left menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children parent dropdown mycart search-toggle"><i class="fa fa-shopping-cart"></i><?php echo ' ('.$woocommerce->cart->get_cart_contents_count(),')';?>
                                    <ul class="dropdown-menu menu-depth-1">
                                        <li class="sub-menu-item  menu-item-depth-1 menu-item menu-item-type-post_type"><a href="<?php echo $cart_url;?>" class="menu-link  sub-menu-link"><?php _e('View Cart','cactusthemes') ?></a></li>
                                        <li class="sub-menu-item menu-item-depth-1 menu-item menu-item-type-post_type"><a href="<?php echo $checkout_url;?>" class="menu-link  sub-menu-link"><?php _e('Check Out','cactusthemes') ?></a></li>
                                    </ul>
                                    </li>
                            </ul>
                            <?php } }?>
                            <div class="navbar-right topnav-sidebar">
                            	<?php
								if ( is_active_sidebar( 'topnav_sidebar' ) ) :
									dynamic_sidebar( 'topnav_sidebar' );
								endif;
								?>
                            </div>
                            <?php if(ot_get_option('enable_search')!='off'){ ?>
                            <div id="nav-search" class="collapse dark-div">
                            	<div class="container">
                                <form action="<?php echo home_url() ?>">
                                    <div class="input-group">
                                        <input type="text" name="s" class="form-control search-field" placeholder="<?php _e('Search Here','cactusthemes') ?>" autocomplete="off">
                                        <span class="input-group-btn">
                                            <button type="submit"><i class="fa fa-search fa-4x"></i>&nbsp;</button>
                                        </span>
                                        <span class="input-group-btn hidden-xs">
                                            <button type="button" data-toggle="collapse" data-target="#nav-search">&nbsp;<i class="fa fa-times fa-2x"></i></button>
                                        </span>
                                    </div>
                                </form>
                                </div>
                            </div>
                            <?php }?>
                        </div><!-- /.navbar-collapse -->
                    </div>
                </nav>
            </div><!--/top-nap-->
            <div id="main-nav" class="dark-div nav-style-<?php echo $nav_style ?>">
                <nav class="navbar navbar-inverse main-color-2-bg" role="navigation">
                    <div class="container">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <?php if(ot_get_option('logo_image') == ''):?>
                            <a class="logo" href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri() ?>/images/logo.png" alt="logo"></a>
                            <?php else:?>
                            <a class="logo" href="<?php echo get_home_url(); ?>" title="<?php wp_title( '|', true, 'right' ); ?>"><img src="<?php echo ot_get_option('logo_image'); ?>" alt="<?php wp_title( '|', true, 'right' ); ?>"/></a>
                            <?php endif;?>
                            
                            <?php if($nav_style=='3'){ 
								echo '<div class="navbar-right callout-text">';
								echo ot_get_option('nav_callout_text');
								echo '</div>';
							} ?>
                        </div>
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <?php $nav_logo_sticky = ot_get_option('nav_logo_sticky');
						$cl_stk =''; 
						if($nav_logo_sticky=='2'){ $cl_stk = 'stck_logo';}
						?>
                        <div class="main-menu hidden-xs <?php echo $cl_stk.' ';  echo $nav_sticky==2?'sticky-light':'' ?>" <?php if($nav_sticky){ ?>data-spy="affix" data-offset-top="500"<?php } ?>>
                        <?php 
						if($nav_logo_sticky=='2'){
						?>
                        <div class="container clearfix logo-menu-st">
                        <div class="row">
							<?php
                            $logo = ot_get_option('logo_image_sticky');
                            if($logo==''){
                                $logo = ot_get_option('logo_image');
                            }
                            //$background_image_post = wp_get_attachment_image_src( $logo, 'full', $icon );
                            if($logo!=''){
                                echo '<a href="'.home_url().'" class="logo"><img src="'.$logo.'" alt="'.wp_title( '|', false, 'right' ).'"></a>';
                            } else { ?>
                                <a href="<?php echo home_url() ?>" class="logo"><img src="<?php echo get_template_directory_uri()?>/images/logo.png" alt="<?php wp_title( '|', true, 'right' );?>"/></a>
                            <?php }
							}?>
							
							<?php if(is_active_sidebar('navigation_sidebar')){
								dynamic_sidebar('navigation_sidebar');
							} else { ?>
                            <ul class="nav navbar-nav navbar-right">
                            	<?php
									if(has_nav_menu( 'primary-menus' )){
										wp_nav_menu(array(
											'theme_location'  => 'primary-menus',
											'container' => false,
											'items_wrap' => '%3$s',
											'walker'=> new custom_walker_nav_menu()
										));	
									}else{?>
										<li><a href="<?php echo home_url(); ?>"><?php _e('Home','cactusthemes') ?> <span class="menu-description"><?php _e('Home page','cactusthemes') ?></span></a></li>
										<?php wp_list_pages('depth=1&number=4&title_li=' ); ?>
								<?php } ?>
                            </ul>
							<?php } ?>
                            <?php 
							$nav_logo_sticky = ot_get_option('nav_logo_sticky');
							if($nav_logo_sticky=='2'){
							?>
                                </div>
                                </div>
                            <?php }?>
                            <?php if($nav_sticky){ ?>
                            	<a href="#top" class="sticky-gototop main-color-1-hover"><i class="fa fa-angle-up"></i></a>
							<?php } ?>
                        </div><!-- /.navbar-collapse -->
                    </div>
                </nav>
            </div><!-- #main-nav -->