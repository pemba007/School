<?php
if(function_exists('cop_get')){
	$slug_pt =  cop_get('u_event_settings','uevent-slug');
	$filter =  cop_get('u_event_settings','uevent-filter');
}  
if($slug_pt==''){
	$slug_pt = 'event';
}
ct_filter_order_lis();
if($filter==1){
	ct_filter_bar($taxono='u_event_cat',$slug_pt);
}
?>
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