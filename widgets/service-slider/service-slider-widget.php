<?php
/**
 * Logo widget class
 *
 */
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;

defined( 'ABSPATH' ) || die();

class carlware_Elementor_pro_services_Slider_Widget extends \Elementor\Widget_Base {
    /**
     * Get widget name.
     *
     * Retrieve carlware widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */

    public function get_name() {
        return 'curlware-service-slider';
    }

    /**
     * Get widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */

    public function get_title() {
        return esc_html__( 'Testimonial Slider', 'carlware' );
    }

    /**
     * Get widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-post-slider';
    }


    public function get_categories() {
        return [ 'carlwarecore_category' ];
    }

    public function get_keywords() {
        return [ 'service' ];
    }


    protected function _register_controls() {       

        $this->start_controls_section(
            '_section_logo',
            [
                'label' => esc_html__( 'Slider', 'carlware' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
          'widget___title',
          [
            'label' => esc_html__( 'Title', 'textdomain' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__( 'Wybierz miesiąc: ', 'textdomain' ),
            'placeholder' => esc_html__( 'Type your title here', 'textdomain' ),
          ]
        );


        $this->end_controls_section();
    }

    protected function render() {
      $settings = $this->get_settings_for_display();
        ?>
            <div class="acamedia-unique-slider-wrapper">
                <?php
                    // Get all categories for the 'testimonial' custom post type
                    $categories = get_terms(array(
                        'taxonomy' => 'testimonial-category', // Replace with your actual taxonomy
                        'hide_empty' => true,
                    ));

                if (!is_wp_error($categories) && !empty($categories)) {
                ?>
                <!-- Slider One -->
                <div class="curlware-academia-select-slider">

                    <div class="select-testimonial-items">
                      <div class="heading">
                        <h4 class="title"><?php echo esc_html( $settings['widget___title'] ); ?></h4>
                      </div>
                        <div class="carlware-selct-contain">
                          <div class="selecte-wrap">
                            <select id="category-selector" onchange="displaySelectedValue()">
                                <option value="all"><?php echo esc_html__('All Categories', 'carlware'); ?></option>
                                <?php foreach ($categories as $category) { ?>
                                    <option id="select-title" value="<?php echo esc_attr($category->term_id); ?>">
                                        <?php echo esc_html($category->name); ?>
                                    </option>
                                <?php } ?>
                            </select>
                          </div>
                            <div class="select-icon">
                              <svg width="12" height="17" viewBox="0 0 12 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.46967 16.5303C5.76256 16.8232 6.23744 16.8232 6.53033 16.5303L11.3033 11.7574C11.5962 11.4645 11.5962 10.9896 11.3033 10.6967C11.0104 10.4038 10.5355 10.4038 10.2426 10.6967L6 14.9393L1.75736 10.6967C1.46447 10.4038 0.989593 10.4038 0.6967 10.6967C0.403806 10.9896 0.403806 11.4645 0.6967 11.7574L5.46967 16.5303ZM5.25 3.27835e-08L5.25 16L6.75 16L6.75 -3.27835e-08L5.25 3.27835e-08Z" fill="#1F2F2F"/>
                                </svg>
                            </div>

                        </div>
                    </div>
                </div>

                
                <!-- Category Title -->
                <div class="category-title-container">
                  <h3 id="selected-category-title"></h3>
                </div>
                
                <?php }?>
               
                <?php  $unique = rand(2012,35120); ?>
                <!-- Slider Two -->
                <div id="academia-slick-slider" class="academia-addon-slider">
                    <?php
                    $best_wp = new wp_Query(array(
                        'post_type' => 'testimonials',
                        'order' => 'ASC',
                        'posts_per_page' => -1,
                    ));
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
                    wp_reset_query();
                    ?>
                </div>
                <!-- Slider Two End -->
            </div>

            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    function initializeSlider() {
                        $('#academia-slick-slider').not('.slick-initialized').slick({
                            slidesToShow: 3,
                            centerMode: true,
                            arrows: true,
                            autoplay: false,
                            slidesToScroll: 1,
                            centerPadding: '15px',
                            autoplaySpeed: 3000,
                            loop: true,
                            vertical: true,
                            prevArrow: '<button type="button" class="slick-custom-arrow slick-prev"> <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.469669 5.46967C0.176777 5.76256 0.176777 6.23744 0.469669 6.53033L5.24264 11.3033C5.53553 11.5962 6.01041 11.5962 6.3033 11.3033C6.59619 11.0104 6.59619 10.5355 6.3033 10.2426L2.06066 6L6.3033 1.75736C6.59619 1.46447 6.59619 0.989592 6.3033 0.696698C6.01041 0.403805 5.53553 0.403805 5.24264 0.696698L0.469669 5.46967ZM17 5.25L1 5.25L1 6.75L17 6.75L17 5.25Z" fill="#1F2F2F"/></svg></button>',
                            nextArrow: '<button type="button" class="slick-custom-arrow slick-next"> <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.5303 6.53033C16.8232 6.23744 16.8232 5.76256 16.5303 5.46967L11.7574 0.696699C11.4645 0.403806 10.9896 0.403806 10.6967 0.696699C10.4038 0.989593 10.4038 1.46447 10.6967 1.75736L14.9393 6L10.6967 10.2426C10.4038 10.5355 10.4038 11.0104 10.6967 11.3033C10.9896 11.5962 11.4645 11.5962 11.7574 11.3033L16.5303 6.53033ZM0 6.75L16 6.75V5.25L0 5.25L0 6.75Z" fill="#1F2F2F"/></svg> </button>'
                        });
                    }

                    // Initialize the slider on page load
                    initializeSlider();

                    // Handle category change
                    $('#category-selector').on('change', function() {
                        var selectedCategory = $(this).val();

                        $.ajax({
                            url: '<?php echo admin_url('admin-ajax.php'); ?>',
                            type: 'POST',
                            data: {
                                action: 'load_testimonial_category',
                                category: selectedCategory
                            },
                            success: function(response) {
                                $('#academia-slick-slider').slick('unslick'); // Remove the existing slider
                                $('#academia-slick-slider').html(response); // Update the slider with new posts
                                initializeSlider(); // Reinitialize the slider
                            }
                        });
                    });
                });


                // Select Value
                function displaySelectedValue() {
                  var selectElement = document.getElementById("category-selector");
                  var selectedValue = selectElement.value;

                  var selectedTexttwo = selectElement.options[selectElement.selectedIndex].text;
                  console.log(selectedTexttwo);

                  // Loop through all options to remove the 'selected' attribute
                  var options = selectElement.options;
                  for (var i = 0; i < options.length; i++) {
                    options[i].removeAttribute("selected");
                  }

                  // Set the 'selected' attribute for the chosen option
                  selectElement.options[selectElement.selectedIndex].setAttribute("selected", "selected");

                  // Display the selected value
                  document.getElementById("selected-category-title").innerText =  selectedTexttwo;
                }

                // Initialize the selected attribute based on the current value (if needed)
                document.addEventListener("DOMContentLoaded", function() {
                  displaySelectedValue();
                }); 
            </script>
        <?php
    }

}