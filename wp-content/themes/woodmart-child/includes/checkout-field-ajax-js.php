<?php
defined( 'ABSPATH' ) || exit('What are doing you silly human' );

/**
 * @since 1.0.0
 * This function is for handling the AJAX request and dropdown visibility
 * for the checkout page.
 */
add_action('wp_footer', 'custom_checkout_jquery');
function custom_checkout_jquery() {
    if (!is_checkout()) return;
    ?>
<script type="text/javascript">
jQuery(document).ready(function($) {
    /**
     * @since 1.0.0
     * This function is used to show or hide the delivery fields based on the selected delivery type.
     * 
     * @return void
     */
    function toggleDeliveryFields() {
        // Show or hide delivery fields based on the selected delivery type
        let deliveryType = $('#delivery_type').val();

        const fieldGroups = {
            'delivery': {
                show: '.delivery-field',
                required: '#delivery_address, #delivery_area'
            },
            'pickup': {
                show: '.pickup-field',
                required: '#pickup_location, #pickup_date'
            }
        };

        Object.entries(fieldGroups).forEach(([type, config]) => {
            if (deliveryType === type) {
                $(config.show).show();
                $(config.required).prop('required', true);
            } else {
                $(config.show).hide();
                $(config.required).prop('required', false);
            }
        });

        // Hide the village field if the Area is not selected
        if ($('#delivery_area').val() === 'not_selected') {
            $('#delivery_village_field').hide();
        }
    }

    /**
     * @since 1.0.0
     * This function is used to show or hide the village field based on the selected area.
     * It sends an AJAX request to the server and updates the village dropdown.
     */
    function handleDeliveryAreaChange() {
        let area = $('#delivery_area').val();
        let village_select = $('#delivery_village');
        let maxRetries = 3;
        let retryCount = 0;

        // Only proceed if delivery type is 'delivery'
        if ($('#delivery_type').val() !== 'delivery') {
            $('#delivery_village_field').hide();
            return;
        }

        function loadVillages(savedVillage = null) {
            $.ajax({
                type: 'POST',
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: {
                    'action': 'get_villages',
                    'area': area
                },
                success: function(response) {
                    if (Object.keys(response).length === 0 && retryCount < maxRetries) {
                        retryCount++;
                        setTimeout(() => loadVillages(savedVillage), 500);
                        return;
                    }

                    village_select.empty();
                    village_select.append($('<option>', {
                        value: 'not_selected',
                        text: 'Select a Village'
                    }));

                    $.each(response, function(key, value) {
                        village_select.append($('<option>', {
                            value: key,
                            text: value
                        }));
                    });

                    if (savedVillage && village_select.find(
                            `option[value="${savedVillage}"]`).length > 0) {
                        village_select.val(savedVillage).trigger('change');
                    }
                },
                error: function() {
                    if (retryCount < maxRetries) {
                        retryCount++;
                        setTimeout(() => loadVillages(savedVillage), 500);
                    }
                }
            });
        }

        if (area === 'not_selected') {
            $('#delivery_village_field').hide();
            village_select.prop('required', false);
        } else {
            $('#delivery_village_field').show();
            if ($('#delivery_type').val() === 'delivery') {
                village_select.prop('required', true);
            }

            <?php if (is_user_logged_in()): ?>
            let savedVillage = '<?php echo esc_js(WC()->session->get('selected_village')); ?>';
            loadVillages(savedVillage);
            <?php else: ?>
            loadVillages();
            <?php endif; ?>
        }
    }

    $('#delivery_area').on('change', handleDeliveryAreaChange);
    $('#delivery_type').on('change', function() {
        handleDeliveryAreaChange();
    });

    $('#delivery_village').on('click', function() {
        let village = $(this).val();

        $.ajax({
            url: woodmart_settings.ajaxurl,
            type: 'POST',
            data: {
                action: 'store_village',
                village: village
            },
            success: function(response) {
                // Force cart and checkout update
                $(document.body).trigger('update_checkout');
                $(document.body).trigger('wc_update_cart');
            }
        });
    });

    $('#delivery_type').on('change', function() {
        let deliveryType = $(this).val();

        // Store delivery type and update checkout
        $.ajax({
            url: woodmart_settings.ajaxurl,
            type: 'POST',
            data: {
                action: 'store_delivery_type',
                delivery_type: deliveryType
            },
            success: function() {
                $(document.body).trigger('update_checkout');
            }
        });

        toggleDeliveryFields();
    });
    toggleDeliveryFields(); // Run on page load
});
</script>
<?php
}
/**
 * @since 1.0.0
 * This function is used to get the village field data based on the selected area.
 * It get and returns the village data from the array in the file 
 */
include_once 'checkout-field-village-data.php';