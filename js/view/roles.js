;(function($){
    $(document).ready(function(){
        $('a.not-allowed').click(function(){
            swal({
                title: "Oops",
                text: "You cannot delete a role that has users",
                type: "warning",
                confirmButtonText: "OK"
            });
        });
    });
})(jQuery);