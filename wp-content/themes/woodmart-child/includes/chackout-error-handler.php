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
    if (is_checkout()) : ?>
<script>
jQuery(function($) {

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