<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Pulp_Gallery_Assets {

    /**
     * Initialize hooks
     */
    public static function init() {
        add_action( 'wp_enqueue_scripts', [ __CLASS__, 'maybe_enqueue_assets' ] );
    }

    /**
     * Conditionally enqueue CSS/JS only when shortcode is present.
     */
    public static function maybe_enqueue_assets() {
        global $post;

        // Always load CSS on the frontend
        wp_enqueue_style(
            'pulp-gallery-css',
            PULP_GALLERY_URL . 'assets/css/pulp-gallery.css',
            [],
            PULP_GALLERY_VERSION
        );

        // Load JS anywhere the shortcode appears
        if ( $post instanceof WP_Post && has_shortcode( $post->post_content, 'pulp_gallery' ) ) {
            wp_enqueue_script(
                'pulp-gallery-js',
                PULP_GALLERY_URL . 'assets/js/pulp-gallery.js',
                [],
                PULP_GALLERY_VERSION,
                true
            );
        }
    }

    /**
     * Register and enqueue plugin assets
     */
    private static function enqueue_assets() {

        // CSS
        wp_enqueue_style(
            'pulp-gallery-css',
            PULP_GALLERY_URL . 'assets/css/pulp-gallery.css',
            [],
            PULP_GALLERY_VERSION
        );

        // JS
        wp_enqueue_script(
            'pulp-gallery-js',
            PULP_GALLERY_URL . 'assets/js/pulp-gallery.js',
            [],
            PULP_GALLERY_VERSION,
            true // load in footer
        );
    }
}