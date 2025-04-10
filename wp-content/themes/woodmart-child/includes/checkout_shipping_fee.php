<?php
defined('ABSPATH') || exit('What are doing you silly human');

// Define villages with special shipping rates
$special_shipping_villages = array(
    'pouderoyen' => 2000,
    'phoentz_town' => 2000,
    'killarney' => 2000,
    'saint_patricks' => 2000,
    'phoenix_park' => 2000,
    'shamrock_manor' => 2000,
    'kashmir' => 2000,
    'malgre_tout' => 2000,
    'versailles' => 2000,
    'goed_fortuin' => 2000,
    'schoonord' => 2000,
    'meer_zorgen' => 2000,
    'joe_vieira_park' => 2000,
    'over_demerara_harbour_bridge' => 2000
);

// Add shipping fee based on village
add_action('woocommerce_cart_calculate_fees', 'add_custom_shipping_fee');

function add_custom_shipping_fee() {
    global $special_shipping_villages;
    
    // Only calculate if on cart or checkout page
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    // Get selected village from session or POST
    $selected_village = WC()->session->get('selected_village');
    if (isset($_POST['village'])) {
        $selected_village = sanitize_text_field($_POST['village']);
    }

    // If village is in our special shipping list, add the fee
    if (!empty($selected_village) && isset($special_shipping_villages[$selected_village])) {
        $shipping_fee = $special_shipping_villages[$selected_village];
        WC()->cart->add_fee(__('Delivery Fee', 'woodmart-child'), $shipping_fee);
    }
}

// Store selected village in session
add_action('wp_ajax_store_village', 'store_village_in_session');
add_action('wp_ajax_nopriv_store_village', 'store_village_in_session');

function store_village_in_session() {
    if (isset($_POST['village'])) {
        $village = sanitize_text_field($_POST['village']);
        WC()->session->set('selected_village', $village);
        wp_send_json_success();
    }
    wp_send_json_error();
}