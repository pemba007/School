<div <?php post_class('blog-item '.(has_post_thumbnail()?'':' no-thumbnail')) ?>>
    <div class="post-item blog-post-item row">
        <div class="col-md-6 col-sm-12">
            <div class="content-pad">
                <div class="blog-thumbnail">
                    <?php get_template_part('loop','item-thumbnail'); ?>
                </div><!--/blog-thumbnail-->
            </div>
        </div>
        <?php global $no_thumbnail; ?>
        <div class="<?php echo $no_thumbnail?'col-md-12':'col-md-6' ?> col-sm-12">
            <div class="content-pad">
                <div class="item-content">
                    <h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="main-color-1-hover"><?php the_title(); ?></a></h3>
                    <div class="item-excerpt blog-item-excerpt"><?php the_excerpt(); ?></div>
                    <div class="item-meta blog-item-meta">
                        <span><?php _e('By ','cactusthemes'); the_author_link(); echo ' <span class="sep">|</span> '; ?></span>
                        <span><?php the_category(' <span class="dot">.</span> '); ?></span>
                    </div>
                    <a class="btn btn-default btn-lighter" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php _e('DETAIL','cactusthemes') ?> <i class="fa fa-angle-right"></i></a>
                </div>
            </div>
        </div>
    </div><!--/post-item-->
</div><!--/blog-item-->