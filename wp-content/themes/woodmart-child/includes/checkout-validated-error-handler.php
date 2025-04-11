<?php
defined('ABSPATH') || exit('What are doing you silly human');

/**
 * @since 1.0.0
 * This function handles the error highlighting for the fields by js.
 * It adds the woocommerce-invalid class to the fields that are not filled in correctly.
 * It also adds the woocommerce-invalid-required-field class to the fields that are required but not filled in. 
 */
add_action('wp_footer', 'highlight_custom_checkout_errors');
function highlight_custom_checkout_errors() {
    if (is_checkout()) :
        // Get user meta data if user is logged in
        $delivery_fields = [];
        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            $delivery_fields = get_user_meta($user_id, 'delivery_fields', true);
        }
?>
<script>
jQuery(function($) {
    // Auto-fill fields from user meta when page loads
    <?php if (!empty($delivery_fields)) : ?>
    $(document).ready(function() {
        // Set delivery type first
        $('#delivery_type').val('<?php echo esc_js($delivery_fields['delivery_type']); ?>').trigger(
            'change');

        // Set delivery address
        $('#delivery_address').val('<?php echo esc_js($delivery_fields['delivery_address']); ?>');

        // Set area and trigger change to load villages
        $('#delivery_area').val('<?php echo esc_js($delivery_fields['delivery_area']); ?>').trigger(
            'change');

        // Wait for villages to load before setting village value
        setTimeout(function() {
            $('#delivery_village').val(
                '<?php echo esc_js($delivery_fields['delivery_village']); ?>').trigger(
                'change');
        }, 1000); // Increased delay to ensure AJAX completes
    });
    <?php endif; ?>

    // Clear previous highlights on form submit
    $('form.checkout').on('checkout_place_order', function() {
        $('#delivery_address_field, #delivery_area_field, #delivery_village_field').removeClass(
            'woocommerce-validated');
    });

    // Real-time validation on blur
    $('#delivery_address, #delivery_area, #delivery_village').on('blur', function() {
        const deliveryType = $('#delivery_type').val();
        const $field = $(this);
        const fieldId = $field.attr('id');

        if (deliveryType === 'delivery') {
            const value = $field.val();

            if (fieldId === 'delivery_address') {
                if (!value) {
                    $('#delivery_address_field').addClass(
                        'woocommerce-invalid woocommerce-invalid-required-field');
                } else {
                    $('#delivery_address_field').removeClass(
                        'woocommerce-invalid woocommerce-invalid-required-field');
                }
            } else if (fieldId === 'delivery_area' || fieldId === 'delivery_village') {
                if (value === 'not_selected') {
                    $(`#${fieldId}_field`).addClass(
                        'woocommerce-invalid woocommerce-invalid-required-field');
                } else {
                    $(`#${fieldId}_field`).removeClass(
                        'woocommerce-invalid woocommerce-invalid-required-field');
                }
            }
        }
    });

    // Validate fields on checkout error
    $(document.body).on('checkout_error', function() {
        if ($('#delivery_type').val() === 'delivery') {
            if (!$('#delivery_address').val()) {
                $('#delivery_address_field').addClass(
                    'woocommerce-invalid woocommerce-invalid-required-field');
            }
            if ($('#delivery_area').val() === 'not_selected') {
                $('#delivery_area_field').addClass(
                    'woocommerce-invalid woocommerce-invalid-required-field');
            }
            if ($('#delivery_village').val() === 'not_selected') {
                $('#delivery_village_field').addClass(
                    'woocommerce-invalid woocommerce-invalid-required-field');
            }
        }
    });

});
</script>
<?php endif;
}

/**
 * @since 1.0.0
 * This function is used to check fields validation on checkout process.
 */
add_action('woocommerce_checkout_process', 'check_delivery_fields');
function check_delivery_fields() {
    if ($_POST['delivery_type'] === 'delivery') {
        if (empty($_POST['delivery_address'])) {
            wc_add_notice('<a href="#delivery_address_field">' . __('Please enter your delivery address.') . '</a>', 'error');
        }
        if (($_POST['delivery_area'] === 'not_selected') || ($_POST['delivery_area'] === '')) {
            wc_add_notice('<a href="#delivery_area_field">' . __('Please select your delivery area.') . '</a>', 'error');
        }
        if ($_POST['delivery_area'] !== 'not_selected') {        
            if ($_POST['delivery_village'] === 'not_selected' || $_POST['delivery_village'] === '') {
                wc_add_notice('<a href="#delivery_village_field">' . __('Please select your village.') . '</a>', 'error');
            }
        }
    }

    // save the custom field value to user meta
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        update_user_meta($user_id, 'delivery_fields', [
            'delivery_type' => sanitize_text_field($_POST['delivery_type']),
            'delivery_address' => sanitize_text_field($_POST['delivery_address']),
            'delivery_area' => sanitize_text_field($_POST['delivery_area']),
            'delivery_village' => sanitize_text_field($_POST['delivery_village'])
        ]);
    }

}


/**
 * @since 1.0.0
 * This function is used to add custom validation for the delivery fields.
 */
add_filter('woocommerce_form_field', 'remove_optional_text_specific_fields', 10, 4);
function remove_optional_text_specific_fields($field, $key, $args, $value) {
    $custom_fields = ['delivery_address', 'delivery_area','delivery_village'];
    if (in_array($key, $custom_fields) && !$args['required']) {
        $field = str_replace('(optional)', '<span style="color: red;">*</span>', $field);
    }
    return $field;
}