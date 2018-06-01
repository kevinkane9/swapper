;(function($){
    $(document).ready(function(){
        // data table
        $('#dne-table').DataTable({
            "lengthMenu": [10, 50, 100, 250],
            "deferRender": true,
            "serverSide": true,
            "processing": true,
            "ajax": {
                "url": "/clients/dne-get-data",
                "method": "post",
                "data": {id: clientId},
                "dataSrc": "domains"
            },
            "columns": [
                { "data": "domain" },
                {
                    "data": "id",
                    "render": function(id, type, row, meta) {
                        return '<a class="edit fa fa-pencil"></a>' + "\n" +
                            '<i class="fa fa-spinner fa-spin"></i>' + "\n" +
                            '<a class="save fa fa-floppy-o" data-id="' + id + '"></a>' + "\n" +
                            '<a class="delete sweet-confirm-ajax fa fa-times" data-id="' + id + '"></a>';
                    }
                }
            ],
            "ordering": false
        });

        $('input[type="search"], select[name="dne-table_length"]')
            .addClass('form-control')
            .css({"width": "auto", "display": "inline-block", "font-weight": "normal"});

        // edit
        $('#dne-table').on('click', '.edit', function(){
            var that = $(this);
            var cell = that.parents('td').siblings('td');
            var name = cell.html();

            cell
                .html('')
                .append(
                    $('<input type="text" class="form-control" data-validation="not-empty" />').val(name)
                );
            that.hide();
            that.siblings('.save').css('display', 'inline-block');
        });

        // save
        $('#dne-table').on('click', '.save', function(){
            var that    = $(this);
            var cell    = that.parents('td').siblings('td');
            var spinner = that.siblings('i');
            var id      = that.attr('data-id');
            var domain  = cell.find('input').val();

            if (false == that.parents('tr').validate()) {
                return false;
            }

            that.hide();
            spinner.css('display', 'inline-block');

            $.ajax({
                method: 'post',
                url: '/clients/dne-edit',
                data: {
                    id: id,
                    domain: domain
                },
                success: function() {
                    cell.html(domain);
                    spinner.hide();
                    that.siblings('.edit').css('display', 'inline-block');
                }
            });
        });

        // delete
        $('#dne-table').on('click-confirmed', '.delete', function(){
            var that    = $(this);
            var spinner = that.siblings('i');
            var id      = that.attr('data-id');

            that.hide();
            spinner.css('display', 'inline-block');

            $.ajax({
                method: 'post',
                url: '/clients/dne-delete',
                data: { id: id },
                success: function() {
                    that.parents('tr').remove();
                }
            });
        });
    });
})(jQuery);