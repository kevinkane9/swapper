$(function() {

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
    }

    $('a.status-toggle').click(function (e) {
        e.preventDefault();
        $this = $(this);
        let faStatus = 'active';
        if ($this.hasClass('fa-active-client')) {
            $this.removeClass('fa-active-client').addClass('fa-paused-client');
            faStatus = 'paused';
        } else if ($this.hasClass('fa-paused-client')) {
            $this.removeClass('fa-paused-client').addClass('fa-active-client');
            faStatus = 'active';
        }

        $this.attr('href');

        $.ajax({
            url: $this.attr('href'),
            type: "POST",
            cache: false,
            data:{
                'status':faStatus,
                'client':$this.attr('data-client')
            },
            success: function(html){
                toastr[html.status](html.data.message, capitalizeFirstLetter(html.status))
             }
          });
    });



});