<?php
/**
 * Plugin Name: (0,00) Zero Price to FREE
 * Plugin URI: https://VEINTIUNO.world/mercadillo
 * Description: This plugin changes the display of product prices from zero to 'FREE' in WooCommerce. The 'FREE' text can be customized from the WooCommerce > Settings > Products > General page.
 * Version: 1.0.2
 * Author: SuperATic inc.
 * Author URI: https://SuperAtic.com/
 * License: GPL2
 * Domanin: zero-price-to-free
 */

// Add a new setting field in WooCommerce > Settings > Products > General
add_filter('woocommerce_product_settings', 'add_custom_free_text_field');

function add_custom_free_text_field($settings){
    
    $settings[] = array(
        'title'     => __( 'FREE Product Settings', 'zero-price-to-free'),
        'type'      => 'title',
        'desc'      => '',
        'id'        => 'free_product_options'
    );
    
    $settings[] = array(
        'title'     => __( 'Free Product Text', 'zero-price-to-free' ),
        'desc'      => __( 'This text will replace the price when a product is free', 'zero-price-to-free' ),
        'id'        => 'woocommerce_free_product_text',
        'default'   => 'FREE',
        'type'      => 'text',
    );
    
    $settings[] = array(
        'type' => 'sectionend',
        'id' => 'free_product_options',
    );
    
    return $settings;
}

// Modify the product price if it's zero
add_filter('woocommerce_get_price_html', 'change_free_price_notification', 10, 2);

function change_free_price_notification($price, $product){

    // Retrieve the custom text from the setting field
    $free_text = get_option('woocommerce_free_product_text', 'FREE');

    if ('0' === $product->get_price()){
        $price = '<span class="amount">' . esc_html($free_text) . '</span>';
    }

    return $price;
}
