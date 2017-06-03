<?php
$the_query = new WP_Query('post_type=banner&posts_per_page=-1');
$loop = 0;
if ( $the_query->have_posts() ) {
    while ( $the_query->have_posts() ) {
        $the_query->the_post();
        $image = get_field('image');
		?>
        <a href='<?=get_field('url');?>' target='_blank' <? if($loop > 0){?>style='display: none'<?php } ?>>
            <img
                <?php if ($loop == 0) { ?>src='<?=$image['url'];?>' <?php } 
						else{
							?>
							 src="#"
					
						<? }?>
						
                    data-src='<?=$image['url'];?>'
					alt='<?=$image['alt'];?>'
                />
        </a>
        <?php
        $loop++;
    }
}
wp_reset_postdata();
