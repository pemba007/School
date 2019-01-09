<?php 
/*
 * Template Name: Demo Nav Style 3
 */
 
global $global_nav_style;
$global_nav_style = 3;
global $global_page_layout;
$global_page_layout = 'true-full';

$single_page_layout = get_post_meta(get_the_ID(),'sidebar_layout',true);
$content_padding = get_post_meta(get_the_ID(),'content_padding',true);
$layout = $single_page_layout ? $single_page_layout : ($global_page_layout ? $global_page_layout : ot_get_option('page_layout','right'));
$global_page_layout = $layout;
?>

<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0">
<?php if(ot_get_option('favicon')):?>
<link rel="shortcut icon" type="ico" href="<?php echo ot_get_option('favicon');?>">
<?php endif;?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php if(ot_get_option('favicon')):?>
<link rel="shortcut icon" type="ico" href="<?php echo ot_get_option('favicon');?>">
<?php endif;?>
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<!--[if lte IE 9]>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie.css" />
<![endif]-->
<?php if(ot_get_option('retina_logo')):?>
<style type="text/css" >
	@media only screen and (-webkit-min-device-pixel-ratio: 2),(min-resolution: 192dpi) {
		/* Retina Logo */
		.logo{background:url(http://university.cactusthemes.com/wp-content/uploads/Logo-dark-2X.png) no-repeat center; display:inline-block !important; background-size:contain;}
		.logo img{ opacity:0; visibility:hidden}
		.logo *{display:inline-block}
	}
</style>
<?php endif;?>
<?php 
if(ot_get_option('echo_meta_tags')!='off') ct_meta_tags(); ?>
<?php wp_head(); ?>
</head>

<body <?php body_class() ?>>
<a name="top" style="height:0; position:absolute; top:0;" id="top-anchor"></a>
<?php if(ot_get_option('pre-loading',2)==1||(ot_get_option('pre-loading',2)==2&&(is_front_page()||is_page_template('page-templates/front-page.php')))){ ?>
<div id="pageloader" class="dark-div" style="position:fixed; top:0; left:0; width:100%; height:100%; z-index:99999; background:<?php echo ot_get_option('loading_bg','#222') ?>;">   
    <div class="spinner">
      <div class="cube1"></div>
      <div class="cube2"></div>
    </div>
</div>
<?php }?>
<?php
	//prepare page title
	global $page_title;
	if(is_search()){
		$page_title = __('Search Result: ','cactusthemes').(esc_html(isset($_GET['s']))?esc_html($_GET['s']):'');
	}elseif(is_category()){
		$page_title = single_cat_title('',false);
	}elseif(is_tag()){
		$page_title = single_tag_title('',false);
	}elseif(is_tax()){
		$page_title = single_term_title('',false);
	}elseif(is_author()){
		$page_title = __("Author: ",'cactusthemes') . get_the_author();
	}elseif(is_day()){
		$page_title = __("Archives for ",'cactusthemes') . date_i18n(get_option('date_format') ,strtotime(get_the_date()));
	}elseif(is_month()){
		$page_title = __("Archives for ",'cactusthemes') . get_the_date('F, Y');
	}elseif(is_year()){
		$page_title = __("Archives for ",'cactusthemes') . get_the_date('Y');
	}elseif(is_home()){
		if(get_option('page_for_posts')){ $page_title = get_the_title(get_option('page_for_posts'));
		}else{
			$page_title = get_bloginfo('name');
		}
	}elseif(is_404()){
		$page_title = ot_get_option('page404_title','404 - Page Not Found');
	}else if(  function_exists ( "is_shop" ) && is_shop()){
			$page_title = woocommerce_page_title($echo = false);
    }else{
		global $post;
		if($post){$page_title = $post->post_title;}
	}
?>
<div id="body-wrap">
    <div id="wrap">
        <header>
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
                                <ul class="nav navbar-right hidden-xs">
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
                            <a class="logo" href="<?php echo home_url(); ?>"><img src="http://university.cactusthemes.com/wp-content/uploads/Logo-dark-1X.png" alt="logo"></a>
                            <?php else:?>
                            <a class="logo" href="<?php echo get_home_url(); ?>" title="<?php wp_title( '|', true, 'right' ); ?>"><img src="http://university.cactusthemes.com/wp-content/uploads/Logo-dark-1X.png" alt="<?php wp_title( '|', true, 'right' ); ?>"/></a>
                            <?php endif;?>
                            
                            <?php if($nav_style=='3'){ 
								echo '<div class="navbar-right callout-text">';
								echo ot_get_option('nav_callout_text');
								echo '</div>';
							} ?>
                        </div>
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="main-menu hidden-xs <?php echo $nav_sticky==2?'sticky-light':'' ?>" <?php if($nav_sticky){ ?>data-spy="affix" data-offset-top="500"<?php } ?>>
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
                            <?php if($nav_sticky){ ?>
                            	<a href="#top" class="sticky-gototop main-color-1-hover"><i class="fa fa-angle-up"></i></a>
							<?php } ?>
                        </div><!-- /.navbar-collapse -->
                    </div>
                </nav>
            </div><!-- #main-nav -->
            <?php
            //get_template_part( 'header', 'navigation' ); // load header-navigation.php 
            get_template_part( 'header', 'frontpage' );
            ?>
        </header>
    <div id="body">
    	<?php if($layout!='true-full'){ ?>
    	<div class="container">
        <?php }?>
        	<?php if($content_padding!='off'){ ?>
        	<div class="content-pad-3x">
            <?php }?>
                <div class="row">
                    <div id="content" class="<?php echo ($layout != 'full' && $layout != 'true-full')?'col-md-9':'col-md-12' ?><?php echo ($layout == 'left') ? " revert-layout":"";?>" role="main">
                        <article class="single-page-content">
                        	<?php
							// The Loop
							while ( have_posts() ) : the_post();
								the_content();
							endwhile;
							?>
                        </article>
                    </div><!--/content-->
                    <?php if($layout != 'full' && $layout != 'true-full'){get_sidebar();} ?>
                </div><!--/row-->
            <?php if($content_padding!='off'){ ?>
            </div><!--/content-pad-3x-->
            <?php }?>
        <?php if($layout!='true-full'){ ?>
        </div><!--/container-->
        <?php }?>
    </div><!--/body-->
<?php get_footer(); ?>