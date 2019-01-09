<?php 
/*
 *  Single Event
 */
get_header();
$content_padding = get_post_meta(get_the_ID(),'course-ctpadding',true);

$course_layout = get_post_meta(get_the_ID(),'course-sidebar',true);
if(function_exists('cop_get') && $course_layout=='def'){
	$course_layout =  cop_get('u_course_settings','u-course-layout');
} 
?>
	<?php get_template_part( 'header', 'heading' ); ?>
    <div id="body">
    	<div class="container">
        	<?php if($content_padding!='off'){ ?>
        	<div class="content-pad-3x">
            <?php }?>
                <div class="row">
                    <div id="content" class="<?php echo ($course_layout != 'full' )?'col-md-9':'col-md-12' ?><?php echo ($course_layout == 'left') ? " revert-layout":"";?>">
                    <?php 
						if (have_posts()) :
							while (have_posts()) : the_post();?>
							<article class="row single-event-content">
								<div class="col-md-4 col-sm-5">
									<?php get_template_part( 'u-course/single', 'course-meta' ); ?>
								</div>
								<div class="col-md-8 col-sm-7">
									<?php get_template_part( 'u-course/single', 'course-detail' ); ?>
									<?php //comments_template( '', true ); ?>
								</div>
							</article>
							<?php 
							endwhile;
						endif;
						?>
                    </div><!--/content-->
                    <?php if($course_layout!='full'){ get_sidebar(); } ?>
                </div><!--/row-->
            <?php if($content_padding!='off'){ ?>
            </div><!--/content-pad-3x-->
            <?php }?>
        </div><!--/container-->
    </div><!--/body-->
<?php get_footer(); ?>