<?php
if (!defined('ABSPATH'))
{
    exit;
}
$table_product_link = get_option(SQ_PRO_COMP_SLUG.'_table_product_link','yes');
$table_product_price = get_option(SQ_PRO_COMP_SLUG.'_table_product_price','yes');
$table_heading_size = get_option(SQ_PRO_COMP_SLUG.'_table_heading_size','h2');
$table_product_image_size = get_option(SQ_PRO_COMP_SLUG.'_table_product_image_size','woocommerce_gallery_thumbnail');
?>
<form method="post" action="<?php echo admin_url("admin.php?page=" . SQ_PRO_COMP_SLUG.'&tab=table_customization'); ?>">
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="table_product_link">
                    <?php _e('Link to Product Page', SQ_PRO_COMP_SLUG); ?>
                </label>
            </th>
            <td>
                <label>
                    <input type="checkbox" name="table_product_link" value="yes" <?php echo (($table_product_link == 'yes')?"checked":"") ?>> <?php _e('Enable',SQ_PRO_COMP_SLUG); ?>
                </label>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="table_product_price">
                    <?php _e('Product Price', SQ_PRO_COMP_SLUG); ?>
                </label>
            </th>
            <td>
                <label>
                    <input type="checkbox" name="table_product_price" value="yes" <?php echo (($table_product_price == 'yes')?"checked":"") ?>> <?php _e('Show',SQ_PRO_COMP_SLUG); ?>
                </label>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="table_heading_size">
                    <?php _e('Table Heading Size', SQ_WEI_INV_SLUG); ?>
                </label>
            </th>
            <td>
                <select name="table_heading_size" id="table_heading_size" style="width:20%;">
                    <option value="h1" <?php echo (($table_heading_size == 'h1')?"selected":"") ?>>H1</option>
                    <option value="h2" <?php echo (($table_heading_size == 'h2')?"selected":"") ?>>H2</option>
                    <option value="h3" <?php echo (($table_heading_size == 'h3')?"selected":"") ?>>H3</option>
                    <option value="h4" <?php echo (($table_heading_size == 'h4')?"selected":"") ?>>H4</option>
                    <option value="h5" <?php echo (($table_heading_size == 'h5')?"selected":"") ?>>H5</option>
                    <option value="h6" <?php echo (($table_heading_size == 'h6')?"selected":"") ?>>H6</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="table_product_image_size">
                    <?php _e('Table Product Image Size', SQ_WEI_INV_SLUG); ?>
                </label>
            </th>
            <td>
                <select name="table_product_image_size" id="table_product_image_size" style="width:40%;">
                    <option value="woocommerce_gallery_thumbnail" <?php echo (($table_product_image_size == 'woocommerce_gallery_thumbnail')?"selected":"") ?>>WooCommerce Gallery Thumbnail</option>
                    <option value="woocommerce_single" <?php echo (($table_product_image_size == 'woocommerce_single')?"selected":"") ?>>WooCommerce Single</option>
                    <option value="woocommerce_thumbnail" <?php echo (($table_product_image_size == 'woocommerce_thumbnail')?"selected":"") ?>>WooCommerce Thumbnail</option>
                </select>
                <p class="description">
                    <b>WooCommerce Single</b> - Shows the full product image, as uploaded, so is always uncropped by default. It defaults to 600px width.<br>
                    <b>WooCommerce Gallery Thumbnail</b> - Is always square cropped and defaults to 100×100 pixels. This is used for navigating images in the gallery.<br>
                    <b>WooCommerce Thumbnail</b> - Defaults to 600px width, square cropped so the product grids look neat. The aspect ratio for cropping can be customized by the store owner.
                </p>
            </td>
        </tr>
    </table>
    <input type="submit" class="button button-primary" name="sq_products_comparison_table_customization" id="sq_products_comparison_table_customization" value="<?php _e("Save Changes", SQ_PRO_COMP_SLUG); ?>">
</form>