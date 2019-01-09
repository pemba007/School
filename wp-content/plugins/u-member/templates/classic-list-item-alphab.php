<div class="member-item col-md-4">
	<div class="member-item-inner">
        <div class="item-thumbnail">
        <?php global $id_mb;global $exc_mb;?>
            <a href="<?php echo get_permalink( $id_mb); ?>" title="<?php  echo get_the_title($id_mb);?>">
                <?php echo get_the_post_thumbnail( $id_mb, 'thumb_526x526' ); ?>
            </a>
        </div>
        <div class="item-content">
            <h3 class="item-title"><a href="<?php echo get_permalink($id_mb) ?>" title="title" class="main-color-1-hover"><?php echo get_the_title($id_mb); ?></a></h3>
            <h4 class="small-text"><?php echo get_post_meta( get_the_ID(),'u-member-pos', true ); ?></h4>
            <p><?php echo $exc_mb; ?></p>
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
			if($link = get_post_meta($id_mb,'umb-'.$social, true )){
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