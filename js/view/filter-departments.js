;(function($){
    $(document).ready(function(){
        $('input').keydown(function(e){
            if (e.keyCode == 13) {
                return false;
            }
        });

        // view group
        $('tbody').on('click', '[data-entity="department"] .view', function(){
            var that        = $(this),
                item        = that.parents('li'),
                departments = item.parents('ul').find('li'),
                id          = item.attr('data-id'),
                spinner     = that.siblings('.fa-spinner');

            that.hide();
            spinner.removeClass('hidden');
            departments.removeClass('selected');

            $.ajax({
                method: 'post',
                url: '/filter-departments/get-keywords',
                data: { id: id },
                success: function(keywords){

                    var keywordCell = $('#cell-keyword');

                    keywordCell.find('ul').hide();
                    if (1 == keywordCell.find('ul[data-department-id="' + id + '"]').length) {
                        keywordCell.find('ul[data-department-id="' + id + '"]').show();
                    } else {
                        var keywordList = $('<ul></ul>')
                            .attr('data-entity', 'keyword')
                            .attr('data-department-id', id);

                        $.each(keywords, function(i, keyword){
                            keywordList.append(
                                $('<li></li>')
                                    .attr('data-id', keyword.id)
                                    .append(
                                        $('<input>')
                                            .addClass('form-control')
                                            .attr('type', 'text')
                                            .attr('name', 'keywords[' + id + '][' + keyword.id + ']')
                                            .val(keyword.keyword)
                                    )
                                    .append($('<a></a>').addClass('fa fa-times delete sweet-confirm-ajax'))
                                    .append($('<i></i>').addClass('fa fa-spinner fa-spin hidden'))
                            );
                        });

                        keywordCell.prepend(keywordList);
                    }

                    $('#add-keyword').show();
                    $('#cell-keyword li').removeClass('selected');

                    spinner.addClass('hidden');
                    that.show();
                    item.addClass('selected');
                }
            });
        });

        $('tbody').on('click-confirmed', 'a.delete', function(){
            var that    = $(this);
            var spinner = that.siblings('.fa-spinner');
            var item    = that.parents('li');
            var id      = item.attr('data-id');
            var entity  = that.parents('ul').attr('data-entity');

            that.hide();
            spinner.removeClass('hidden');

            $.ajax({
                method: 'post',
                url: '/filter-departments/delete',
                data: {
                    entity: entity,
                    id: id
                },
                success: function(){

                    // delete child elements
                    switch (entity) {
                        case 'department':
                            $('[data-department-id="'+ id + '"]').each(function(){
                                var keywordsList = $(this);
                                keywordsList.find('li').each(function(){
                                    $('[data-keyword-id="' + $(this).attr('data-id') + '"]').each(function(){
                                        $(this).remove();
                                    });
                                });
                                keywordsList.remove();
                                if (item.hasClass('selected')) {
                                    $('#add-keyword').hide();
                                }
                            });
                            break;

                        case 'keyword':
                            $('[data-keyword-id="' + id + '"]').remove();
                            break;
                    }

                    item.remove();
                }
            });
        });

        // add department
        $('tbody').on('click', '#add-department', function(){

            swal({
                    title: "Enter a Department",
                    inputPlaceholder: "Department",
                    type: "input",
                    showCancelButton: true,
                    animation: "slide-from-top"
                },
                function(department) {
                    if (false === department || "" === department) return false;

                    $.ajax({
                        method: 'post',
                        url: '/filter-departments/add',
                        data: {
                            entity: 'department',
                            department: department
                        },
                        success: function(response){
                            var id = response.id;

                            $('[data-entity="department"]').scrollTop($('[data-entity="department"]').offset().top - 250);

                            $('#cell-department ul').prepend(
                                $('<li></li>')
                                    .attr('data-id', id)
                                    .append('&nbsp;')
                                    .append(
                                        $('<input>')
                                            .addClass('form-control')
                                            .attr('type', 'text')
                                            .attr('name', 'departments[' + id + ']')
                                            .val(department)
                                    )
                                    .append('&nbsp;')
                                    .append($('<a></a>').addClass('fa fa-times delete sweet-confirm-ajax'))
                                    .append('&nbsp;')
                                    .append(
                                        $('<i></i>').addClass('fa fa-spinner fa-spin hidden')
                                    )
                                    .append($('<a></a>').addClass('fa fa-chevron-right view'))
                                    .append('&nbsp;')
                            );
                        }
                    });
                }
            );
        });

        // add keyword
        $('tbody').on('click', '#add-keyword', function() {
            var keywordsList = $('#cell-keyword ul:not([style="display: none;"])');
            var departmentId   = keywordsList.attr('data-department-id');

            swal({
                    title: "Enter a Keyword",
                    inputPlaceholder: "Keyword",
                    type: "input",
                    showCancelButton: true,
                    animation: "slide-from-top"
                },
                function(keyword) {
                    if (false === keyword || "" === keyword) return false;

                    $.ajax({
                        method: 'post',
                        url: '/filter-departments/add',
                        data: {
                            entity: 'keyword',
                            departmentId: departmentId,
                            keyword: keyword
                        },
                        success: function (response) {
                            var id = response.id;

                            keywordsList.append(
                                $('<li></li>')
                                    .attr('data-id', id)
                                    .append(
                                        $('<input>')
                                            .addClass('form-control')
                                            .attr('type', 'text')
                                            .attr('name', 'departments[' + departmentId + '][' + id + ']')
                                            .val(keyword)
                                    )
                                    .append($('<a></a>').addClass('fa fa-times delete sweet-confirm-ajax'))
                                    .append($('<i></i>').addClass('fa fa-spinner fa-spin hidden'))
                            );
                        }
                    });
                }
            );
        });
    });
})(jQuery);