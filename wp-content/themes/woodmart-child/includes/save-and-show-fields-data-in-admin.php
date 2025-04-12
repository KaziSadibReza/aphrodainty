<?php 
defined('ABSPATH') || exit('What are doing you silly human');


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
    
    if (isset($_POST['delivery_type']) && $_POST['delivery_type'] === 'pickup') {
        $fields = [
            'pickup_location',
            'pickup_date'
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
    if (!is_a($order, 'WC_Order')) return;

    $order_id = $order->get_id();

    // Location label mappings
    $location_labels = [
        'areas' => [
            'georgetown'   => 'Georgetown',
            'east_coast'   => 'East Coast Demerara',
            'east_bank'    => 'East Bank Demerara',
            'west_coast'   => 'West Coast Demerara',
            'west_bank'    => 'West Bank Demerara'
        ],
        'pickup' => [
            'nike_store'   => 'Nike Store - Georgetown',
            'adidas_store' => 'Adidas Store - East Bank',
            'puma_store'   => 'Puma Store - West Bank'
        ]
    ];

    // Helper: Format value
    $format = function($value) {
        return ucwords(str_replace('_', ' ', $value));
    };

    // Helper: Get mapped label
    $get_label = function($type, $key) use ($location_labels, $format) {
        return $location_labels[$type][$key] ?? $format($key);
    };

    // Delivery type
    $delivery_type = $order->get_meta('delivery_type');
    $delivery_type_clean = $format($delivery_type);

    // Field definitions
    $common_fields = [
        'delivery_type' => [
            'label' => __('Delivery Type'),
            'value' => $delivery_type_clean
        ]
    ];

    $delivery_fields = [
        'delivery_address' => [
            'label' => __('Delivery Address'),
            'value' => $order->get_meta('delivery_address')
        ],
        'delivery_area' => [
            'label' => __('Delivery Area'),
            'value' => $get_label('areas', $order->get_meta('delivery_area'))
        ],
        'delivery_village' => [
            'label' => __('Delivery Village'),
            'value' => $format($order->get_meta('delivery_village'))
        ]
    ];

    $pickup_fields = [
        'pickup_location' => [
            'label' => __('Pickup Location'),
            'value' => $get_label('pickup', $order->get_meta('pickup_location'))
        ],
        'pickup_date' => [
            'label' => __('Pickup Date'),
            'value' => $order->get_meta('pickup_date')
        ]
    ];

    // Final fields to display
    $fields_to_display = $common_fields;

    if (strtolower($delivery_type_clean) === 'delivery') {
        $fields_to_display += $delivery_fields;
    }

    if (strtolower($delivery_type_clean) === 'pickup') {
        $fields_to_display += $pickup_fields;
    }

    // Output
    echo '<div class="delivery-details" style="margin-top: 10px; padding: 10px; border: 1px solid #ccc;">';
    echo '<h3>' . __('Delivery Information') . '</h3>';
    foreach ($fields_to_display as $field) {
        if (!empty($field['value'])) {
            echo '<p><strong>' . esc_html($field['label']) . ':</strong> ' . esc_html($field['value']) . '</p>';
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

    // Location mappings
    $locations = [
        'areas' => [
            'georgetown' => 'Georgetown',
            'east_coast' => 'East Coast Demerara',
            'east_bank' => 'East Bank Demerara',
            'west_coast' => 'West Coast Demerara',
            'west_bank' => 'West Bank Demerara'
        ],
        'pickup' => [
            'nike_store' => 'Nike Store - Georgetown',
            'adidas_store' => 'Adidas Store - East Bank',
            'puma_store' => 'Puma Store - West Bank'
        ]
    ];

    // Helper functions
    $format_text = function($text) {
        return ucwords(str_replace('_', ' ', $text));
    };

    $get_location = function($type, $key) use ($locations, $format_text) {
        return $locations[$type][$key] ?? $format_text($key);
    };

    // Get and format delivery type
    $delivery_type = $format_text($order->get_meta('delivery_type'));
    
    // Build delivery info
    $data['delivery_info'] = '';
    if (!$delivery_type) return $data;

    $data['delivery_info'] .= "<strong>Delivery Type:</strong> {$delivery_type}<br/>";
    
    if ($delivery_type === 'Delivery') {
        $delivery_fields = [
            'Address' => $order->get_meta('delivery_address'),
            'Area' => $get_location('areas', $order->get_meta('delivery_area')),
            'Village' => $format_text($order->get_meta('delivery_village'))
        ];

        foreach ($delivery_fields as $label => $value) {
            if ($value) {
                $data['delivery_info'] .= "<strong>{$label}:</strong> {$value}<br/>";
            }
        }
    } elseif ($delivery_type === 'Pickup') {
        $pickup_fields = [
            'Pickup Location' => $get_location('pickup', $order->get_meta('pickup_location')),
            'Pickup Date' => $order->get_meta('pickup_date')
        ];

        foreach ($pickup_fields as $label => $value) {
            if ($value) {
                $data['delivery_info'] .= "<strong>{$label}:</strong> {$value}<br/>";
            }
        }
    }

    // Remove last <br/>
    $data['delivery_info'] = rtrim($data['delivery_info'], '<br/>');

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

/**
 * @since 1.0.0
 * Add delivery information to thank you page
 * * @param int $order_id
 * @return void
 */
add_action('woocommerce_thankyou', 'display_delivery_info_on_thankyou', 10, 1);
function display_delivery_info_on_thankyou($order_id) {
    $order = wc_get_order($order_id);
    if (!$order) return;

    // Location label mappings (reuse existing array)
    $location_labels = [
        'areas' => [
            'georgetown'   => 'Georgetown',
            'east_coast'   => 'East Coast Demerara',
            'east_bank'    => 'East Bank Demerara',
            'west_coast'   => 'West Coast Demerara',
            'west_bank'    => 'West Bank Demerara'
        ],
        'pickup' => [
            'nike_store'   => 'Nike Store - Georgetown',
            'adidas_store' => 'Adidas Store - East Bank',
            'puma_store'   => 'Puma Store - West Bank'
        ]
    ];

    $delivery_type = $order->get_meta('delivery_type');
    $delivery_type_clean = ucwords(str_replace('_', ' ', $delivery_type));

    echo '<section class="woocommerce-delivery-info">';
    echo '<h2>Delivery Information</h2>';
    echo '<p class="woocommerce-customer-details--"><strong>Delivery Type:</strong> ' . esc_html($delivery_type_clean) . '</p>';

    if ($delivery_type === 'delivery') {
        $area_key = $order->get_meta('delivery_area');
        $area_label = $location_labels['areas'][$area_key] ?? ucwords(str_replace('_', ' ', $area_key));
        $village = ucwords(str_replace('_', ' ', $order->get_meta('delivery_village')));

        
        echo '<p class="woocommerce-customer-details--"><strong>Delivery Address:</strong> ' . esc_html($order->get_meta('delivery_address')) . '</p>';
        echo '<p class="woocommerce-customer-details--"><strong>Delivery Area:</strong> ' . esc_html($area_label) . '</p>';
        echo '<p class="woocommerce-customer-details--"><strong>Village:</strong> ' . esc_html($village) . '</p>';
    }

    if ($delivery_type === 'pickup') {
        $location_key = $order->get_meta('pickup_location');
        $location_label = $location_labels['pickup'][$location_key] ?? ucwords(str_replace('_', ' ', $location_key));
        
        echo '<p><strong>Pickup Location:</strong> ' . esc_html($location_label) . '</p>';
        echo '<p><strong>Pickup Date:</strong> ' . esc_html($order->get_meta('pickup_date')) . '</p>';
    }
    echo '</section>';
}

/**
 * @since 1.0.0
 * Add delivery information to order email
 * * @param WC_Order $order
 * * @param bool $sent_to_admin
 * * @param bool $plain_text
 * * @param WC_Email $email
 * @return void
 */
add_action('woocommerce_email_after_order_table', 'add_delivery_info_to_emails', 10, 4);
function add_delivery_info_to_emails($order, $sent_to_admin, $plain_text, $email) {
    if (!$order) return;

    $location_labels = [
        'areas' => [
            'georgetown'   => 'Georgetown',
            'east_coast'   => 'East Coast Demerara',
            'east_bank'    => 'East Bank Demerara',
            'west_coast'   => 'West Coast Demerara',
            'west_bank'    => 'West Bank Demerara'
        ],
        'pickup' => [
            'nike_store'   => 'Nike Store - Georgetown',
            'adidas_store' => 'Adidas Store - East Bank',
            'puma_store'   => 'Puma Store - West Bank'
        ]
    ];

    $delivery_type = $order->get_meta('delivery_type');
    $delivery_type_clean = ucwords(str_replace('_', ' ', $delivery_type));

    if ($plain_text) {
        echo "\nDelivery Information\n\n";
        echo "Delivery Type: " . $delivery_type_clean . "\n";

        if ($delivery_type === 'delivery') {
            $area_key = $order->get_meta('delivery_area');
            $area_label = $location_labels['areas'][$area_key] ?? ucwords(str_replace('_', ' ', $area_key));
            $village = ucwords(str_replace('_', ' ', $order->get_meta('delivery_village')));
            
            echo "Delivery Address: " . $order->get_meta('delivery_address') . "\n";
            echo "Delivery Area: " . $area_label . "\n";
            echo "Village: " . $village . "\n";
        }

        if ($delivery_type === 'pickup') {
            $location_key = $order->get_meta('pickup_location');
            $location_label = $location_labels['pickup'][$location_key] ?? ucwords(str_replace('_', ' ', $location_key));
            
            echo "Pickup Location: " . $location_label . "\n";
            echo "Pickup Date: " . $order->get_meta('pickup_date') . "\n";
        }
    } else {
        echo '<h2>Delivery Information</h2>';
        echo '<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; margin-bottom: 20px;">';
        echo '<tr><th>Delivery Type:</th><td>' . esc_html($delivery_type_clean) . '</td></tr>';

        if ($delivery_type === 'delivery') {
            $area_key = $order->get_meta('delivery_area');
            $area_label = $location_labels['areas'][$area_key] ?? ucwords(str_replace('_', ' ', $area_key));
            $village = ucwords(str_replace('_', ' ', $order->get_meta('delivery_village')));
            
            echo '<tr><th>Delivery Address:</th><td>' . esc_html($order->get_meta('delivery_address')) . '</td></tr>';
            echo '<tr><th>Delivery Area:</th><td>' . esc_html($area_label) . '</td></tr>';
            echo '<tr><th>Village:</th><td>' . esc_html($village) . '</td></tr>';
        }

        if ($delivery_type === 'pickup') {
            $location_key = $order->get_meta('pickup_location');
            $location_label = $location_labels['pickup'][$location_key] ?? ucwords(str_replace('_', ' ', $location_key));
            
            echo '<tr><th>Pickup Location:</th><td>' . esc_html($location_label) . '</td></tr>';
            echo '<tr><th>Pickup Date:</th><td>' . esc_html($order->get_meta('pickup_date')) . '</td></tr>';
        }
        echo '</table>';
    }
}