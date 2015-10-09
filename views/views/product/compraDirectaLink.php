<?php
$site = get_site_url();
$idProducto = get_the_ID();
$url = $site . "?linkCompraDirecta&idProducto=" . $idProducto;

log_me($url);
?>


<div id="edit-slug-box" class="hide-if-no-js">
    <strong>Link Compra Directa :</strong>
    <span id="sample-permalink" tabindex="-1"><?php echo $url ?></span>
</div>