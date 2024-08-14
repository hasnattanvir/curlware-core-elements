<?php
class back_Testimonial_pro_Post_Type {
	public function __construct() {
		add_action( 'init', array( $this, 'back_testimonial_register_post_type' ) );		
		add_action( 'init', array( $this, 'back_testimoanl_create_taxonomy' ) );		
		add_action( 'admin_menu', array( $this, 'back_testimonials_meta_box' ) );		
		add_action( 'save_post', array( $this, 'back_save_testimonials_meta' ) );
	}

	function back_testimonial_register_post_type() {
		$labels = array(
			'name'               => esc_html__( 'Testimonial', 'carlware'),
			'singular_name'      => esc_html__( 'Testimonial', 'carlware'),
			'add_new'            => esc_html__( 'Add New Testimonial', 'carlware'),
			'add_new_item'       => esc_html__( 'Add New Testimonial', 'carlware'),
			'edit_item'          => esc_html__( 'Edit Testimonial', 'carlware'),
			'new_item'           => esc_html__( 'New Testimonial', 'carlware'),
			'all_items'          => esc_html__( 'All Testimonial', 'carlware'),
			'view_item'          => esc_html__( 'View Testimonial', 'carlware'),
			'search_items'       => esc_html__( 'Search Testimonials', 'carlware'),
			'not_found'          => esc_html__( 'No Testimonials found', 'carlware'),
			'not_found_in_trash' => esc_html__( 'No Testimonials found in Trash', 'carlware'),
			'parent_item_colon'  => esc_html__( 'Parent Testimonial:', 'carlware'),
			'featured_image'     => esc_html__('Author Image'),
			'set_featured_image' => esc_html__('Upload Author Image'),
			'menu_name'          => esc_html__( 'Testimonials', 'carlware'),
		);	
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_in_menu'       => true,
			'menu_icon' 		 => 'dashicons-calendar', // Set your custom icon URL here,
			'show_in_admin_bar'  => true,
			'can_export'         => true,
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => 20,		
			'supports'           => array( 'title', 'thumbnail', 'editor' )
		);
		register_post_type( 'testimonials', $args );
	}

	function back_testimoanl_create_taxonomy() {
		
		register_taxonomy(
			'testimonial-category',
			'testimonials',
			array(
				'label'             => esc_html__( 'Testimonial Categories','carlware'),			
				'hierarchical'      => true,
				'show_admin_column' => true,		
			)
		);
	}

	// Registering metabox

	function back_testimonials_meta_box() {
		add_meta_box(
			'testimonial_info_meta',
			esc_html__( 'Author Info', 'carlware' ),
			array( $this, 'back_testimonials_meta_callback' ),
			array( 'testimonials', 'advanced', 'high', 1 )
		);		
	}

	// Testimonial info callback
	function back_testimonials_meta_callback( $testimonial_info ) {
		wp_nonce_field( 'testimonial_social_metabox', 'testimonial_social_metabox_nonce' );

		$time = get_post_meta( $testimonial_info->ID, 'time', true );
		$name = get_post_meta( $testimonial_info->ID, 'name', true );
		$subname = get_post_meta( $testimonial_info->ID, 'subname', true );
		?>
		<div class="carlware-admin-input">
			<label for="time"><?php esc_html_e( 'Time', 'cl-testimonial' ) ?></label>
			<input type="text" name="time" id="time" class="time" value="<?php echo esc_html($time); ?>"/>
		</div>
		<div class="carlware-admin-input">
			<label for="name"><?php esc_html_e( 'Name', 'cl-testimonial' ) ?></label>
			<input type="text" name="name" id="name" class="name" value="<?php echo esc_html($name); ?>"/>
		</div>
		<div class="carlware-admin-input">
			<label for="subname"><?php esc_html_e( 'Subname', 'cl-testimonial' ) ?></label>
			<input type="text" name="subname" id="subname" class="subname" value="<?php echo esc_html($subname); ?>"/>
		</div>
	<?php }

	/*--------------------------------------------------------------
	 * Save testimonial social meta
	 *-------------------------------------------------------------*/
	function back_save_testimonials_meta( $post_id ) {
		if ( ! isset( $_POST['testimonial_social_metabox_nonce'] ) ) {
			return $post_id;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if ( 'clt_testimonials' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		if( isset($_POST['time']) ) {
			update_post_meta( $post_id, 'time', sanitize_text_field($_POST['time']) );
		}
		
		if( isset($_POST['name']) ) {
			update_post_meta( $post_id, 'name', sanitize_text_field($_POST['name']) );
		}
		
		if( isset($_POST['subname']) ) {
			update_post_meta( $post_id, 'subname', sanitize_text_field($_POST['subname']) );
		}
	}
}
new back_Testimonial_pro_Post_Type();
