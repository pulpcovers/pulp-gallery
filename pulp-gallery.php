<?php
/**
 * Plugin Name: Pulp Gallery
 * Description: A lightweight, fast gallery plugin for displaying images attached to posts on PulpCovers.com
 * Plugin URI: https://github.com/pulpcovers/pulp-gallery
 * Version: 1.0.0
 * Author: PulpCovers
 * Author URI: https://pulpcovers.com
 * Text Domain: pulp-gallery
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // No direct access
}

/**
 * ------------------------------------------------------------
 * Plugin Constants
 * ------------------------------------------------------------
 */
define( 'PULP_GALLERY_PATH', plugin_dir_path( __FILE__ ) );
define( 'PULP_GALLERY_URL', plugin_dir_url( __FILE__ ) );
define( 'PULP_GALLERY_VERSION', '1.0.0' );

/**
 * ------------------------------------------------------------
 * Autoload Includes
 * ------------------------------------------------------------
 */
require_once PULP_GALLERY_PATH . 'includes/class-pulp-gallery-assets.php';
require_once PULP_GALLERY_PATH . 'includes/class-pulp-gallery-shortcode.php';
require_once PULP_GALLERY_PATH . 'includes/helpers.php';
require_once PULP_GALLERY_PATH . 'includes/rss-fallback.php';

/**
 * ------------------------------------------------------------
 * Plugin Initialization
 * ------------------------------------------------------------
 */
function pulp_gallery_init() {

    // Register asset loader
    Pulp_Gallery_Assets::init();

    // Register shortcode handler
    Pulp_Gallery_Shortcode::init();
}

add_action( 'plugins_loaded', 'pulp_gallery_init' );
