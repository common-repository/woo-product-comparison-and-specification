jQuery(function () {
    jQuery('#products_comparison_section').on('change','#comparison_tab',function(){
        if(jQuery(this).is(':checked'))
        {
            jQuery('.comparison_table_place_tr').hide();
        }
        else
        {
            jQuery('.comparison_table_place_tr').show();
        }
    });
});

jQuery(function () {
    jQuery('#comparison_tab').trigger('change');
    jQuery("select").each(function () {
        jQuery(this).select2({minimumResultsForSearch: -1});
    });
});