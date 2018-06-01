;(function($){
    $(document).ready(function(){

        $('body').on('click', '.request-list li', function(){
            var that             = $(this),
                modal            = $('#request-card'),
                requestData      = modal.find('.request-data'),
                requestComments  = modal.find('.request-comments'),
                errorDetails     = modal.find('.error-details');

            // request attributes
            modal.attr('data-list-request-id', that.attr('data-list-request-id'));
            modal.find('[name="list_request_id"]').val(that.attr('data-list-request-id'));
            modal.find('.request-header h3').html(that.find('.request-header h3').html());
            modal.find('.request-header h4').html(that.find('.request-header h4').html());
            modal.find('.request-header p').html('').html(that.find('.request-header p').html());
            modal.find('.badges').html(that.find('.badges').html());

            modal.find('[name="client_id"]').val(that.attr('data-client-id'));
            modal.find('.status-select option[value="' + that.attr('data-status') + '"]').prop('selected', true);
            
            // request data
            requestData.html('');
            that.find('.request-data span').each(function(){
                var span      = $(this),
                    label     = span.attr('data-label'),
                    content   = span.html();
				
				if( label == 'Job Titles' )
				{
					content = content.replace(/,\\*/g,"</br>"); // Replace the comma with </br>
				}
				
                requestData.append(
                    $('<div class="col-sm-12"><hr></div>').append(
                        $('<div class="row"></div>')
                            .append(
                                $('<div class="col-sm-3 text-left"></div>').append(
                                    $('<strong></strong>').html(label + ':')
                                )
                            )
                            .append($('<div class="col-sm-6 text-left"></div>').html(content))
                    )
                );
            });

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

            modal.modal('show');
        });

        $('#request-card .btn-submit-comment').click(function(){
            var that  = $(this),
                modal = that.parents('.modal');

            if (false !== that.parents('.col-sm-12').validate()) {
                that.loader('on');

                $.ajax({
                    url: '/targeting-request-board/comment',
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
                url: '/targeting-request-board/delete',
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

        $('.request-list .controls select, .request-list .controls input').change(function(){
            var sort_by_created_date = $('#sort-by-created-date').prop('checked');
            var status = $('.new-requests [name="status"]').val();
            var client_id = $('.new-requests [name="client_id"]').val();

            $.ajax({
                method: 'post',
                url: '/targeting-request-board/ajax-set-session-data',
                data: {
                    sort_by_created_date: sort_by_created_date,
                    status: status,
                    client_id: client_id
                },
                success: function(){
                    location.reload(true);
                }
            });            

        });

       $('.status-select').change(function () {
            var that  = $(this),
            modal = that.parents('.modal'),
            id    = modal.attr('data-list-request-id');

            that.loader('on');

            $.ajax({
                url: '/targeting-request-board/update-status',
                method: 'post',
                dataType: 'json',
                data: { id: id,status:$(this).val() },
                success: function(){
                    that.loader('off');
                    modal.modal('hide');
                    
                    location.reload(true);
                }
            });
       });
    });
})(jQuery);
