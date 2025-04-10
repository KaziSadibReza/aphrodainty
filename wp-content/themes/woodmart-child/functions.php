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


add_filter('woocommerce_form_field', 'remove_optional_text_specific_fields', 10, 4);
function remove_optional_text_specific_fields($field, $key, $args, $value) {
    $custom_fields = ['delivery_address', 'delivery_area','delivery_village'];
    if (in_array($key, $custom_fields) && !$args['required']) {
        $field = str_replace('(optional)', '<span style="color: red;">*</span>', $field);
    }
    return $field;
}


// Add validation for delivery fields
add_action('woocommerce_checkout_process', 'check_delivery_fields');
function check_delivery_fields() {
    if ($_POST['delivery_type'] === 'delivery') {
        if (empty($_POST['delivery_address'])) {
            wc_add_notice(__('Please enter your delivery address.'), 'error');
        }
        if (empty($_POST['delivery_area'])) {
            wc_add_notice(__('Please select your delivery area.'), 'error');
        }
        if (empty($_POST['delivery_village'])) {
            wc_add_notice(__('Please select your Village.'), 'error');
        }
    }
}

add_action('wp_footer', 'highlight_custom_checkout_errors');
function highlight_custom_checkout_errors() {
    if (is_checkout()) : ?>
<script>
jQuery(function($) {
    $('form.checkout').on('checkout_place_order', function() {
        // Remove previous highlights
        $('#delivery_address, #delivery_area, #delivery_village').removeClass(
            'validate-error');
    });

    $(document.body).on('checkout_error', function() {
        // If delivery type is selected, then highlight missing fields
        if ($('#delivery_type').val() === 'delivery') {
            if (!$('#delivery_address').val()) {
                $('#delivery_address').addClass('validate-error');
            }
            if (!$('#delivery_area').val()) {
                $('#delivery_area').addClass('validate-error');
            }
            if (!$('#delivery_village').val()) {
                $('#delivery_village').addClass('validate-error');
            }
        }
    });
});
</script>
<style>
.validate-error {
    border-color: #dc3545 !important;
}
</style>
<?php endif;
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