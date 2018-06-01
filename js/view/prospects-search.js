;(function($){
    $(document).ready(function(){

        var toggleSidebar = $('#toggle-sidebar'),
            searchForm    = $('.search-form'),
            profile       = searchForm.find('[name="search_profile_id"]'),
            source        = searchForm.find('[name="source_id"]'),
            company       = searchForm.find('[name="company_id"]'),
            industry      = searchForm.find('[name="industries[]"]');

        /////////////////////////////////
        // search form
        /////////////////////////////////

        searchForm.find('[name="outreach_account_id"]')
            .select2({
                placeholder: "Outreach Account",
                allowClear: true
            })
            .change(function(){
                if ('' !== $(this).val()) {
                    $.ajax({
                        url: '/prospects/search/get-client-profiles',
                        method: 'post',
                        dataType: 'json',
                        data: {
                            outreachAccountId: $(this).val()
                        },
                        success: function(response) {
                            if ('success' == response.status) {
                                profile.html('<option value=""></option>');

                                for (i in response.data) {
                                    profile.append(
                                        $('<option></option>').val(response.data[i].id).html(response.data[i].name)
                                    );
                                }

                                profile.removeAttr('disabled').select2({
                                    placeholder: "Search Profile",
                                    allowClear: true,
                                    minimumResultsForSearch: Infinity
                                });
                            }
                        }
                    });
                } else {
                    profile.html('').attr('disabled', true);
                }
            })
        ;

        profile
            .select2({
                placeholder: "Search Profile",
                allowClear: true,
                minimumResultsForSearch: Infinity
            })
            .change(function(){
                if ('' !== $(this).val() && null !== $(this).val()) {
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

                                $('[name="geotarget"]').val(response.data.profile.geotarget);
                                $('[name="geotarget_lat"]').val(response.data.profile.geotarget_lat);
                                $('[name="geotarget_lng"]').val(response.data.profile.geotarget_lng);
                                $('[name="radius"]').val(response.data.profile.radius);
                            }
                        }
                    });
                } else {
                    resetForm(true);
                }
            })
        ;

        var resetForm   = function (preserveAccount) {
            if ("undefined" == typeof(preserveAccount)) {
                preserveAccount = false;
            }

            if (false == preserveAccount) {
                $('[name="outreach_account_id"]').val('').trigger('change');
                $('[name="search_profile_id"]').val('').trigger('change');
            }

            $('[name="source_id"]').val('').trigger('change');
            $('[name="company_id"]').val('').trigger('change');
            $('[name="industries[]"]').val('').trigger('change');
            $('[name="titles[]"]').val('').trigger('change');
            $('[name="departments[]"]').val('').trigger('change');
            $('[name="states[]"]').val('').trigger('change');
            $('[name="countries[]"]').val(['.io', '.me', '.us']).trigger('change');
        };

        var parseValues = function (response) {
            return {
                results: $.map(response.data, function(item) {
                    var parser = new DOMParser;
                    var dom = parser.parseFromString(
                        '<!doctype html><body>' + item.text,
                        'text/html');
                    var string = dom.body.textContent;
                    return {
                        text: string,
                        id: item.id
                    }
                })
            };
        };

        source.select2({
            placeholder: "Source",
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: '/prospects/search/find-source',
                method: 'post',
                dataType: 'json',
                delay: 250,
                data: function (term) {
                    return {
                        term: term.term
                    };
                },
                processResults: parseValues
            }
        });

        company.select2({
            placeholder: "Company",
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: '/prospects/search/find-company',
                method: 'post',
                dataType: 'json',
                delay: 250,
                data: function (term) {
                    return {
                        term: term.term
                    };
                },
                processResults: parseValues
            }
        });

        industry.select2({
            placeholder: "Industry",
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: '/prospects/search/find-industry',
                method: 'post',
                dataType: 'json',
                delay: 250,
                data: function (term) {
                    return {
                        term: term.term
                    };
                },
                processResults: function (response, term) {
                    if (0 == response.data.length) {
                        return {results: [{
                            text: term.term + ' (unused)',
                            id: '!' + term.term
                        }]};
                    } else {
                        return parseValues(response);
                    }
                }
            },
            templateSelection: function(item) {
                return item.text.replace(' (unused)', '');
            }
        });

        $('.country-domains-container select').on('rendered.bs.select', function(){
            var filterOption = $('.country-domains-container .filter-option');
            filterOption.html(
                '<span style="color: #999">Countries:</span> ' +
                filterOption.html()
            );
        });

        $('[type="reset"]').click(function(){
            resetForm();
        });

        /////////////////////////////////
        // search results
        /////////////////////////////////

        // adjust fixed tab headers
        var adjustHeader = function() {
            $('.search-results table').each(function () {
                var table = $(this).DataTable();
                table.fixedHeader.adjust();
            });
        };

        toggleSidebar.click(function(){
            setTimeout(function(){
                adjustHeader();
            }, 10);
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function() {
            adjustHeader();
        });

        $('.search-results table').DataTable({
            lengthMenu: [50, 200, 500],
            fixedHeader: {
                headerOffset: 50
            }
        });

        $('[type="checkbox"].selector').click(function(){
            var that   = $(this),
                tabKey = that.parents('.tab-pane').attr('id'),
                modal  = $('.modal#selector');

            switch ($(this).prop('checked')) {
                case true:
                    modal.attr('data-tab-key', tabKey).modal('show');
                    break;

                case false:
                    var table = that.parents('table').DataTable();
                    $('[type="checkbox"]', table.rows().nodes()).prop('checked', false);
                    updateProspectsSelected($('#' + tabKey));
                    break;
            }
        });

        $('.modal#selector .btn-select-all').click(function(){
            var modal  = $(this).parents('.modal'),
                tabKey = modal.attr('data-tab-key'),
                table  = $('#' + tabKey + ' table').DataTable();

            $('td [type="checkbox"]', table.rows({ search: 'applied'}).nodes()).prop('checked', true);

            updateProspectsSelected($('#' + tabKey));

            modal.modal('hide');
        });

        $('.modal#selector .btn-select-rows').click(function(){
            var that       = $(this),
                rowCount   = that.parents('.row').find('input'),
                modal      = that.parents('.modal'),
                tabKey     = modal.attr('data-tab-key'),
                table      = $('#' + tabKey + ' table').DataTable();

            if (that.parents('.row').validate()) {
                $('td [type="checkbox"]', table.rows().nodes()).prop('checked', false);
                $('td [type="checkbox"]', table.rows({ search: 'applied'}).nodes()).slice(0, parseInt(rowCount.val())).prop('checked', true);

                updateProspectsSelected($('#' + tabKey));

                modal.modal('hide');
                rowCount.val('');
            }
        });

        // prospect controls
        var updateProspectsSelected = function(tab) {
            var table        = tab.find('table').DataTable(),
            prospectsSelects = tab.find('.prospects-selected');

            prospectsSelects.html(
                $('td [type="checkbox"]:checked', table.rows({ search: 'applied'}).nodes()).length
            );
        };

        $('.search-results').on('change', 'td [type="checkbox"]', function(){
            var that = $(this),
                tab  = that.parents('.tab-pane');

            updateProspectsSelected(tab);
        });

        // initiate recycled list request
        $('.btn-upload-to-outreach').click(function(){
            var tab        = $(this).parents('.tab-pane'),
                table      = tab.find('table').DataTable(),
                checkboxes = $('td [type="checkbox"]:checked', table.rows({ search: 'applied'}).nodes());

            if (0 == checkboxes.length) {
                swal({
                    title: "Oops",
                    text: "Please select at least 1 prospect first",
                    type: "warning",
                    confirmButtonText: "OK"
                });
                return;
            }

            var createRequestModal = $('#create-list-request');

            createRequestModal.find('[name="title"]').val($('[data-list-request-title]').attr('data-list-request-title'));

            createRequestModal
                .attr('data-tab-key', tab.attr('id'))
                .attr('data-type', 'recycled')
                .modal('show')
            ;
        });

        // initiate new list request
        $('.btn-request-new-list').click(function(){
            var createRequestModal = $('#create-list-request');

            createRequestModal.find('[name="title"]').val($('[data-list-request-title]').attr('data-list-request-title'));

            createRequestModal.attr({'data-type': 'new'}).modal('show');
        });

        // create list request
        $('#create-list-request .btn-create-list-request').click(function(){
            var that  = $(this),
                modal = that.parents('.modal');

            if (false == that.parents('.modal-body').validate()) {
                return;
            }

            that.loader('on');

            switch (modal.attr('data-type')) {
                case 'new':
                    $.ajax({
                        url: '/list-request/create',
                        method: 'post',
                        datatType: 'json',
                        data: {
                            outreachAccountId: $('[name="outreach_account_id"]').val(),
                            type: 'new',
                            title: $('#create-list-request [name="title"]').val(),
                            assignedTo: $('#create-list-request [name="assigned_to"]').val(),
                            dueDate: $('#create-list-request [name="due_date"]').val(),
                            description: $('#create-list-request [name="description"]').val(),
                            companyId: $('[name="company_id"]').val(),
                            sourceId: $('[name="source_id"]').val(),
                            industries: $('[name="industries[]"]').val(),
                            titles: $('[name="titles[]"]').val(),
                            departments: $('[name="departments[]"]').val(),
                            countries: $('[name="countries[]"]').val(),
                            geotarget: $('[name="geotarget"]').val(),
                            radius: $('[name="radius"]').val(),
                            states: $('[name="states[]"]').val()
                        },
                        success: function(response){
                            if ('success' == response.status) {
                                window.location = '/list-request/success';
                            } else {
                                that.loader('off');
                                swal({
                                    title: "Oops",
                                    text: response.data.message,
                                    type: "warning",
                                    confirmButtonText: "OK"
                                });
                            }
                        }
                    });
                    break;

                case 'recycled':
                    var tab        = $('#' + modal.attr('data-tab-key')),
                        table      = tab.find('table').DataTable(),
                        checkboxes = $('td [type="checkbox"]:checked', table.rows({ search: 'applied'}).nodes()),
                        prospectIds = [];

                    checkboxes.each(function(){
                        prospectIds.push($(this).parents('tr').attr('data-prospect-id'));
                    });

                    $.ajax({
                        url: '/list-request/create',
                        method: 'post',
                        datatType: 'json',
                        data: {
                            outreachAccountId: $('[name="outreach_account_id"]').val(),
                            type: 'recycled',
                            title: $('#create-list-request [name="title"]').val(),
                            assignedTo: $('#create-list-request [name="assigned_to"]').val(),
                            dueDate: $('#create-list-request [name="due_date"]').val(),
                            description: $('#create-list-request [name="description"]').val(),
                            prospectIds: prospectIds
                        },
                        success: function(response){
                            if ('success' == response.status) {
                                window.location = '/list-request/success';
                            } else {
                                that.loader('off');
                                swal({
                                    title: "Oops",
                                    text: response.data.message,
                                    type: "warning",
                                    confirmButtonText: "OK"
                                });
                            }
                        }
                    });
                    break;
            }
        });

        // datatables fixed header / template conflict
        setTimeout(function(){
            adjustHeader();
        }, 10);
    });
})(jQuery);