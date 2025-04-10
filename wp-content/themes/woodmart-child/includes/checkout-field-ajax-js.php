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
        if (deliveryType === 'delivery') {
            $('.delivery-field').show();
            $('#delivery_address, #delivery_area').prop('required', true);
        } else {
            $('.delivery-field').hide();
            $('#delivery_address, #delivery_area, #delivery_village').prop('required', false);
        }

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
    $('#delivery_area').on('change', function() {
        let area = $(this).val();
        let village_select = $('#delivery_village');

        if (area === 'not_selected') {
            $('#delivery_village_field').hide();
            village_select.prop('required', false);
        } else {
            $('#delivery_village_field').show();
            if ($('#delivery_type').val() === 'delivery') {
                village_select.prop('required', true);
            }

            $.ajax({
                type: 'POST',
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: {
                    'action': 'get_villages',
                    'area': area
                },
                success: function(response) {
                    village_select.empty();
                    village_select.append($('<option>', {
                        value: '',
                        text: 'Select a Village'
                    }));

                    $.each(response, function(key, value) {
                        village_select.append($('<option>', {
                            value: key,
                            text: value
                        }));
                    });
                }
            });
        }
    });

    $('#delivery_type').on('change', toggleDeliveryFields);
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