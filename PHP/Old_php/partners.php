<div class="footPartners">
    <a class="arrow-left" href="#"></a>
    <a class="arrow-right" href="#"></a>
    <div class="swiper-container">
        <div class="swiper-wrapper">
        <?php
            $the_query = new WP_Query('post_type=partners&posts_per_page=-1');
            $loop = 0;
            if ( $the_query->have_posts() ) {
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    $image = get_field('image');?>
                    <a class='swiper-slide' href="<?=get_field('url');?>" target="_blank">
                        <img 
                            data-src="<?=$image['url'];?>"
                            <?php if($loop < 4) { ?>src="<?=$image['url'];?>" <? } ?>
                            alt="<?=get_the_title();?>"
                            >
                    </a>
                    <?php
                    $loop++;
                }
            }
            wp_reset_postdata();
            ?>
        </div>
    </div>
    <div class="pagination"></div>
</div>
