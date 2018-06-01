;(function($){
    $(document).ready(function(){
        // data table
        $('#downloads-table')
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
                    "url": "/downloads/get-data",
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
                        "data": "filtered_count",
                        "render": function(count, type, row, meta) {
                            if (0 == count) {
                                return '0';
                            } else {
                                return '<a href="/downloads/download/filtered/' + row.id + '">' + "\n" +
                                       '<i class="fa fa-download"></i> ' + count.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "\n" +
                                       '</a>';
                            }
                        }
                    },
                    {
                        "data": "purged_count",
                        "render": function(count, type, row, meta) {
                            if (0 == count) {
                                return '0';
                            } else {
                                return '<a href="/downloads/download/purged/' + row.id + '">' + "\n" +
                                    '<i class="fa fa-download"></i> ' + count.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "\n" +
                                    '</a>';
                            }
                        }
                    },
                    {
                        "data": "id",
                        "render": function(id, type, row, meta) {
                            var html = '<a href="/downloads/delete/' + id + '" class="fa fa-times sweet-confirm-href"></a>';

                            if (0 == row.saved_to_db) {
                                html += '<a href="/downloads/save/' + row.id + '" class="fa fa-floppy-o sweet-confirm-href" title="Save to Database"></a>';
                            } else if (0 == row.uploaded_to_outreach) {
                                html += '<a data-id="' + row.id + '" class="fa fa-upload" title="Upload to Outreach" data-toggle="modal" data-target="#upload"></a>';
                            }

                            return html;
                        }
                    }
                ]
            })
        ;

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
    });
})(jQuery);