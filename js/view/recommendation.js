;(function($){
    $(document).ready(function(){

        // toggling current client
        $('.icon-toggle').click(function(){

            var self           = $(this),
                input          = $('input[name="current_sapper_client"]'),
                clientDropdown = $('#client');

            // toggling off
            if (self.hasClass('fa-toggle-on')) {
                clearFields(true);
                clientDropdown.removeAttr('data-validation').find('~ .select2 .select2-selection').removeClass('error');
                self.removeClass('fa-toggle-on').addClass('fa-toggle-off');
                input.val(0);
                $('.intro-text').addClass('hidden').filter('.not-current-client').removeClass('hidden');
                $('.sapper-client-name-container').addClass('hidden');
            } else {
                // toggline on
                clientDropdown.attr('data-validation', 'not-empty');
                self.removeClass('fa-toggle-off').addClass('fa-toggle-on');
                input.val(1);
                $('.intro-text').addClass('hidden').filter('.current-client').removeClass('hidden');
                $('.sapper-client-name-container').removeClass('hidden');
            }
        });

        // clear fields
        var clearFields = function(includingClient, includingNonClientFields){
            $('#state').val('').trigger('change.select2');
            $('#city').val('');
            $('#zip').val('');
            $('#num-employees').val('').trigger('change.select2');
            $('#company-revenue').val('').trigger('change.select2');
            $('#industry').val('').trigger('change.select2');
            $('#founding-year').val('').trigger('change.select2');

            if (true == includingClient) {
                $('#client').val('').trigger('change.select2');
            }

            if (true == includingNonClientFields) {
                $('#approved-industries, #approved-titles').val([]).trigger('change');
            }
        };

        // select2 inputs
        $('#client')
            .select2({
                placeholder: "Enter Company Name",
                allowClear: true
            })
            .change(function(){

                var clientId     = $(this).val(),
                    clientFields = $('#state, #city, #zip, #num-employees, #company-revenue, #industry, #founding-year');

                if ('' !== clientId) {

                    clientFields.addClass('disabled');

                    $.ajax({
                        url: '/recommendation/get-client-attributes',
                        method: 'post',
                        dataType: 'json',
                        data: { clientId: clientId },
                        success: function(response) {

                            clientFields.removeClass('disabled');

                            switch (response.status){
                                case 'success':

                                    $('#state').val(response.data.state).trigger('change.select2');
                                    $('#city').val(response.data.city);
                                    $('#zip').val(response.data.postal_code);
                                    $('#num-employees').val(response.data.number_of_employees).trigger('change.select2');
                                    $('#company-revenue').val(response.data.company_revenue).trigger('change.select2');
                                    $('#industry').val(response.data.industry).trigger('change.select2');

                                    if (null !== response.data.company_age) {
                                        $('#founding-year')
                                            .val((new Date()).getFullYear() - parseInt(response.data.company_age))
                                            .trigger('change.select2')
                                        ;
                                    } else {
                                        $('#founding-year').val('').trigger('change.select2');
                                    }

                                    break;

                                case 'error':
                                    swal({
                                        title: "Oops",
                                        text: response.data.message,
                                        type: "warning",
                                        confirmButtonText: "OK"
                                    });
                                    break;
                            }
                        }
                    });
                } else {
                    clearFields();
                }
            })
        ;

        $('#state')
            .select2({
                placeholder: "Enter your State",
                allowClear: true
            })
        ;

        $('#num-employees')
            .select2({
                placeholder: "Choose a range",
                allowClear: true
            })
        ;

        $('#company-revenue')
            .select2({
                placeholder: "Choose a range",
                allowClear: true
            })
        ;

        $('#industry')
            .select2({
                placeholder: "Select best fit",
                allowClear: true
            })
        ;

        $('#founding-year')
            .select2({
                placeholder: "Choose Year Founded",
                allowClear: true
            })
        ;

        $('.btn-reset').click(function(){
            clearFields(true, true);
        });

        $('.btn-generate').click(function(){

            var form = $('form');

            if (form.validate()) {
                var backdrop = $('#backdrop');

                backdrop.removeClass('hidden');

                // check if there is sufficient data to generate recommendation
                $.ajax({
                    url: '/recommendation/check-sufficient-data',
                    method: 'post',
                    dataType: 'json',
                    data: {data: form.serialize()},
                    success: function(response) {
                        switch (response.status){
                            case 'success':
                                form.submit();
                                break;

                            case 'error':
                                backdrop.addClass('hidden');
                                swal({
                                    title: "Oops",
                                    text: 'Insufficient data to generate recommendations based on your selections. Please alter your criteria and try again.',
                                    type: "warning",
                                    confirmButtonText: "OK"
                                });
                                break;
                        }
                    }
                });
            }
        });

    });
})(jQuery);