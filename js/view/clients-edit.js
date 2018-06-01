;(function($){
    $(document).ready(function(){

        // mange survey invites emails
        var updateSurveyEmail = function(email) {
            if (false === email) {
                return;
            }
            $.ajax({
                method: 'post',
                url: '/gmail/update-survey-email/' + window.currentGmailAccountId,
                data: {
                    email: email
                },
                success: function(){
                    location.reload(true);
                }
            });
        };

        $('.edit-survey-email').click(function(){
            var that      = $(this),
                accountId = that.attr('data-account-id'),
                val       = $(this).html();

            window.currentGmailAccountId = accountId;

            swal({
                    title: "Edit Survey Invite Email(s)",
                    inputValue: val,
                    type: "input",
                    showCancelButton: true,
                    animation: "slide-from-top"
                },
                updateSurveyEmail
            );
        });

        $('.set-survey-email').click(function(){
            var that      = $(this),
                accountId = that.attr('data-account-id');

            window.currentGmailAccountId = accountId;

            swal({
                    title: "Add Survey Invite Email(s)",
                    inputPlaceholder: "Email Address",
                    type: "input",
                    showCancelButton: true,
                    animation: "slide-from-top"
                },
                updateSurveyEmail
            );
        });

        // manage survey results emails
        var updateSurveyResultsEmail = function(email) {

            if (false === email) {
                return;
            }

            $.ajax({
                method: 'post',
                url: '/gmail/update-survey-results-email/' + window.currentGmailAccountId,
                data: {
                    email: email
                },
                success: function(){
                    location.reload(true);
                }
            });
        };

        $('.edit-survey-results-email').click(function(){
            var that      = $(this),
                accountId = that.attr('data-account-id'),
                val       = $(this).html();

            window.currentGmailAccountId = accountId;

            swal({
                    title: "Edit Surveys Results Email(s)",
                    inputValue: val,
                    type: "input",
                    showCancelButton: true,
                    animation: "slide-from-top"
                },
                updateSurveyResultsEmail
            );
        });

        $('#meeting-year-select').on('change',function(){
            var year = $(this).val();

            $.ajax({
                method: 'post',
                url: '/clients/ajax-set-session-data',
                data: {
                    meeting_year: year
                },
                success: function(){
                    location.reload(true);
                }
            });
        });
        $('.set-survey-results-email').click(function(){
            var that      = $(this),
                accountId = that.attr('data-account-id');

            window.currentGmailAccountId = accountId;

            swal({
                    title: "Add Survey Results Email(s)",
                    inputPlaceholder: "Email Address",
                    type: "input",
                    showCancelButton: true,
                    animation: "slide-from-top"
                },
                updateSurveyResultsEmail
            );
        });

        // send survey
        $('.btn-send-survey').click(function(){
            var self = $(this);

            self.loader('on');
            $.ajax({
                method: 'post',
                url: '/clients/ajax-get-eligible-survey-events/' + $('input[type="hidden"][name="client_id"]').val(),
                data: {},
                success: function(response){

                    self.loader('off');

                    if (0 == response.data.events.length) {
                        swal({
                            title: "Oops",
                            text: "No eligible meetings to choose from",
                            type: "warning",
                            confirmButtonText: "OK"
                        });
                    } else {
                        var modal  = $('#modal-send-survey'),
                            select = modal.find('select[name="meeting"]');

                        select.html('<option value=""></option>');

                        for (i in response.data.events) {
                            select.append(
                                $('<option></option>').val(response.data.events[i].id).html(response.data.events[i].label)
                            );
                        }

                        modal.modal('show');
                    }
                }
            });
        });

        $('#modal-send-survey .btn-send').click(function(){
            var self  = $(this),
                modal = self.parents('.modal');

            if (modal.validate()) {
                self.loader('on');

                $.ajax({
                    method: 'post',
                    url: '/clients/ajax-send-survey-invitation/',
                    data: {
                        eventId: modal.find('select[name="meeting"]').val()
                    },
                    success: function (response) {

                        switch(response.status) {
                            case 'success':
                                self.loader('off');

                                modal.modal('hide');

                                swal('Survey Sent', 'A survey invitation has been sent.', 'success');
                                break;

                            case 'error':
                                self.loader('off');
                                swal('Oops', response.data.message, 'error');
                                break;
                        }
                    }
                });
            }
        });
    });
})(jQuery);