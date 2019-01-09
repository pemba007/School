<div class="member-item <?php global $layout; echo ($layout != 'full' && $layout != 'true-full')?'col-md-4':'col-md-3' ?>">
	<div class="member-item-inner">
        <div class="item-thumbnail">
            <a href="<?php echo get_permalink( get_the_ID()); ?>" title="<?php the_title_attribute()?>">
                <?php if(has_post_thumbnail(get_the_ID())){
					echo get_the_post_thumbnail( get_the_ID(), 'thumb_526x526' );
				}else{
					$thumbnail = u_get_default_image('blog-square'); ?>
                    <img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
				<?php }?>
            </a>
        </div>
        <div class="item-content">
            <h3 class="item-title"><a href="<?php echo get_permalink(get_the_ID()) ?>" title="title" class="main-color-1-hover"><?php echo the_title_attribute() ?></a></h3>
            <h4 class="small-text"><?php echo get_post_meta( get_the_ID(),'u-member-pos', true ); ?></h4>
            <p><?php echo get_the_excerpt(); ?></p>
			<?php
            $social_account = array(
                'facebook',
                'instagram',
                'envelope',
                'twitter',
                'linkedin',
                'tumblr',
                'google-plus',
                'pinterest',
                'youtube',
                'flickr',
				'github',
				'dribbble',
				'vk',
            );
            ?>
            <ul class="list-inline social-light">
            <?php
			foreach($social_account as $social){
			if($link = get_post_meta(get_the_ID(),'umb-'.$social, true )){
				if($social=='envelope'){ ?>
					<li><a class="btn btn-default social-icon" href="mailto:<?php echo $link ?>"> <i class="fa fa-<?php echo $social ?>"></i></a></li>
				<?php } else{?>
					<li><a class="btn btn-default social-icon" href="<?php echo $link ?>"><i class="fa fa-<?php echo $social ?>"></i></a></li>
			<?php 
					  } 
				}
			} ?>
            </ul>
        </div>
    </div>
</div>