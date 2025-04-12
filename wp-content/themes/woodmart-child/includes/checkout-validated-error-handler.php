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
        } else {
            $delivery_fields = WC()->session ? WC()->session->get('guest_delivery_fields') : [];
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

        if ('<?php echo isset($delivery_fields['pickup_location']); ?>') {
            $('#pickup_location').val('<?php echo esc_js($delivery_fields['pickup_location']); ?>');
        }
        if ('<?php echo isset($delivery_fields['pickup_date']); ?>') {
            $('#pickup_date').val('<?php echo esc_js($delivery_fields['pickup_date']); ?>');
        }
    });
    <?php endif; ?>

    // Clear previous highlights on form submit
    $('form.checkout').on('checkout_place_order', function() {
        $('#delivery_address_field, #delivery_area_field, #delivery_village_field').removeClass(
            'woocommerce-validated');
    });

    // Real-time validation on blur
    // Add any new field IDs here in the jQuery selector
    $('#delivery_address, #delivery_area, #delivery_village, #pickup_location, #pickup_date').on('blur',
        function() {
            const $field = $(this);
            const fieldId = $field.attr('id');
            const deliveryType = $('#delivery_type').val();
            const value = $field.val();

            // Validation rules object - Add new rules here
            const validationRules = {
                delivery: {
                    delivery_address: value => value !== '',
                    delivery_area: value => value !== 'not_selected',
                    delivery_village: value => value !== 'not_selected'
                    // Add new delivery fields here like:
                    // delivery_phone: value => value.length >= 10,
                    // delivery_instructions: value => value.length > 0
                },
                pickup: {
                    pickup_location: value => value !== 'not_selected',
                    pickup_date: value => value !== ''
                    // Add new pickup fields here like:
                    // pickup_time: value => value !== '',
                    // pickup_notes: value => value.length > 0
                }
                // Add new delivery types here like:
                // express: {
                //     express_address: value => value !== '',
                //     express_time: value => value !== ''
                // }
            };

            if (validationRules[deliveryType] && validationRules[deliveryType][fieldId]) {
                handleValidation(
                    `#${fieldId}_field`,
                    validationRules[deliveryType][fieldId](value)
                );
            }
        });

    function handleValidation(fieldSelector, isValid) {
        if (isValid) {
            $(fieldSelector).removeClass('woocommerce-invalid woocommerce-invalid-required-field');
        } else {
            $(fieldSelector).addClass('woocommerce-invalid woocommerce-invalid-required-field');
        }
    }
    // Validate fields on checkout error
    $(document.body).on('checkout_error', function() {
        const fields = {
            delivery: {
                delivery_address: value => value !== '',
                delivery_area: value => value !== 'not_selected',
                delivery_village: value => value !== 'not_selected'
            },
            pickup: {
                pickup_location: value => value !== 'not_selected' && value !== '',
                pickup_date: value => value !== ''
            }
        };

        const deliveryType = $('#delivery_type').val();
        Object.keys(fields[deliveryType] || {}).forEach(fieldId => {
            const value = $(`#${fieldId}`).val();
            if (!fields[deliveryType][fieldId](value)) {
                $(`#${fieldId}_field`).addClass(
                    'woocommerce-invalid woocommerce-invalid-required-field');
            }
        });
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
    $validation_rules = [
        'delivery' => [
            'delivery_address' => ['not_empty', 'Please enter your delivery address.'],
            'delivery_area' => ['not_selected', 'Please select your delivery area.'],
            'delivery_village' => ['not_selected', 'Please select your village.']
        ],
        'pickup' => [
            'pickup_location' => ['not_selected', 'Please select your pickup location.'],
            'pickup_date' => ['not_empty', 'Please select your pickup date.']
        ]
    ];

    $delivery_type = $_POST['delivery_type'];
    if (isset($validation_rules[$delivery_type])) {
        foreach ($validation_rules[$delivery_type] as $field => $rule) {
            $value = $_POST[$field] ?? '';
            $is_invalid = ($rule[0] === 'not_selected' && ($value === 'not_selected' || $value === '')) ||
                         ($rule[0] === 'not_empty' && empty($value));
            
            if ($is_invalid) {
                wc_add_notice("<a href='#{$field}_field'>{$rule[1]}</a>", 'error');
            }
        }
    }

    // save the custom field value to user meta
    // For logged in users, save to user meta
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $fields_to_save = ['delivery_type', 'delivery_address', 'delivery_area', 'delivery_village', 'pickup_location', 'pickup_date'];
        $delivery_fields = array_reduce($fields_to_save, function($acc, $field) {
            $acc[$field] = sanitize_text_field($_POST[$field] ?? '');
            return $acc;
        }, []);
        update_user_meta($user_id, 'delivery_fields', $delivery_fields);
    } 
    // For guest users, save to WooCommerce session
    else {
        $fields_to_save = ['delivery_type', 'delivery_address', 'delivery_area', 'delivery_village', 'pickup_location', 'pickup_date'];
        $delivery_fields = array_reduce($fields_to_save, function($acc, $field) {
            $acc[$field] = sanitize_text_field($_POST[$field] ?? '');
            return $acc;
        }, []);
        WC()->session->set('guest_delivery_fields', $delivery_fields);
    }

}



/**
 * @since 1.0.0
 * This function is used to add custom validation for the delivery fields.
 */
add_filter('woocommerce_form_field', 'remove_optional_text_specific_fields', 10, 4);
function remove_optional_text_specific_fields($field, $key, $args, $value) {
    $custom_fields = ['delivery_address', 'delivery_area','delivery_village', 'pickup_location', 'pickup_date'];
    if (in_array($key, $custom_fields) && !$args['required']) {
        $field = str_replace('(optional)', '<span style="color: red;">*</span>', $field);
    }
    return $field;
}