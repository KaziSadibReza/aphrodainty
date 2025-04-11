<?php
defined('ABSPATH') || exit('What are doing you silly human');

// Define villages with special shipping rates
$special_shipping_villages = array(
    // Georgetown
    // Add Georgetown villages here if applicable

    // West Bank Demerara (WBD)
    'farm_wbd' => 5000,  // Renamed from 'farm'
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
    'over_demerara_harbour_bridge' => 2000,
    'la_grange' => 2500,
    'number_one_canal' => 2500,
    'mindenburg' => 2500,
    'bagotville' => 2500,
    'la_parfaite_harmony' => 2500,
    'west_minister' => 2500,
    'nismes' => 2700,
    'toevlugt' => 2700,
    'la_retraite' => 2700,
    'stanleytown' => 2700,
    'number_two_canal' => 2700,
    'belle_vue' => 3000,
    'good_intent' => 3000,
    'sisters' => 3000,
    'goedverwagting' => 3500,
    'wales_estates' => 3500,
    'patentia' => 3500,

    // West Coast Demerara (WCD)
    'farm_wcd' => 5000,  // Renamed from 'farm'
    'vreed_en_hoop' => 2000,
    'the_best' => 2000,
    'nouvelle_flanders' => 2000,
    'union' => 2000,
    'rotterdam' => 2000,
    'harlem' => 2300,
    'mary' => 2300,
    'wallers_delight' => 2300,
    'ruimzigt' => 2300,
    'windsor_forest' => 2500,
    'la_jalousie' => 2500,
    'blankenburg' => 2500,
    'den_amstel' => 2800,
    'fellowship' => 2800,
    'hague' => 2800,
    'cornelia_ida' => 2900,
    'anna_catherina' => 3200,
    'edinburgh' => 3200,
    'groenveldt' => 3500,
    'leonora' => 3500,
    'stewartville' => 3500,
    'uitvlugt' => 3500,
    'ocean_view' => 3500,
    'zeeburg' => 3500,
    'de_william' => 3500,
    'met_en_meer_zorg' => 3500,
    'de_kinderen' => 4000,
    'boarasie_river' => 4000,
    'zeelugt' => 4000,
    'tuschen' => 4000,
    'vergenoegen' => 5000,
    'philadelphia' => 5000,
    'barnwell' => 5000,
    'greenwhich_park' => 5000,
    'goodhope' => 5000,
    'ruby' => 5000,

    // East Bank Demerara (EBD)
    'farm_ebd' => 1800,  // Renamed from 'farm'
    'montrose_ebd' => 1500,  // Disambiguated
    'golden_grove_ebd' => 2300,  // Replace 'golden_grove' with region-specific version
    'eccles' => 1200,
    'bagotstown' => 1200,
    'demerara_harbour_bridge' => 1300,
    'peters_hall' => 1400,
    'nandy_park' => 1400,
    'republic_park' => 1400,
    'ramsburg' => 1500,
    'providence' => 1500,
    'greenfield_park_providence' => 1600,
    'mocha' => 1700,
    'herstelling' => 1700,
    'farm' => 1800,
    'vreed_en_rust' => 1800,
    'covent_garden' => 1800,
    'prospect' => 1900,
    'little_diamond' => 2000,
    'great_diamond' => 2000,
    'good_success' => 2500,
    'craig' => 2500,
    'new_hope' => 2600,
    'friendship' => 2700,
    'garden_of_eden' => 2800,
    'brickery' => 2900,
    'supply' => 3000,
    'support' => 3000,
    'relief' => 3000,
    'land_of_canaan' => 3500,
    'sarah_johanna' => 3700,
    'pearl' => 3700,
    'caledonia' => 3900,
    'te_huis_te_coverden' => 3900,
    'den_heuvel' => 4000,
    'soesdyke_junction' => 4000,

    // East Coast Demerara (ECD)
    'montrose_ecd' => 1600,  // Disambiguated
    'golden_grove_ecd' => 3500,  // Replace 'golden_grove' with region-specific version
    'goedverwagting' => 1300,
    'sparendaam' => 1300,
    'plaisance' => 1300,
    'better_hope' => 1300,
    'vryheids_lust' => 1400,
    'brothers' => 1500,
    'atlantic_gardens' => 1500,
    'happy_acres' => 1600,
    'felicity' => 1600,
    'le_ressouvenir' => 1700,
    'success' => 1700,
    'chateau_margot' => 1700,
    'lbi' => 1800,
    'betterverwagting' => 1800,
    'triumph' => 1800,
    'mon_repos' => 1800,
    'de_endragt' => 1800,
    'good_hope' => 2000,
    'two_friends' => 2000,
    'lusignan' => 2000,
    'annandale' => 2000,
    'la_reconnaissance' => 2100,
    'buxton' => 2100,
    'friendship_ecd' => 2100,
    'vigilance' => 2200,
    'strathspey' => 2300,
    'bladen_hall' => 2300,
    'coldingen' => 2400,
    'non_pareil' => 2400,
    'enterprise' => 2500,
    'elizabeth_hall' => 2500,
    'melanie_damishana' => 2500,
    'bachelors_adventure' => 2800,
    'paradise' => 2800,
    'foulis' => 2800,
    'hope' => 3000,
    'logwood' => 3000,
    'enmore' => 3000,
    'haslington' => 3500,
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
        // Also store in transient as backup
        set_transient('temp_village_' . get_current_user_id(), $village, HOUR_IN_SECONDS);
        wp_send_json_success();
    }
    wp_send_json_error();
}

// Clear village session if user meta doesn't have village data
add_action('init', 'clear_village_session');

function clear_village_session() {
    if (!is_admin() && !wp_doing_ajax() && WC()->session) {
        $user_id = get_current_user_id();
        if (is_user_logged_in()) {
            $delivery_fields = get_user_meta($user_id, 'delivery_fields', true);
            $temp_village = get_transient('temp_village_' . $user_id);
            
            if (!empty($delivery_fields['delivery_village'])) {
                WC()->session->set('selected_village', $delivery_fields['delivery_village']);
            } elseif ($temp_village) {
                WC()->session->set('selected_village', $temp_village);
            } else {
                WC()->session->set('selected_village', null);
            }
        }
    }
}