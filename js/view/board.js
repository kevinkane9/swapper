;(function($){
    $(document).ready(function(){
        initSort = function() {
            var sortableLists = [];
            if (false == $('#new-sort-by-due-date').prop('checked')) {
                sortableLists.push('.new-requests ul');
            }
            if (false == $('#recycled-sort-by-due-date').prop('checked')) {
                sortableLists.push('.recycled-requests ul');
            }

            $.each(sortableLists, function(i, val){
                $(val).sortable({
                    axis: "y",
                    placeholder: "ui-state-highlight",
                    update: function(event, ui) {
                        var list      = $(this);
                        var sortOrder = [];
                        var type      = list.parents('.request-list').attr('data-type');

                        list.find('li').each(function(){
                            sortOrder.push($(this).attr('data-list-request-id'));
                        });
                        $.ajax({
                            method: 'post',
                            url: '/board/sort',
                            data: {
                                type: type,
                                sortOrder: sortOrder
                            }
                        });
                    }
                });
            });
        };

        initSort();

        $('body').on('click', '.request-list li', function(){
            var that             = $(this),
                modal            = $('#request-card'),
                requestData      = modal.find('.request-data'),
                requestProspects = that.find('.prospects-container'),
                requestComments  = modal.find('.request-comments'),
                errorDetails     = modal.find('.error-details');

            // request attributes
            modal.attr('data-list-request-id', that.attr('data-list-request-id'));
            modal.find('[name="list_request_id"]').val(that.attr('data-list-request-id'));
            modal.find('.request-header h3').html(that.find('.request-header h3').html());
            modal.find('.request-header h4').html(that.find('.request-header h4').html());
            modal.find('.request-header p').html('').html(that.find('.request-header p').html());
            modal.find('.badges').html(that.find('.badges').html());

            modal.attr('data-download-filtered-id', that.attr('data-download-filtered-id'));
            modal.attr('data-saved-to-db', that.attr('data-saved-to-db'));
            modal.find('[name="download_filtered_id"]').val(that.attr('data-download-filtered-id'));
            modal.find('[name="client_id"]').val(that.attr('data-client-id'));
            modal.find('.import-form').find('form').attr('action', '/board/fulfill/');
            modal.find('.board-csv-upload-label').html('Fulfill Request');
            modal.find('.btn-upload').removeClass('btn-success btn-primary').addClass('btn-primary');
            
            modal.find('.prospects-view-form').hide();
            modal.find('.import-form').show();
            
            if (that.attr('data-download-filtered-id') > 0) {
                modal.find('.import-form').find('form').attr('action', '/board/fulfill-filtered/');
                modal.find('.board-csv-upload-label').html('Zoominfo Prospects Import');
                modal.find('.btn-upload').removeClass('btn-success btn-primary').addClass('btn-success');
                
                if (that.attr('data-saved-to-db') > 0) {
                    modal.find('.import-form').hide();
                    modal.find('.prospects-view-form').show();
                }
            }
            
            // request data
            requestData.html('');
            that.find('.request-data span').each(function(){
                var span      = $(this),
                    label     = span.attr('data-label'),
                    content   = span.html();

                requestData.append(
                    $('<div class="col-sm-6"></div>').append(
                        $('<div class="row"></div>')
                            .append(
                                $('<div class="col-sm-6 text-right"></div>').append(
                                    $('<strong></strong>').html(label + ':')
                                )
                            )
                            .append($('<div class="col-sm-6"></div>').html(content))
                    )
                );
            });

            // prospects
            modal.find('.prospects-container').html('');
            if (1 == requestProspects.length) {
                modal.find('.prospects-container').html(requestProspects.html());
            }

            // error details
            errorDetails.html(that.find('.error-details').html());

            // comments
            requestComments.html('');
            that.find('.request-comments span').each(function(){
                var span      = $(this),
                    commentBy = span.attr('data-comment-by'),
                    createdAt = span.attr('data-created-at');

                requestComments.append(
                    $('<div class="col-sm-12"></div>')
                        .append(
                            $('<div></div>').html(
                                '<strong>' + commentBy + '</strong>' +
                                ' <small class="text-muted">' + createdAt + '</small>'
                            )
                        )
                        .append(
                            $('<p></p>').html(span.html())
                        )
                );
            });

            // fulfill vs approve
            if (that.parents('.request-list').hasClass('new-requests')) {
                if (('closed' == that.attr('data-status') || 'processing' == that.attr('data-status') || 'fulfilled' == that.attr('data-status')) && that.attr('data-download-filtered-id') < 1) {
                    modal.find('.fulfill-container').addClass('hidden');
                } else {
                    modal.find('.fulfill-container').removeClass('hidden');
                }

                modal.find('.btn-approve').addClass('hidden');
                modal.find('.btn-view-prospects').addClass('hidden');
            } else {
                if ('closed' == that.attr('data-status') || 'processing' == that.attr('data-status') || 'fulfilled' == that.attr('data-status')) {
                    modal.find('.btn-approve').addClass('hidden');
                } else {
                    modal.find('.btn-approve').removeClass('hidden');
                }

                modal.find('.fulfill-container').addClass('hidden');
                modal.find('.btn-view-prospects')
                    .attr('href', '/prospects/search/list-request/' + that.attr('data-list-request-id'))
                    .removeClass('hidden');
            }

            // closeable
            if ('closed' == that.attr('data-status')) {
                modal.find('.btn-close').addClass('hidden');
            } else {
                modal.find('.btn-close').removeClass('hidden');
            }

            modal.modal('show');
        });

        $('#request-card .btn-submit-comment').click(function(){
            var that  = $(this),
                modal = that.parents('.modal');

            if (false !== that.parents('.col-sm-12').validate()) {
                that.loader('on');

                $.ajax({
                    url: '/list-request/comment',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        listRequestId: modal.attr('data-list-request-id'),
                        comment: that.siblings('textarea').val()
                    },
                    success: function(response){
                        that.loader('off');

                        if ('success' == response.status) {
                            var requestComments  = modal.find('.request-comments');

                            requestComments.prepend(
                                $('<div class="col-sm-12"></div>')
                                    .append(
                                        $('<div></div>').html(
                                            '<strong>' + response.data.first_name + ' ' + response.data.last_name + '</strong>' +
                                            ' <small class="text-muted">' + response.data.created_at + '</small>'
                                        )
                                    )
                                    .append($('<p></p>').html(response.data.comment))
                            );

                            that.siblings('textarea').val('');

                            $('li[data-list-request-id="' + response.data.list_request_id + '"] .request-comments').append(
                                '<span data-comment-by="' + response.data.first_name + ' ' + response.data.last_name + '" ' +
                                'data-created-at="' + response.data.created_at + '">' + response.data.comment + '</span>'
                            );
                        }
                    }
                });
            }
        });

        $('#request-card').on('click-confirmed', '.btn-delete', function(){
            var that  = $(this),
                modal = that.parents('.modal'),
                id    = modal.attr('data-list-request-id');

            that.loader('on');

            $.ajax({
                url: '/board/delete',
                method: 'post',
                dataType: 'json',
                data: { id: id },
                success: function(){
                    that.loader('off');
                    modal.modal('hide');
                    $('li[data-list-request-id="' + id + '"]').fadeOut();
                }
            });
        });

        $('#request-card').on('click-confirmed', '.btn-close', function(){
            var that  = $(this),
                modal = that.parents('.modal'),
                id    = modal.attr('data-list-request-id');

            that.loader('on');

            $.ajax({
                url: '/board/close',
                method: 'post',
                dataType: 'json',
                data: { id: id },
                success: function(){
                    that.loader('off');
                    modal.modal('hide');
                    $('li[data-list-request-id="' + id + '"]').fadeOut();
                }
            });
        });

        $('#request-card').on('click-confirmed', '.btn-approve', function(){
            var that  = $(this),
                modal = that.parents('.modal'),
                id    = modal.attr('data-list-request-id');

            that.loader('on');

            var form = $('<form method="post" action="/board/approve"></form>')
                .append($('<input type="hidden" name="list_request_id" />').val(id));

            $('body').append(form);
            form.submit();
        });

        $('#request-card').on('click-confirmed', '.btn-reprocess', function(){
            var that  = $(this),
                modal = that.parents('.modal'),
                id    = modal.attr('data-list-request-id');

            that.loader('on');

            var form = $('<form method="post" action="/board/reprocess"></form>')
                .append($('<input type="hidden" name="list_request_id" />').val(id));

            $('body').append(form);
            form.submit();
        });

        $('.request-list .controls select, .request-list .controls input').change(function(){
            var form = $('<form method="post" action="/board/view"></form>')
                .append($('<input type="hidden" name="new[status]" />').val($('.new-requests [name="status"]').val()))
                .append($('<input type="hidden" name="new[assigned_to]" />').val($('.new-requests [name="assigned_to"]').val()))
                .append($('<input type="hidden" name="new[client_id]" />').val($('.new-requests [name="client_id"]').val()))
                .append($('<input type="hidden" name="recycled[status]" />').val($('.recycled-requests [name="status"]').val()))
                .append($('<input type="hidden" name="recycled[assigned_to]" />').val($('.recycled-requests [name="assigned_to"]').val()))
                .append($('<input type="hidden" name="recycled[client_id]" />').val($('.recycled-requests [name="client_id"]').val()));

            // sort by due date
            if (true == $('#new-sort-by-due-date').prop('checked')) {
                form.append($('<input type="hidden" name="new[sort_by_due_date]" />').val(1));
            }

            if (true == $('#recycled-sort-by-due-date').prop('checked')) {
                form.append($('<input type="hidden" name="recycled[sort_by_due_date]" />').val(1));
            }

            // show archived
            if (true == $('#new-show-archived').prop('checked')) {
                form.append($('<input type="hidden" name="new[show_archived]" />').val(1));
            }

            if (true == $('#recycled-show-archived').prop('checked')) {
                form.append($('<input type="hidden" name="recycled[show_archived]" />').val(1));
            }

            $('body').append(form);
            form.submit();
        });
    });
})(jQuery);
