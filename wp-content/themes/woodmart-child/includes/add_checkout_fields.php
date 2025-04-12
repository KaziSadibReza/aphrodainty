<?php
defined('ABSPATH') || exit('What are doing you silly human');

// Add this function before custom_override_checkout_fields
function get_village_with_shipping_label($village_name, $village_key) {
    global $special_shipping_villages;
    if (isset($special_shipping_villages[$village_key])) {
        return $village_name . ' (Delivery Fee: $' . number_format($special_shipping_villages[$village_key]) . ')';
    }
    return $village_name;
}

add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');
function custom_override_checkout_fields($fields) {
    // Make last name and email not required
    $fields['billing']['billing_last_name']['required'] = false;
    $fields['billing']['billing_email']['required'] = false;
    
    // Add delivery type dropdown
    $fields['billing']['delivery_type'] = array(
        'type'      => 'select',
        'label'     => __('Delivery Type', 'woocommerce'),
        'required'  => true,
        'class'     => array('form-row-wide'),
        'clear'     => true,
        'options'   => array(
            'pickup'    => __('Pick up', 'woocommerce'),
            'delivery'  => __('Delivery', 'woocommerce')
        )
    );
    
    // Add delivery address fields with conditional requirements
    $fields['billing']['delivery_address'] = array(
        'type'      => 'text',
        'label'     => __('Address', 'woocommerce'),
        'required'  => false,
        'class'     => array('form-row-wide', 'delivery-field'),
        'clear'     => true,
        'placeholder' => __('Lot Number & Street', 'woocommerce'),
    );
    
    $fields['billing']['delivery_area'] = array(
        'type'      => 'select',
        'label'     => __('Area', 'woocommerce'),
        'required'  => false,
        'class'     => array('form-row-wide', 'delivery-field'),
        'clear'     => true,
        'options'   => array(
            'not_selected'                    => __('Select an Area', 'woocommerce'),
            'georgetown'         => __('Georgetown', 'woocommerce'),
            'east_coast'         => __('East Coast Demerara', 'woocommerce'),
            'east_bank'          => __('East Bank Demerara', 'woocommerce'),
            'west_coast'         => __('West Coast Demerara', 'woocommerce'),
            'west_bank'          => __('West Bank Demerara', 'woocommerce')
        )
    );
    
    // Modified village field to start empty
    $fields['billing']['delivery_village'] = array(
        'type'      => 'select',
        'label'     => __('Village', 'woocommerce'),
        'required'  => false,
        'class'     => array('form-row-wide', 'delivery-field'),
        'clear'     => true,
        'options'   => array(
            'not_selected' => __('Select a Village', 'woocommerce')
            // Other options will be populated via AJAX with shipping fees
        )
    );

    // Add pickup location field
    $fields['billing']['pickup_location'] = array(
        'type'      => 'select',
        'label'     => __('Pickup Location', 'woocommerce'),
        'required'  => false,
        'class'     => array('form-row-wide', 'pickup-field'),
        'clear'     => true,
        'options'   => array(
            'not_selected' => __('Select a Pickup Location', 'woocommerce'),
            'small-business-hub-kitty'   => __( 'Small Business Hub - Kitty', 'woocommerce'),
            'others'               => __('Others','woocommerce'')
        )
    );
    
    // Add pickup date field with date range
    $fields['billing']['pickup_date'] = array(
        'type'      => 'date',
        'label'     => __('Pickup Date', 'woocommerce'),
        'required'  => false,
        'class'     => array('form-row-wide', 'pickup-field'),
        'clear'     => true,
        'custom_attributes' => array(
            'min' => date('Y-m-d'), // Today's date as minimum
            'max' => date('Y-m-d', strtotime('+30 days')), // 30 days from today as maximum
        )
    );

    
    // Remove existing fields
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_postcode']);
    
    return $fields;
}
