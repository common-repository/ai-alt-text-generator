<?php

class AATG_Text_Generator_Restpoint {
    private $batch_size = 10;
	private $rewrite_all = false;

    public function __construct() {
		$this->rewrite_all = get_option('aatg_text_generator_options')['all_alt_text'];
        add_action('rest_api_init', array($this, 'register_rest_routes'));
        add_action('ai_process_media_batch', array($this, 'process_media_batch'), 10, 1);
    }

    public function register_rest_routes() {
        register_rest_route('ai-alt-text-generator/v1', '/start-processing', array(
            'methods' => 'POST',
            'callback' => array($this, 'start_processing'),
            'permission_callback' => function() {
                return current_user_can('manage_options');
            },
        ));
    }

    public function start_processing(WP_REST_Request $request) {
        wp_schedule_single_event(time(), 'ai_process_media_batch', array($this->batch_size));
        return new WP_REST_Response(array('status' => 'scheduled'), 200);
    }



	public function process_media_batch($batch_size) {

		$args = array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'posts_per_page' => $batch_size,
		);

		// If not rewriting all, fetch images without alt text
		if ( ! $this->rewrite_all ) {
			$ids = $this->get_images_without_alt_text_ids();
			if (empty($ids)) {
				return;
			}
			$args['post__in'] = $ids;
		}
	
		$media_items = get_posts($args);
	
		if (empty($media_items)) {
			return;
		}

		$admin_instance = AATG_Text_Generator_Admin::get_instance();

		foreach ($media_items as $item) {
			$image_url = $admin_instance->get_image_url_by_size($item->ID, 'thumbnail');
			$alt_text = $admin_instance->generate_alt_text_with_openai($image_url);
	
			if ($alt_text) {
				update_post_meta($item->ID, '_wp_attachment_image_alt', $alt_text);
			} else {
				error_log('Failed to generate alt text for media ID: ' . $item->ID);
			}
		}
	
		wp_schedule_single_event(time() + 60, 'ai_process_media_batch', array($batch_size));
	}

	private function get_images_without_alt_text_ids() {
		global $wpdb;

		$query = "
			SELECT p.ID
			FROM {$wpdb->posts} p
			LEFT JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id AND pm.meta_key = '_wp_attachment_image_alt'
			WHERE p.post_type = 'attachment'
			AND p.post_mime_type LIKE 'image%'
			AND (pm.meta_value IS NULL OR pm.meta_value = '')
		";

		$results = $wpdb->get_results($query);
		$ids = array_map(function($result) {
			return $result->ID;
		}, $results);

		return $ids;
	}
	
}

// Initialize the class
new AATG_Text_Generator_Restpoint();
