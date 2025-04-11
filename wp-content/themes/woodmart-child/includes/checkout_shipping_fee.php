<?php
defined('ABSPATH') || exit('What are doing you silly human');

// Define villages with special shipping rates
$special_shipping_villages = array(
    // West Bank Demerara Start
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

    // West Bank Demerara End
    // West Coast Demerara Start
     // 2000 group
     'vreed_en_hoop' => 2000,
     'the_best' => 2000,
     'nouvelle_flanders' => 2000,
     'union' => 2000,
     'rotterdam' => 2000,
 
     // 2300 group
     'harlem' => 2300,
     'mary' => 2300,
     'wallers_delight' => 2300,
     'ruimzigt' => 2300,
 
     // 2500 group
     'windsor_forest' => 2500,
     'la_jalousie' => 2500,
     'blankenburg' => 2500,
 
     // 2800 group
     'den_amstel' => 2800,
     'fellowship' => 2800,
     'hague' => 2800,
 
     // 2900 group
     'cornelia_ida' => 2900,
 
     // 3200 group
     'anna_catherina' => 3200,
     'edinburgh' => 3200,
 
     // 3500 group
     'groenveldt' => 3500,
     'leonora' => 3500,
     'stewartville' => 3500,
     'uitvlugt' => 3500,
     'ocean_view' => 3500,
     'zeeburg' => 3500,
     'de_william' => 3500,
     'met_en_meer_zorg' => 3500,
     'goedverwagting' => 3500,
     'wales_estates' => 3500,
     'patentia' => 3500,
 
     // 4000 group
     'de_kinderen' => 4000,
     'boarasie_river' => 4000,
     'zeelugt' => 4000,
     'tuschen' => 4000,
 
     // 5000 group
     'vergenoegen' => 5000,
     'philadelphia' => 5000,
     'barnwell' => 5000,
     'greenwhich_park' => 5000,
     'goodhope' => 5000,
     'ruby' => 5000,
     'farm' => 5000,
 
     // 6000 group
     'le_destin' => 6000,
     'organgestein' => 6000,
     'bushy_park' => 6000,
     'hydronie' => 6000,
     'parika' => 6000,
 
     // 2700 group
     'nismes' => 2700,
     'toevlugt' => 2700,
     'la_retraite' => 2700,
     'stanleytown' => 2700,
     'number_two_canal' => 2700,
 
     // 3000 group
     'belle_vue' => 3000,
     'good_intent' => 3000,
     'sisters' => 3000,
    //  West Coast Demerara End
    // East Bank Demerara Start
     // 1200 group
     'eccles' => 1200,
     'bagotstown' => 1200,
 
     // 1300 group
     'demerara_harbour_bridge' => 1300,
 
     // 1400 group
     'peters_hall' => 1400,
     'nandy_park' => 1400,
     'republic_park' => 1400,
 
     // 1500 group
     'ramsburg' => 1500,
     'providence' => 1500,
 
     // 1600 group
     'greenfield_park_providence' => 1600,
 
     // 1700 group
     'mocha' => 1700,
     'herstelling' => 1700,
 
     // 1800 group
     'farm' => 1800,
     'vreed_en_rust' => 1800,
     'covent_garden' => 1800,
 
     // 1900 group
     'prospect' => 1900,
 
     // 2000 group (existing extended)
     'little_diamond' => 2000,
     'great_diamond' => 2000,
     'vreed_en_hoop' => 2000,
     'the_best' => 2000,
     'nouvelle_flanders' => 2000,
     'union' => 2000,
     'rotterdam' => 2000,
 
     // 2300 group (existing extended)
     'golden_grove' => 2300,
     'harlem' => 2300,
     'mary' => 2300,
     'wallers_delight' => 2300,
     'ruimzigt' => 2300,
 
     // 2500 group (existing extended)
     'good_success' => 2500,
     'craig' => 2500,
     'windsor_forest' => 2500,
     'la_jalousie' => 2500,
     'blankenburg' => 2500,
 
     // 2600 group
     'new_hope' => 2600,
 
     // 2700 group (existing extended)
     'friendship' => 2700,
     'nismes' => 2700,
     'toevlugt' => 2700,
     'la_retraite' => 2700,
     'stanleytown' => 2700,
     'number_two_canal' => 2700,
 
     // 2800 group (existing extended)
     'garden_of_eden' => 2800,
     'den_amstel' => 2800,
     'fellowship' => 2800,
     'hague' => 2800,
 
     // 2900 group (existing extended)
     'brickery' => 2900,
     'cornelia_ida' => 2900,
 
     // 3000 group (existing extended)
     'supply' => 3000,
     'support' => 3000,
     'relief' => 3000,
     'belle_vue' => 3000,
     'good_intent' => 3000,
     'sisters' => 3000,
 
     // 3500 group (existing extended)
     'land_of_canaan' => 3500,
     'groenveldt' => 3500,
     'leonora' => 3500,
     'stewartville' => 3500,
     'uitvlugt' => 3500,
     'ocean_view' => 3500,
     'zeeburg' => 3500,
     'de_william' => 3500,
     'met_en_meer_zorg' => 3500,
     'goedverwagting' => 3500,
     'wales_estates' => 3500,
     'patentia' => 3500,
 
     // 3700 group
     'sarah_johanna' => 3700,
     'pearl' => 3700,
 
     // 3900 group
     'caledonia' => 3900,
     'te_huis_te_coverden' => 3900,
 
     // 4000 group (existing extended)
     'den_heuvel' => 4000,
     'soesdyke_junction' => 4000,
     'de_kinderen' => 4000,
     'boarasie_river' => 4000,
     'zeelugt' => 4000,
     'tuschen' => 4000,
 
     // 5000 group (existing)
     'vergenoegen' => 5000,
     'philadelphia' => 5000,
     'barnwell' => 5000,
     'greenwhich_park' => 5000,
     'goodhope' => 5000,
     'ruby' => 5000,
     'farm' => 5000, // Note: 'farm' appears in multiple groups, you might want to differentiate by region.
 
     // 6000 group (existing)
     'le_destin' => 6000,
     'organgestein' => 6000,
     'bushy_park' => 6000,
     'hydronie' => 6000,
     'parika' => 6000,
    //  East Bank Demerara End
    // East Coast Demerara Start
    // 1200 group
    'eccles' => 1200,
    'bagotstown' => 1200,

    // 1300 group (existing extended)
    'demerara_harbour_bridge' => 1300,
    'goedverwagting' => 1300,
    'sparendaam' => 1300,
    'plaisance' => 1300,
    'better_hope' => 1300,

    // 1400 group (existing extended)
    'peters_hall' => 1400,
    'nandy_park' => 1400,
    'republic_park' => 1400,
    'vryheids_lust' => 1400,

    // 1500 group (existing extended)
    'ramsburg' => 1500,
    'providence' => 1500,
    'brothers' => 1500,
    'montrose' => 1500,
    'atlantic_gardens' => 1500,

    // 1600 group (existing extended)
    'greenfield_park_providence' => 1600,
    'happy_acres' => 1600,
    'montrose' => 1600, // Duplicate in 1500, verify if separate location
    'felicity' => 1600,

    // 1700 group (existing extended)
    'mocha' => 1700,
    'herstelling' => 1700,
    'le_ressouvenir' => 1700,
    'success' => 1700,
    'chateau_margot' => 1700,

    // 1800 group (existing extended)
    'farm' => 1800,
    'vreed_en_rust' => 1800,
    'covent_garden' => 1800,
    'lbi' => 1800,
    'betterverwagting' => 1800,
    'triumph' => 1800,
    'mon_repos' => 1800,
    'de_endragt' => 1800,

    // 1900 group
    'prospect' => 1900,

    // 2000 group (existing extended)
    'little_diamond' => 2000,
    'great_diamond' => 2000,
    'vreed_en_hoop' => 2000,
    'the_best' => 2000,
    'nouvelle_flanders' => 2000,
    'union' => 2000,
    'rotterdam' => 2000,
    'good_hope' => 2000,
    'two_friends' => 2000,
    'lusignan' => 2000,
    'annandale' => 2000,

    // 2100 group
    'la_reconnaissance' => 2100,
    'buxton' => 2100,
    'friendship_ecd' => 2100,

    // 2200 group
    'vigilance' => 2200,

    // 2300 group (existing extended)
    'golden_grove' => 2300,
    'harlem' => 2300,
    'mary' => 2300,
    'wallers_delight' => 2300,
    'ruimzigt' => 2300,
    'strathspey' => 2300,
    'bladen_hall' => 2300,

    // 2400 group
    'coldingen' => 2400,
    'non_pareil' => 2400,

    // 2500 group (existing extended)
    'good_success' => 2500,
    'craig' => 2500,
    'windsor_forest' => 2500,
    'la_jalousie' => 2500,
    'blankenburg' => 2500,
    'enterprise' => 2500,
    'elizabeth_hall' => 2500,
    'melanie_damishana' => 2500,

    // 2600 group
    'new_hope' => 2600,

    // 2700 group (existing extended)
    'friendship' => 2700,
    'nismes' => 2700,
    'toevlugt' => 2700,
    'la_retraite' => 2700,
    'stanleytown' => 2700,
    'number_two_canal' => 2700,

    // 2800 group (existing extended)
    'garden_of_eden' => 2800,
    'den_amstel' => 2800,
    'fellowship' => 2800,
    'hague' => 2800,
    'bachelors_adventure' => 2800,
    'paradise' => 2800,
    'foulis' => 2800,

    // 2900 group (existing extended)
    'brickery' => 2900,
    'cornelia_ida' => 2900,

    // 3000 group (existing extended)
    'supply' => 3000,
    'support' => 3000,
    'relief' => 3000,
    'belle_vue' => 3000,
    'good_intent' => 3000,
    'sisters' => 3000,
    'hope' => 3000,
    'logwood' => 3000,
    'enmore' => 3000,

    // 3500 group (existing extended)
    'land_of_canaan' => 3500,
    'groenveldt' => 3500,
    'leonora' => 3500,
    'stewartville' => 3500,
    'uitvlugt' => 3500,
    'ocean_view' => 3500,
    'zeeburg' => 3500,
    'de_william' => 3500,
    'met_en_meer_zorg' => 3500,
    'haslington' => 3500,
    'golden_grove' => 3500,

    // 3700 group
    'sarah_johanna' => 3700,
    'pearl' => 3700,

    // 3900 group
    'caledonia' => 3900,
    'te_huis_te_coverden' => 3900,

    // 4000 group (existing extended)
    'den_heuvel' => 4000,
    'soesdyke_junction' => 4000,
    'de_kinderen' => 4000,
    'boarasie_river' => 4000,
    'zeelugt' => 4000,
    'tuschen' => 4000,

    // 5000 group (existing)
    'vergenoegen' => 5000,
    'philadelphia' => 5000,
    'barnwell' => 5000,
    'greenwhich_park' => 5000,
    'goodhope' => 5000,
    'ruby' => 5000,
    'farm' => 5000, // Note: 'farm' appears in multiple groups, you might want to differentiate by region.

    // 6000 group (existing)
    'le_destin' => 6000,
    'organgestein' => 6000,
    'bushy_park' => 6000,
    'hydronie' => 6000,
    'parika' => 6000,
    // East Coast Demerara End
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