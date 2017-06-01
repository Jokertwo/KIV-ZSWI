<?php
$the_query = new WP_Query('post_type=carousel&posts_per_page=-1');
$loop = 0;
if ( $the_query->have_posts() ) {
    ?>
    <div class="device">
        <a class="arrow-left" href="#"></a>
        <a class="arrow-right" href="#"></a>
        <div class="swiper-container">
            <div class="swiper-wrapper">
            <?php
                $loop = 0;
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    $image = get_field('image');?>
                    <div class="swiper-slide">
                        <a href='<?=get_field('url');?>'>
                            <img
                                <?php if ($loop == 0) { ?>src="<?=$image['url'];?>"<?php } ?>
                                data-src="<?=$image['url'];?>"
                                alt='<? the_title();?>'
                                >
                        </a>
                    </div>
                <?php
                    $loop++;
                    }
                ?>
            </div>
        </div>
        <div class="pagination"></div>
    </div>
    <?php
}
wp_reset_postdata();
