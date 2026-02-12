<?php
/**
 * Helper Functions for Pulp Gallery
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get image URL for a specific size without calling wp_get_attachment_image_src() repeatedly.
 *
 * @param int    $id   Attachment ID.
 * @param string $size Image size name (e.g., 'medium', 'thumbnail', 'full').
 * @param array  $meta Attachment metadata array from _wp_attachment_metadata.
 * @return string Image URL or empty string if not found.
 */
if ( ! function_exists( 'pulp_get_image_url' ) ) {
    function pulp_get_image_url( $id, $size, $meta ) {
        // If metadata missing, fallback to WordPress function
        if ( empty( $meta ) ) {
            $fallback = wp_get_attachment_image_src( $id, $size );
            return $fallback ? $fallback[0] : '';
        }
        
        $upload_dir = wp_upload_dir();
        
        // Full size - return direct attachment URL
        if ( $size === 'full' ) {
            return wp_get_attachment_url( $id );
        }
        
        // If this size exists in metadata, build URL manually
        if ( isset( $meta['sizes'][ $size ] ) ) {
            $subdir = dirname( $meta['file'] ); // e.g., "2024/01"
            return trailingslashit( $upload_dir['baseurl'] ) .
                   trailingslashit( $subdir ) .
                   $meta['sizes'][ $size ]['file'];
        }
        
        // Size doesn't exist - fallback to WordPress function
        $fallback = wp_get_attachment_image_src( $id, $size );
        return $fallback ? $fallback[0] : '';
    }
}
