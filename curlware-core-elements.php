<?php 
/**
 *Plugin Name: Carlware Core Elements
 * Description: Back Core Elements is the most advanced frontend drag & drop page builder addon. Create high-end, pixel perfect websites at record speeds. Any theme, any page, any design.
 * Plugin URI:  carlware
 * Version:     1.0.0
 * Author:      carlware
 * Author URI:  carlware
 * Text Domain: carlware-core-elements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


define( 'BACK_CORE_ELEMENTS_DIR_PATH_PRO', plugin_dir_path( __FILE__ ) );
define( 'BACK_CORE_ELEMENTS_DIR_URL_PRO', plugin_dir_url( __FILE__ ) );
define( 'Back_CORE_ELEMENTS_ASSETS_PRO', trailingslashit( BACK_CORE_ELEMENTS_DIR_URL_PRO . 'assets' ) );

require BACK_CORE_ELEMENTS_DIR_PATH_PRO . 'base.php';
require BACK_CORE_ELEMENTS_DIR_PATH_PRO . 'post-type/post-type.php';




add_action('wp_ajax_load_testimonial_category', 'load_testimonial_category');
add_action('wp_ajax_nopriv_load_testimonial_category', 'load_testimonial_category');

function load_testimonial_category() {
    $category_id = sanitize_text_field($_POST['category']);
    
    $args = array(
        'post_type' => 'testimonials',
        'posts_per_page' => 4, // Show all posts
        'order' => 'ASC',
    );

    // If a specific category is selected and not "all"
    if ($category_id !== 'all') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'testimonial-category', // Replace with your actual taxonomy
                'field' => 'term_id',
                'terms' => $category_id,
            ),
        );
    }

    $best_wp = new WP_Query($args);

     if ($best_wp->have_posts()) {
            while ($best_wp->have_posts()): $best_wp->the_post();
                $time = !empty(get_post_meta(get_the_ID(), 'time', true)) ? get_post_meta(get_the_ID(), 'time', true) : '';
                $name = !empty(get_post_meta(get_the_ID(), 'name', true)) ? get_post_meta(get_the_ID(), 'name', true) : '';
                $subname = !empty(get_post_meta(get_the_ID(), 'subname', true)) ? get_post_meta(get_the_ID(), 'subname', true) : '';

                ?>
                <div class="grid-item">
                    <div class="date"><span><?php echo esc_html($time); ?></span></div>
                    <div class="name"><h4><?php echo esc_html($name); ?></h4></div>
                    <div class="author-info">
                      <div class="author-bio">
                        <h3><?php echo esc_html__('Prowadzący:', 'carlware-core-elements'); ?></h3>
                      </div>
                      <div class="author-name">
                        <h4><?php echo esc_html($subname); ?></h4>
                      </div>
                    </div>
                </div>
            <?php endwhile;
        }else{
             echo '<p>' . esc_html__('No testimonials found for the selected category.', 'carlware-core-elements') . '</p>';
        }

    wp_reset_postdata();
    die();
}




