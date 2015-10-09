<?php
$site = get_site_url();
$idProducto = get_the_ID();
$url = $site . "?linkCompraDirecta&idProducto=" . $idProducto;

log_me($url);
?>
<form>
    <label for="linkCompraDirecta">Link Compra Directa : </label>


    <input name="post_compraDirecta" value="<?php echo $url ?>" 
           id="title"
           type="text"
           disabled="false"
           style="width: 100%"
           >
</form> 