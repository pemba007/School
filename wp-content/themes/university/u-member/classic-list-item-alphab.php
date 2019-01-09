<div class="member-item <?php global $layout; echo ($layout != 'full' && $layout != 'true-full')?'col-md-4':'col-md-3' ?>">
	<div class="member-item-inner">
        <div class="item-thumbnail">
        <?php global $id_mb;global $exc_mb;?>
            <a href="<?php echo get_permalink( $id_mb); ?>" title="<?php  echo get_the_title($id_mb);?>">
                <?php if(has_post_thumbnail($id_mb)){
					echo get_the_post_thumbnail( $id_mb, 'thumb_526x526' );
				}else{
					$thumbnail = u_get_default_image('blog-square'); ?>
                    <img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>">
				<?php }?>
            </a>
        </div>
        <div class="item-content">
            <h3 class="item-title"><a href="<?php echo get_permalink($id_mb) ?>" title="title" class="main-color-1-hover"><?php echo get_the_title($id_mb); ?></a></h3>
            <h4 class="small-text"><?php echo get_post_meta( $id_mb,'u-member-pos', true ); ?></h4>
            <p><?php
				global $post;  
				$save_post = $post;
				$post = get_post($id_mb);
				$output = get_the_excerpt();
				$post = $save_post;
				echo $output;
			?></p>
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