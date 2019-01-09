<?php 
/*
 *  Single Member
 */
get_header();
$content_padding = get_post_meta(get_the_ID(),'member-ctpadding',true);
$layout = get_post_meta(get_the_ID(),'member-sidebar',true);
if(function_exists('cop_get') && $layout==''){
	$layout =  cop_get('u_member_settings','u-member-layout');
} 

?>
	<?php
	get_template_part( 'header', 'heading' ); ?>
    <div id="body">
    	<div class="container">
        	<?php if($content_padding!='off'){ ?>
        	<div class="content-pad-3x">
            <?php }?>
        	<div class="content-pad-3x">
                <div class="row">
                    <div id="content" class="<?php echo ($layout != 'full' )?'col-md-9':'col-md-12' ?><?php echo ($layout == 'left') ? " revert-layout":"";?>">
                    <?php 
						if (have_posts()) :
							while (have_posts()) : the_post();?>
                            <article class="single-event-content">
                                <?php get_template_part('u-member/member-content'); ?>
                                <?php get_template_part('u-member/member-course'); ?>
                            </article>
							<?php 
							endwhile;
						endif;
						?>
                    </div><!--/content-->
                    <?php if($layout!='full'){ get_sidebar(); } ?>
                </div><!--/row-->
            <?php if($content_padding!='off'){ ?>
            </div><!--/content-pad-3x-->
            <?php }?>
        </div><!--/container-->
    </div><!--/body-->
<?php get_footer(); ?>