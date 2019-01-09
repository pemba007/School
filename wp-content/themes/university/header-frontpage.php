<?php
$header_background_style = get_post_meta(get_the_ID(),'header_background_style',true);
$header_background_image = get_post_meta(get_the_ID(),'header_background_image', true);
$header_background_rev = get_post_meta(get_the_ID(),'header_background_rev',true);
$header_background_rev_style = get_post_meta(get_the_ID(),'header_background_rev_style',true);
$header_custom_height = get_post_meta(get_the_ID(),'header_custom_height',true);
$header_content_style = get_post_meta(get_the_ID(),'header_content_style',true);
//query arg
$posttype = get_post_meta(get_the_ID(),'header_content_posttype',true);
$cat = get_post_meta(get_the_ID(),'header_content_cat',true);
$tag = get_post_meta(get_the_ID(),'header_content_tag',true);
$ids = get_post_meta(get_the_ID(),'header_content_ids',true);
$count = get_post_meta(get_the_ID(),'header_content_count',true);
$visible = get_post_meta(get_the_ID(),'header_content_visible',true);
$order = get_post_meta(get_the_ID(),'header_content_order',true);
$orderby = get_post_meta(get_the_ID(),'header_content_orderby',true);
$meta_key = get_post_meta(get_the_ID(),'header_content_meta_key',true);
$show_date = get_post_meta(get_the_ID(),'header_content_show_date',true);
$show_price = get_post_meta(get_the_ID(),'header_content_show_price',true);
$show_venue = get_post_meta(get_the_ID(),'header_content_show_venue',true);
$show_time = get_post_meta(get_the_ID(),'header_content_show_time',true);
$link_text = get_post_meta(get_the_ID(),'header_content_link_text',true);
$link_url = get_post_meta(get_the_ID(),'header_content_link_url',true);
if(($header_custom_height=='' && $header_background_image!='' && $header_background_style=='img') || ($header_custom_height=='' && $header_background_rev!='' && $header_background_style=='rev') || ($header_custom_height=='' && is_active_sidebar( 'frontpage_sidebar' ) && $header_background_style=='sidebar')){
	$header_custom_height = 400;
}
if($header_background_style!=''){
?>
		<div id="slider" class="<?php echo 'header-bg-'.$header_background_style.' header-content-'.$header_content_style; if(isset($header_background_image['background-attachment'])){ echo $header_background_image['background-attachment']=='fixed'?' is-paralax':'';}?>">
        <?php
		if($header_background_style=='rev'){
			if( $header_background_rev ){
				echo $header_background_rev_style=='on'?'<div class="cactus-rev-slider-default">':'';
				echo do_shortcode('[rev_slider '.$header_background_rev.']');
				echo $header_background_rev_style=='on'?'</div>':'';
			}
		}elseif($header_background_style=='sidebar'){
			if ( is_active_sidebar( 'frontpage_sidebar' ) ) :
			$maintop_layout = ot_get_option('frontpage_sidebar','full');	
			if($maintop_layout=='boxed'){ ?>
            <div class="container">
            <?php } ?>
                <?php dynamic_sidebar( 'frontpage_sidebar' ); ?>
            <?php if($maintop_layout=='boxed'){ ?>
            </div><!--/container-->
            <?php } ?>
            <?php endif;
		} //else $header_style
		if($header_content_style=='scroller'){ ?>
        	<div class="header-overlay-content header-overlay-scroller">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5">
                        <?php echo do_shortcode('[u_post_scroller post_type="'.$posttype.'" count="'.$count.'" visible="'.$visible.'" order="'.$order.'" orderby="'.$orderby.'" cat="'.$cat.'" tag="'.$tag.'" ids="'.$ids.'" meta_key="'.$meta_key.'" link_text="'.$link_text.'" link_url="'.$link_url.'"]'); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
		}elseif($header_content_style=='carousel'){ ?>
        	<div class="header-overlay-content">
                <div class="container">
				<?php echo do_shortcode('[u_post_carousel post_type="'.$posttype.'" count="'.$count.'" visible="'.$visible.'" order="'.$order.'" orderby="'.$orderby.'" show_date="'.$show_date.'" show_price="'.$show_price.'" show_venue="'.$show_venue.'" show_time="'.$show_time.'" cat="'.$cat.'" tag="'.$tag.'" ids="'.$ids.'" meta_key="'.$meta_key.'"]'); ?>
				</div>
            </div>
        <?php }//if content style ?>
        </div><!--/slider-->
		<style type="text/css" scoped="scoped">
		<?php
		if($header_background_style=='img'){
			if($header_background_image){ ?>
			#slider{
			<?php if($header_background_image['background-color']){ echo 'background-color:'.$header_background_image['background-color'].';';} ?>
			<?php if($header_background_image['background-attachment']){ echo 'background-attachment:'.$header_background_image['background-attachment'].';';} ?>
			<?php if($header_background_image['background-repeat']){
				echo 'background-repeat:'.$header_background_image['background-repeat'].';';
				echo 'background-size: initial;';
			} ?>
			<?php if($header_background_image['background-size']){ echo 'background-size:'.$header_background_image['background-size'].';';} ?>
			<?php if($header_background_image['background-position']){ echo 'background-position:'.$header_background_image['background-position'].';';} ?>
			<?php if($header_background_image['background-image']){ echo 'background-image:url('.$header_background_image['background-image'].');';} ?>
			}
		<?php }
		}//if = img
		if($header_custom_height){ ?>
			#slider{ height:<?php echo $header_custom_height ?>px; }
		<?php } ?>
		</style>
<?php }?>