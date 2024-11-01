<?php

if (!defined('ABSPATH'))
{
    exit;
}

if (!class_exists('SQueue_Pro_Comparison_Process'))
{

    class SQueue_Pro_Comparison_Process
    {
        protected $comparison_products = array();
        protected $comparison_products_attributes = array();
        protected $product;
        protected $product_id;
                
        function __construct()
        {
            add_action( 'woocommerce_before_single_product', array($this,'init_comparison'),10 );
            $comparison_tab = get_option(SQ_PRO_COMP_SLUG.'_comparison_tab','yes');
            if($comparison_tab == 'yes')
            {
                add_filter('woocommerce_product_tabs', array($this, 'add_comparison_tabs'));
            }
            else
            {
                $comparison_table_place = get_option(SQ_PRO_COMP_SLUG.'_comparison_table_place','after_summary');
                switch ($comparison_table_place)
                {
                    case 'before_product':
                        add_action( 'woocommerce_before_single_product', array($this, 'comparison_table_template'),99);
                        break;
                    case 'after_product':
                        add_action( 'woocommerce_after_single_product', array($this, 'comparison_table_template'));
                        break;
                    case 'before_summary':
                        add_action( 'woocommerce_before_single_product_summary', array($this, 'comparison_table_template'));
                        break;
                    case 'after_summary':
                        add_action( 'woocommerce_after_single_product_summary', array($this, 'comparison_table_template'));
                        break;
                }
            }
        }
        
        function init_comparison()
        {
            if(is_product())
            {
                global $product;
                $this->product = $product;
                $this->product_id = $product->get_id();
                $this->comparison_products = $this->get_comparison_products();
                $this->comparison_products_attributes = $this->get_comparison_products_attributes();
            }
        }

        function add_comparison_tabs($tabs)
        {
            $comparison_tab_text = get_option(SQ_PRO_COMP_SLUG . '_comparison_tab_text', __('Product Comparison', SQ_PRO_COMP_SLUG));
            $tabs['desc_tab'] = array(
                'title' => $comparison_tab_text,
                'priority' => 20,
                'callback' => array($this, 'comparison_table_template')
            );
            return $tabs;
        }

        function comparison_table_template()
        {
            require SQ_PRO_COMP_VIEWS.'sq-pro-comp-comparison-tabs.php';
        }
        
        function get_comparison_products()
        {
            $comparison_suggestions = get_option(SQ_PRO_COMP_SLUG.'_comparison_suggestions','categories');
            $categories_id = wc_get_product_cat_ids($this->product_id);
            $products_ids = array();
            switch ($comparison_suggestions)
            {
                case 'categories':
                    if(!empty($categories_id))
                    {
                        $tax_query = array();
                        foreach ($categories_id as $id)
                        {
                            $tax_query[] = array(
                                    'taxonomy' => 'product_cat',
                                    'field' => 'term_id',
                                    'terms' => $id,
                                    'operator' => 'IN',
                                );
                        }
                        $tax_query['relation'] = 'OR';
                        $products_ids =  get_posts(array(
                            'numberposts' => -1,
                            'post_status' => array('publish'),
                            'post_type' => array('product'),
                            'tax_query' => array(
                                'relation'=>'OR',
                                $tax_query
                            ),
                            'fields' => 'ids'
                        ));
                    }
                    break;
            }
            if(!empty($products_ids))
            {
                array_unshift($products_ids, $this->product_id);
                $products_ids = array_values(array_unique($products_ids));
            }
            return $products_ids;
        }
        
        function get_comparison_products_attributes()
        {
            $compare_by = get_option(SQ_PRO_COMP_SLUG.'_compare_by','woocommerce_attributes');
            $table_product_link = get_option(SQ_PRO_COMP_SLUG.'_table_product_link','yes');
            $table_product_price = get_option(SQ_PRO_COMP_SLUG.'_table_product_price','yes');
            $table_product_image_size = get_option(SQ_PRO_COMP_SLUG.'_table_product_image_size','woocommerce_gallery_thumbnail');
            $attributes = array();
            $products = $this->comparison_products;
            switch ($compare_by)
            {
                case 'woocommerce_attributes':
                    foreach ($products as $id)
                    {
                        $att = get_post_meta($id,'_product_attributes',true);
                        if($att)
                        {
                            $attributes[$id]=$att;
                        }
                        else
                        {
                            $attributes[$id]=array();
                        }
                    }
                    break;
            }
            $keys = array();
            foreach ($attributes as $attribute)
            {
                $keys = array_unique(array_merge($keys, array_keys($attribute)));
            }
            $product_attributes = array();
            foreach ($this->comparison_products as $product)
            {
                $pro = wc_get_product($product);
                $product_attributes['product_details'][$product] = array(
                    'title' => $pro->get_title(),
                    'thumb' => $pro->get_image($table_product_image_size),
                    'type' => $pro->get_type(),
                );
                if($table_product_link == 'yes')
                {
                    $product_attributes['product_details'][$product]['product_link'] = get_permalink($product);
                }
                if($table_product_price == 'yes')
                {
                    $product_attributes['product_details'][$product]['product_price'] = $pro->get_price_html();
                }
            }
            foreach ($attributes as $id => $attribute)
            {
                foreach ($keys as $key)
                {
                    if(isset($attribute[$key]))
                    {
                        $product_attributes[$attribute[$key]['name']][$id] = $attribute[$key]['value'];
                    }
                }
            }
            foreach ($product_attributes as $key => $value)
            {
                if(isset($value[$this->product_id]))
                {
                    $this->move_to_top($product_attributes[$key], $this->product_id);
                }
            }
            return $product_attributes;
        }
        
        function move_to_top(&$array, $key) {
            $temp = array($key => $array[$key]);
            unset($array[$key]);
            $array = $temp + $array;
        }

    }

}
$enable_comparison = get_option(SQ_PRO_COMP_SLUG.'_enable_comparison','yes');
if($enable_comparison == 'yes')
{
    new SQueue_Pro_Comparison_Process();
}