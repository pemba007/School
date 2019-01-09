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
		.logo{background:url(<?php echo ot_get_option('retina_logo'); ?>) no-repeat center; display:inline-block !important; background-size:contain;}
		.logo img{ opacity:0; visibility:hidden}
		.logo *{display:inline-block}
	}
</style>
<?php endif;?>
<?php 
if(ot_get_option('echo_meta_tags')!='off') ct_meta_tags(); ?>
<?php wp_head(); ?>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-1152642518017280",
          enable_page_level_ads: true
     });
</script>
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
    }elseif(is_archive()){
		$page_title = get_the_archive_title();
	} else {
		global $post;
		if($post){$page_title = $post->post_title;}
	}
?>
<div id="body-wrap">
    <div id="wrap">
        <header>
            <?php
            get_template_part( 'header', 'navigation' ); // load header-navigation.php 
            if(is_single()){
                //get_template_part( 'header', 'single' );
            }elseif(is_category()){
                //get_template_part( 'header', 'category' );
            }elseif(is_front_page()||is_page_template('page-templates/front-page.php')){
               get_template_part( 'header', 'frontpage' );
            }
            ?>
        </header>