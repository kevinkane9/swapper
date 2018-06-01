(function($) {
    $(document).ready(function(){

        var $body         = $('body'),
            toggleSidebar = $('#toggle-sidebar');

        $body.show();

        /**
         * Common
         */

        // sidebar
        toggleSidebar.click(function(){
            var that      = $(this),
                leftSide  = $('#sidebar-collapse'),
                rightSide = $('.right-side-content');

            switch (that.attr('data-state')) {
                case 'open':
                    leftSide.hide();
                    rightSide.attr('class', 'col-sm-12 main right-side-content');
                    that.attr('data-state', 'closed');
                    toggleSidebar.html('&rarr;');
                    break;

                case 'closed':
                    leftSide.show();
                    rightSide.attr('class', 'col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main right-side-content');
                    that.attr('data-state', 'open');
                    toggleSidebar.html('&larr;');
                    break;
            }

            $.ajax({
                url: '/home/sidebar',
                method: 'post',
                dataType: 'json',
                data: {  state: 'closed' == that.attr('data-state') ? true : false }
            });
        });

        // form validation
        $('button[type="submit"]').click(function(){
            var that    = $(this),
                form    = that.parents('form');

            if (form.validate()) {
                that.loader('on');
                form.submit();
            } else {
                return false;
            }
        });

        // sweet alerts
        $body.on('click', '.sweet-confirm-href', function(e){
            e.preventDefault();

            var that  = $(e.currentTarget),
                title = that.attr('data-sweet-title'),
                text  = that.attr('data-sweet-text');

            swal({
                    title: undefined == title ? "Are you sure?" : title,
                    text: undefined == text ? null : text,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes",
                    cancelButtonText: "Cancel"
                },
                function(confirmed){
                    if (confirmed) {
                        location.href = e.currentTarget.href;
                    }
                }
            );
        });

        $body.on('click', '.sweet-confirm-ajax', function(e){
            swal({
                    title: "Are you sure?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes",
                    cancelButtonText: "Cancel"
                },
                function(confirmed){
                    if (confirmed) {
                        $(e.currentTarget).trigger('click-confirmed');
                    }
                }
            );
        });

        // datepickers
        if ("undefined" != typeof($.fn.datepicker)) {
            $.fn.datepicker.noConflict();
            $('.datepicker-future-only').datepicker({minDate: 0});
            $('.datepicker-here').datepicker();
        }

        // tooltips
        $('[data-toggle="tooltip"]').tooltip();

        var theInput = $('[name="geotarget"]'),
            geoLat   = $('[name="geotarget_lat"]'),
            geoLng   = $('[name="geotarget_lng"]');

        if (1 == theInput.length && "undefined" != typeof(google)) {
            autocomplete = new google.maps.places.Autocomplete(
                theInput[0],
                {
                    types: ['(regions)'],
                    componentRestrictions: {country: 'us'}
                }
            );

            autocomplete.addListener('place_changed', function(){
                var place = autocomplete.getPlace();
                geoLat.val(place.geometry.location.lat());
                geoLng.val(place.geometry.location.lng());
            });
        }

        theInput.on('keyup keypress blur change', function(){
            if ('' == theInput.val()) {
                geoLat.val('');
                geoLng.val('');
            }
        });

        if (1 == $('.view-survey').length) {
            $('[name="feedback"]').change(function(){

                if ('other' == $('[name="feedback"]:checked').val()) {
                    $('[name="feedback_other"]').attr('data-validation', 'not-empty');
                } else {
                    $('[name="feedback_other"]').removeAttr('data-validation').removeClass('error');
                }
            });
        }

        $('.csm_user').editable({
            value: $(this).attr('data-value'),
            source: $(this).attr('data-source'),
            success: function(response, newValue) {
                id = $(this).attr('data-pk');
                $('#pod_' + id).html(response);
            }
        });
    });
})(jQuery);

/** responsive nav **/
$(window).on('resize', function () {
    if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
    if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
});