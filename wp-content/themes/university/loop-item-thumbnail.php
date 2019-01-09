<?php 
// blog loop item's thumbnail
$format = get_post_format();
global $no_thumbnail;
$no_thumbnail = 0;
if($format == 'gallery'){ ?>
<div class="item-thumbnail-gallery">
	<?php $images=get_children('post_type=attachment&numberposts=10&post_mime_type=image&post_parent='.get_the_ID());
    if(count($images) > 0){ ?>
        <div class="is-carousel single-carousel post-gallery content-image" id="post-gallery-<?php the_ID() ?>">
            <?php
            foreach((array)$images as $attachment_id => $attachment){
                $image = wp_get_attachment_image_src( $attachment_id, 'thumb_409x258' ); ?>
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <div class='item-thumbnail'>
                    <img src='<?php echo $image[0] ?>'>
                    <div class='thumbnail-hoverlay main-color-1-bg'></div>
                    <div class='thumbnail-hoverlay-cross'></div>
                </div>
                </a>
            <?php } ?>
        </div><!--/is-carousel-->
    <?php }else{ ?>
    	<div class="item-thumbnail">
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php if(has_post_thumbnail()){
					$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'thumb_409x258', true); ?>
					<img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
                    <div class="thumbnail-hoverlay main-color-1-bg"></div>
                    <div class="thumbnail-hoverlay-cross"></div>
				<?php }else{
					$no_thumbnail = 1;
				}?>
            </a>
        </div>
    <?php } ?>
</div>
<?php }elseif($format=='video' && !is_search()){
	global $post;
	$has_video = 0;
	preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $post->post_content, $match);
	foreach($match[0] as $amatch){
		if (strpos($amatch,'youtube.com') !== false || strpos($amatch,'vimeo.com') !== false) { ?>
			<div class="item-thumbnail-video">
            	<div class="item-thumbnail-video-inner">
            	<?php echo wp_oembed_get($amatch); ?>
                </div>
            </div>
            <?php $has_video = 1;
			break;
		}
	}
	if(!$has_video){ ?>
    	<div class="item-thumbnail">
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php if(has_post_thumbnail()){
					$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'thumb_409x258', true); ?>
					<img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
               		<div class="thumbnail-hoverlay main-color-1-bg"></div>
                	<div class="thumbnail-hoverlay-cross"></div>
				<?php }else{
					$no_thumbnail = 1;
				}?>
            </a>
        </div>
	<?php }
}else{ ?>
<div class="item-thumbnail">
    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
        <?php if(has_post_thumbnail()){
			$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'thumb_409x258', true); ?>
			<img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
        	<div class="thumbnail-hoverlay main-color-1-bg"></div>
        	<div class="thumbnail-hoverlay-cross"></div>
		<?php }else{
			$no_thumbnail = 1;
		}?>
    </a>
</div>
<?php } ?>
<?php if(!$no_thumbnail){ ?>
<div class="thumbnail-overflow">
    <?php if(comments_open()){ ?>
    <div class="comment-block main-color-1-bg dark-div">
        <a href="<?php the_permalink(); ?>#comment" title="<?php _e('View comments','cactusthemes'); ?>">
            <i class="fa fa-comment"></i> <?php echo get_comments_number(); ?>
        </a>
    </div>
    <?php }
	if(is_tax('u_event_cat') || is_tax('u_event_tags') || get_post_type( get_the_ID() ) =='u_event'){
		$startdate = get_post_meta(get_the_ID(),'u-startdate', true );
		$all_day = get_post_meta(get_the_ID(),'all_day', true );
		if($startdate){
			$startdate = gmdate("Y-m-d\TH:i:s\Z", $startdate);// convert date ux
			$con_date = new DateTime($startdate);
			$month = $con_date->format('M');
			$day = $con_date->format('d');
			$year = $con_date->format('Y');
			$start_datetime = $con_date->format(get_option('time_format'));
		}
		?>
    	<div class="date-block main-color-2-bg dark-div">
            <div class="year" style="display:none"><?php echo $year; ?></div>
            <div class="month"><?php echo date_i18n( 'M', strtotime( $startdate ) ); ?></div>
            <div class="day"><?php echo $day; ?></div>
        </div>
    <?php }else{?>
        <div class="date-block main-color-2-bg dark-div">
            <div class="month"><?php the_time( 'M' ); ?></div>
            <div class="day"><?php the_time( 'd' ); ?></div>
        </div>
    <?php }?>
</div>
<?php } ?>