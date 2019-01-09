<?php

//header('Content-type: text/css');

//require '../../../../wp-load.php';
//convert hex 2 rgba
if(!function_exists('cactus_hex2rgba')){
function cactus_hex2rgba($hex,$opacity) {
   $hex = str_replace("#", "", $hex);
   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $opacity = $opacity/100;
   $rgba = array($r, $g, $b, $opacity);
   return implode(",", $rgba); // returns the rgba values separated by commas
   //return $rgba; // returns an array with the rgb values
}
}
/* Get Theme Options here and echo custom CSS */
// 
// for example: 
// $topmenu_visible = ot_get_option( 'topmenu_visible', 1);

//color
if($main_color_1 = ot_get_option('main_color_1')){ ?>
    .main-color-1, .main-color-1-hover:hover, a:hover, a:focus,
    header .multi-column > .dropdown-menu>li>a:hover,
    header .multi-column > .dropdown-menu .menu-column>li>a:hover,
    #main-nav.nav-style-2 .navbar-nav>li:hover>a,
    #main-nav.nav-style-2 .navbar-nav>.current-menu-item>a,
    #main-nav.nav-style-3 .navbar-nav>li:hover>a,
    #main-nav.nav-style-3 .navbar-nav>.current-menu-item>a,
    .item-meta a:not(.btn):hover,
    .map-link.small-text,
    .single-u_event .event-info .cat-link:hover,
    .single-course-detail .cat-link:hover,
    .related-event .ev-title a:hover,
    #checkout-uni li.active a,
    .woocommerce-review-link,
    .woocommerce #content div.product p.price,
    .woocommerce-tabs .active,
    .woocommerce p.stars a, .woocommerce-page p.stars a,
    .woocommerce .star-rating:before, .woocommerce-page .star-rating:before, .woocommerce .star-rating span:before, .woocommerce-page .star-rating span:before, .woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price,
    .woocommerce .uni-thankyou-page .order_item .product-name,
    .woocommerce .uni-thankyou-page .addresses h3,
    .wpb_wrapper .wpb_content_element .wpb_tabs_nav li.ui-tabs-active, .wpb_wrapper .wpb_content_element .wpb_tabs_nav li:hover,
    .wpb_wrapper .wpb_content_element .wpb_tabs_nav li.ui-tabs-active a, .wpb_wrapper .wpb_content_element .wpb_tabs_nav li:hover a,
    li.bbp-topic-title .bbp-topic-permalink:hover, #bbpress-forums li.bbp-body ul.topic .bbp-topic-title:hover a, #bbpress-forums li.bbp-body ul.forum .bbp-forum-info:hover .bbp-forum-title,
    #bbpress-forums li.bbp-body ul.topic .bbp-topic-title:hover:before, #bbpress-forums li.bbp-body ul.forum .bbp-forum-info:hover:before,
    #bbpress-forums .bbp-body li.bbp-forum-freshness .bbp-author-name,
    .bbp-topic-meta .bbp-topic-started-by a,
    div.bbp-template-notice a.bbp-author-name,
    #bbpress-forums .bbp-body li.bbp-topic-freshness .bbp-author-name,
    #bbpress-forums #bbp-user-wrapper h2.entry-title,
    .bbp-reply-header .bbp-meta a:hover,
    .member-tax a:hover,
    #bbpress-forums #subscription-toggle a,
    .uni-orderbar .dropdown-menu li a:hover,
    .main-menu.affix .sticky-gototop:hover{
        color:<?php echo $main_color_1 ?>;
    }
    .related-item .price{color:<?php echo $main_color_1 ?> !important;}
    .main-color-1-bg, .main-color-1-bg-hover:hover,
    input[type=submit],
    table:not(.shop_table)>thead, table:not(.shop_table)>tbody>tr:hover>td, table:not(.shop_table)>tbody>tr:hover>th,
    header .dropdown-menu>li>a:hover, header .dropdown-menu>li>a:focus,
    header .multi-column > .dropdown-menu li.menu-item:hover,
	header .multi-column > .dropdown-menu .menu-column li.menu-item:hover,
    .un-icon:hover, .dark-div .un-icon:hover,
    .woocommerce-cart .shop_table.cart thead tr,
    .uni-addtocart .add-text,
    .event-classic-item .item-thumbnail:hover a:before,
    .owl-carousel .owl-dots .owl-dot.active span, .owl-carousel .owl-dots .owl-dot:hover span,
    .course-list-table>tbody>tr:hover>td, .course-list-table>tbody>tr:hover>th,
    .project-item:hover .project-item-excerpt,
    .navbar-inverse .navbar-nav>li>a:after, .navbar-inverse .navbar-nav>li>a:focus:after,
    .topnav-sidebar #lang_sel_click ul ul a:hover,
    div.bbp-submit-wrapper .button,
	.topnav-sidebar #lang_sel ul ul a:hover{
        background-color:<?php echo $main_color_1 ?>;
    }
    #sidebar .widget_nav_menu  #widget-inner ul li a:hover,
    .main-color-1-border{
        border-color:<?php echo $main_color_1 ?>;
    }
    .btn-primary, .un-button-2, .un-button-2-lg,
    .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit, .woocommerce #content input.button, .woocommerce-page a.button, 				    .woocommerce-page button.button, .woocommerce-page input.button, .woocommerce-page #respond input#submit, .woocommerce-page #content input.button,
    .woocommerce #review_form #respond .form-submit input, .woocommerce-page #review_form #respond .form-submit input,
    .wpb_wrapper .wpb_accordion .wpb_accordion_wrapper .ui-accordion-header-active, .wpb_wrapper .wpb_accordion .wpb_accordion_wrapper .wpb_accordion_header:hover,
    .wpb_wrapper .wpb_toggle:hover, #content .wpb_wrapper h4.wpb_toggle:hover, .wpb_wrapper #content h4.wpb_toggle:hover,
	.wpb_wrapper .wpb_toggle_title_active, #content .wpb_wrapper h4.wpb_toggle_title_active, .wpb_wrapper #content h4.wpb_toggle_title_active{
    	background-color: <?php echo $main_color_1 ?>;
    	border-color: <?php echo $main_color_1 ?>;
    }
    .woocommerce ul.products li.product .onsale, .woocommerce-page ul.products li.product .onsale,
    .single-product.woocommerce .images span.onsale, .single-product.woocommerce-page .images span.onsale,
    #sidebar .widget_nav_menu  #widget-inner ul li a:hover,
    .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit, .woocommerce #content input.button, .woocommerce-page a.button, 				    .woocommerce-page button.button, .woocommerce-page input.button, .woocommerce-page #respond input#submit, .woocommerce-page #content input.button,
    .woocommerce #review_form #respond .form-submit input, .woocommerce-page #review_form #respond .form-submit input,
    .main-menu.affix .navbar-nav>.current-menu-item>a,
    .main-menu.affix .navbar-nav>.current-menu-item>a:focus,
    #bbpress-forums li.bbp-header,
    #bbpress-forums div.bbp-reply-author .bbp-author-role,
    #bbp-search-form #bbp_search_submit,
    #bbpress-forums #bbp-single-user-details #bbp-user-navigation li:hover,
    #main-nav .main-menu.affix .navbar-nav>li:hover>a{
        background:<?php echo $main_color_1 ?>;
    }
    .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit, .woocommerce #content input.button, .woocommerce-page a.button, 	    
    .woocommerce-page button.button, .woocommerce-page input.button, .woocommerce-page #respond input#submit, .woocommerce-page #content input.button, .woocommerce a.button.alt, 
    .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce #respond input#submit.alt, .woocommerce #content input.button.alt, .woocommerce-page a.button.alt,
    .woocommerce-page button.button.alt, .woocommerce-page input.button.alt, .woocommerce-page #respond input#submit.alt, .woocommerce-page #content input.button.alt, 
    .woocommerce #review_form #respond .form-submit input, .woocommerce-page #review_form #respond .form-submit input{background:<?php echo $main_color_1 ?>;}
    .thumbnail-overlay {
    	background: rgba(<?php echo cactus_hex2rgba($main_color_1,80); ?>);
    }
    
    .event-default-red ,
    .container.cal-event-list .event-btt:hover,
    #calendar-options .right-options ul li ul li:hover, #calendar-options .right-options ul li ul li:hover a,
    #stm-list-calendar .panel-group .panel .panel-heading .panel-title a.collapsed:hover { background:<?php echo $main_color_1 ?> !important;}
    
    .cal-day-weekend span[data-cal-date],
    #cal-slide-content a.event-item:hover, .cal-slide-content a.event-item:hover,
    .container.cal-event-list .owl-controls .owl-prev:hover i:before, 
    .container.cal-event-list .close-button:hover i:before,
    #calendar-options a:hover,
    .container.cal-event-list .owl-controls .owl-next:hover i:before,
    #calendar-options a.active {color:<?php echo $main_color_1 ?> !important;}
    .container.cal-event-list .owl-controls .owl-prev:hover,
    .container.cal-event-list .owl-controls .owl-next:hover,
    .container.cal-event-list .close-button:hover{border-color: <?php echo $main_color_1 ?> !important;}
    #stm-list-calendar .panel-group .panel .panel-heading .panel-title a.collapsed > .arrow-down{border-top: 0px !important; border-left: 10px solid transparent !important;
border-right: 10px solid transparent !important ;}
#stm-list-calendar .panel-group .panel .panel-heading .panel-title a > .arrow-down{border-top: 10px solid <?php echo $main_color_1 ?> !important;}
	#stm-list-calendar .panel-group .panel .panel-heading .panel-title a{
        background-color:<?php echo $main_color_1 ?> !important;
    }
<?php
}//main color 1

if($main_color_2 = ot_get_option('main_color_2')){ ?>
	.main-color-2, .main-color-2-hover:hover{
        color:<?php echo $main_color_2 ?>;
    }
    .main-color-2-bg{
        background-color:<?php echo $main_color_2 ?>;
    }
<?php
}//main color 2
if($footer_bg = ot_get_option('footer_bg')){ ?>
    footer.main-color-2-bg, .un-separator .main-color-2-bg, .main-color-2-bg.back-to-top{
        background-color:<?php echo $footer_bg ?>;
    }
<?php
}//footer_bg

//fonts
if($custom_font_1 = ot_get_option( 'custom_font_1')){ ?>
	@font-face
    {
    	font-family: 'custom-font-1';
    	src: url('<?php echo $custom_font_1 ?>');
    }
<?php }
if($custom_font_2 = ot_get_option( 'custom_font_2')){ ?>
	@font-face
    {
    	font-family: 'custom-font-2';
    	src: url('<?php echo $custom_font_2 ?>');
    }
<?php }
$main_font = ot_get_option( 'main_font', false);
$main_font_family = explode(":", $main_font);
$main_font_family = $main_font_family[0];
$heading_font = ot_get_option( 'heading_font', false);
$heading_font_family = explode(":", $heading_font);
$heading_font_family = $heading_font_family[0];

if($main_font){?>
    body {
        font-family: "<?php echo $main_font_family ?>",sans-serif;
    }
<?php }
if($main_size = ot_get_option( 'main_size' )){ ?>
	body {
        font-size: <?php echo $main_size ?>px;
    }
<?php }
if($heading_font){?>
    h1, .h1, .minion, .content-dropcap p:first-child:first-letter, .dropcap, #your-profile h3, #learndash_delete_user_data h2{
        font-family: "<?php echo $heading_font_family ?>", Times, serif;
    }
<?php }
if($loading_spin_color = ot_get_option( 'loading_spin_color', false)){ ?>
.cube1, .cube2 {
	background:<?php echo $loading_spin_color; ?>
}
<?php }
if($letter_spacing = ot_get_option( 'letter_spacing')){ ?>
body{
	letter-spacing:<?php echo $letter_spacing; ?>
}
<?php }
$letter_spacing_heading = ot_get_option( 'letter_spacing_heading');
if($letter_spacing_heading ==''){ $letter_spacing_heading =0;}?>
h1,h2,h3,h4,h5,h6,.h1,.h2,.h3,.h4,.h5,.h6{
	letter-spacing:<?php echo $letter_spacing_heading; ?>
}
<?php

//custom CSS
echo ot_get_option('custom_css','');