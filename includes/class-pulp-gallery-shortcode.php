<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

	// Load RSS fallback function
require_once PULP_GALLERY_PATH . 'includes/rss-fallback.php';

class Pulp_Gallery_Shortcode {

    // Register the shortcode
    public static function init() {
        add_shortcode( 'pulp_gallery', [ __CLASS__, 'render_shortcode' ] );
    }

		// Shortcode callback
    public static function render_shortcode( $atts ) {
        global $post;

        if ( ! $post instanceof WP_Post ) {
            return '<div class="pulp-gallery-error">No attachments found for this post.</div>';
        }

        // Default shortcode attributes
        $atts = shortcode_atts([
            'size'      => 'medium',
            'thumbsize' => 'thumbnail',
        ], $atts, 'pulp_gallery' );

         // FAST ATTACHMENT QUERY
        $query = new WP_Query([
            'post_parent'            => $post->ID,
            'post_type'              => 'attachment',
            'post_mime_type'         => 'image',
            'post_status'            => 'any',
            'orderby'                => 'menu_order',
            'order'                  => 'ASC',
            'posts_per_page'         => -1,
            'fields'                 => 'ids',
            'no_found_rows'          => true,
            'update_post_meta_cache' => true,
            'update_post_term_cache' => false,
        ]);

        $image_ids = $query->posts;

        // No attachments found
        if ( empty( $image_ids ) ) {
            return '<div class="pulp-gallery-error">No attachments found for this post.</div>';
        }

        // RSS Feed Failback
        if ( is_feed() ) {
            $feed_atts         = $atts;
            $feed_atts['ids']  = implode( ',', array_map( 'intval', $image_ids ) );
            return pulp_gallery_rss_fallback_from_shortcode( $feed_atts );
        }

        // Build image objects
		
        $images = [];

        foreach ( $image_ids as $id ) {
            $images[] = get_post( $id ); // lightweight, uses cached data
        }

        // Prepare data for template
        $data = [
            'atts'   => $atts,
            'images' => $images,
        ];

        return self::load_template( 'gallery.php', $data );
    }

		//Load a template file and pass variables to it
    private static function load_template( $template_name, $data = [] ) {

        $template_path = PULP_GALLERY_PATH . 'templates/' . $template_name;

        if ( ! file_exists( $template_path ) ) {
            return '<!-- Pulp Gallery template missing: ' . esc_html( $template_name ) . ' -->';
        }

        if ( ! empty( $data ) ) {
            extract( $data, EXTR_SKIP );
        }

        ob_start();
        include $template_path;
        return ob_get_clean();
    }
}