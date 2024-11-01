jQuery(function () {
    jQuery('#specifcation_product_data').on('change','#sq_specs_is_data',function(){
        if(jQuery(this).is(':checked'))
        {
            jQuery(this).closest('tr').find('#sq_specs_input_value').hide();
            jQuery(this).closest('tr').find('#sq_specs_select_data').show();
        }
        else
        {
            jQuery(this).closest('tr').find('#sq_specs_input_value').show();
            jQuery(this).closest('tr').find('#sq_specs_select_data').hide();
        }
    });
    jQuery('#specifcation_product_data').on('click','.sq_new_specs_tr .sq_add_new_specs',function(){
        var duplicate = jQuery('#sq_specs_duplicator').html();
        var count = parseInt(jQuery('#sq_specs_count').val())+1;
        html = duplicate.replace(/resolve_count/g,count);
        jQuery('#sq_new_specs_table tr:last').after('<tr class="sq_new_specs_tr">'+html+'</tr>');
        jQuery('#sq_specs_count').val(count);
        jQuery(this).parent('td').html('-');
    });
    jQuery('#specifcation_product_data').on('click','.sq_exist_specs_tr .sq_remove_specs',function(){
        jQuery(this).closest('tr').remove();
    });
});

jQuery(function () {
    jQuery("#sq_specs_is_data").each(function () {
        jQuery(this).trigger('change');
    });
});