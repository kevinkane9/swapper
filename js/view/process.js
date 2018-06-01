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

        $('[name="client_id"]').change(function(){
            var searchProfile = $('.search-profile'),
                profileSelect = searchProfile.find('select');

            if ('' !== $(this).val()) {
                $.ajax({
                    url: '/process/get-client-profiles',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        id: $(this).val()
                    },
                    success: function(response) {
                        if ('success' == response.status) {
                            profileSelect.html('<option value=""></option>');

                            for (i in response.data) {
                                profileSelect.append(
                                    $('<option></option>').val(response.data[i].id).html(response.data[i].name)
                                );
                            }

                            profileSelect.select2({
                                placeholder: "None",
                                allowClear: true,
                                minimumResultsForSearch: Infinity
                            });
                            searchProfile.removeClass('hidden');
                        }
                    }
                });
            } else {
                searchProfile.addClass('hidden');
            }
        });

        $('.search-profile select').change(function(){
            if ('' !== $(this).val()) {
                $.ajax({
                    url: '/process/get-profile-preferences',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        id: $(this).val()
                    },
                    success: function(response) {
                        if ('success' == response.status) {

                            $('[name="titles[]"]').selectpicker('deselectAll');
                            $('[name="titles[]"]').selectpicker('val', response.data.profileTitles);

                            $('[name="departments[]"]').selectpicker('deselectAll');
                            $('[name="departments[]"]').selectpicker('val', response.data.profileDepartments);

                            $('[name="states[]"]').selectpicker('deselectAll');
                            $('[name="states[]"]').selectpicker('val', response.data.profile.states);

                            $('[name="countries[]"]').selectpicker('deselectAll');
                            $('[name="countries[]"]').selectpicker('val', response.data.profile.countries);

                            $('[name="prospects"]').val(response.data.profile.max_prospects);
                            $('[name="prospectsScope"]').val(response.data.profile.max_prospects_scope);
                            $('[name="geotarget"]').val(response.data.profile.geotarget);
                            $('[name="geotarget_lat"]').val(response.data.profile.geotarget_lat);
                            $('[name="geotarget_lng"]').val(response.data.profile.geotarget_lng);
                            $('[name="radius"]').val(response.data.profile.radius);
                        }
                    }
                });
            }
        });
    });
})(jQuery);