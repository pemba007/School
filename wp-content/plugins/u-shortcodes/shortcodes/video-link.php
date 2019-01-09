<?php
function parse_u_video_link($atts, $content){
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$image = isset($atts['image']) ? $atts['image'] : '';
	$style = isset($atts['style']) ? $atts['style'] : 'fullwidth';
	$width = isset($atts['width']) ? $atts['width'] : '';
	$height = isset($atts['height']) ? $atts['height'] : '';
	$opacity = isset($atts['opacity']) ? $atts['opacity'] : '';
	$hover_opacity = isset($atts['hover_opacity']) ? $atts['hover_opacity'] : '';
	$video_url = isset($atts['video_url']) ? $atts['video_url'] : '#';
	$parallax = isset($atts['parallax']) ? $atts['parallax'] : '1';
	$target = isset($atts['target']) ? $atts['target'] : 'popup';
	$animation_class = '';
	if(isset($atts['css_animation'])){
		$animation_class = $atts['css_animation']?'wpb_'.$atts['css_animation'].' wpb_animate_when_almost_visible':'';
	}
	$animation_delay = isset($atts['animation_delay']) ? $atts['animation_delay'] : 0;
	
	if($target=='popup'){
		wp_enqueue_style( 'lightbox2', get_template_directory_uri() . '/js/colorbox/colorbox.css');
		wp_enqueue_script( 'colorbox', get_template_directory_uri() . '/js/colorbox/jquery.colorbox-min.js', array('jquery'), '', true );
	}
	//display
	
	$banner_image = wp_get_attachment_image_src($image,'full');
	ob_start(); ?>
    <div class="un-video-banner <?php echo 'un-video-banner-'.$ID; echo ' '.$style.' '.$animation_class; ?>" data-delay=<?php echo $animation_delay; ?>>
    	<div class="video-banner-inner dark-div <?php echo $parallax?'is-paralax':''; ?>">
			<a class="overlay text-center <?php echo $target=='popup'?'colorbox-video-banner':'' ?>" href="<?php echo $video_url ?>" <?php echo $target=='blank'?'target="_blank"':'' ?> data-rel="un-video-banner-<?php echo $ID; ?>" data-content=".un-video-banner-<?php echo $ID; ?>" >
            	<div class="overlay-inner">
                    <i class="fa fa-play"></i>
                    <h3 class="h1"><?php echo $content ?></h3>
                </div>
			</a>
        </div>
        <?php if($target=='popup'){ ?>
        <div class="hidden">
            <div class="popup-data dark-div video-banner-popup">
                <?php
					preg_match("/<embed\s+(.+?)>/i", $video_url, $matches_emb); if(isset($matches_emb[0])){ echo $matches_emb[0];}
					preg_match("/<source\s+(.+?)>/i", $video_url, $matches_sou) ;
					preg_match('/\<object(.*)\<\/object\>/is', $video_url, $matches_oj); 
					preg_match('/<iframe.*src=\"(.*)\".*><\/iframe>/isU', $video_url, $matches);
					preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $video_url, $match);
	
					if(!isset($matches_emb[0]) && isset($matches_sou[0])){
						echo $matches_sou[0];
					}else if(!isset($matches_sou[0]) && isset($matches_oj[0])){
						echo $matches_oj[0];
					}else if( !isset($matches_oj[0]) && isset($matches[0])){
						echo $matches[0];
					}else if( !isset($matches[0]) && isset($match[0])){
						foreach ($match as $matc) {
							echo wp_oembed_get($matc[0]);
						}
					}else{
						echo $video_url;
					}
				?>
            </div>
        </div><!--/hidden-->
    	<?php }//if gallery ?>
    </div>
    <style scoped="scoped">
		.un-video-banner-<?php echo $ID; ?> .video-banner-inner{
			<?php if($banner_image){ ?>
			background-image: url(<?php echo $banner_image[0] ?>);
			<?php }
			if($parallax){ ?>
			background-attachment: fixed;
			<?php } ?>
		}
		<?php if($opacity){ ?>
		.un-video-banner-<?php echo $ID; ?> .overlay{
			background:rgba(0,0,0,<?php echo $opacity ?>);
		}
		<?php }
		if($hover_opacity){ ?>
		.un-video-banner-<?php echo $ID; ?>:hover .overlay{
			background:rgba(0,0,0,<?php echo $hover_opacity ?>);
		}
		<?php }
		if($width && $style!='fullwidth'){ ?>
		.un-video-banner-<?php echo $ID.'.'.$style; ?>{
			width: <?php echo $width ?>px;
		}
		<?php } ?>
		<?php if($height){ ?>
		.un-video-banner-<?php echo $ID.'.'.$style; ?> .video-banner-inner{
			height: <?php echo $height ?>px;
		}
		<?php } ?>
	</style>
    <?php
	//return
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'u_video_link', 'parse_u_video_link' );
add_action( 'after_setup_theme', 'reg_u_video_link' );
function reg_u_video_link(){
	if(function_exists('vc_map')){
		/* Register shortcode with Visual Composer */
		vc_map( array(
		   "name" => __("Video Banner",'cactusthemes'),
		   "base" => "u_video_link",
		   "class" => "",
		   "controls" => "full",
		   "category" => 'Content',
		   "icon" => "icon-video-banner",
		   "params" => array(
			  array(
				 "type" => "attach_image",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Image", 'cactusthemes'),
				 "param_name" => "image",
				 "value" => "",
				 "description" => __('Select image for the banner','cactusthemes'),
			  ),
			  array(
				 "type" => "dropdown",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Style", "cactusthemes"),
				 "param_name" => "style",
				 "value" => array(
					__('Fullwidth', 'cactusthemes') => 'fullwidth',
					__('Boxed', 'cactusthemes') => 'boxed',
				 ),
				 "description" => __('Select style for the banner','cactusthemes'),
			  ),
			  array(
				"type" => "textfield",
				"heading" => __("Width", "cactusthemes"),
				"param_name" => "width",
				"value" => "",
				"description" => __("(number) Width of banner in pixels, only work with Boxed style", "cactusthemes"),
			  ),
			  array(
				"type" => "textfield",
				"heading" => __("Height", "cactusthemes"),
				"param_name" => "height",
				"value" => "",
				"description" => __("(number) Height of banner in pixels", "cactusthemes"),
			  ),
			  array(
				"type" => "textfield",
				"heading" => __("Text", "cactusthemes"),
				"param_name" => "content",
				"value" => "",
				"description" => __("Text that appears on banner", "cactusthemes"),
			  ),
			  array(
				"type" => "textfield",
				"heading" => __("Opacity", "cactusthemes"),
				"param_name" => "opacity",
				"value" => "",
				"description" => __("Value of opacity layer, from 0 to 0.99", "cactusthemes"),
			  ),
			  array(
				"type" => "textfield",
				"heading" => __("Hover Opacity", "cactusthemes"),
				"param_name" => "hover_opacity",
				"value" => "",
				"description" => __("Value of opacity layer when hovering, from 0 to 0.99", "cactusthemes"),
			  ),
			  array(
				"type" => "textfield",
				"heading" => __("Video URL", "cactusthemes"),
				"param_name" => "video_url",
				"value" => "",
				"description" => __("URL of the video", "cactusthemes"),
			  ),
			  array(
				 "type" => "dropdown",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Parallax", "cactusthemes"),
				 "param_name" => "parallax",
				 "value" => array(
					__('Yes', 'cactusthemes') => '1',
					__('No', 'cactusthemes') => '0',
				 ),
				 "description" => __('Enable parallax effect','cactusthemes'),
			  ),
			  array(
				 "type" => "dropdown",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("URL Target", "cactusthemes"),
				 "param_name" => "target",
				 "value" => array(
					__('Popup', 'cactusthemes') => 'popup',
					__('Current', 'cactusthemes') => 'current',
					__('Open in New Tab', 'cactusthemes') => 'blank',
				 ),
				 "description" => __('Choose link target','cactusthemes'),
			  ),
		   )
		) );
	}
}