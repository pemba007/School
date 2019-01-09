<div class="event-listing un-grid-listing">
    <div class="grid-listing-wrap">
        <div class="grid-listing">
            <?php 
			//global $the_query;
			if (have_posts() ) : 
				 while (have_posts() ) : the_post();
			//loop here
					get_template_part('u-event/grid','list-item');?>
              	<?php endwhile; ?>
            <?php endif; ?>
        </div>
			<?php if(function_exists('wp_pagenavi')){
                wp_pagenavi();
            }else{
                cactusthemes_content_nav('paging');
            }?>
    </div>
</div><!--/un-grid-listing-->