;(function($){
    $(document).ready(function(){
        $('input').keydown(function(e){
            if (e.keyCode == 13) {
                return false;
            }
        });

        initSort = function() {
            $('ul.sortable').sortable({
                handle: ".fa-arrows",
                axis: "y",
                placeholder: "ui-state-highlight",
                update: function(event, ui) {
                    var list      = $(this);
                    var sortOrder = [];
                    var entity    = list.attr('data-entity');

                    list.find('li').each(function(){
                        var item = $(this);
                        sortOrder.push(item.attr('data-id'));
                    });
                    $.ajax({
                        method: 'post',
                        url: '/filter-titles/sort',
                        data: {
                            entity: entity,
                            sortOrder: sortOrder
                        }
                    });
                }
            });
        };

        initSort();

        // view group
        $('tbody').on('click', '[data-entity="group"] .view', function(){
            var that    = $(this);
            var item    = that.parents('li');
            var groups  = item.parents('ul').find('li');
            var id      = item.attr('data-id');
            var spinner = that.siblings('.fa-spinner');

            that.hide();
            spinner.removeClass('hidden');
            groups.removeClass('selected');

            $.ajax({
                method: 'post',
                url: '/filter-titles/get-titles',
                data: { id: id },
                success: function(titles){

                    var titleCell = $('#cell-title');

                    titleCell.find('ul').hide();
                    if (1 == titleCell.find('ul[data-group-id="' + id + '"]').length) {
                        titleCell.find('ul[data-group-id="' + id + '"]').show();
                    } else {
                        var titleList = $('<ul></ul>')
                            .addClass('sortable')
                            .attr('data-entity', 'title')
                            .attr('data-group-id', id);

                        $.each(titles, function(i, title){
                            titleList.append(
                                $('<li></li>')
                                    .attr('data-id', title.id)
                                    .append($('<i></i>').addClass('fa fa-arrows'))
                                    .append(
                                        $('<input>')
                                            .addClass('form-control')
                                            .attr('type', 'text')
                                            .attr('name', 'titles[' + id + '][' + title.id + ']')
                                            .val(title.name)
                                    )
                                    .append($('<a></a>').addClass('fa fa-times delete sweet-confirm-ajax'))
                                    .append($('<i></i>').addClass('fa fa-spinner fa-spin hidden'))
                                    .append($('<a></a>').addClass('fa fa-chevron-right view'))
                            );
                        });

                        titleCell.prepend(titleList);
                    }

                    $('#add-title').show();
                    $('#cell-variation ul, #add-variation, #cell-negative ul, #add-negative').hide();
                    $('#cell-title li').removeClass('selected');
                    initSort();

                    spinner.addClass('hidden');
                    that.show();
                    item.addClass('selected');
                }
            });
        });

        // view title
        $('tbody').on('click', '[data-entity="title"] .view', function(){
            var that    = $(this);
            var item    = that.parents('li');
            var titles  = item.parents('ul').find('li');
            var id      = item.attr('data-id');
            var spinner = that.siblings('.fa-spinner');

            that.hide();
            spinner.removeClass('hidden');
            titles.removeClass('selected');

            $.ajax({
                method: 'post',
                url: '/filter-titles/get-variations',
                data: { id: id },
                success: function(variations){

                    var variationCell = $('#cell-variation');

                    variationCell.find('ul').hide();
                    if (1 == variationCell.find('ul[data-title-id="' + id + '"]').length) {
                        variationCell.find('ul[data-title-id="' + id + '"]').show();
                    } else {
                        var variationList = $('<ul></ul>')
                            .addClass('sortable')
                            .attr('data-entity', 'variation')
                            .attr('data-title-id', id);

                        $.each(variations, function(i, variation){
                            variationList.append(
                                $('<li></li>')
                                    .attr('data-id', variation.id)
                                    .append(
                                        $('<input>')
                                            .addClass('form-control')
                                            .attr('type', 'text')
                                            .attr('name', 'variations[' + id + '][' + variation.id + ']')
                                            .val(variation.name)
                                    )
                                    .append($('<a></a>').addClass('fa fa-times delete sweet-confirm-ajax'))
                                    .append($('<i></i>').addClass('fa fa-spinner fa-spin hidden'))
                            )
                        });

                        variationCell.prepend(variationList);
                    }

                    $('#add-variation').show();

                    spinner.addClass('hidden');
                    that.show();
                    item.addClass('selected');
                }
            });

            $.ajax({
                method: 'post',
                url: '/filter-titles/get-negative-keywords',
                data: { id: id },
                success: function(negatives){

                    var negativeCell = $('#cell-negative');

                    negativeCell.find('ul').hide();
                    if (1 == negativeCell.find('ul[data-title-id="' + id + '"]').length) {
                        negativeCell.find('ul[data-title-id="' + id + '"]').show();
                    } else {
                        var negativeList = $('<ul></ul>')
                            .addClass('sortable')
                            .attr('data-entity', 'negative')
                            .attr('data-title-id', id);

                        $.each(negatives, function(i, negative){
                            negativeList.append(
                                $('<li></li>')
                                    .attr('data-id', negative.id)
                                    .append(
                                        $('<input>')
                                            .addClass('form-control')
                                            .attr('type', 'text')
                                            .attr('name', 'negatives[' + id + '][' + negative.id + ']')
                                            .val(negative.keyword)
                                    )
                                    .append($('<a></a>').addClass('fa fa-times delete sweet-confirm-ajax'))
                                    .append($('<i></i>').addClass('fa fa-spinner fa-spin hidden'))
                            )
                        });

                        negativeCell.prepend(negativeList);
                    }

                    $('#add-negative').show();

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
                url: '/filter-titles/delete',
                data: {
                    entity: entity,
                    id: id
                },
                success: function(){

                    // delete child elements
                    switch (entity) {
                        case 'group':
                            $('[data-group-id="'+ id + '"]').each(function(){
                                var titlesList = $(this);
                                titlesList.find('li').each(function(){
                                    $('[data-title-id="' + $(this).attr('data-id') + '"]').each(function(){
                                        $(this).remove();
                                    });
                                });
                                titlesList.remove();
                                if (item.hasClass('selected')) {
                                    $('#add-title, #add-variation, #add-negative').hide();
                                }
                            });
                            break;

                        case 'title':
                            $('[data-title-id="' + id + '"]').remove();
                            if (item.hasClass('selected')) {
                                $('#add-variation, #add-negative').hide();
                            }
                            break;
                    }

                    item.remove();
                }
            });
        });

        // add group
        $('tbody').on('click', '#add-group', function(){
            swal({
                    title: "Enter a Group Name",
                    inputPlaceholder: "Group name",
                    type: "input",
                    showCancelButton: true,
                    animation: "slide-from-top"
                },
                function(name){
                    if (false === name || "" === name) return false;

                    $.ajax({
                        method: 'post',
                        url: '/filter-titles/add',
                        data: {
                            entity: 'group',
                            name: name
                        },
                        success: function(response){
                            var id = response.id;

                            $('#cell-group ul').append(
                                $('<li></li>')
                                    .attr('data-id', id)
                                    .append('&nbsp;')
                                    .append(
                                        $('<i></i>').addClass('fa fa-arrows')
                                    )
                                    .append('&nbsp;')
                                    .append(
                                        $('<input>')
                                            .addClass('form-control')
                                            .attr('type', 'text')
                                            .attr('name', 'groups[' + id + ']')
                                            .val(name)
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

        // add title
        $('tbody').on('click', '#add-title', function(){
            var titlesList = $('#cell-title ul:not([style="display: none;"])');
            var groupId    = titlesList.attr('data-group-id');

            swal({
                    title: "Enter a Title",
                    inputPlaceholder: "Title",
                    type: "input",
                    showCancelButton: true,
                    animation: "slide-from-top"
                },
                function(name) {
                    if (false === name || "" === name) return false;

                    $.ajax({
                        method: 'post',
                        url: '/filter-titles/add',
                        data: {
                            entity: 'title',
                            groupId: groupId,
                            name: name
                        },
                        success: function(response) {
                            var id = response.id;

                            titlesList.append(
                                $('<li></li>')
                                    .attr('data-id', id)
                                    .append($('<i></i>').addClass('fa fa-arrows'))
                                    .append(
                                        $('<input>')
                                            .addClass('form-control')
                                            .attr('type', 'text')
                                            .attr('name', 'titles[' + groupId + '][' + id + ']')
                                            .val(name)
                                    )
                                    .append($('<a></a>').addClass('fa fa-times delete sweet-confirm-ajax'))
                                    .append($('<i></i>').addClass('fa fa-spinner fa-spin hidden'))
                                    .append($('<a></a>').addClass('fa fa-chevron-right view'))
                            );
                        }
                    });
                }
            );
        });

        // add variation
        $('tbody').on('click', '#add-variation', function(){
            var variationsList = $('#cell-variation ul:not([style="display: none;"])');
            var titleId        = variationsList.attr('data-title-id');

            swal({
                    title: "Enter a Variation",
                    inputPlaceholder: "Variation",
                    type: "input",
                    showCancelButton: true,
                    animation: "slide-from-top"
                },
                function(name) {
                    if (false === name || "" === name) return false;

                    $.ajax({
                        method: 'post',
                        url: '/filter-titles/add',
                        data: {
                            entity: 'variation',
                            titleId: titleId,
                            name: name
                        },
                        success: function (response) {
                            var id = response.id;

                            variationsList.append(
                                $('<li></li>')
                                    .attr('data-id', id)
                                    .append(
                                        $('<input>')
                                            .addClass('form-control')
                                            .attr('type', 'text')
                                            .attr('name', 'variations[' + titleId + '][' + id + ']')
                                            .val(name)
                                    )
                                    .append($('<a></a>').addClass('fa fa-times delete sweet-confirm-ajax'))
                                    .append($('<i></i>').addClass('fa fa-spinner fa-spin hidden'))
                            );
                        }
                    });
                }
            );
        });

        // add negative
        $('tbody').on('click', '#add-negative', function(){
            var negativesList = $('#cell-negative ul:not([style="display: none;"])');
            var titleId        = negativesList.attr('data-title-id');

            swal({
                    title: "Enter a Negative Keyword",
                    inputPlaceholder: "Negative keyword",
                    type: "input",
                    showCancelButton: true,
                    animation: "slide-from-top"
                },
                function(keyword) {
                    if (false === keyword || "" === keyword) return false;

                    $.ajax({
                        method: 'post',
                        url: '/filter-titles/add',
                        data: {
                            entity: 'negative',
                            titleId: titleId,
                            keyword: keyword
                        },
                        success: function (response) {
                            var id = response.id;

                            negativesList.append(
                                $('<li></li>')
                                    .attr('data-id', id)
                                    .append(
                                        $('<input>')
                                            .addClass('form-control')
                                            .attr('type', 'text')
                                            .attr('name', 'negatives[' + titleId + '][' + id + ']')
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