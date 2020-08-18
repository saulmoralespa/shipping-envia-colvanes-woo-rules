<?php
/*
Plugin Name: Shipping Envia Colvanes Woo Rules
Description: Reglas para Shipping Envia Colvanes Woo
Version: 1.0.0
Author: Saul Morales Pacheco
Author URI: https://saulmoralespa.com
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; //Exit if accessed directly
}

if(!defined('SHIPPING_ENVIA_COLVANES_EC_RULES_VERSION')){
    define('SHIPPING_ENVIA_COLVANES_EC_RULES_VERSION', '1.0.0');
}

add_action( 'plugins_loaded', 'shipping_envia_colvanes_ec_rules_rules_init', 1000);

function shipping_envia_colvanes_ec_rules_rules_init(){
    if(!shipping_envia_colvanes_ec_rules_requirements()) return;

    add_filter('shipping_envia_colvanes_get_shop', 'shipping_envia_colvanes_get_shop_filter', 10, 2);

}

function shipping_envia_colvanes_ec_rules_notices( $notice ) {
    ?>
    <div class="error notice">
        <p><?php echo esc_html( $notice ); ?></p>
    </div>
    <?php
}

function shipping_envia_colvanes_ec_rules_requirements(){
    if (!class_exists('Shipping_Envia_Colvanes_Plugin_EC')) {
        if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
            add_action(
                'admin_notices',
                function() {
                    shipping_envia_colvanes_ec_rules_notices( 'Shipping Envia Colvanes Woo Rules: Requiere que se encuentre instalado y activo: Shipping Envia Colvanes Woo' );
                }
            );
        }
        return false;
    }

    return true;
}

function shipping_envia_colvanes_get_shop_filter($store, $product_id){
    $vendor_id = wcfm_get_vendor_id_by_post( $product_id );
    return $vendor_id && get_user_meta( $vendor_id, 'wcfmmp_profile_settings', true ) ?? null;
}