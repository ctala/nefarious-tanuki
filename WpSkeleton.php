<?php

/*
  Plugin Name: Woo Compra Directa
  Plugin URI:  https://github.com/ctala/nefarious-tanuki
  Description: Plugin que permite la compra directa de los productos agregandolos al carrito y llevando a la página de checkout.
  Version:     0.1
  Author:      Cristian Tala Sánchez
  Author URI:  http://www.cristiantala.cl
  License:     MIT
  License URI: http://opensource.org/licenses/MIT
  Domain Path: /languages
  Text Domain: ctala-text_domain
 */
include_once 'helpers/debug.php';

/**
 * Esto nos sirve si y solo si woocommerce está activo.
 * */
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {


    function compraDirecta() {

        if (!isset($_GET['linkCompraDirecta']))
            return true;

        log_me("SE RECIBE PARAMETRO COMPRA DIRECTA");

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

        //Vaciamos Carrito si existe la variable empty

        if (isset($_REQUEST["empty"])) {
            log_me("Vaciamos carrito");
            WC()->cart->empty_cart();
        }
        //Agregamos al carrito
        log_me("Agregamos a carrito");
        WC()->cart->add_to_cart($idProducto);


        //Reenviamos a la página de Checkout.
        $checkout_url = $woocommerce->cart->get_checkout_url();
        log_me("Redirigimos a checkout $checkout_url ");
        wp_redirect($checkout_url);
        exit;
    }

    add_action('wp_loaded', 'compraDirecta');

    add_action('edit_form_top', 'compraDirectaLinkInfo');

    function compraDirectaLinkInfo($post) {
        if (in_array($post->post_type, array('product'))) {
            $post_status = get_post_status();
            if ($post_status == 'publish') {
                include_once plugin_dir_path(__FILE__) . '/views/views/product/compraDirectaLink.php';
            }
        }
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
}

class WCompraDirecta {
    
}

?>