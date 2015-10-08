<?php

/*
  Plugin Name: Woocommerce Compra Directa
  Plugin URI:  https://github.com/ctala/wp-skeleton
  Description: Plugin que permite la compra directa de los productos agregandolos al carrito y llevando a la página de checkout.
  Version:     1.0
  Author:      Cristian Tala Sánchez
  Author URI:  http://www.cristiantala.cl
  License:     MIT
  License URI: http://opensource.org/licenses/MIT
  Domain Path: /languages
  Text Domain: ctala-text_domain
 */
include_once 'helpers/debug.php';

function compraDirecta($idProducto = 8) {
    global $woocommerce;
    //Revisamos que el producto existe, si no existe volvemos al home.
    //Vaciamos Carrito
    //Agregamos al carrito


    $woocommerce->cart->add_to_cart($idProducto);

    //Reenviamos a la página de Checkout.
    $checkout_url = $woocommerce->cart->get_checkout_url();
    wp_redirect($checkout_url);
    exit;
}

function agregarProductoCarrito($idProducto) {
    
}

// Registramos los menus correspondientes

function ctala_setup_admin_menu_compradirecta() {
    if (empty($GLOBALS['admin_page_hooks']['CTala'])) {
        add_menu_page('CTala', 'CTala', 'manage_options', 'ctala', 'ctala_view_admin');
    }
//    add_submenu_page('ctala', 'SubMen', 'Admin Page', 'manage_options', 'myplugin-top-level-admin-menu', 'myplugin_admin_page');
}

function ctala_view_admin() {
    include_once 'views/admin/viewAdmin.php';
}

if (!has_action('admin_menu', 'ctala_setup_admin_menu_compradirecta')) {
    add_action('admin_menu', 'ctala_setup_admin_menu_compradirecta');
}
?>