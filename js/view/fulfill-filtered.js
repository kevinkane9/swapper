;(function($){
    $(document).ready(function(){
        /////////////////////////////////
        // search results
        /////////////////////////////////

        // adjust fixed tab headers
        var toggleSidebar = $('#toggle-sidebar');
        var adjustHeader = function () {
            $('.search-results table').each(function () {
                var table = $(this).DataTable();
                table.fixedHeader.adjust();
            });
        };
       
        
        toggleSidebar.click(function () {
            setTimeout(function () {
                adjustHeader();
            }, 10);
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
            adjustHeader();
        });

        $('.search-results table').DataTable({
            lengthMenu: [50, 200, 500],       
            fixedHeader: {
                headerOffset: 50
            }
        });  
        
        $('[type="checkbox"].selector').click(function () {
            var that = $(this),
                tabKey = that.parents('.tab-pane').attr('id'),
                modal = $('.modal#selector');

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

        $('.modal#selector .btn-select-all').click(function () {
            var modal = $(this).parents('.modal'),
                tabKey = modal.attr('data-tab-key'),
                table = $('#' + tabKey + ' table').DataTable();

            $('td [type="checkbox"]', table.rows({search: 'applied'}).nodes()).prop('checked', true);

            updateProspectsSelected($('#' + tabKey));

            modal.modal('hide');
        });

        $('.modal#selector .btn-select-rows').click(function () {
            var that = $(this),
                rowCount = that.parents('.row').find('input'),
                modal = that.parents('.modal'),
                tabKey = modal.attr('data-tab-key'),
                table = $('#' + tabKey + ' table').DataTable();

            if (that.parents('.row').validate()) {
                $('td [type="checkbox"]', table.rows().nodes()).prop('checked', false);
                $('td [type="checkbox"]', table.rows({search: 'applied'}).nodes()).slice(0, parseInt(rowCount.val())).prop('checked', true);

                updateProspectsSelected($('#' + tabKey));

                modal.modal('hide');
                rowCount.val('');
            }
        });

        // prospect controls
        var updateProspectsSelected = function (tab) {
            var table = tab.find('table').DataTable(),
                prospectsSelects = tab.find('.prospects-selected');

            prospectsSelects.html(
                $('td [type="checkbox"]:checked', table.rows({search: 'applied'}).nodes()).length
            );
        };

        $(document).on('change', '.search-results td [type="checkbox"]', function () {
            var that = $(this),
                tab = that.parents('.tab-pane');

            updateProspectsSelected(tab);
        });       
        
        // initiate recycled list request
        $(document).on('click', '.btn-upload-to-outreach', function () {
            var tab = $(this).parents('.tab-pane'),
                table = tab.find('table').DataTable(),
                checkboxes = $('td [type="checkbox"]:checked', table.rows({search: 'applied'}).nodes());

            if (0 == checkboxes.length) {
                swal({
                    title: "Oops",
                    text: "Please select at least 1 prospect first",
                    type: "warning",
                    confirmButtonText: "OK"
                });
                return;
            }
            
            $('.hdn-prospects').val(checkboxes.serialize());
            $('.btn-upload-to-outreach-submit').click();
            
        });   

        $(document).on('keyup', '.inline-edit', function () {
            var fieldValue = $(this).val();
            var tabKey = that.parents('.tab-pane').attr('id');
            var fieldName = $(this).attr('data-editable-id');

            $('.tab-pane').each(function () {
                table = $(this).find('#' + tabKey + ' table').DataTable();
                $("." + fieldName, table.rows({search: 'applied'}).nodes()).val(fieldValue);
                // $(this).find('table tr td').find("." + fieldName).val(fieldValue);
            });            
        });           
        
        $(document).on('click', '.btn-save-changes', function () {
            var form = $('#form_prospects_upload');
            
            $.ajax({
                url: '/board/prospects-save',
                method: 'post',
                dataType: 'json',
                data: form.serialize(), 
                beforeSend: function () {
                    $('.btn-save-changes').find('i').removeClass('fa-floppy-o').addClass('fa fa-spinner fa-pulse fa-fw');
                },
                complete: function () {
                     $('.btn-save-changes').find('i').removeClass('fa-spinner fa-pulse fa-fw').addClass('fa-floppy-o');
                },
                success: function(response){
                    if (response.status === 'success') {
                        $('.update-message').fadeIn('show').delay(2000).hide(0);
                    } else {
                        
                    }
                }
            });
                
            return false;
            
        });         

        $(document).on('click', '.btn-pre-export', function () {
            var form = $('#form_prospects_export');
            
            form.submit();
                
            return false;            
        });
        
//        $(document).on('dblclick', '[data-editable]', function () {
//            var td = $(this);
//            td.html(
//                '<input data-editable-col="' + td.attr('data-col-name') + '" type="text" class="form-control" value="' + td.text() + '">'                
//            );
//        });
//
//        $(document).on('blur', '[data-editable]', function () {
//            var inputGroup = $(this).parents('[data-editable-input]');
//            var input = inputGroup.find('input');
//            var td = inputGroup.parents('td');
//
//            td.html(input.val());
//        });        
    });
})(jQuery);