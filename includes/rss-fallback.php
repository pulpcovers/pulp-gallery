<?php
/**
 * RSS fallback for pulp gallery shortcode.
 * Outputs all images vertically at medium size, each linking to the full image.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Generate RSS-safe gallery output from shortcode attributes.
 *
 * @param array $atts Shortcode attributes, must include 'ids'.
 * @return string RSS-safe HTML.
 */
function pulp_gallery_rss_fallback_from_shortcode( $atts ) {

    // No IDs? Nothing to output.
    if ( empty( $atts['ids'] ) ) {
        return '';
    }

    // Convert comma-separated list into array of integers.
    $ids = array_map( 'intval', explode( ',', $atts['ids'] ) );

    $output = '<div class="pulp-gallery-rss">' . "\n";

    foreach ( $ids as $id ) {

        // Full-size image URL
        $full = wp_get_attachment_url( $id );

        // Medium-size image URL
        $medium = wp_get_attachment_image_src( $id, 'medium' );

        // Alt text (fallback to attachment title)
        $alt = get_post_meta( $id, '_wp_attachment_image_alt', true );
        if ( empty( $alt ) ) {
            $alt = get_the_title( $id );
        }

        if ( $medium ) {
            $output .= sprintf(
                '<p><a href="%s" target="_blank" rel="noopener noreferrer"><img src="%s" alt="%s" /></a></p>' . "\n",
                esc_url( $full ),
                esc_url( $medium[0] ),
                esc_attr( $alt )
            );
        }
    }

    $output .= "</div>\n";

    return $output;
}

/**
 * Ensure shortcodes run inside RSS feeds.
 *
 * Some themes or plugins strip shortcodes from feed content,
 * preventing pulp_gallery from running. This forces WordPress
 * to execute shortcodes BEFORE feed content is finalized.
 */
add_filter( 'the_content_feed', function( $content ) {
    return do_shortcode( $content );
}, 9 );

add_filter( 'the_excerpt_rss', function( $content ) {
    return do_shortcode( $content );
}, 9 );