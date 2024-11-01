<?php

/*
  Plugin Name: WooCommerce Product Comparison and Specification
  Plugin URI: https://stepqueue.com/plugins/woocommerce-product-comparison-and-specification/
  Description: The best way to compare products based on WooCommerce attributes and helps to view similar products.
  Version: 1.0.2
  Author: StepQueue
  Author URI: https://stepqueue.com
  License: GPL 3.0
  WC requires at least: 3.0.0
  WC tested up to: 3.2.0
 */

if (!defined('ABSPATH'))
{
    exit;
}
require_once(ABSPATH . "wp-admin/includes/plugin.php");
if (in_array('woocommerce/woocommerce.php', get_option('active_plugins')))
{
    if (!in_array('woocommerce-product-comparison-and-specification-pro/woocommerce-product-comparison-and-specification-pro.php', get_option('active_plugins')))
    {
        if (!defined('SQ_PRO_COMP_VERSION'))
        {
            define('SQ_PRO_COMP_VERSION', '1.0.2');
        }
        if (!defined('SQ_PRO_COMP_SLUG'))
        {
            define('SQ_PRO_COMP_SLUG', 'sq_pro_comp');
        }
        if (!defined('SQ_PRO_COMP_URL'))
        {
            define('SQ_PRO_COMP_URL', plugin_dir_url(__FILE__));
        }
        if (!defined('SQ_PRO_COMP_PATH'))
        {
            define('SQ_PRO_COMP_PATH', plugin_dir_path(__FILE__));
        }
        if (!defined('SQ_PRO_COMP_IMG'))
        {
            define('SQ_PRO_COMP_IMG', SQ_PRO_COMP_URL . "assets/img/");
        }
        if (!defined('SQ_PRO_COMP_CSS'))
        {
            define('SQ_PRO_COMP_CSS', SQ_PRO_COMP_URL . "assets/css/");
        }
        if (!defined('SQ_PRO_COMP_JS'))
        {
            define('SQ_PRO_COMP_JS', SQ_PRO_COMP_URL . "assets/js/");
        }
        if (!defined('SQ_PRO_COMP_INC'))
        {
            define('SQ_PRO_COMP_INC', SQ_PRO_COMP_PATH . "includes/");
        }
        if (!defined('SQ_PRO_COMP_VIEWS'))
        {
            define('SQ_PRO_COMP_VIEWS', SQ_PRO_COMP_PATH . "views/");
        }
        add_action('init', 'sq_pro_comp_run', 99);

        function sq_pro_comp_run()
        {
            require_once (SQ_PRO_COMP_INC . "sq-pro-comp-init.php");
            require_once (SQ_PRO_COMP_INC . "sq-pro-comp-processor.php");
            new SQueue_Pro_Comp();
            if (!class_exists('StepQueue_Uninstall_feedback_Listener')) {
                require_once (SQ_PRO_COMP_INC . "class-stepqueue-uninstall.php");
            }
            $qvar = array(
                'name' => 'WooCommerce Product Comparison and Specification',
                'version' => SQ_PRO_COMP_VERSION,
                'slug' => 'woo-product-comparison-and-specification',
                'lang' => SQ_PRO_COMP_SLUG,
            );
            new StepQueue_Uninstall_feedback_Listener($qvar);
        }
        
        add_filter('plugin_row_meta', 'sq_pro_comp_plugin_row_meta', 10, 2);
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'sq_pro_comp_plugin_action_link');

        function sq_pro_comp_plugin_action_link($links)
        {
            $plugin_links = array(
                '<a href="' . admin_url('admin.php?page='.SQ_PRO_COMP_SLUG.'&tab=products_comparison') . '">' . __('Comparison Settings', SQ_PRO_COMP_SLUG) . '</a>'
            );
            if (array_key_exists('deactivate', $links))
            {
                $links['deactivate'] = str_replace('<a', '<a class="woo-product-comparison-and-specification-deactivate-link"', $links['deactivate']);
            }
            return array_merge($plugin_links, $links);
        }

        function sq_pro_comp_plugin_row_meta($links, $file)
        {
            if ($file == plugin_basename(__FILE__))
            {
                $row_meta = array(
                    '<a href="https://stepqueue.com/documentation/woocommerce-product-comparison-and-specification-setup/" target="_blank">' . __('Documentation', SQ_PRO_COMP_SLUG) . '</a>',
                    '<a href="https://stepqueue.com/plugins/woocommerce-product-comparison-and-specification/" target="_blank">' . __('Buy Pro', SQ_PRO_COMP_SLUG) . '</a>',
                    '<a href="https://wordpress.org/support/plugin/woocommerce-product-comparison-and-specification/" target="_blank">' . __('Support', SQ_PRO_COMP_SLUG) . '</a>'
                );
                return array_merge($links, $row_meta);
            }
            return (array) $links;
        }

    } else
    {
        add_action('admin_notices', 'sq_pro_comp_admin_notices', 99);
        deactivate_plugins(plugin_basename(__FILE__));

        function sq_pro_comp_admin_notices()
        {
            is_admin() && add_filter('gettext', function($translated_text, $untranslated_text, $domain)
                    {
                        $old = array(
                            "Plugin <strong>activated</strong>.",
                            "Selected plugins <strong>activated</strong>."
                        );
                        $new = "<span style='color:red'>WooCommerce Product Comparison and Specification - Pro Version is currently installed and active</span>";
                        if (in_array($untranslated_text, $old, true))
                        {
                            $translated_text = $new;
                        }
                        return $translated_text;
                    }, 99, 3);
        }

        return;
    }
} else
{
    add_action('admin_notices', 'sq_pro_comp_wc_basic_admin_notices', 99);
    deactivate_plugins(plugin_basename(__FILE__));

    function sq_pro_comp_wc_basic_admin_notices()
    {
        is_admin() && add_filter('gettext', function($translated_text, $untranslated_text, $domain)
                {
                    $old = array(
                        "Plugin <strong>activated</strong>.",
                        "Selected plugins <strong>activated</strong>."
                    );
                    $new = "<span style='color:red'>WooCommerce Product Comparison and Specification - WooCommerce is not Installed</span>";
                    if (in_array($untranslated_text, $old, true))
                    {
                        $translated_text = $new;
                    }
                    return $translated_text;
                }, 99, 3);
    }

    return;
}