<?php

if (!defined('ABSPATH'))
{
    exit;
}

class SQueue_Pro_Comp
{

    function __construct()
    {
        add_action('admin_menu', array($this, 'admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
    }
    
    function admin_menu()
    {
        add_submenu_page('woocommerce', __('Products Comparison & Specification',SQ_PRO_COMP_SLUG), __('Products Comparison & Specification',SQ_PRO_COMP_SLUG), 'manage_woocommerce',SQ_PRO_COMP_SLUG, array($this, 'render_tab'));
    }
    
    function admin_scripts()
    {
        $page = (!empty($_GET['page']))? esc_attr($_GET['page']) : '';
        $tab = (!empty($_GET['tab']))? esc_attr($_GET['tab']) : 'products_comparison';
        if($page == SQ_PRO_COMP_SLUG)
        {
            wp_enqueue_script('jquery');
            wp_enqueue_script('wc-enhanced-select');
            wp_enqueue_style( 'woocommerce_admin_styles');
            wp_enqueue_style( 'sq-pro-comp-admin-page',SQ_PRO_COMP_CSS.'sq-pro-comp-admin-page.css');
            wp_enqueue_script( 'sq-pro-comp-admin-page',SQ_PRO_COMP_JS.'sq-pro-comp-admin-page.js');
        }
        $screen = get_current_screen();
        $screen_id = $screen ? $screen->id : '';
        if (in_array($screen_id, array('product', 'edit-product')))
        {
            wp_enqueue_style( 'sq-pro-comp-admin-product',SQ_PRO_COMP_CSS.'sq-pro-comp-admin-product.css');
            wp_enqueue_script( 'sq-pro-comp-admin-product',SQ_PRO_COMP_JS.'sq-pro-comp-admin-product.js');
        }
        if($page == SQ_PRO_COMP_SLUG && $tab == 'premium')
        {
            wp_enqueue_style('bootstrap', SQ_PRO_COMP_CSS . 'bootstrap.css');
        }
    }
    
    function render_tab()
    {
        $page = (!empty($_GET['page']))? esc_attr($_GET['page']) : '';
        $tab = (!empty($_GET['tab']))? esc_attr($_GET['tab']) : 'products_comparison';
        if($page == SQ_PRO_COMP_SLUG && $tab == 'products_comparison' && isset($_POST['sq_products_comparison_settings']))
        {
            if(isset($_POST['enable_comparison']))
            {
                update_option(SQ_PRO_COMP_SLUG.'_enable_comparison','yes');
            }
            else
            {
                update_option(SQ_PRO_COMP_SLUG.'_enable_comparison','no');
            }
            if(isset($_POST['comparison_tab']))
            {
                update_option(SQ_PRO_COMP_SLUG.'_comparison_tab','yes');
            }
            else
            {
                update_option(SQ_PRO_COMP_SLUG.'_comparison_tab','no');
            }
            update_option(SQ_PRO_COMP_SLUG.'_comparison_table_place', sanitize_text_field($_POST['comparison_table_place']));
            update_option(SQ_PRO_COMP_SLUG.'_comparison_tab_text', sanitize_text_field($_POST['comparison_tab_text']));
            update_option(SQ_PRO_COMP_SLUG.'_comparison_suggestions',sanitize_text_field($_POST['comparison_suggestions']));
            update_option(SQ_PRO_COMP_SLUG.'_compare_by', sanitize_text_field($_POST['compare_by']));
        }
        if($page == SQ_PRO_COMP_SLUG && $tab == 'table_customization' && isset($_POST['sq_products_comparison_table_customization']))
        {
            if(isset($_POST['table_product_link']))
            {
                update_option(SQ_PRO_COMP_SLUG.'_table_product_link','yes');
            }
            else
            {
                update_option(SQ_PRO_COMP_SLUG.'_table_product_link','no');
            }
            if(isset($_POST['table_product_price']))
            {
                update_option(SQ_PRO_COMP_SLUG.'_table_product_price','yes');
            }
            else
            {
                update_option(SQ_PRO_COMP_SLUG.'_table_product_price','no');
            }
            update_option(SQ_PRO_COMP_SLUG.'_table_heading_size', sanitize_text_field($_POST['table_heading_size']));
            update_option(SQ_PRO_COMP_SLUG.'_table_product_image_size', sanitize_text_field($_POST['table_product_image_size']));
        }
        echo '
            <div class="wrap">
                <h1 class="wp-heading-inline">'.__('WooCommerce Product Comparison and Specification', SQ_PRO_COMP_SLUG).'</h1>
                <hr class="wp-header-end">';
            $this->admin_page_tabs($tab);
            switch($tab)
            {
                case "products_comparison":
                    echo '<div class="table-box table-box-main" id="products_comparison_section" style="margin-top: 10px;">';
                       require SQ_PRO_COMP_VIEWS.'sq-pro-comp-products-comparison.php';
                    echo '</div>';
                    break;
                case "table_customization":
                    echo '<div class="table-box table-box-main" id="table_customization_section" style="margin-top: 10px;">';
                       require SQ_PRO_COMP_VIEWS.'sq-pro-comp-table-customization.php';
                    echo '</div>';
                    break;
                case "premium":
                    echo '<div class="table-box table-box-main" id="premium_section" style="margin-top: 10px;">';
                       require SQ_PRO_COMP_VIEWS.'upgrade_premium.php';
                    echo '</div>';
                    break;
            }
    echo '</div>';
    }
    
    function admin_page_tabs($current = 'products_comparison') {
        $tabs = array(
            'products_comparison'   => __("Products Comparison", SQ_PRO_COMP_SLUG),
            'table_customization'   => __("Comparison Table Customization", SQ_PRO_COMP_SLUG),
            'premium'   => __("Premium Features", SQ_PRO_COMP_SLUG)
        );
        $html =  '<h2 class="nav-tab-wrapper">';
        foreach( $tabs as $tab => $name ){
            $class = ($tab == $current) ? 'nav-tab-active' : '';
            $style = ($tab == $current) ? 'border-bottom: 1px solid transparent !important;' : '';
            $html .=  '<a style="text-decoration:none !important;'.$style.'" class="nav-tab ' . $class . '" href="?page='.SQ_PRO_COMP_SLUG.'&tab=' . $tab . '">' . $name . '</a>';
        }
        $html .= '</h2>';
        echo $html;
    }

}