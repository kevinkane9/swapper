;(function($){
    $(document).ready(function(){
        // data table
        $('#downloads-filtered-table')
            .on('xhr.dt', function ( e, settings, json, xhr ) {
                $('[data-toggle="tooltip"]').tooltip();
            })
            .DataTable({
                "lengthMenu": [[10, 50, 100, 250], [10, 50, 100, 250]],
                "deferRender": true,
                "serverSide": true,
                "ordering": false,                
                "processing": true,
                "ajax": {
                    "url": "/downloads-filtered/get-data",
                    "method": "post",
                    "dataSrc": "downloads"
                },
                "columns": [
                    { "data": "date" },
                    {
                        "data": "filename",
                        "render": function(count, type, row, meta) {
                            html = row.filename;

                            if (null != row.title) {
                                html += '<br> <div class="badge">' + row.title + '</div>';
                            }
                            return html;
                        }
                    },
                    { "data": "row_count" },
                    {
                        "data": "nidb_count",
                        "render": function(count, type, row, meta) {
                            if (0 == count) {
                                return '0';
                            } else {
                                return '<a href="/downloads-filtered/download/nidb/' + row.id + '">' + "\n" +
                                       '<i class="fa fa-download"></i> ' + count.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "\n" +
                                       '</a>';
                            }
                        }
                    },
                    {
                        "data": "idbnor_count",
                        "render": function(count, type, row, meta) {
                            if (0 == count) {
                                return '0';
                            } else {
                                return '<a href="/downloads-filtered/download/idbnor/' + row.id + '">' + "\n" +
                                       '<i class="fa fa-download"></i> ' + count.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "\n" +
                                       '</a>';
                            }
                        }
                    },
                    /*
                    {
                        "data": "idbior_count",
                        "render": function(count, type, row, meta) {
                            if (0 == count) {
                                return '0';
                            } else {
                                return '<a href="/downloads-filtered/download/idbior/' + row.id + '">' + "\n" +
                                       '<i class="fa fa-download"></i> ' + count.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "\n" +
                                       '</a>';
                            }
                        }
                    },*/
                    { "data": "status" },
                    {
                        "data": "id",
                        "render": function(id, type, row, meta) {
                            var html = '<a href="/downloads-filtered/delete/' + id + '" class="fa fa-times sweet-confirm-href"></a>';

                            if (0 == row.saved_to_db) {
                                // html += '<a href="/downloads-filtered/save/' + row.id + '" class="fa fa-floppy-o sweet-confirm-href" title="Create New Card"></a>';
                            } else if (0 == row.uploaded_to_outreach) {
                                // html += '<a data-id="' + row.id + '" class="fa fa-upload" title="Upload to Outreach" data-toggle="modal" data-target="#upload"></a>';
                            }
                            html += '&nbsp;&nbsp;&nbsp;';
                            
                            if (row.client_id != null && row.client_id != '') {
                                html += '<a href="#" class="fa fa-floppy-o btn-request-new-list-filtered" title="Create New Card" data-outreach-account-id="' + row.outreach_account_id + '" data-list-request-title="' + row.list_request_title + '" data-download-id="' + row.id + '" data-client-id="' + row.client_id + '" data-client-name="' + row.client_name + '" >';
                                html += "<span data-search-criteria='" + row.search_criteria + "' ></span>";
                                html += '</a>';
                            }
                            
                            return html;
                        }
                    }
                ]
            });

        $('#upload [name="outreach_account_id"]').select2({
            placeholder: "Outreach Account",
            allowClear: true
        });

        $('body').on('click', '.fa-upload', function(){
            $('#upload').attr('data-download-id', $(this).attr('data-id'));
        });

        $('#upload .btn-primary').click(function(){
            var that       = $(this),
                modal      = that.parents('.modal'),
                step1      = modal.find('.step-1'),
                step2      = modal.find('.step-2'),
                downloadId = modal.attr('data-download-id'),
                account    = modal.find('select'),
                accountId  = account.val(),
                tag        = modal.find('input').val();

            if (step1.validate()) {
                that.loader('on');

                $.ajax({
                    url: '/downloads/upload-to-outreach/',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        downloadId: downloadId,
                        accountId: accountId,
                        tag: tag
                    },
                    success: function(){
                        that.loader('off');
                        that.hide();

                        step1.fadeOut('slow', function(){
                            step2.fadeIn('slow');
                        });
                    }
                });
            }
        });

        $('#upload').on('hidden.bs.modal', function(){
            var that = $(this);

            that.find('.step-2').hide();
            that.find('.step-1').show();

            that.find('.btn-primary').show();
            that.find('select').val('').trigger('change');
            that.find('input').val('');
        });
        
        // initiate new list request
        $(document.body).on('click','.btn-request-new-list-filtered',function (e) {
            e.preventDefault();
            
            var createRequestModal = $('#create-list-request-filtered');
            var createRequestTitle = $(this).attr('data-list-request-title');

            createRequestModal.find('[name="title"]').val(createRequestTitle);
            
            createRequestModal.find('[name="outreach_account_id"]').val($(this).attr('data-outreach-account-id'));
            createRequestModal.find('[name="download_filtered_id"]').val($(this).attr('data-download-id'));
            createRequestModal.find('[name="search_criteria"]').val($(this).find('span').attr('data-search-criteria'));

            createRequestModal.attr({'data-type': 'new'}).modal('show');
        });    
        
        // create list request
        $(document.body).on('click','.btn-create-list-request-filtered', function () {            
            var that = $(this),
                modal = that.parents('.modal');

            var requestType = modal.find('input[name=type_of_request]:checked').val();

            if (false == that.parents('.modal-body').validate()) {
                return;
            }

            that.loader('on');            
            
            $.ajax({
                url: '/list-request/create',
                method: 'post',
                datatType: 'json',
                data: {
                    outreachAccountId: $('[name="outreach_account_id"]').val(),
                    downloadFilteredId: $('[name="download_filtered_id"]').val(),
                    type: 'new',
                    status: 'QA Check',
                    title: $('#create-list-request-filtered [name="title"]').val(),
                    assignedTo: $('#create-list-request-filtered [name="assigned_to"]').val(),
                    dueDate: $('#create-list-request-filtered [name="due_date"]').val(),
                    description: $('#create-list-request-filtered [name="description"]').val(),

                    searchCriteria: $('#create-list-request-filtered [name="search_criteria"]').val()
                },
                success: function (response) {
                    if ('success' == response.status) {
                        if (requestType == 'other') {
                            console.log('Request Type: Other.');
                            window.location = '/list-request/success';
                        } else {
                            console.log('Request Type: ZoomInfo.');
                            getZoomInfoData();
                        }
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
        });        
    });
})(jQuery);
