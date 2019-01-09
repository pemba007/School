<div class="member-item">
	<div class="row">
    	<div class="col-md-4 col-xs-5">
        	<div class="content-pad">
                <div class="item-thumbnail">
                    <?php echo get_the_post_thumbnail( get_the_ID(), 'thumb_263x263' ); ?>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-xs-7">
        	<div class="content-pad">
                <div class="item-content">
                    <h3 class="item-title"><?php  the_title_attribute() ?></h3>
                    <h4 class="small-text"><?php echo get_post_meta( get_the_ID(),'u-member-pos', true ); ?></h4>
                    <p><?php  if (has_excerpt()){ echo get_the_excerpt(); }?></p>
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
            </div><!--/content-pad-->
        </div>
    </div><!--/row-->
</div><!--/member-item-->
<div class="pure-content">
	<div class="content-pad">
		<p><?php echo get_the_content(); ?></p>
    </div>
</div><!--/pure-content-->
