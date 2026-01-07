<?php
/**
 * Template: Gallery Output
 *
 * Variables passed from shortcode:
 * - $atts   (array)  Shortcode attributes
 * - $images (array)  Attached image objects
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$count  = count( $images );
$images = array_values( $images );

// Preload all metadata once
$meta_cache = [];
foreach ( $images as $img ) {
    $meta_cache[ $img->ID ] = wp_get_attachment_metadata( $img->ID );
}

// Helper: get URL for a given size without calling wp_get_attachment_image_src()
if ( ! function_exists( 'pulp_get_image_url' ) ) {
    function pulp_get_image_url( $id, $size, $meta ) {
        // If metadata missing, fallback
        if ( empty( $meta ) ) {
            $fallback = wp_get_attachment_image_src( $id, $size );
            return $fallback ? $fallback[0] : '';
        }

        $upload_dir = wp_upload_dir();

        // Full size
        if ( $size === 'full' ) {
            return wp_get_attachment_url( $id );
        }

        // If this size exists
        if ( isset( $meta['sizes'][ $size ] ) ) {
            $subdir = dirname( $meta['file'] ); // e.g. "2024/01"
            return trailingslashit( $upload_dir['baseurl'] ) .
                   trailingslashit( $subdir ) .
                   $meta['sizes'][ $size ]['file'];
        }

        // Fallback to WP
        $fallback = wp_get_attachment_image_src( $id, $size );
        return $fallback ? $fallback[0] : '';
    }
}

// Single image case
if ( $count === 1 ) :

    $image = $images[0];
    $meta  = $meta_cache[ $image->ID ];

    $main_url = pulp_get_image_url( $image->ID, $atts['size'], $meta );
    $full_url = pulp_get_image_url( $image->ID, 'full', $meta );

    $alt = get_post_meta( $image->ID, '_wp_attachment_image_alt', true );
    if ( empty( $alt ) ) {
        $alt = get_the_title( $image->ID );
    }
?>
    <div class="pulp-gallery-single-wrapper">
        <a href="<?php echo esc_url( $full_url ); ?>"
           target="_blank"
           rel="noopener noreferrer"
           class="pulp-gallery-single-link">

            <!-- Caption overlay (hover) -->
            <div class="pulp-caption"><?php echo esc_html( $alt ); ?></div>

            <img
                src="<?php echo esc_url( $main_url ); ?>"
                alt="<?php echo esc_attr( $alt ); ?>"
                loading="lazy"
                class="pulp-gallery-single"
            >
        </a>
    </div>
<?php
    return;
endif;
?>

<div class="pulp-gallery" data-pulp-gallery>

    <div class="pulp-gallery-thumbs">
        <?php foreach ( $images as $index => $image ) :

            $meta = $meta_cache[ $image->ID ];

            $thumb_url = pulp_get_image_url( $image->ID, $atts['thumbsize'], $meta );
            $main_url  = pulp_get_image_url( $image->ID, $atts['size'], $meta );

            $alt = get_post_meta( $image->ID, '_wp_attachment_image_alt', true );
            if ( empty( $alt ) ) {
                $alt = get_the_title( $image->ID );
            }
        ?>
            <button
                class="pulp-thumb <?php echo $index === 0 ? 'is-active' : ''; ?>"
                type="button"
                data-pulp-target="<?php echo esc_attr( $index ); ?>"
                data-pulp-src="<?php echo esc_url( $main_url ); ?>"
                data-pulp-alt="<?php echo esc_attr( $alt ); ?>"
                data-pulp-full="<?php echo esc_url( pulp_get_image_url( $image->ID, 'full', $meta ) ); ?>"
            >
                <img
                    src="<?php echo esc_url( $thumb_url ); ?>"
                    alt="<?php echo esc_attr( $alt ); ?>"
                    loading="lazy"
                >
            </button>
        <?php endforeach; ?>
    </div>

    <?php
    // First image for main display
    $first      = $images[0];
    $first_meta = $meta_cache[ $first->ID ];
    $first_url  = pulp_get_image_url( $first->ID, $atts['size'], $first_meta );

    $first_alt = get_post_meta( $first->ID, '_wp_attachment_image_alt', true );
    if ( empty( $first_alt ) ) {
        $first_alt = get_the_title( $first->ID );
    }
    ?>

    <div class="pulp-gallery-main">
        <div class="pulp-gallery-spinner" hidden></div>

        <a href="<?php echo esc_url( pulp_get_image_url( $first->ID, 'full', $first_meta ) ); ?>"
           target="_blank"
           rel="noopener noreferrer"
           data-pulp-main-link>

            <!-- ⭐ Caption container for hover + long‑press -->
            <div class="pulp-caption" data-pulp-caption></div>

            <img
                data-pulp-main
                src="<?php echo esc_url( $first_url ); ?>"
                alt="<?php echo esc_attr( $first_alt ); ?>"
                loading="lazy"
                class="pulp-fade-in"
            >
        </a>
    </div>


</div>
