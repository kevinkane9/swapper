;(function($){
    $(document).ready(function(){
        $('.geoencode-toggle, .disconnect-notifications-toggle, .exception-notifications-toggle').click(function(){
            var that     = $(this),
                checkbox = that.siblings('[type="hidden"]');

            if (that.hasClass('fa-toggle-on')) {
                that.removeClass('fa-toggle-on').addClass('fa-toggle-off');
                checkbox.val('0');
            } else {
                that.removeClass('fa-toggle-off').addClass('fa-toggle-on');
                checkbox.val('1');
            }
        });
    });
})(jQuery);