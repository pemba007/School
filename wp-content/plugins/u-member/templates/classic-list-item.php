<div class="member-item col-md-4">
	<div class="member-item-inner">
        <div class="item-thumbnail">
            <a href="<?php echo get_permalink( get_the_ID()); ?>" title="<?php the_title_attribute()?>">
                <?php echo get_the_post_thumbnail( get_the_ID(), 'thumb_526x526' ); ?>
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