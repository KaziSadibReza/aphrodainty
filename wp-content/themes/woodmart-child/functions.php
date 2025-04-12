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
 * @since 1.0.0
 * include all save and show fields data in admin
 * @return void
 */
include_once 'includes/save-and-show-fields-data-in-admin.php';