<?php

include 'components/api.php';
include 'components/radio.php';
include 'components/membership.php';
include 'components/settings-page.php';
include 'components/cron.php';

add_theme_support( 'menus' );
add_theme_support( 'post-thumbnails' );
register_nav_menu( 'main-menu', 'Main menu' );
register_nav_menu( 'top-menu', 'Top menu' );
add_image_size( 'list', 320, 180, true );
add_image_size( 'big', 450, 250, true );

register_sidebar(array(
	'name' => 'Footer',
	'id' => 'footer',
	'before_widget' => '<div id="%1$s" class="col-sm-4 widget %2$s">',
	'after_widget' => '</div>',
	'before_title'  => '<h3 class="widgettitle">',
	'after_title'   => '</h3>'
	));

function addchapter( $content ) {
	ob_start();
    if( have_rows('chapter') ){ ?>
        <div class='clear'></div>
        <p><strong>In this Czech-American TV online Broadcast you will see:</strong></p>
        <?php while( have_rows('chapter') ): the_row();
			$image = get_sub_field('image');
			
        	?>
            <img src='<?php echo $image;?>' class='alignleft' />
            <?php the_sub_field('description');?>
            <div class='clear'></div>
        <?php endwhile; ?>
        <p><strong>Stay tune! New Weekly Broadcasts are on Monday/Tuesday at www.catvusa.com</strong></p>
    <?php }
    $chapter = ob_get_contents();
    ob_end_clean();
    $content = $content . $chapter;
    return $content;
}

function my_formatter($content) {
	$new_content = '';
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

	foreach ($pieces as $piece) {
		if (preg_match($pattern_contents, $piece, $matches)) {
			$new_content .= $matches[1];
		} else {
			$new_content .= wptexturize(wpautop($piece));
		}
	}

	return $new_content;
}

remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');
add_filter('the_content', 'my_formatter', 99);
add_filter( 'the_content', 'addchapter' );

function myfeed_request($qv) {
    if (isset($qv['feed']) && !isset($qv['post_type']))
        $qv['post_type'] = array('post', 'broadcast');
    return $qv;
}
add_filter('request', 'myfeed_request');


function add_custom_types_to_tax( $query ) {
	if( (is_category() || is_tag()) && $query->is_category() ) {
		$post_types = array("post", "class");
		$query->set( 'post_type', $post_types );
		return $query;
		}
}
add_filter( 'pre_get_posts', 'add_custom_types_to_tax' );


function main_script_enqueuer() {
		wp_register_script( "swiper", get_template_directory_uri() . '/swiper/idangerous.swiper.js', array('jquery') );
		wp_enqueue_script('swiper');
		wp_register_script( "jwplayer", get_template_directory_uri() . '/jwplayer/jwplayer.js', array('jquery') );
		wp_enqueue_script('jwplayer');
		wp_register_script( "main", get_template_directory_uri() . '/js/main.js', array('jquery') );
		wp_enqueue_script('main');
		wp_register_style( 'swiper', get_template_directory_uri() . '/swiper/idangerous.swiper.css' );
		wp_enqueue_style( 'swiper' );
		wp_register_script( "bootstrap", get_template_directory_uri() . '/bootstrap/bootstrap.js', array('jquery') );
		wp_enqueue_script('bootstrap');
}

add_action('init', 'main_script_enqueuer');

function pagging($wp_query){
	ob_start();
	$pocetStranek = ceil($wp_query->found_posts / get_settings('posts_per_page'));
		if ($pocetStranek > 1) { ?>
		<ul class="pagination"><?
			$aktualniStranka = absint(get_query_var('paged'));
			if ($aktualniStranka == 0){
					$aktualniStranka = 1;
				}
			if ($aktualniStranka != 1){
					echo "<li><a href='" . get_pagenum_link($aktualniStranka - 1) . "'>&laquo;</a></li>";
				}
				for ($i = 1; $i <= $pocetStranek; $i++) {
						if ((($i >= ($aktualniStranka - 4)
										and $i < $aktualniStranka)
										or ($i > $aktualniStranka and $i <= ($aktualniStranka + 4))
										or ($i == $pocetStranek and $index == ($i - 1)))
										and $i != $aktualniStranka) {
								$index = $i;
								echo "<li><a href='" . get_pagenum_link($i) . "'>$i</a></li> ";
						} elseif ($i == $aktualniStranka) {
								$index = $i;
								echo "<li class='active'><a href='" . get_pagenum_link($i) . "'>$i</a></li> ";
						} elseif ($i == 1 and !$index == 1) {
								echo "<li><a href='" . get_pagenum_link(1) . "'>1...</a></li> ";
						} elseif ($i == $pocetStranek AND $index < $pocetStranek) {
								echo "<li><a href='" . get_pagenum_link($pocetStranek) . "'>...$pocetStranek</a></li> ";
						}
				}
				if ($aktualniStranka != $pocetStranek)
						echo "<li><a href='" . get_pagenum_link($aktualniStranka + 1) . "'>»</a></li>";
		?></ul><?
		}
	$html = ob_get_contents();
	ob_end_clean();
	return $html;
}


function our_team_func( $atts ) {
	extract( shortcode_atts( array(

	), $atts ) );
		ob_start();
		include 'parts/our-team.php';
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
}
add_shortcode( 'our_team', 'our_team_func' );


function customCookingOrder($query) {
    if ($query->is_post_type_archive('cooking')) {
        $query->set('orderby', 'menu_order');
    }
}

add_action('pre_get_posts', 'customCookingOrder');

add_action('cronForSnuffleCooking', 'snuffleCooking');
 
function crn_activation() {
    if (!wp_next_scheduled('cronForSnuffleCooking')) {
        wp_schedule_event(time(), 'weekly', 'cronForSnuffleCooking');
        snuffleCooking();
    }
}
 
add_action('wp', 'crn_activation');

function snuffleCooking() {
    foreach(get_posts([
	'posts_per_page' => -1,
	'post_status' => 'publish',
	'post_type' => 'cooking'
	]) as $post) {
    	wp_update_post([
    		'ID' => $post->ID,
    		'menu_order' => rand(0, 100)
    		]);
    }
}