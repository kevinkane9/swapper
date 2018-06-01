;(function($){
    $(document).ready(function(){
        $('select[name="role_id"]').change(function(){
            if ('' != id) {
                var that = $(this),
                    id = that.val(),
                    checkboxes = that.parents('form').find('input[type="checkbox"]');

                checkboxes.attr('disabled', true);

                $.ajax({
                    method: 'post',
                    url: '/users/get-role',
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function (response) {
                        checkboxes.removeAttr('disabled').each(function () {
                            if (-1 !== $.inArray(this.value, response.permissions)) {
                                this.checked = true;
                                $(this).trigger('change');
                            } else {
                                this.checked = false;
                            }
                        });
                    }
                });
            }
        });
    });
})(jQuery);