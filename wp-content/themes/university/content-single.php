<div class="single-post-content-text content-pad">
	<?php 
	if(get_post_format()=='video' || get_post_format()=='audio'){
		$content =  preg_replace ('#<embed(.*?)>(.*)#is', ' ', get_the_content());
		$content =  preg_replace ('@<iframe[^>]*?>.*?</iframe>@siu', ' ', $content);
		preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $content, $match);
		foreach ($match[0] as $amatch) {
			if(strpos($amatch,'youtube.com') !== false || strpos($amatch,'vimeo.com') !== false || strpos($amatch,'soundcloud.com') !== false){
				$content = str_replace($amatch, '', $content);
			}
		}
		$content = preg_replace('%<object.+?</object>%is', '', $content);
		echo apply_filters('the_content',$content);
	}else{ the_content(); }?>
</div>
<?php
$pagiarg = array(
	'before'           => '<div class="single-post-pagi">'.__( 'Pages: ','cactusthemes'),
	'after'            => '</div>',
	'link_before'      => '<span class="btn btn-default btn-lighter">',
	'link_after'       => '</span>',
	'next_or_number'   => 'number',
	'separator'        => ' ',
	'nextpagelink'     => __( 'Next page','cactusthemes'),
	'previouspagelink' => __( 'Previous page','cactusthemes'),
	'pagelink'         => '%',
	'echo'             => 1
);
wp_link_pages($pagiarg); ?>
<div class="clearfix"></div>
<div class="item-meta single-post-meta content-pad">
	<?php if(ot_get_option('enable_author_info')!='off'){ ?>
    <span><?php _e('By ','cactusthemes'); the_author_link(); echo ' <span class="sep">|</span> '; ?></span>
    <?php }?>
    <?php if(ot_get_option('single_published_date')!='off'){ ?>
    <span><?php the_time(get_option('date_format')); echo ' <span class="sep">|</span> '; ?></span>
    <?php }?>
    <?php if(ot_get_option('single_categories')!='off'){ ?>
    <span><?php the_category(' <span class="dot">.</span> ');?></span>
    <?php }?>
    <?php if(ot_get_option('single_cm_count')!='off'){ ?>
    <?php if(comments_open()){ ?><span class="sep">|</span> <a href="#comment"><?php comments_number(__('0 Comments','cactusthemes'),__('1 Comment','cactusthemes')); ?></a></span><?php } //check comment open?>
    <?php }?>
    <?php if(ot_get_option('single_tags')!='off'){ ?>
    <span class="sep">|</span> <span><?php the_tags(__('Tags: ','cactusthemes'), ', ', ''); ?></span>
    <?php }?>
</div>
<ul class="list-inline social-light">
	<?php cactus_social_share(); ?>
</ul>