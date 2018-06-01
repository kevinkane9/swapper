;(function($){
    $(document).ready(function(){
        $('select').change(function(){
            var that          = $(this);
            var selectedCount = that.find(':selected').length;
            var badge         = that.parents('.column').siblings('.badge-column').find('.badge');

            if (selectedCount > 0) {
                badge.html(selectedCount);
            } else {
                badge.html('');
            }
        });

        $('[name="max_prospects"]').change(function(){
            if ('' == $(this).val()) {
                $('[name="max_prospects_scope"]').removeAttr('data-validation');
            } else {
                $('[name="max_prospects_scope"]').attr('data-validation', 'not-empty');
            }
        });
    });
})(jQuery);