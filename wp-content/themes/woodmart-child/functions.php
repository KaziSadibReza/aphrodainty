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
 * include all error handler and validation for checkout fields
 * @return void
 */
include_once 'includes/checkout-validated-error-handler.php';

/**
 * @since 1.0.0
 * include all shipping fee for checkout
 * @return void
 */
include_once 'includes/checkout_shipping_fee.php';

/**
 * @since 
 * Save field data to order meta
 * @param WC_Order $order
 * @param array $data
 */
remove_action('woocommerce_checkout_update_order_meta', 'save_delivery_type_field');
add_action('woocommerce_checkout_create_order', 'save_delivery_type_field', 10, 2);

function save_delivery_type_field($order, $data) {
    if (!is_a($order, 'WC_Order')) {
        error_log('Error: Invalid order object');
        return;
    }

    // Always save delivery_type
    if (isset($_POST['delivery_type'])) {
        $delivery_type = sanitize_text_field($_POST['delivery_type']);
        $order->update_meta_data('delivery_type', $delivery_type);
    }

    // Only save other fields if delivery_type is 'delivery'
    if (isset($_POST['delivery_type']) && $_POST['delivery_type'] === 'delivery') {
        $fields = [
            'delivery_address',
            'delivery_area',
            'delivery_village'
        ];

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $value = sanitize_text_field($_POST[$field]);
                $order->update_meta_data($field, $value);
            }
        }
    }
    
    $order->save();
}

/**
 * Display delivery fields in billing address with debug info
 * @param WC_Order $order
 */
add_action('woocommerce_admin_order_data_after_billing_address', 'display_delivery_fields_in_admin');
function display_delivery_fields_in_admin($order) {
    if (!is_a($order, 'WC_Order')) {
        return;
    }

    $order_id = $order->get_id();
    
    // Format delivery area and type
    $delivery_type_raw = $order->get_meta('delivery_type');
    $delivery_area_raw = $order->get_meta('delivery_area');
    $delivery_village_raw = $order->get_meta('delivery_village');
    
    // Convert delivery type
    $delivery_type = ucfirst($delivery_type_raw);
    
    // Convert area
    $areas = [
        'georgetown' => 'Georgetown',
        'east_coast' => 'East Coast Demerara',
        'east_bank' => 'East Bank Demerara',
        'west_coast' => 'West Coast Demerara',
        'west_bank' => 'West Bank Demerara'
    ];
    $delivery_area = isset($areas[$delivery_area_raw]) ? $areas[$delivery_area_raw] : ucwords(str_replace('_', ' ', $delivery_area_raw));
    
    // Convert village
    $delivery_village = ucwords(str_replace('_', ' ', $delivery_village_raw));
    
    // Display delivery information
    $fields = [
        'delivery_type' => [
            'label' => __('Delivery Type'),
            'value' => $delivery_type
        ],
        'delivery_address' => [
            'label' => __('Delivery Address'),
            'value' => $order->get_meta('delivery_address')
        ],
        'delivery_area' => [
            'label' => __('Delivery Area'),
            'value' => $delivery_area
        ],
        'delivery_village' => [
            'label' => __('Delivery Village'),
            'value' => $delivery_village
        ]
    ];

    echo '<div class="delivery-details" style="margin-top: 10px; padding: 10px; border: 1px solid #ccc;">';
    echo '<h3>' . __('Delivery Information') . '</h3>';
    
    foreach ($fields as $key => $data) {
        if (!empty($data['value'])) {
            echo '<p><strong>' . $data['label'] . ':</strong> ' . esc_html($data['value']) . '</p>';
        }
    }
    echo '</div>';
}

/**
 * @since 1.0.0
 * Add delivery information to order preview
 *  * @param array $data
 * @param WC_Order $order
 * @return array
 */
add_filter('woocommerce_admin_order_preview_get_order_details', 'add_delivery_info_to_order_preview', 10, 2);
function add_delivery_info_to_order_preview($data, $order) {
    if (!is_a($order, 'WC_Order')) {
        return $data;
    }

    // Get delivery information
    $delivery_type = ucfirst($order->get_meta('delivery_type'));
    
    $areas = [
        'georgetown' => 'Georgetown',
        'east_coast' => 'East Coast Demerara',
        'east_bank' => 'East Bank Demerara',
        'west_coast' => 'West Coast Demerara',
        'west_bank' => 'West Bank Demerara'
    ];
    
    $delivery_area_raw = $order->get_meta('delivery_area');
    $delivery_area = isset($areas[$delivery_area_raw]) ? $areas[$delivery_area_raw] : ucwords(str_replace('_', ' ', $delivery_area_raw));
    
    $delivery_village = ucwords(str_replace('_', ' ', $order->get_meta('delivery_village')));
    $delivery_address = $order->get_meta('delivery_address');

    // Add delivery information to preview data
    $data['delivery_info'] = '';
    if ($delivery_type) {
        $data['delivery_info'] .= "<strong>Delivery Type:</strong> {$delivery_type}<br/>";
        
        if ($delivery_type === 'Delivery') {
            if ($delivery_address) {
                $data['delivery_info'] .= "<strong>Address:</strong> {$delivery_address}<br/>";
            }
            if ($delivery_area) {
                $data['delivery_info'] .= "<strong>Area:</strong> {$delivery_area}<br/>";
            }
            if ($delivery_village) {
                $data['delivery_info'] .= "<strong>Village:</strong> {$delivery_village}";
            }
        }
    }

    return $data;
}

/**
 * @since 1.0.0
 * Add delivery information to order preview template
 * @param array $data
 * @return void
 * @see woocommerce/templates/admin/meta-boxes/views/html-order-preview.php
 */
add_action('woocommerce_admin_order_preview_start', 'display_delivery_info_in_order_preview');
function display_delivery_info_in_order_preview() {
    ?>
<# if (data.delivery_info) { #>
    <div class="wc-order-preview-delivery-info" style="padding: 1.5em 1.5em 0">
        <h2 class="wc-order-preview-heading">Delivery Information</h2>
        {{{ data.delivery_info }}}
    </div>
    <# } #>
        <?php
}