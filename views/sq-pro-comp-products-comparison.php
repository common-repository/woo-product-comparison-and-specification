<?php
if (!defined('ABSPATH'))
{
    exit;
}
$enable_comparison = get_option(SQ_PRO_COMP_SLUG.'_enable_comparison','yes');
$comparison_tab = get_option(SQ_PRO_COMP_SLUG.'_comparison_tab','yes');
$comparison_table_place = get_option(SQ_PRO_COMP_SLUG.'_comparison_table_place','after_summary');
$comparison_tab_text = get_option(SQ_PRO_COMP_SLUG.'_comparison_tab_text',__('Product Comparison',SQ_PRO_COMP_SLUG));
$comparison_suggestions = get_option(SQ_PRO_COMP_SLUG.'_comparison_suggestions','categories');
$compare_by = get_option(SQ_PRO_COMP_SLUG.'_compare_by','woocommerce_attributes');
?>
<form method="post" action="<?php echo admin_url("admin.php?page=" . SQ_PRO_COMP_SLUG.'&tab=products_comparison'); ?>">
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="enable_comparison">
                    <?php _e('Product Comparison', SQ_PRO_COMP_SLUG); ?>
                </label>
            </th>
            <td>
                <label>
                    <input type="checkbox" name="enable_comparison" value="yes" <?php echo (($enable_comparison == 'yes')?"checked":"") ?>> <?php _e('Enable',SQ_PRO_COMP_SLUG); ?>
                </label>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="comparison_tab">
                    <?php _e('Comparison Tab', SQ_PRO_COMP_SLUG); ?>
                </label>
            </th>
            <td>
                <label>
                    <input type="checkbox" name="comparison_tab" id="comparison_tab" value="yes" <?php echo (($comparison_tab == 'yes')?"checked":"") ?>> <?php _e('Enable',SQ_PRO_COMP_SLUG); ?>
                </label>
                <p class="description"><?php _e('This will add a comparison tabs on single product page.',SQ_PRO_COMP_SLUG); ?></p>
            </td>
        </tr>
        <tr class="comparison_table_place_tr">
            <th scope="row">
                <label for="comparison_table_place">
                    <?php _e('Comparison Table Place', SQ_PRO_COMP_SLUG); ?>
                </label>
            </th>
            <td>
                <label>
                    <input name="comparison_table_place" type="radio" value="before_product" <?php echo (($comparison_table_place == 'before_product')?"checked":"") ?>>
                    <?php _e("Before Single Product Starts", SQ_PRO_COMP_SLUG); ?>
                </label>
                <br>
                <label>
                    <input name="comparison_table_place" type="radio" value="after_product" <?php echo (($comparison_table_place == 'after_product')?"checked":"") ?>>
                    <?php _e("After Single Product Ends", SQ_PRO_COMP_SLUG); ?>
                </label>
                <br>
                <label>
                    <input name="comparison_table_place" type="radio" value="before_summary" <?php echo (($comparison_table_place == 'before_summary')?"checked":"") ?>>
                    <?php _e("Before Single Product Summary", SQ_PRO_COMP_SLUG); ?>
                </label>
                <br>
                <label>
                    <input name="comparison_table_place" type="radio" value="after_summary" <?php echo (($comparison_table_place == 'after_summary')?"checked":"") ?>>
                    <?php _e("After Single Product Summary", SQ_PRO_COMP_SLUG); ?>
                </label>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="comparison_tab_text">
                    <?php _e('Comparison Tab Text', SQ_PRO_COMP_SLUG); ?>
                </label>
            </th>
            <td>
                <input name="comparison_tab_text" size="43" type="text" value="<?php echo $comparison_tab_text; ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="comparison_suggestions">
                    <?php _e('Comparison Suggestions', SQ_PRO_COMP_SLUG); ?>
                </label>
            </th>
            <td>
                <label>
                    <input name="comparison_suggestions" type="radio" value="categories" <?php echo (($comparison_suggestions == 'categories')?"checked":"") ?>>
                    <?php _e("Based on product categories", SQ_PRO_COMP_SLUG); ?>
                </label>
                <br>
                <label>
                    <?php _e("Based on specific products (Pro Feature)", SQ_PRO_COMP_SLUG); ?>
                </label>
                <p class="description"><?php _e('Based on products categories will pull all the products from its categories for comparison',SQ_PRO_COMP_SLUG); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="compare_by">
                    <?php _e('Compare Products by', SQ_PRO_COMP_SLUG); ?>
                </label>
            </th>
            <td>
                <label>
                    <input name="compare_by" type="radio" value="woocommerce_attributes" <?php echo (($compare_by == 'woocommerce_attributes')?"checked":"") ?>>
                    <?php _e("WooCommerce Product Attributes", SQ_PRO_COMP_SLUG); ?>
                </label>
                <br>
                <label>
                    <?php _e("Product Specifications (pro Feature)", SQ_PRO_COMP_SLUG); ?>
                </label>
            </td>
        </tr>
    </table>
    <input type="submit" class="button button-primary" name="sq_products_comparison_settings" id="sq_products_comparison_settings" value="<?php _e("Save Changes", SQ_PRO_COMP_SLUG); ?>">
</form>