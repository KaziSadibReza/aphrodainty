<?php
defined('ABSPATH') || exit('What are doing you silly human');

// AJAX handler for getting villages
/**
 * @since 1.0.0
 * Get villages based on the selected Area
 */
add_action('wp_ajax_get_villages', 'get_villages_by_area');
add_action('wp_ajax_nopriv_get_villages', 'get_villages_by_area');
/**
 * @since 1.0.0
 * Get villages based on the selected Area
 * You can add more villages as needed.
 * Make sure to write the village names and keys accordingly.
 * case is Area name village array is village name
 * @return void
 */
function get_villages_by_area() {
    $area = $_POST['area'];
    $villages = array();
    
    switch($area) {
        case 'georgetown':
            $villages = array(
                'north_south_cumminsburg' => 'North/South Cumminsburg',
                'regent_street' => 'Regent Street',
                'robb_street' => 'Robb Street',
                'charlotte_street' => 'Charlotte Street',
                'north_south_road' => 'North/South Road',
                'brickdam' => 'Brickdam',
                'hadfield_street' => 'Hadfield Street',
                'durban_street' => 'Durban Street',
                'bent_street' => 'Bent Street',
                'princess_street' => 'Princess Street',
                'alberttown' => 'Alberttown',
                'queenstown' => 'Queenstown',
                'durban_park' => 'Durban Park',
                'cemetary_road' => 'Cemetary Road',
                'lodge' => 'Lodge',
                'kitty' => 'Kitty',
                'sheriff_street' => 'Sheriff Street',
                'kingston' => 'Kingston',
                'seawall_road' => 'Seawall Road',
                'campbellville' => 'Campbellville',
                'prashad_nagar' => 'Prashad Nagar',
                'lamaha_gardens' => 'Lamaha Gardens',
                'mandela_avenue' => 'Mandela Avenue',
                'durban_backlands' => 'Durban Backlands',
                'lodge_housing_scheme' => 'Lodge Housing Scheme',
                'meadowbrook_garden' => 'Meadowbrook Garden',
                'new_la_penitence' => 'NE&W La Penitence',
                'lamaha_park' => 'Lamaha Park',
                'lamaha_springs' => 'Lamaha Springs (Cuyun, Berbice, Essequibo & Mazaruni Street)',
                'north_ruimvelds' => 'North Ruimvelds (Festival City, Flying Fish, Ozama & Kaikan Street)',
                'section_a_sophia' => 'Section A Sophia',
                'section_bcd_sophia' => 'Section B, C and D Sophia',
                'south_ruimveldt_gardens' => 'South Ruimveldt Gardens',
                'south_ruimveldt_park' => 'South Ruimveldt Park',
                'cane_view_avenue' => 'Cane View Avenue',
                'cummings_park_sophia' => 'Cummings Park/Red Shop Sophia'
            );
            break;

        case 'east_coast':
            $villages = array(
                'thomas_lands' => 'Thomas Lands',
                'kitty' => 'Kitty',
                'subryanville' => 'Subryanville',
                'bel_air_gardens_springs' => 'Bel Air Gardens & Bel Air Springs',
                'liliendaal_pattensen' => 'Liliendaal & Pattensen',
                'turkeyen' => 'Turkeyen',
                'nando_gardens_ug' => 'Nando Gardens/University of Guyana',
                'atlantic_ville' => 'Atlantic Ville',
                'grahams_hall' => 'Grahams Hall',
                'ug_road' => 'UG Road',
                'industry' => 'Industry',
                'oleander_gardens' => 'Oleander Gardens',
                'crowndam' => 'Crowndam',
                'ogle_line_top' => 'Ogle Line Top/Ogle Public Road',
                'shamrock_gardens' => 'Shamrock Gardens',
                'courida_park_ogle' => 'Courida Park, Ogle',
                'goedverwagting' => 'Goedverwagting',
                'sparendaam' => 'Sparendaam',
                'plaisance' => 'Plaisance',
                'better_hope' => 'Better Hope',
                'vryheids_lust' => 'Vryheid’s Lust',
                'brothers' => 'Brothers',
                'montrose' => 'Montrose',
                'montrose_ecd' => 'Montrose (East Coast)',
                'atlantic_gardens' => 'Atlantic Gardens',
                'happy_acres' => 'Happy Acres',
                'felicity' => 'Felicity',
                'le_ressouvenir' => 'Le Ressouvenir',
                'success' => 'Success',
                'chateau_margot' => 'Chateau Margot',
                'lbi' => 'LBI',
                'betterverwagting' => 'Betterverwagting',
                'triumph' => 'Triumph',
                'mon_repos' => 'Mon Repos',
                'de_endragt' => 'De Endragt',
                'good_hope' => 'Good Hope',
                'two_friends' => 'Two Friends',
                'lusignan' => 'Lusignan',
                'annandale' => 'Annandale',
                'la_reconnaissance' => 'La Reconnaissance',
                'buxton' => 'Buxton',
                'friendship_ecd' => 'Friendship (ECD)',
                'vigilance' => 'Vigilance',
                'strathspey' => 'Strathspey',
                'bladen_hall' => 'Bladen Hall',
                'coldingen' => 'Coldingen',
                'non_pareil' => 'Non Pareil',
                'enterprise' => 'Enterprise',
                'elizabeth_hall' => 'Elizabeth Hall',
                'melanie_damishana' => 'Melanie Damishana',
                'bachelors_adventure' => 'Bachelors Adventure',
                'paradise' => 'Paradise',
                'foulis' => 'Foulis',
                'hope' => 'Hope',
                'logwood' => 'Logwood',
                'enmore' => 'Enmore',
                'haslington' => 'Haslington',
                'golden_grove_ecd' => 'Golden Grove (East Coast)'
            );
            break;

        case 'east_bank':
            $villages = array(
                'albouystown' => 'Albouystown',
                'west_la_penitence' => 'West La Penitence',
                'alexander_village' => 'Alexander Village',
                'riverview_ruimveldt' => 'Riverview Ruimveldt',
                'thirst_park' => 'Thirst Park',
                'meadow_bank' => 'Meadow Bank',
                'rahaman_park' => 'Rahaman Park',
                'houston' => 'Houston',
                'rome' => 'Rome',
                'mc_doom' => 'Mc Doom',
                'agricola' => 'Agricola',
                'eccles' => 'Eccles',
                'bagotstown' => 'Bagotstown',
                'demerara_harbour_bridge' => 'Demerara Harbour Bridge',
                'peters_hall' => 'Peters Hall',
                'nandy_park' => 'Nandy Park',
                'republic_park' => 'Republic Park',
                'ramsburg' => 'Ramsburg',
                'providence' => 'Providence',
                'greenfield_park_providence' => 'Greenfield Park Providence',
                'mocha' => 'Mocha',
                'herstelling' => 'Herstelling',
                'farm' => 'Farm',
                'farm_ebd' => 'Farm (East Bank)',
                'montrose_ebd' => 'Montrose (East Bank)',
                'golden_grove_ebd' => 'Golden Grove (East Bank)',
                'vreed_en_rust' => 'Vreed en Rust',
                'covent_garden' => 'Covent Garden',
                'prospect' => 'Prospect',
                'little_diamond' => 'Little Diamond',
                'great_diamond' => 'Great Diamond',
                'good_success' => 'Good Success',
                'craig' => 'Craig',
                'new_hope' => 'New Hope',
                'friendship' => 'Friendship',
                'garden_of_eden' => 'Garden of Eden',
                'brickery' => 'Brickery',
                'supply' => 'Supply',
                'support' => 'Support',
                'relief' => 'Relief',
                'land_of_canaan' => 'Land of Canaan',
                'sarah_johanna' => 'Sarah Johanna',
                'pearl' => 'Pearl',
                'caledonia' => 'Caledonia',
                'te_huis_te_coverden' => 'Te Huis te Coverden',
                'den_heuvel' => 'Den Heuvel',
                'soesdyke_junction' => 'Soesdyke Junction'
            );
            break;
            
        case 'west_coast':
            $villages = array(
                'vreed_en_hoop' => 'Vreed-En-Hoop',
                'the_best' => 'The Best',
                'nouvelle_flanders' => 'Nouvelle Flanders',
                'union' => 'Union',
                'rotterdam' => 'Rotterdam',
                'harlem' => 'Harlem',
                'mary' => 'Mary',
                'wallers_delight' => 'Waller’s Delight',
                'ruimzigt' => 'Ruimzigt',
                'windsor_forest' => 'Windsor Forest',
                'la_jalousie' => 'La Jalousie',
                'blankenburg' => 'Blankenburg',
                'den_amstel' => 'Den Amstel',
                'fellowship' => 'Fellowship',
                'hague' => 'Hague',
                'cornelia_ida' => 'Cornelia Ida',
                'anna_catherina' => 'Anna Catherina',
                'edinburgh' => 'Edinburgh',
                'groenveldt' => 'Groenveldt',
                'leonora' => 'Leonora',
                'stewartville' => 'Stewartville',
                'uitvlugt' => 'Uitvlugt',
                'ocean_view' => 'Ocean View',
                'zeeburg' => 'Zeeburg',
                'de_william' => 'De William',
                'met_en_meer_zorg' => 'Met-en-meer-zorg',
                'de_kinderen' => 'De Kinderen',
                'boarasie_river' => 'Boarasie River',
                'zeelugt' => 'Zeelugt',
                'tuschen' => 'Tuschen',
                'vergenoegen' => 'Vergenoegen',
                'philadelphia' => 'Philadelphia',
                'barnwell' => 'Barnwell',
                'greenwhich_park' => 'Greenwhich Park',
                'goodhope' => 'Goodhope',
                'ruby' => 'Ruby',
                'farm' => 'Farm',
                'farm_wcd' => 'Farm (West Coast)',
                'le_destin' => 'Le Destin',
                'organgestein' => 'Organgestein',
                'bushy_park' => 'Bushy Park',
                'hydronie' => 'Hydronie',
                'parika' => 'Parika'
            );
            break;
            
        case 'west_bank': 
            $villages = array(
                'pouderoyen' => 'Pouderoyen',
                'phoentz_town' => 'Phoentz Town',
                'killarney' => 'Killarney',
                'saint_patricks' => 'Saint Patricks',
                'phoenix_park' => 'Phoenix Park',
                'shamrock_manor' => 'Shamrock Manor',
                'kashmir' => 'Kashmir',
                'malgre_tout' => 'Malgre Tout',
                'versailles' => 'Versailles',
                'goed_fortuin' => 'Goed Fortuin',
                'schoonord' => 'Schoonord',
                'meer_zorgen' => 'Meer Zorgen',
                'joe_vieira_park' => 'Joe Vieira Park',
                'over_demerara_harbour_bridge' => 'Over Demerara Harbour Bridge',
                'la_grange' => 'La Grange',
                'number_one_canal' => 'Number One Canal',
                'mindenburg' => 'Mindenburg',
                'bagotville' => 'Bagotville',
                'la_parfaite_harmony' => 'La Parfaite Harmony',
                'west_minister' => 'West Minister',
                'nismes' => 'Nismes',
                'toevlugt' => 'Toevlugt',
                'la_retraite' => 'La Retraite',
                'stanleytown' => 'Stanleytown',
                'number_two_canal' => 'Number Two Canal',
                'belle_vue' => 'Belle Vue',
                'good_intent' => 'Good Intent',
                'sisters' => 'Sisters',
                'goedverwagting' => 'Goedverwagting',
                'wales_estates' => 'Wales Estates',
                'patentia' => 'Patentia',
                'farm_wbd' => 'Farm (West Bank)'
            );
            break;                

    }


    wp_send_json($villages);
}