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

function compraDirecta() {

    log_me("SE RECIBE PARAMETRO COMPRA DIRECTA");


    if (!isset($_GET['linkCompraDirecta']))
        return true;

    if (!isset($_GET['idProducto']))
        return true;

    $idProducto = $_GET['idProducto'];
    log_me("SE INICIA COMPRA DE PRODUCTO ID  : $idProducto");

    //Revisamos si el idProducto es numerico.
    if (!is_numeric($idProducto)) {
        return true;
    }

    //Ya tenemos el producto para el cual queremos hacer la compra directa.
    //Ahora revisamos que existe.
    $args = array('post_type' => 'product', 'id' => $idProducto);
    $loop = new WP_Query($args);


    if (!(count($loop) == 1)) {
        log_me("NO EXISTE EL PRODUCTO CON ID $idProducto");
        return true;
    }


    global $woocommerce;
    
    //Vaciamos Carrito
    //Agregamos al carrito


    $woocommerce->cart->add_to_cart($idProducto);

    //Reenviamos a la página de Checkout.
    $checkout_url = $woocommerce->cart->get_checkout_url();
    wp_redirect($checkout_url);
    exit;
}

add_action('init', 'compraDirecta');

function agregarProductoCarrito($idProducto) {
    
}

// Registramos los menus correspondientes

function ctala_setup_admin_menu_compradirecta() {
    if (empty($GLOBALS['admin_page_hooks']['ctala_admin'])) {
        add_menu_page(
                'Herramientras extra para Woocommerce por Cristian Tala', 'Extra Tools', 'manage_options', 'ctala_admin', 'ctala_view_admin');
    }

    add_submenu_page('ctala_admin', 'Generar Link Directo de Compra', 'Generar Link Directo de Compra', 'manage_options', 'crearLinkDirecto', 'ctala_view_admin_compradirecta'
    );
}

function ctala_view_admin_compradirecta() {
    include_once 'views/admin/viewAdmin.php';
}

if (!has_action('admin_menu', 'ctala_setup_admin_menu_compradirecta')) {
    add_action('admin_menu', 'ctala_setup_admin_menu_compradirecta');
}
?>