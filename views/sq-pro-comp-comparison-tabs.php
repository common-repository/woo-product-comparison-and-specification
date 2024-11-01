<?php
if (!defined('ABSPATH'))
{
    exit;
}
$table_product_link = get_option(SQ_PRO_COMP_SLUG.'_table_product_link','yes');
$table_product_price = get_option(SQ_PRO_COMP_SLUG.'_table_product_price','yes');
$table_heading_size = get_option(SQ_PRO_COMP_SLUG.'_table_heading_size','h2');
if(!empty($this->comparison_products))
{
    ?>
    <style>
        table.sq_pro_comp_comparison_tabs td
        {
            white-space: nowrap;
        }
        table.sq_pro_comp_comparison_tabs span.price
        {
            display: block;
            margin-bottom: 5%;
        }
    </style>
    <<?php echo $table_heading_size?>><?php echo apply_filters('sq_pro_comp_comparison_table_heading',__('Compare with similar items',SQ_PRO_COMP_SLUG)); ?></<?php echo $table_heading_size?>>
    <div style="overflow-y: scroll;">
        <table class="shop_attributes sq_pro_comp_comparison_tabs">
            <?php
            foreach ($this->comparison_products_attributes as $name => $attribute)
            {
                echo '<tr>';
                if($name != 'product_details')
                {
                    echo '<th>';
                    echo $name;
                    echo '</th>';
                }
                else
                {
                    echo '<th style="vertical-align:middle;">';
                    _e('Product',SQ_PRO_COMP_SLUG);
                    echo '</th>';
                }
                foreach ($this->comparison_products as $id)
                {
                    switch ($name)
                    {
                        case 'product_details':
                            echo '<td style="vertical-align:middle;">';
                                echo '<div class="sq_pro_comp_product_details"><center>';
                                if($table_product_link == 'yes')
                                {
                                    echo '<a href="'.$attribute[$id]['product_link'].'" target="_blank">';
                                }
                                echo $attribute[$id]['thumb'];
                                echo '<h4>'.$attribute[$id]['title'].'</h4>';
                                if($table_product_price == 'yes')
                                {
                                    echo '<span class="price">'.$attribute[$id]['product_price'].'</span>';
                                }
                                if($table_product_link == 'yes')
                                {
                                    echo '</a>';
                                }
                                echo '</center></div>';
                            echo '</td>';
                            break;
                        default:
                            echo '<td>';
                            if (isset($attribute[$id]))
                            {
                                echo $attribute[$id];
                            }
                            else
                            {
                                echo '-';
                            }
                            echo '</td>';
                            break;
                    }
                }
                echo '</tr>';
            }
            ?>
        </table>
    </div>
    <?php
}