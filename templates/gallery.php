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
global $wpdb;
$image_ids = wp_list_pluck( $images, 'ID' );
$ids_placeholder = implode( ',', array_fill( 0, count( $image_ids ), '%d' ) );

$bulk_data = $wpdb->get_results(
    $wpdb->prepare( "
        SELECT
            p.ID,
            p.post_title,
            MAX(CASE WHEN pm.meta_key = '_wp_attachment_metadata' THEN pm.meta_value END) as metadata,
            MAX(CASE WHEN pm.meta_key = '_wp_attachment_image_alt' THEN pm.meta_value END) as alt_text
        FROM {$wpdb->posts} p
        LEFT JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
        WHERE p.ID IN ({$ids_placeholder})
        AND (pm.meta_key IN ('_wp_attachment_metadata', '_wp_attachment_image_alt') OR pm.meta_key IS NULL)
        GROUP BY p.ID
    ", $image_ids ),
    OBJECT_K
);

// Build lookup arrays
$meta_cache = [];
$alt_cache = [];
$title_cache = [];

foreach ( $bulk_data as $id => $data ) {
    $meta_cache[ $id ] = !empty( $data->metadata ) ? maybe_unserialize( $data->metadata ) : [];
    $alt_cache[ $id ] = $data->alt_text ?? '';
    $title_cache[ $id ] = $data->post_title ?? '';
}

// Single image case
if ( $count === 1 ) :
    $image = $images[0];
    $meta  = $meta_cache[ $image->ID ];
    $main_url = pulp_get_image_url( $image->ID, $atts['size'], $meta );
    $full_url = pulp_get_image_url( $image->ID, 'full', $meta );
    $alt = !empty( $alt_cache[ $image->ID ] ) ? $alt_cache[ $image->ID ] : $title_cache[ $image->ID ];
?>
    <div class="pulp-gallery-single-wrapper">
        <a href="<?php echo esc_url( $full_url ); ?>"
           target="_blank"
           rel="noopener noreferrer"
           class="pulp-gallery-single-link">
            <div class="pulp-caption"><?php echo esc_html( $alt ); ?></div>
            <?php
            $w = $meta['width']  ?? null;
            $h = $meta['height'] ?? null;
            ?>
            <img
                src="<?php echo esc_url( $main_url ); ?>"
                alt="<?php echo esc_attr( $alt ); ?>"
                loading="lazy"
                class="pulp-gallery-single"
                <?php if ( $w && $h ) : ?>
                    width="<?php echo esc_attr( $w ); ?>"
                    height="<?php echo esc_attr( $h ); ?>"
                <?php endif; ?>
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
            $alt = !empty( $alt_cache[ $image->ID ] ) ? $alt_cache[ $image->ID ] : $title_cache[ $image->ID ];
            
            // Get dimensions for the main size (not thumbnail)
            $main_size_meta = $meta['sizes'][ $atts['size'] ] ?? $meta;
            $main_width = $main_size_meta['width'] ?? $meta['width'] ?? null;
            $main_height = $main_size_meta['height'] ?? $meta['height'] ?? null;
        ?>
            <button
                class="pulp-thumb <?php echo $index === 0 ? 'is-active' : ''; ?>"
                type="button"
                data-pulp-target="<?php echo esc_attr( $index ); ?>"
                data-pulp-src="<?php echo esc_url( $main_url ); ?>"
                data-pulp-alt="<?php echo esc_attr( $alt ); ?>"
                data-pulp-full="<?php echo esc_url( pulp_get_image_url( $image->ID, 'full', $meta ) ); ?>"
                <?php if ( $main_width && $main_height ) : ?>
                    data-pulp-width="<?php echo esc_attr( $main_width ); ?>"
                    data-pulp-height="<?php echo esc_attr( $main_height ); ?>"
                <?php endif; ?>
            >
                <?php
                $thumb_meta = $meta['sizes'][ $atts['thumbsize'] ] ?? null;
                $tw = $thumb_meta['width']  ?? null;
                $th = $thumb_meta['height'] ?? null;
                ?>
                <img
                    src="<?php echo esc_url( $thumb_url ); ?>"
                    alt="<?php echo esc_attr( $alt ); ?>"
                    loading="lazy"
                    <?php if ( $tw && $th ) : ?>
                        width="<?php echo esc_attr( $tw ); ?>"
                        height="<?php echo esc_attr( $th ); ?>"
                    <?php endif; ?>
                >
            </button>
        <?php endforeach; ?>
    </div>
    
    <?php
    // First image for main display
    $first      = $images[0];
    $first_meta = $meta_cache[ $first->ID ];
    $first_url  = pulp_get_image_url( $first->ID, $atts['size'], $first_meta );
    $first_alt  = !empty( $alt_cache[ $first->ID ] ) ? $alt_cache[ $first->ID ] : $title_cache[ $first->ID ];
    
    // Get dimensions for the display size (same as thumbnails)
    $first_size_meta = $first_meta['sizes'][ $atts['size'] ] ?? $first_meta;
    $mw = $first_size_meta['width'] ?? $first_meta['width'] ?? null;
    $mh = $first_size_meta['height'] ?? $first_meta['height'] ?? null;
    ?>
    <div class="pulp-gallery-main">
        <div class="pulp-gallery-spinner" hidden></div>
        <a href="<?php echo esc_url( pulp_get_image_url( $first->ID, 'full', $first_meta ) ); ?>"
           target="_blank"
           rel="noopener noreferrer"
           data-pulp-main-link>
            <div class="pulp-caption" data-pulp-caption><?php echo esc_html( $first_alt ); ?></div>
            <img
                data-pulp-main
                src="<?php echo esc_url( $first_url ); ?>"
                alt="<?php echo esc_attr( $first_alt ); ?>"
                loading="lazy"
                class="pulp-fade-in"
                <?php if ( $mw && $mh ) : ?>
                    width="<?php echo esc_attr( $mw ); ?>"
                    height="<?php echo esc_attr( $mh ); ?>"
                <?php endif; ?>
            >
        </a>
    </div>
</div>
