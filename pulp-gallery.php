<?php
/**
* Plugin Name: Pulp Gallery
* Description: A lightweight, fast gallery plugin for displaying images attached to posts on PulpCovers.com
* Plugin URI: https://github.com/pulpcovers/pulp-gallery
* Version: 1.1.0
* Author: PulpCovers
* License: GPLv2 or later
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

// Read version from plugin header automatically
if ( ! defined( 'PULP_GALLERY_VERSION' ) ) {
    // phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $plugin_data = get_file_data( __FILE__, array( 'Version' => 'Version' ) );
    // phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    define( 'PULP_GALLERY_VERSION', $plugin_data['Version'] );
}

/**
* ------------------------------------------------------------
* Autoload Includes
* ------------------------------------------------------------
*/
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
$pulp_gallery_required_files = array(
    'includes/class-pulp-gallery-assets.php',
    'includes/class-pulp-gallery-shortcode.php',
    'includes/helpers.php',
    'includes/rss-fallback.php',
);

foreach ( $pulp_gallery_required_files as $file ) {
    $filepath = PULP_GALLERY_PATH . $file;
    if ( ! file_exists( $filepath ) ) {
        add_action( 'admin_notices', function() use ( $file ) {
            ?>
            <div class="notice notice-error">
                <p><strong>Pulp Gallery Error:</strong> Missing required file: <?php echo esc_html( $file ); ?></p>
                <p>Please reinstall the plugin or contact support.</p>
            </div>
            <?php
        });
        return;
    }
    require_once $filepath;
}
// phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

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
