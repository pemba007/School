<div class="content-pad single-event-meta single-course-meta">
	<?php
	$date_format = get_option('date_format');
	$startdate = get_post_meta(get_the_ID(),'u-course-start', true );
	if($startdate){
		$startdate = gmdate("Y-m-d\TH:i:s\Z", $startdate);// convert date ux
		$con_date = new DateTime($startdate);
		$start_datetime = $con_date->format($date_format);
	}
	$id_course = get_post_meta(get_the_ID(),'u-courseid', true );
	$time_duration = get_post_meta(get_the_ID(),'u-course-dur', true );
	$u_credit = get_post_meta(get_the_ID(),'u-course-cre', true );
	$u_dl = get_post_meta(get_the_ID(),'u-course-dl', true );
	$u_sub = get_post_meta(get_the_ID(),'u-course-sub', true );
	$u_label = get_post_meta(get_the_ID(),'u-course-label', true );
	if($u_label==''){$u_label = 'SIGN UP NOW';}
	$u_label_bro = get_post_meta(get_the_ID(),'u-course-label-bro', true );
	if($u_label_bro==''){$u_label_bro = 'DOWNLOAD PROCHURE ';}
	 ?>
    <div class="item-thumbnail">
    	<?php echo get_the_post_thumbnail( get_the_ID(), 'thumb_263x263' ); ?>
    </div><!--/item-thumbnail-->
        <div class="event-description course-des">
        	<p class="course-exc"><?php if(has_excerpt( get_the_ID())){ echo get_the_excerpt();} ?></p>
            <?php if($u_dl){ ?>
        	<p class="course-dl"><a class="btn btn-primary btn-block btn-grey" href="<?php echo $u_dl; ?>"><?php _e($u_label_bro,'cactusthemes');?> <i class="fa fa-angle-right"></i></a></p>
            <?php }?>
            <div class="course-meta">
			<?php if($start_datetime){ ?>
                <?php _e('START:','cactusthemes');?>
                <div class="course-start"><?php echo $start_datetime; ?></div>
            <?php }?>
            <?php if($time_duration){ ?>
                <?php _e('DURATION:','cactusthemes');?>
                <div class="course-start"><?php echo $time_duration; ?></div>
            <?php }?>
            <?php if($id_course){ ?>
                <?php _e('ID:','cactusthemes');?>
                <div class="course-start"><?php echo $id_course; ?></div>
            <?php }?>
            <?php if($u_credit){ ?>
                <?php _e('CREDIT:','cactusthemes'); ?>
                <div class="course-start"><?php echo $u_credit; ?></div>
            <?php }?>
            </div>
        </div>
    <?php if($u_sub){ ?>    
    <div class="event-action course-action">
            <div class="element-pad">
            <a href="<?php echo $u_sub; ?>" class="button medium price-button submit-button left">
            <button class="btn btn-primary btn-lg btn-block"><?php _e( $u_label,'cactusthemes') ?></button>
            </a>
            </div>
    </div>
    <?php }?>
</div>
