<?php 
/** Added all post type
*/
class backaddon_pro_Post_Type{
	public function __construct(){
		$this->load_post_type();
	}

	public function load_post_type(){	
		require plugin_dir_path( __FILE__ ). '/testimonial/testimonial.php';
	}
	
}
new backaddon_pro_Post_Type();
