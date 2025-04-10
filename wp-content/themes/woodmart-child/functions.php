<?php
/**
 * Enqueue script and styles for child theme
 */
function woodmart_child_enqueue_styles() {
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'woodmart-style' ), woodmart_get_theme_info( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'woodmart_child_enqueue_styles', 10010 );


/**
 * @since 1.0.0
 * include all ajax js files for checkout field
 * @return void
 */
include_once 'includes/checkout-field-ajax-js.php';

/**
 * @since 1.0.0
 * include all custom checkout fields
 * @return void
 */
include_once 'includes/add_checkout_fields.php';

/**
 * @since 1.0.0
 * include all error handler for checkout fields
 */
include_once 'includes/chackout-error-handler.php';

add_filter('woocommerce_form_field', 'remove_optional_text_specific_fields', 10, 4);
function remove_optional_text_specific_fields($field, $key, $args, $value) {
    $custom_fields = ['delivery_address', 'delivery_area','delivery_village'];
    if (in_array($key, $custom_fields) && !$args['required']) {
        $field = str_replace('(optional)', '<span style="color: red;">*</span>', $field);
    }
    return $field;
}





// Save the new fields
add_action('woocommerce_checkout_update_order_meta', 'save_delivery_type_field');
function save_delivery_type_field($order_id) {
    if (!empty($_POST['delivery_type'])) {
        update_post_meta($order_id, 'delivery_type', sanitize_text_field($_POST['delivery_type']));
    }
    if (!empty($_POST['delivery_address'])) {
        update_post_meta($order_id, 'delivery_address', sanitize_text_field($_POST['delivery_address']));
    }
    if (!empty($_POST['delivery_area'])) {
        update_post_meta($order_id, 'delivery_area', sanitize_text_field($_POST['delivery_area']));
    }
    if (!empty($_POST['delivery_village'])) {
        update_post_meta($order_id, 'delivery_village', sanitize_text_field($_POST['delivery_village']));
    }
}